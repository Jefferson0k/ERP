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
        /* $pagina2 = $pages[1]->getText();
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
        ]; */
        $pagina_2 = $pdf->getPages()[1]->getText();
        $i0_pagina_2 = strpos($pagina_2, 'INFORMACIÓN ECONÓMICO - FINANCIERA');
        $i1_pagina_2 = strpos($pagina_2, 'INFORMACIÓN DEL IMPUESTO TEMPORAL A LOS ACTIVOS NETOS');

        $anos_pagina_2 = explode("\n", $pagina_2)[2];
        $ano_1_pagina_2 = explode("\t", $anos_pagina_2)[0];
        $ano_2_pagina_2 = explode("\t", $anos_pagina_2)[1];

        $pagina_2 = substr($pagina_2, $i0_pagina_2, $i1_pagina_2 - $i0_pagina_2);
        $pagina_2 = explode("\n", $pagina_2);
    
        $ingresos_netos_periodo = explode("\t", substr($pagina_2[1], 0, -26));
        $otros_ingresos_declarados = explode("\t", substr($pagina_2[2], 0, -25));
        $total_activos_netos = explode("\t", substr($pagina_2[3], 0, -19));
        $cuentas_por_cobrar_comerciales_terceros = explode("\t", substr($pagina_2[4], 0, -41));
        $cuentas_por_cobrar_comerciales_relacionados = explode("\t", substr($pagina_2[5], 0, -45));
        $cuentas_por_cobrar_diversas_terceros = explode("\t", substr($pagina_2[6], 0, -38));
        $cuentas_por_cobrar_diversas_relacionados = explode("\t", substr($pagina_2[7], 0, -42));
        $cuentas_por_cobrar_accionistas_socios_directores = explode("\t", substr($pagina_2[8], 0, -52));
        $provision_por_cuentas_cuentas_cobranza_dudosa = explode("\t", substr($pagina_2[9], 0, -51));
        $total_cuentas_por_pagar = explode("\t", substr($pagina_2[10], 0, -68));
        $total_pasivo = explode("\t", substr($pagina_2[11], 0, -12));
        $total_patrimonio = explode("\t", substr($pagina_2[12], 0, -16));
        $capital_social = explode("\t", substr($pagina_2[13], 0, -14));
        $resultado_bruto = explode("\t", substr($pagina_2[14], 0, -37));
        $resultado_antes_participaciones = explode("\t", substr($pagina_2[15], 0));
        $importe_pagado = explode("\t", substr($pagina_2[18], 0, -14));

        $informacion_economico = array(
            'Anos' => [$ano_1_pagina_2, $ano_2_pagina_2],
            'IngresosNetosPeriodo' => [substr($ingresos_netos_periodo[0], 0, -2), substr($ingresos_netos_periodo[1], 0, -2)],
            'OtrosIngresosDeclarados' => [substr($otros_ingresos_declarados[0], 0, -2), substr($otros_ingresos_declarados[1], 0, -2)],
            'TotalActivosNetos' => [substr($total_activos_netos[0], 0, -2), substr($total_activos_netos[1], 0, -2)],
            'CuentasPorCobrarComercialesTerceros' => [substr($cuentas_por_cobrar_comerciales_terceros[0], 0, -2), substr($cuentas_por_cobrar_comerciales_terceros[1], 0, -2)],
            'CuentasPorCobrarComercialesRelacionados' => [substr($cuentas_por_cobrar_comerciales_relacionados[0], 0, -2), substr($cuentas_por_cobrar_comerciales_relacionados[1], 0, -2)],
            'CuentasPorCobrarDiversasTerceros' => [substr($cuentas_por_cobrar_diversas_terceros[0], 0, -2), substr($cuentas_por_cobrar_diversas_terceros[1], 0, -2)],
            'CuentasPorCobrarDiversasRelacionados' => [substr($cuentas_por_cobrar_diversas_relacionados[0], 0, -2), substr($cuentas_por_cobrar_diversas_relacionados[1], 0, -2)],
            'CuentasPorCobrarAccionistasSociosDirectores' => [substr($cuentas_por_cobrar_accionistas_socios_directores[0], 0, -2), substr($cuentas_por_cobrar_accionistas_socios_directores[1], 0, -2)],
            'ProvisionCuentasCuentasCobranzaDudosa' => [substr($provision_por_cuentas_cuentas_cobranza_dudosa[0], 0, -2), substr($provision_por_cuentas_cuentas_cobranza_dudosa[1], 0, -2)],
            'TotalCuentasPorPagar' => [substr($total_cuentas_por_pagar[0], 0, -2), substr($total_cuentas_por_pagar[1], 0, -2)],
            'TotalPasivo' => [substr($total_pasivo[0], 0, -2), substr($total_pasivo[1], 0, -2)],
            'TotalPatrimonio' => [substr($total_patrimonio[0], 0, -2), substr($total_patrimonio[1], 0, -2)],
            'CapitalSocial' => [substr($capital_social[0], 0, -2), substr($capital_social[1], 0, -2)],
            'ResultadoBruto' => [substr($resultado_bruto[0], 0, -2), substr($resultado_bruto[1], 0, -2)],
            'ResultadoAntesParticipacionesImpuestos' => [substr($resultado_antes_participaciones[0], 0, -2), substr($resultado_antes_participaciones[1], 0, -2)],
            'ImportePagado' => [substr($importe_pagado[0], 0, -2), substr($importe_pagado[1], 0, -2)]
        );

        // ================= 3. DECLARACIONES MENSUALES =================
        /* $meses = explode(' ', 'ENERO FEBRERO MARZO ABRIL MAYO JUNIO JULIO AGOSTO SETIEMBRE OCTUBRE NOVIEMBRE DICIEMBRE');
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
        }*/
        //$pagina_3 = $pdf->getPages()[2]->getText();
    
        $text = $pdf->getText();
        $text = str_replace("\n", ' ', $text);

        $i1_text = strpos($text, 'INFORMACIÓN DE LAS DECLARACIONES MENSUALES DE RENTAS 3ra CAT. - EJERCICIO');
        $i2_text = strrpos($text, 'INFORMACIÓN DE LAS DECLARACIONES MENSUALES DE RENTAS 3ra CAT.');
        $i3_text = strpos($text, 'INFORMACIÓN DE VENTAS, INGRESOS DE RENTA,');

        $meses = explode(' ', 'ENERO FEBRERO MARZO ABRIL MAYO JUNIO JULIO AGOSTO SETIEMBRE OCTUBRE NOVIEMBRE DICIEMBRE');

        $bloque_1 = trim(substr($text, $i1_text, $i2_text - $i1_text));
        $index_bloque_1 = strpos($bloque_1, 'Presentó');
        $index_bloque_2 = strrpos($bloque_1, 'Presentó');
        $index_bloque_3 = strpos($bloque_1, 'INFORMACIÓN DE LA DECLARACIÓN JURADA MENSUAL INCLUYE');
        $presento_bloque_1 = explode(' ', trim(substr($bloque_1, $index_bloque_1, ($index_bloque_2 + 9) - $index_bloque_1)));
        $datos_bloque_1 = explode(' ', trim(substr($bloque_1, ($index_bloque_2 + 9), $index_bloque_3 - ($index_bloque_2 + 9))));

        $bloque_2 = trim(substr($text, $i2_text, $i3_text - $i2_text));
        $index_bloque_4 = strpos($bloque_2, 'Presentó');
        $index_bloque_5 = strrpos($bloque_2, 'Presentó');
        $index_bloque_6 = strpos($bloque_2, 'www.sunat.gob.pe');
        $presento_bloque_2 = explode(' ', trim(substr($bloque_2, $index_bloque_4, ($index_bloque_5 + 9) - $index_bloque_4)));
        $datos_bloque_2 = explode(' ', trim(substr($bloque_2, ($index_bloque_5 + 9), $index_bloque_6 - ($index_bloque_5 + 9))));

        $limite_bloque_1 = count($datos_bloque_1) / 2;
        $limite_bloque_2 = count($datos_bloque_2) / 2;
        for ($i = count($datos_bloque_1); $i > 0; $i--) {
            if (count($datos_bloque_1) > $limite_bloque_1) {
                unset($datos_bloque_1[$i]);
            }
        }
        for ($i = count($datos_bloque_2); $i > 0; $i--) {
            if (count($datos_bloque_2) > $limite_bloque_2) {
                unset($datos_bloque_2[$i]);
            }
        }

        $declaraciones_mensuales = array('EjercicioAnterior' => [], 'EjercicioActual' => []);

        for ($i = 0; $i < count($presento_bloque_1); $i++) {
            array_push($declaraciones_mensuales['EjercicioAnterior'], [$meses[$i], $datos_bloque_1[$i]]);
        }

        for ($i = 0; $i < count($presento_bloque_2); $i++) {
            array_push($declaraciones_mensuales['EjercicioActual'], [$meses[$i], $datos_bloque_2[$i]]);
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
        /* $pagina5 = str_replace(["\n", "\t"], ' ', $pages[4]->getText());
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
        ];*/
        $pagina_5 = $pdf->getPages()[4]->getText();

        $i0_pagina_5 = $indice_iguales('COMO SOCIO', $pagina_5)[0];
        $i1_pagina_5 = $indice_iguales('COMO SOCIO', $pagina_5)[1];

        $pagina_5 = substr($pagina_5, ($i0_pagina_5 + 11), $i1_pagina_5 - ($i0_pagina_5 + 143));
        $arreglo_pagina_5 = explode("\n", $pagina_5);    
        $participacion = $arreglo_pagina_5[count($arreglo_pagina_5) - 1];

        $pagina_5 = substr($pagina_5, 0, -7);
        $pagina_5 = str_replace("\n", ' ', $pagina_5);
        $pagina_5 = str_replace("\t", ' ', $pagina_5);

        $i3_pagina_5 = $indice_iguales('Persona Natural Domiciliada', $pagina_5)[0];
        $i4_pagina_5 = $indice_iguales('Persona Natural Domiciliada', $pagina_5)[1];

        $texto_1_pagina_5 = substr($pagina_5, ($i3_pagina_5 + 28), $i4_pagina_5 - ($i3_pagina_5 + 29));
        $nombre_1_pagina_5 = trim(substr($texto_1_pagina_5, 0, -27));
        $tipo_1_pagina_5 = trim(substr($texto_1_pagina_5, 34, -23));
        $dni_1_pagina_5 = substr($texto_1_pagina_5, -8);
        $participacion_1_pagina_5 = trim(substr($texto_1_pagina_5, 48, -8));
        $fecha_1_pagina_5 = trim(substr($texto_1_pagina_5, 38, -13));

        $texto_2_pagina_5 = substr($pagina_5, ($i4_pagina_5 + 28));
        $nombre_2_pagina_5 = trim(substr($texto_2_pagina_5, 0, -27));
        $tipo_2_pagina_5 = trim(substr($texto_2_pagina_5, 38, -23));
        $dni_2_pagina_5 = substr($texto_2_pagina_5, -8);
        $participacion_2_pagina_5 = trim(substr($texto_2_pagina_5, 52, -8));
        $fecha_2_pagina_5 = trim(substr($texto_2_pagina_5, 42, -13));

        $participacion_patrimonial = array(
            'Persona1' => [ 'Persona Natural Domiciliada', $nombre_1_pagina_5, $tipo_1_pagina_5, $dni_1_pagina_5, $participacion_1_pagina_5, $fecha_1_pagina_5],
            'Persona2' => [ 'Persona Natural Domiciliada', $nombre_2_pagina_5, $tipo_2_pagina_5, $dni_2_pagina_5, $participacion_2_pagina_5, $fecha_2_pagina_5]
        );

        return response()->json([
            'message' => 'PDF procesado correctamente.',
            'datos_generales' => $datos_generales,
            'informacion_economico' => $informacion_economico,
            'declaraciones_mensuales' => $declaraciones_mensuales,
            'ventas' => $ventas,
            'participacion_patrimonial' => $participacion_patrimonial,
        ]);
    }
}
