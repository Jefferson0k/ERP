<?php

namespace App\Services;

use Smalot\PdfParser\Parser;

class SunatPdfParserService
{
    public function procesarPDF(string $path): array
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($path);
        $text = $pdf->getText();

        // EXTRAER BLOQUE ECONÓMICO-FINANCIERO
        $inicio = stripos($text, 'INFORMACIÓN DE LA DECLARACIÓN JURADA ANUAL - RENTAS DE 3RA. CATEGORIA');
        $fin = stripos($text, 'INFORMACIÓN DEL IMPUESTO TEMPORAL A LOS ACTIVOS');

        if ($inicio === false || $fin === false) {
            return [
                'message' => 'No se pudo encontrar la sección solicitada.',
            ];
        }

        $bloque = substr($text, $inicio, $fin - $inicio);
        $lineas = preg_split("/\r\n|\r|\n/", $bloque);

        $map = [
            'Ingresos Netos del periodo' => 'ingresos_netos',
            'Otros Ingresos declarados' => 'otros_ingresos',
            'Total Activos Netos' => 'activos_netos',
            'Cuentas Por Cobrar Comerciales - Terceros' => 'cuentas_por_cobrar_comerciales_terceros',
            'Cuentas Por Cobrar Comerciales - Relacionados' => 'cuentas_por_cobrar_comerciales_relacionados',
            'Cuentas Por Cobrar Diversas - Terceros' => 'cuentas_por_cobrar_diversas_terceros',
            'Cuentas Por Cobrar Diversas - Relacionados' => 'cuentas_por_cobrar_diversas_relacionados',
            'Cuentas por cobrar a accionistas, socios, directores' => 'cuentas_por_cobrar_a_socios',
            'Provisión por cuentas de cuentas de cobranza dudosa' => 'provision_cuentas_dudosas',
            'Total Cuentas por Pagar (proveedores / de terceros / a relacionados)' => 'total_cuentas_por_pagar',
            'Total Pasivo' => 'total_pasivo',
            'Total patrimonio' => 'total_patrimonio',
            'Capital social' => 'capital_social',
            'Resultado Bruto (Utilidad o Pérdida)' => 'resultado_bruto',
            'Resultado antes de participaciones e impuestos (antes de ajustes tributarios)' => 'resultado_antes_imp',
            'Importe pagado' => 'importe_pagado',
        ];

        $data2024 = [];
        $data2023 = [];

        foreach ($lineas as $i => $linea) {
            foreach ($map as $label => $key) {
                if (stripos($linea, $label) !== false) {
                    $valores = trim(str_ireplace($label, '', $linea));
                    if (empty($valores) && isset($lineas[$i + 1])) {
                        $valores = trim($lineas[$i + 1]);
                    }

                    preg_match_all("/(\d{1,3}(?:,\d{3})*|\d+)(?:\s)?([OSNR])/", $valores, $matches);
                    if (count($matches[0]) >= 2) {
                        $data2024[$key] = [
                            'valor' => (int) str_replace(',', '', $matches[1][0]),
                            'origen' => $matches[2][0]
                        ];
                        $data2023[$key] = [
                            'valor' => (int) str_replace(',', '', $matches[1][1]),
                            'origen' => $matches[2][1]
                        ];
                    } elseif (count($matches[0]) === 1) {
                        $data2024[$key] = [
                            'valor' => (int) str_replace(',', '', $matches[1][0]),
                            'origen' => $matches[2][0]
                        ];
                        $data2023[$key] = [
                            'valor' => 0,
                            'origen' => 'S'
                        ];
                    } else {
                        $data2024[$key] = ['valor' => 0, 'origen' => 'S'];
                        $data2023[$key] = ['valor' => 0, 'origen' => 'S'];
                    }
                }
            }
        }

        // EXTRAER BLOQUE DE SOCIOS - MEJORADO
        $inicioSocios = stripos($text, 'INFORMACIÓN DE PARTICIPACIÓN PATRIMONIAL');
        $finSocios = stripos($text, 'Se muestra información de hasta los 5 principales socios, asociados y otros declarados');

        $contenido_socios = '';
        $socios2024 = [];
        $socios2023 = [];

        if ($inicioSocios !== false && $finSocios !== false) {
            $contenido_socios = substr($text, $inicioSocios, $finSocios - $inicioSocios);

            // DEBUG: Agregar logs para verificar el contenido
            error_log("Contenido socios encontrado: " . substr($contenido_socios, 0, 500));

            // Limpiar y normalizar texto
            $contenido_socios = preg_replace("/\s{2,}/", " ", str_replace(["\t", "\r"], [" ", ""], $contenido_socios));
            $contenido_socios = str_replace("\n", " ", $contenido_socios);

            // Dividir por año - MEJORADO
            if (preg_match('/2024(.*?)2023/s', $contenido_socios, $match2024)) {
                $socios2024 = $this->parsearSocios($match2024[1]);
                error_log("Socios 2024 parseados: " . json_encode($socios2024));
            }
            
            if (preg_match('/2023(.*)/s', $contenido_socios, $match2023)) {
                $socios2023 = $this->parsearSocios($match2023[1]);
                error_log("Socios 2023 parseados: " . json_encode($socios2023));
            }

            // Si no encuentra con el patrón anterior, probar alternativas
            if (empty($socios2024) && empty($socios2023)) {
                error_log("No se encontraron socios con el patrón inicial, probando alternativas...");
                
                // Intentar con todo el contenido
                $todosSocios = $this->parsearSocios($contenido_socios);
                if (!empty($todosSocios)) {
                    $socios2024 = $todosSocios;
                    error_log("Socios encontrados con patrón alternativo: " . json_encode($todosSocios));
                }
            }
        } else {
            error_log("No se encontró la sección de socios. Inicio: " . ($inicioSocios !== false ? 'SÍ' : 'NO') . ", Fin: " . ($finSocios !== false ? 'SÍ' : 'NO'));
        }

        return [
            'message' => 'PDF procesado correctamente.',
            'data' => [
                'anio_2024' => $data2024,
                'anio_2023' => $data2023,
                'socios_2024' => $socios2024,
                'socios_2023' => $socios2023,
            ]
        ];
    }

    private function parsearSocios(string $texto): array
    {
        $socios = [];
        $texto = str_replace(["\t", "\n", "\r"], " ", $texto);
        $texto = preg_replace("/\s{2,}/", " ", $texto);
        
        error_log("Texto a parsear socios: " . substr($texto, 0, 500));

        // Patrón original
        preg_match_all('/(Persona [^ ]+ [^ ]+)\s+([A-ZÑÁÉÍÓÚ\s]+)\s+(DNI|RUC|CE)\s+(\d{8,11})\s+(\d{2}\/\d{2}\/\d{4})\s+([\d\.]+)/u', $texto, $matches, PREG_SET_ORDER);
        
        if (empty($matches)) {
            error_log("No se encontraron matches con el patrón original, probando patrones alternativos...");
            
            // Patrón alternativo 1: más flexible con espacios
            preg_match_all('/(Persona\s+[^\s]+\s+[^\s]+)\s+([A-ZÑÁÉÍÓÚ\s]+?)\s+(DNI|RUC|CE)\s+(\d{8,11})\s+(\d{2}\/\d{2}\/\d{4})\s+([\d\.]+)/ui', $texto, $matches, PREG_SET_ORDER);
        }
        
        if (empty($matches)) {
            // Patrón alternativo 2: buscar solo DNI/RUC seguido de fecha y porcentaje
            preg_match_all('/([A-ZÑÁÉÍÓÚ\s]+?)\s+(DNI|RUC|CE)\s+(\d{8,11})\s+(\d{2}\/\d{2}\/\d{4})\s+([\d\.]+)/ui', $texto, $matches2, PREG_SET_ORDER);
            
            foreach ($matches2 as $match) {
                $socios[] = [
                    'tipo_socio' => 'Persona Natural', // Valor por defecto
                    'nombre' => trim($match[1] ?? ''),
                    'tipo_documento' => trim($match[2] ?? ''),
                    'numero_documento' => trim($match[3] ?? ''),
                    'fecha_constitucion' => trim($match[4] ?? ''),
                    'porcentaje_participacion' => (float) str_replace(',', '.', $match[5] ?? 0),
                ];
            }
        } else {
            foreach ($matches as $match) {
                $socios[] = [
                    'tipo_socio' => trim($match[1] ?? ''),
                    'nombre' => trim($match[2] ?? ''),
                    'tipo_documento' => trim($match[3] ?? ''),
                    'numero_documento' => trim($match[4] ?? ''),
                    'fecha_constitucion' => trim($match[5] ?? ''),
                    'porcentaje_participacion' => (float) str_replace(',', '.', $match[6] ?? 0),
                ];
            }
        }
        
        error_log("Socios parseados: " . json_encode($socios));
        return $socios;
    }
}