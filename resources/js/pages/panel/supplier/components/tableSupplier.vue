<template>
    <div class="container-table overflow-x-auto mt-[84px]">
        <LoadingTable v-if="loading" :headers="7" :row-count="12" />
        <div v-else class="table-content">
            <div class="table-container">
                <div class="table-responsive">
                    <Table>
                        <TableHeader class="table-header-row">
                            <TableRow>
                                <TableHead class="table-head">RUC</TableHead>
                                <TableHead class="table-head">Razón Social</TableHead>
                                <TableHead class="table-head">Nombre Comercial</TableHead>
                                <TableHead class="table-head-status">Dirección</TableHead>
                                <TableHead class="table-head-actions">Actividad Económica</TableHead>
                                <TableHead class="table-head-actions">F. Actividades</TableHead>
                                <TableHead class="table-head-actions">Email</TableHead>
                                <TableHead class="table-head-actions">Persona Contacto</TableHead>
                                <TableHead class="table-head-actions">Cargo</TableHead>
                                <TableHead class="table-head-actions">Tasa Esperada</TableHead>
                                <TableHead class="table-head-actions">Comisión</TableHead>
                                <TableHead class="table-head-actions">Estado</TableHead>
                                <TableHead class="table-head-actions">Acciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody class="table-body">
                            <TableRow v-for="supplier in suppliers" :key="supplier.id">
                                <TableHead>{{ supplier.ruc }}</TableHead>
                                <TableHead>{{ supplier.razon_social }}</TableHead>
                                <TableHead>{{ supplier.nombre_comercial }}</TableHead>
                                <TableHead>{{ supplier.direccion }}</TableHead>
                                <TableHead>{{ supplier.actividad_economica }}</TableHead>
                                <TableHead>{{ supplier.fecha_inicio_actividades }}</TableHead>
                                <TableHead>{{ supplier.email }}</TableHead>
                                <TableHead>{{ supplier.persona_contacto }}</TableHead>
                                <TableHead>{{ supplier.cargo_contacto }}</TableHead>
                                <TableHead>{{ supplier.tasa_esperada }}%</TableHead>
                                <TableHead>{{ supplier.comision }}%</TableHead>
                                <TableHead>
                                    <span :class="supplier.estado === 'activo' ? 'text-green-600' : 'text-red-600'">
                                        {{ supplier.estado }}
                                    </span>
                                </TableHead>
                                <TableHead class="flex gap-1">
                                    <button class="bg-blue-500 text-white px-2 py-1 rounded" @click="verProveedor(supplier)">Ver</button>
                                    <button class="bg-yellow-500 text-white px-2 py-1 rounded" @click="editarProveedor(supplier)">Editar</button>
                                    <button class="bg-red-500 text-white px-2 py-1 rounded" @click="eliminarProveedor(supplier.id)">Eliminar</button>
                                </TableHead>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Table, TableBody, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { ref } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import { toast } from 'vue-sonner'

const page = usePage()
const suppliers = ref(page.props.suppliers ?? [])
const loading = ref(false)

function verProveedor(supplier: any) {
    router.visit(`/suppliers/${supplier.id}`)
}

function editarProveedor(supplier: any) {
    router.visit(`/suppliers/${supplier.id}/edit`)
}

async function eliminarProveedor(id: number) {
    if (confirm('¿Estás seguro de eliminar este proveedor?')) {
        try {
            await axios.delete(`/suppliers/${id}`)
            suppliers.value = suppliers.value.filter(s => s.id !== id)
            toast.success('Proveedor eliminado correctamente.')
        } catch (error) {
            toast.error('Error al eliminar proveedor.')
        }
    }
}
</script>
