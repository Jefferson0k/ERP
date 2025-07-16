<template>
    <Head title="Reporte tributario" />
    <AppLayout :breadcrumbs="breadcrumbs">

    <div class="flex h-full flex-1 flex-col rounded-xl p-10 mt-[67px]">

      <div class="bg-purple-fincore rounded-t-xl p-5">
        <h1 class="m-0 text-white text-3xl font-bold">Registro de Reporte Tributario</h1>
      </div>

        <div class="flex">
            <div
                class="relative flex-1 rounded-b-xl border border-sidebar-border/70 dark:border-sidebar-border p-6 space-y-6">

                <!-- Fila de carga archivo, clasificación y empresa -->
                <div class="flex flex-col gap-4 md:flex-row md:items-end">
                    <!-- Cargar reporte tributario -->
                    <div class="flex-1 space-y-1.5">
                        <Label for="reporte">Reporte Tributario</Label>
                        <Button variant="outline" class="w-full bg-skyblue-fincore border-0 text-white" as="label" :disabled="isUploading">
                            <UploadCloud class="w-4 h-4 mr-2" />
                            {{ isUploading ? 'Procesando...' : 'Subir archivo' }}
                            <input id="reporte" type="file" class="hidden" accept=".pdf" @change="handleFileUpload"
                                :disabled="isUploading" />
                        </Button>
                        <p v-if="uploadedFileName" class="text-sm text-green-600">
                            Archivo cargado: {{ uploadedFileName }}
                        </p>
                    </div>
                </div>

                <!-- Mensaje de error -->
                <div v-if="errorMessage" class="bg-red-50 border border-red-200 rounded-lg p-4 text-red-700">
                    {{ errorMessage }}
                </div>

                <div v-if="pdfData">

                <!-- datos generales -->
                <div class="space-y-2 mt-8">
                    <Label class="font-bold text-purple-fincore text-lg">Datos generales</Label>
                    <div class="border rounded-lg p-4 text-black-fincore text-sm">
                        <Table class="w-full">
                            <TableBody v-if="pdfData?.datos_generales">
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600 pe-10">
                                       Nombre Comercial
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.datos_generales.NombreComercial }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600 pe-10">
                                       Fecha de Inscripción
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.datos_generales.FechaInscripcion }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600 pe-10">
                                       Fecha de Inicio de Actividades
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.datos_generales.FechaInicioActividades }}
                                    </TableCell>
                                </TableRow>
                                 <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600 pe-10">
                                       Estado del Contribuyente
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.datos_generales.EstadoContribuyente }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600 pe-10">
                                       Condición del Contribuyente
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.datos_generales.CondicionContribuyente }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600 pe-10">
                                       Domicilio Fiscal
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.datos_generales.DomicilioFiscal }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600 pe-10">
                                       Actividad de Comercio Exterior
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.datos_generales.ActividadComercioExterior }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600 pe-10">
                                       Actividad Económica
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.datos_generales.ActividadEconomica }}
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Información Financiera -->
                <div class="space-y-2 mt-8">
                    <Label class="font-bold text-purple-fincore text-lg">Información Financiera</Label>
                    <div class="border rounded-lg p-4 text-black-fincore text-sm">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead className="w-2/5 text-gray-600 text-start">Año</TableHead>
                                    <TableHead class="text-gray-600">{{ pdfData?.informacion_economico.Anos[0] }}</TableHead>
                                    <TableHead class="text-gray-600">{{ pdfData?.informacion_economico.Anos[1] }}</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-if="!pdfData?.informacion_economico.Anos">
                                    <TableCell class="text-black-fincore">
                                        No hay datos disponibles
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Ingresos Netos del Periodo
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.IngresosNetosPeriodo[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.IngresosNetosPeriodo[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Otros Ingresos Declarados
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.OtrosIngresosDeclarados[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.OtrosIngresosDeclarados[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Total Activos Netos
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.TotalActivosNetos[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.TotalActivosNetos[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Cuentas Por Cobrar Comerciales - Terceros
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.CuentasPorCobrarComercialesTerceros[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.CuentasPorCobrarComercialesTerceros[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Cuentas Por Cobrar Comerciales - Relacionados
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.CuentasPorCobrarComercialesRelacionados[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.CuentasPorCobrarComercialesRelacionados[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Cuentas Por Cobrar Diversas - Terceros
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.CuentasPorCobrarDiversasTerceros[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.CuentasPorCobrarDiversasTerceros[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Cuentas Por Cobrar Diversas - Relacionados
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.CuentasPorCobrarDiversasRelacionados[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.CuentasPorCobrarDiversasRelacionados[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Cuentas Por Cobrar a Accionistas, Socios, Directores
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.CuentasPorCobrarAccionistasSociosDirectores[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.CuentasPorCobrarAccionistasSociosDirectores[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Provision por Cuentas de Cuentas de Cobranza Dudosa
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.ProvisionCuentasCuentasCobranzaDudosa[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.ProvisionCuentasCuentasCobranzaDudosa[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Total Cuentas Por Pagar
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.TotalCuentasPorPagar[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.TotalCuentasPorPagar[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    {{ console.log(pdfData?.informacion_economico) }}
                                    <TableCell class="text-gray-600">
                                        Total Pasivo
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.TotalPasivo[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.TotalPasivo[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Total Patrimonio
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.TotalPatrimonio[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.TotalPatrimonio[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Capital Social
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.CapitalSocial[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.CapitalSocial[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Resultado Bruto
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.ResultadoBruto[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.ResultadoBruto[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Resultado Antes de Participaciones e Impuestos
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.ResultadoAntesParticipacionesImpuestos[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.ResultadoAntesParticipacionesImpuestos[1] }}
                                    </TableCell>
                                </TableRow>
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-gray-600">
                                        Importe Pagado
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.ImportePagado[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore">
                                        {{ pdfData?.informacion_economico.ImportePagado[1] }}
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>

                        <!-- Paginación condicional -->
                        <Pagination v-if="pdfData?.informacion_economico?.Anos?.length > itemsPerPage"
                            :total-pages="totalPages" :current-page="currentPage"
                            @update:current-page="currentPage = $event" class="mt-4" />
                    </div>
                </div>

                <!-- Información de declaraciones mensuales -->
                <div class="space-y-2 mt-8">
                    <Label class="font-bold text-purple-fincore text-lg">Información de las declaraciones mensuales</Label>

                    <div v-for="(declaracionData, declaracionKey) in pdfData?.declaraciones_mensuales || {}" :key="declaracionKey" class="mb-6">
                        <div class="border rounded-lg p-4 text-black-fincore text-sm">
                            <h4 class="text-gray-600 mb-2">{{ declaracionKey }}</h4>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead v-for="(item, index) in declaracionData" :key="index" class="text-gray-600">{{ item[0] }}</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                        <TableCell v-for="(item, index) in declaracionData" :key="index">
                                            {{ item[1] || '-' }}
                                        </TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </div>
                    <div v-if="!pdfData?.ventas || Object.keys(pdfData.ventas).length === 0">
                        <p class="text-center text-black-fincore">No hay datos de ventas disponibles</p>
                    </div>
                </div>

                <div class="space-y-2 mt-8">
                    <Label class="font-bold text-purple-fincore text-lg">Información de Ventas</Label>
                    
                        <div v-for="(ventaData, ventaKey) in pdfData?.ventas || {}" :key="ventaKey" class="mb-6">
                            <div class="border rounded-lg p-4 text-black-fincore text-sm">
                                <h4 class="text-gray-600 mb-2">{{ ventaKey }}</h4>
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead v-for="(item, index) in ventaData" :key="index" class="text-gray-600">{{ item[0] }}</TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                            <TableCell v-for="(item, index) in ventaData" :key="index">{{ item[1] || '-' }}</TableCell>
                                        </TableRow>
                                    </TableBody>
                                </Table>
                            </div>
                        </div>
                        <div v-if="!pdfData?.ventas || Object.keys(pdfData.ventas).length === 0">
                            <p class="text-center text-black-fincore">No hay datos de ventas disponibles</p>
                        </div>
                    
                </div>

                <!-- datos generales -->
                <div class="space-y-2 mt-8">
                    <Label class="font-bold text-purple-fincore text-lg">Información de participación patrimonial</Label>
                    <div class="border rounded-lg p-4 text-black-fincore text-sm">
                        <Table class="w-full">
                            <TableHeader>
                                <TableRow>
                                    <TableHead class="text-gray-600 !text-wrap">Tipo de socio</TableHead>
                                    <TableHead class="text-gray-600 !text-wrap">Apellidos, nombres o razón social</TableHead>
                                    <TableHead class="text-gray-600 !text-wrap">Tipo de documento</TableHead>
                                    <TableHead class="text-gray-600 !text-wrap">Número de documento</TableHead>
                                    <TableHead class="text-gray-600">% Participación</TableHead>
                                    <TableHead class="text-gray-600 !text-wrap">De de constitución como socio</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody v-if="pdfData?.participacion_patrimonial">
                                <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.participacion_patrimonial.Persona1[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.participacion_patrimonial.Persona1[1] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.participacion_patrimonial.Persona1[2] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.participacion_patrimonial.Persona1[3] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.participacion_patrimonial.Persona1[4] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.participacion_patrimonial.Persona1[5] }}
                                    </TableCell>
                                </TableRow>
                                 <TableRow class="odd:bg-gray-100 even:bg-white border-none">
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.participacion_patrimonial.Persona2[0] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.participacion_patrimonial.Persona2[1] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.participacion_patrimonial.Persona2[2] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.participacion_patrimonial.Persona2[3] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.participacion_patrimonial.Persona2[4] }}
                                    </TableCell>
                                    <TableCell class="text-black-fincore !text-wrap">
                                        {{ pdfData?.participacion_patrimonial.Persona2[5] }}
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <div class="pt-5 text-center">
                    <Button type="button" :disabled="guardando" class="bg-skyblue-fincore" @click="guardarReporte">
                        {{ guardando ? 'Navegando...' : 'Guardar Reporte Tributario' }}
                    </Button>
                    </div>
                </div>

            </div>

            </div>

        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import axios from 'axios'

import { UploadCloud } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow
} from '@/components/ui/table'
import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
    SelectItem
} from '@/components/ui/select'
import { Pagination } from '@/components/ui/pagination'

// Breadcrumbs
const breadcrumbs = [
  { title: 'Prospectos', href: '/prospectos' },
  { title: 'Prospecto', href: '/prospectos/prospecto' },
  { title: 'Reporte Tributario', href: '/prospectos/prospecto/reporte' },
]
const guardando = ref(false)

// Estados
const isUploading = ref(false)
const uploadedFileName = ref('')
const errorMessage = ref('')
const pdfData = ref(null)
const selectedClassification = ref('')
const selectedCompany = ref('')
const observacion = ref('')

// Paginación
const currentPage = ref(1)
const itemsPerPage = 5

const paginatedFinancialYears = computed(() => {
    const years = pdfData.value?.informacion_economico?.Anos || []
    const start = (currentPage.value - 1) * itemsPerPage
    return years.slice(start, start + itemsPerPage)
})

const totalPages = computed(() => {
    const totalItems = pdfData.value?.informacion_economico?.Anos?.length || 0
    return Math.ceil(totalItems / itemsPerPage)
})

const convertirFecha = (fecha: string): string | null => {
  const partes = fecha.split('/')
  if (partes.length !== 3) return null
  const [dia, mes, anio] = partes
  if (
    isNaN(Number(dia)) ||
    isNaN(Number(mes)) ||
    isNaN(Number(anio))
  ) return null
  return `${anio.padStart(4, '0')}-${mes.padStart(2, '0')}-${dia.padStart(2, '0')}`
}

const convertirNumero = (value: string): number => {
  if (!value) return 0
  const cleanValue = value.replace(/,/g, '')
  return Number(cleanValue)
}

const obtenerSuma12 = (value: string | string[]): number => {
  if (!value) return 0
  let suma = 0
  for (let i = 0; i < value.length; i++) {
    const cleanValue = Number(value[i][1].replace(/,/g, ''))
    suma += cleanValue
  }
  return suma
}

const obtenerPromedio12 = (value: string | string[]): number => {
  if (!value) return 0
  let promedio = 0
  for (let i = 0; i < value.length; i++) {
    const cleanValue = Number(value[i][1].replace(/,/g, ''))
    promedio += cleanValue
  }
  return promedio / value.length
}

const obtenerSuma6 = (value: string | string[]): number => {
  if (!value) return 0
  const lastSix = value.slice(value.length - 6)
  let suma = 0
  for (let i = 0; i < lastSix.length; i++) {
    const cleanValue = Number(lastSix[i][1].replace(/,/g, ''))
    suma += cleanValue
  }
  return suma
}

const obtenerPromedio6 = (value: string | string[]): number => {
  if (!value) return 0
  const lastSix = value.slice(value.length - 6)
  let promedio = 0
  for (let i = 0; i < lastSix.length; i++) {
    const cleanValue = Number(lastSix[i][1].replace(/,/g, ''))
    promedio += cleanValue
  }
  return promedio / lastSix.length
}

const guardarReporte = async () =>  {
    if (!pdfData.value?.datos_generales) return;

    try {
        const res = await axios.post('/api/prospecto/guardar_sunat_reporte', {
            supplier_id: 1,
            ano: '2025',
            nombre_comercial:  pdfData.value?.datos_generales.NombreComercial,
            fecha_inscripcion:  convertirFecha(pdfData.value?.datos_generales.FechaInscripcion),
            fecha_inicio_actividades:  convertirFecha(pdfData.value?.datos_generales.FechaInicioActividades),
            estado_contribuyente:  pdfData.value?.datos_generales.EstadoContribuyente,
            condicion_contribuyente:  pdfData.value?.datos_generales.CondicionContribuyente,
            domicilio_fiscal:  pdfData.value?.datos_generales.DomicilioFiscal,
            actividad_comercio_exterior:  pdfData.value?.datos_generales.ActividadComercioExterior,
            actividad_economica:  pdfData.value?.datos_generales.ActividadEconomica,
            ingresos_netos: convertirNumero(pdfData.value?.informacion_economico.IngresosNetosPeriodo[0]),
            otros_ingresos: convertirNumero(pdfData.value?.informacion_economico.OtrosIngresosDeclarados[0]),
            total_activos: convertirNumero(pdfData.value?.informacion_economico.TotalActivosNetos[0]),
            total_cuentas_por_pagar: convertirNumero(pdfData.value?.informacion_economico.TotalCuentasPorPagar[0]),
            total_pasivo: convertirNumero(pdfData.value?.informacion_economico.TotalPasivo[0]),
            total_patrimonio: convertirNumero(pdfData.value?.informacion_economico.TotalPatrimonio[0]),
            capital_social: convertirNumero(pdfData.value?.informacion_economico.CapitalSocial[0]),
            resultado_bruto: convertirNumero(pdfData.value?.informacion_economico.ResultadoBruto[0]),
            resultado_antes_imp: convertirNumero(pdfData.value?.informacion_economico.ResultadoAntesParticipacionesImpuestos[0]),
            importe_pagado: convertirNumero(pdfData.value?.informacion_economico.ImportePagado[0]),
            ingreso_12_meses: obtenerSuma12(pdfData.value?.declaraciones_mensuales.EjercicioAnterior),
            ingreso_6_meses: obtenerSuma6(pdfData.value?.declaraciones_mensuales.EjercicioAnterior),
            promedio_ingreso_12_meses: obtenerPromedio12(pdfData.value?.declaraciones_mensuales.EjercicioAnterior),
            promedio_ingreso_6_meses: obtenerPromedio6(pdfData.value?.declaraciones_mensuales.EjercicioAnterior),
        })

        if (res.status === 200 || res.status === 201) {
            //toast.success(res.data.message || 'Prospecto guardado exitosamente')
            router.visit('/prospectos')
        }
    } catch (err: any) {
        console.error('Error al guardar reporte:', err)
    }
}

// Subida de archivo
const handleFileUpload = async (event: Event) => {
    const target = event.target as HTMLInputElement
    const file = target.files?.[0]

    if (!file) return

    if (file.type !== 'application/pdf') {
        errorMessage.value = 'Por favor selecciona un archivo PDF válido'
        return
    }

    if (file.size > 10 * 1024 * 1024) {
        errorMessage.value = 'El archivo no debe exceder los 10MB'
        return
    }

    const formData = new FormData()
    formData.append('archivo', file)

    try {
        isUploading.value = true
        errorMessage.value = ''
        uploadedFileName.value = file.name

        const response = await axios.post('/api/procesar-pdf-sunat', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })

        pdfData.value = response.data
        currentPage.value = 1
    } catch (error) {
        console.error('Error al procesar el archivo:', error)
        errorMessage.value = error.response?.data?.message || 'Error al procesar el archivo PDF'
        uploadedFileName.value = ''
        pdfData.value = null
    } finally {
        isUploading.value = false
    }
}

</script>
