<template>

    <Head title="Comité proveedor" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6 space-y-6">

                <!-- Fila de carga archivo, clasificación y empresa -->
                <div class="flex flex-col gap-4 md:flex-row md:items-end">
                    <!-- Cargar reporte tributario -->
                    <div class="flex-1 space-y-1.5">
                        <Label for="reporte">Reporte Tributario</Label>
                        <Button variant="outline" class="w-full" as="label" :disabled="isUploading">
                            <UploadCloud class="w-4 h-4 mr-2" />
                            {{ isUploading ? 'Procesando...' : 'Subir archivo' }}
                            <input id="reporte" type="file" class="hidden" accept=".pdf" @change="handleFileUpload"
                                :disabled="isUploading" />
                        </Button>
                        <p v-if="uploadedFileName" class="text-sm text-green-600">
                            Archivo cargado: {{ uploadedFileName }}
                        </p>
                    </div>

                    <!-- Clasificación -->
                    <div class="flex-1 space-y-1.5">
                        <Label for="clasificacion">Clasificación</Label>
                        <Select v-model="selectedClassification">
                            <SelectTrigger id="clasificacion" class="w-full">
                                <SelectValue placeholder="Selecciona una clasificación" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="normal">Normal</SelectItem>
                                <SelectItem value="cpp">CPP</SelectItem>
                                <SelectItem value="deficiente">Deficiente</SelectItem>
                                <SelectItem value="dudoso">Dudoso</SelectItem>
                                <SelectItem value="perdida">Perdida</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    <!-- Empresa -->
                    <div class="flex-1 space-y-1.5">
                        <Label for="empresa">Empresa</Label>
                        <Select v-model="selectedCompany">
                            <SelectTrigger id="empresa" class="w-full">
                                <SelectValue placeholder="Selecciona una empresa" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="pequenas">Pequeñas</SelectItem>
                                <SelectItem value="media">Media</SelectItem>
                                <SelectItem value="grande">Grande</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                </div>

                <!-- Mensaje de error -->
                <div v-if="errorMessage" class="bg-red-50 border border-red-200 rounded-lg p-4 text-red-700">
                    {{ errorMessage }}
                </div>

                <!-- Información Financiera -->
                <div class="space-y-2">
                    <Label class="font-semibold">Información Financiera</Label>
                    <div class="border rounded-lg p-4 text-muted-foreground text-sm">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Año</TableHead>
                                    <TableHead>Ingresos</TableHead>
                                    <TableHead>Utilidad</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-if="!pdfData?.informacion_economico?.Anos">
                                    <TableCell colspan="3" class="text-center text-muted-foreground">
                                        No hay datos disponibles
                                    </TableCell>
                                </TableRow>
                                <TableRow v-for="(año, index) in paginatedFinancialYears" :key="index">
                                    <TableCell>{{ año }}</TableCell>
                                    <TableCell>{{
                                        formatNumber(pdfData?.informacion_economico?.IngresosNetosPeriodo?.[index +
                                        (currentPage - 1) * itemsPerPage]) }}</TableCell>
                                    <TableCell>{{ formatNumber(pdfData?.informacion_economico?.ResultadoBruto?.[index +
                                        (currentPage - 1) * itemsPerPage]) }}</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>

                        <!-- Paginación condicional -->
                        <Pagination v-if="pdfData?.informacion_economico?.Anos?.length > itemsPerPage"
                            :total-pages="totalPages" :current-page="currentPage"
                            @update:current-page="currentPage = $event" class="mt-4" />
                    </div>
                </div>

                <!-- Información de Ventas -->
                <div class="space-y-2">
                    <Label class="font-semibold">Información de Ventas</Label>
                    <div class="border rounded-lg p-4 text-muted-foreground text-sm">
                        <div v-for="(ventaData, ventaKey) in pdfData?.ventas || {}" :key="ventaKey" class="mb-6">
                            <h4 class="font-medium mb-2">{{ ventaKey }}</h4>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Mes</TableHead>
                                        <TableHead>Monto</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow v-for="(item, index) in ventaData" :key="index">
                                        <TableCell>{{ item[0] }}</TableCell>
                                        <TableCell>{{ item[1] || 'N/A' }}</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                        <div v-if="!pdfData?.ventas || Object.keys(pdfData.ventas).length === 0">
                            <p class="text-center text-muted-foreground">No hay datos de ventas disponibles</p>
                        </div>
                    </div>
                </div>

                <!-- Línea / Operación Propuesta -->
                <div class="space-y-2">
                    <Label class="font-semibold">Línea / Operación Propuesta</Label>
                    <div class="border rounded-lg p-4 text-muted-foreground text-sm">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Tipo</TableHead>
                                    <TableHead>Monto</TableHead>
                                    <TableHead>Plazo</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow>
                                    <TableCell colspan="3" class="text-center text-muted-foreground">
                                        No hay datos disponibles
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Observación y botón siguiente -->
                <div class="space-y-2">
                    <Label for="observacion" class="font-semibold">Observación</Label>
                    <textarea id="observacion" v-model="observacion" rows="4"
                        class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
                        placeholder="Escribe alguna observación adicional..."></textarea>

                    <div class="flex justify-end mt-2">
                        <Button @click="handleSiguiente">
                            Siguiente
                        </Button>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
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
    { title: 'Proveedores', href: '/Supplier' },
    { title: 'Crear proveedor', href: '/Supplier/create' },
    { title: 'Comité proveedor', href: '/Panel/comite' }
]

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

// Formato número
const formatNumber = (value: number | null | undefined): string => {
    if (value === null || value === undefined || isNaN(value)) return 'N/A'
    return new Intl.NumberFormat('es-PE', {
        style: 'currency',
        currency: 'PEN',
        minimumFractionDigits: 0
    }).format(value)
}

// Acción del botón siguiente
const handleSiguiente = () => {
    console.log('Observación:', observacion.value)
    // Aquí puedes redirigir, enviar un formulario o pasar al siguiente paso
}
</script>
