<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Smalot\PdfParser\Parser;

class SunatReportController extends Controller{
    public function procesar(Request $request){
        $request->validate([
            'archivo' => 'required|file|mimes:pdf|max:10240',
        ]);

        $archivo = $request->file('archivo');
        $path = $archivo->storeAs('reports/sunat', $archivo->getClientOriginalName());
        $fullPath = storage_path('app/' . $path);

        $parser = new Parser();
        $pdf = $parser->parseFile($fullPath);
        $pages = $pdf->getPages();
        $text = str_replace("\n", ' ', $pdf->getText());

        // Funciones auxiliares
        $indice_iguales = function ($palabra, $cadena) {
            $respuesta = [];
            for ($i = 0; $i <= strlen($cadena); $i++) {
                if (substr($cadena, $i, strlen($palabra)) === $palabra) {
                    $respuesta[] = $i;
                }
            }
            return $respuesta;
        };

        $limpiar_ejercicio = fn($ejercicio) => count($ejercicio) > 11 ? array_slice($ejercicio, 0, 11) : $ejercicio;

        $formato_titulo = fn($titulo) => str_replace(' ', '', substr(ucwords(strtolower($titulo)), 0, -7));

        $obtener_ventas = function ($arr, $titulo, $n) use ($formato_titulo) {
            $tituloFinal = $formato_titulo($titulo) . $n;
            $res = [$tituloFinal => []];
            foreach ($arr as $linea) {
                $partes = explode("\t", $linea);
                $mes = $partes[0];
                $valor = '';
                if (isset($partes[1])) {
                    $arreglo_cadena = explode(' ', $partes[1]);
                    $valor = substr($arreglo_cadena[0], -strlen($arreglo_cadena[1] ?? ''));
                }
                $res[$tituloFinal][] = [$mes, $valor];
            }
            return $res;
        };

        // ================= 1. DATOS GENERALES =================
        $pagina1 = str_replace("\n", ' ', $pages[0]->getText());
        $extraer = fn($inicio, $fin, $offset) => trim(substr($pagina1, $inicio + $offset, $fin - ($inicio + $offset)));

        $indices = [
            'nombre' => strpos($pagina1, 'Nombre Comercial'),
            'inscripcion' => strpos($pagina1, 'Fecha de Inscripción'),
            'inicio' => strpos($pagina1, 'Fecha de Inicio de Actividades'),
            'estado' => strpos($pagina1, 'Estado del Contribuyente'),
            'condicion' => strpos($pagina1, 'Condición del Contribuyente'),
            'domicilio' => strpos($pagina1, 'Domicilio Fiscal'),
            'comercio' => strpos($pagina1, 'Actividad de Comercio Exterior'),
            'economica' => strpos($pagina1, 'Actividad Económica'),
            'sistema' => strpos($pagina1, 'INFORMACIÓN SOBRE SISTEMA DE FACTURACIÓN'),
        ];

        $datos_generales = [
            'NombreComercial' => $extraer($indices['nombre'], $indices['inscripcion'], 16),
            'FechaInscripcion' => $extraer($indices['inscripcion'], $indices['inicio'], 21),
            'FechaInicioActividades' => $extraer($indices['inicio'], $indices['estado'], 30),
            'EstadoContribuyente' => $extraer($indices['estado'], $indices['condicion'], 24),
            'CondicionContribuyente' => $extraer($indices['condicion'], $indices['domicilio'], 28),
            'DomicilioFiscal' => $extraer($indices['domicilio'], $indices['comercio'], 16),
            'ActividadComercioExterior' => $extraer($indices['comercio'], $indices['economica'], 30),
            'ActividadEconomica' => $extraer($indices['economica'], $indices['sistema'], 20),
        ];

        // ================= 2. INFORMACIÓN ECONÓMICA =================
        $pagina2 = $pages[1]->getText();
        $lineas = explode("\n", $pagina2);
        $anos = isset($lineas[2]) ? explode("\t", $lineas[2]) : [null, null];

        $campo = function ($line, $recorte) use ($lineas) {
            if (!isset($lineas[$line])) return [null, null];
            $partes = explode("\t", substr($lineas[$line], 0, -$recorte));
            return array_map(fn($v) => (int) str_replace(['.', ',', ' '], '', substr($v, 0, -2)), $partes);
        };

        $informacion_economico = [
            'Anos' => $anos,
            'IngresosNetosPeriodo' => $campo(1, 26),
            'OtrosIngresosDeclarados' => $campo(2, 25),
            'TotalActivosNetos' => $campo(3, 19),
            'CuentasPorCobrarComercialesTerceros' => $campo(4, 41),
            'CuentasPorCobrarComercialesRelacionados' => $campo(5, 45),
            'CuentasPorCobrarDiversasTerceros' => $campo(6, 38),
            'CuentasPorCobrarDiversasRelacionados' => $campo(7, 42),
            'CuentasPorCobrarAccionistasSociosDirectores' => $campo(8, 52),
            'ProvisionCuentasCuentasCobranzaDudosa' => $campo(9, 51),
            'TotalCuentasPorPagar' => $campo(10, 68),
            'TotalPasivo' => $campo(11, 12),
            'TotalPatrimonio' => $campo(12, 16),
            'CapitalSocial' => $campo(13, 14),
            'ResultadoBruto' => $campo(14, 37),
            'ResultadoAntesParticipacionesImpuestos' => $campo(15, 0),
            'ImportePagado' => $campo(18, 14),
        ];

        // ================= 3. DECLARACIONES MENSUALES =================
        $meses = explode(' ', 'ENERO FEBRERO MARZO ABRIL MAYO JUNIO JULIO AGOSTO SETIEMBRE OCTUBRE NOVIEMBRE DICIEMBRE');
        $i1 = strpos($text, 'INFORMACIÓN DE LAS DECLARACIONES MENSUALES DE RENTAS 3ra CAT.');
        $i2 = strpos($text, 'INFORMACIÓN DE VENTAS, INGRESOS DE RENTA,');
        $bloque = substr($text, $i1, $i2 - $i1);

        preg_match_all('/Presentó(.+?)INFORMACIÓN DE LA DECLARACIÓN/', $bloque, $matches);
        $presentoAnterior = isset($matches[1][0]) ? explode(' ', trim($matches[1][0])) : [];
        $presentoActual = isset($matches[1][1]) ? explode(' ', trim($matches[1][1])) : [];

        $datosAnterior = [];
        $datosActual = [];

        if (!empty($presentoAnterior)) {
            $pos = strpos($bloque, end($presentoAnterior));
            $sub = substr($bloque, $pos + strlen(end($presentoAnterior)), 100);
            $datosAnterior = array_slice(explode(' ', trim($sub)), 0, 12);
        }

        if (!empty($presentoActual)) {
            $pos = strpos($bloque, end($presentoActual), $pos ?? 0);
            $sub = substr($bloque, $pos + strlen(end($presentoActual)), 100);
            $datosActual = array_slice(explode(' ', trim($sub)), 0, 12);
        }

        $declaraciones = ['EjercicioAnterior' => [], 'EjercicioActual' => []];
        for ($i = 0; $i < 12; $i++) {
            $declaraciones['EjercicioAnterior'][] = [$meses[$i], $datosAnterior[$i] ?? null];
            $declaraciones['EjercicioActual'][] = [$meses[$i], $datosActual[$i] ?? null];
        }

        // ================= 4. VENTAS =================
        $pagina4 = $pages[3]->getText();
        $ia = $indice_iguales('EJERCICIO ANTERIOR', $pagina4);
        $ic = $indice_iguales('EJERCICIO CORRIENTE', $pagina4);
        $contribuciones = $indice_iguales('CONTRIBUCIÓN', $pagina4);

        $ventas = array_merge(
            $obtener_ventas($limpiar_ejercicio(explode("\n", substr($pagina4, strpos($pagina4, 'ENERO', $contribuciones[0]), $contribuciones[1] - $contribuciones[0]))), substr($pagina4, $ia[0], 25), '1'),
            $obtener_ventas($limpiar_ejercicio(explode("\n", substr($pagina4, strpos($pagina4, 'ENERO', $contribuciones[1]), $contribuciones[2] - $contribuciones[1]))), substr($pagina4, $ia[1], 25), '2'),
            $obtener_ventas($limpiar_ejercicio(explode("\n", substr($pagina4, strpos($pagina4, 'ENERO', $contribuciones[2]), $contribuciones[3] - $contribuciones[2]))), substr($pagina4, $ic[0], 26), '0'),
        );

        // ================= 5. SOCIOS =================
        $pagina5 = str_replace(["\n", "\t"], ' ', $pages[4]->getText());
        $pIndices = $indice_iguales('Persona Natural Domiciliada', $pagina5);

        $extractPersona = function ($texto) {
            return [
                'tipo_socio' => 'Persona Natural Domiciliada',
                'nombre' => trim(substr($texto, 0, -27)),
                'tipo_documento' => trim(substr($texto, 34, -23)),
                'numero_documento' => substr($texto, -8),
                'porcentaje_participacion' => (float) str_replace(['%', ','], ['', '.'], substr($texto, 48, -8)),
                'fecha_constitucion' => trim(substr($texto, 38, -13))
            ];
        };

        $participacion_patrimonial = [
            'Persona1' => isset($pIndices[0], $pIndices[1]) ? $extractPersona(substr($pagina5, $pIndices[0] + 28, $pIndices[1] - $pIndices[0] - 28)) : null,
            'Persona2' => isset($pIndices[1]) ? $extractPersona(substr($pagina5, $pIndices[1] + 28)) : null,
        ];

        return response()->json([
            'message' => 'PDF procesado correctamente.',
            'datos_generales' => $datos_generales,
            'informacion_economico' => $informacion_economico,
            'declaraciones_mensuales' => $declaraciones,
            'ventas' => $ventas,
            'participacion_patrimonial' => $participacion_patrimonial,
        ]);
    }
}
