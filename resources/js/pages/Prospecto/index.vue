<template>

  <Head title="Prospectos" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-10 mt-[67px]">

      <div class="bg-purple-fincore rounded-t-xl p-5">
        <h1 class="m-0 text-white text-3xl font-bold">Prospectos</h1>
      </div>
      
      <div class="inset-ring inset-ring-gray-100 rounded-t-none rounded-b-xl p-5">

            <div class="text-center">
              <Button type="button" :disabled="guardando" class="bg-skyblue-fincore" @click="router.visit('/prospectos/prospecto')">
                {{ guardando ? 'Navegando...' : 'Nuevo prospecto' }}
              </Button>
            </div>

                      <!-- <Table>
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
                                <TableHead>{{ supplier.business_name }}</TableHead>
                                <TableHead>{{ supplier.address }}</TableHead>
                                <TableHead>{{ supplier.economic_activity }}</TableHead>
                                <TableHead>{{ supplier.fecha_inicio_actividades }}</TableHead>
                                <TableHead>{{ supplier.email }}</TableHead>
                                <TableHead>{{ supplier.persona_contacto }}</TableHead>
                                <TableHead>{{ supplier.position }}</TableHead>
                                <TableHead>{{ supplier.expected_rate }}%</TableHead>
                                <TableHead>{{ supplier.commission }}%</TableHead>
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
                    </Table> -->


                    <div class="w-full">
    <div class="flex items-center py-4">
      <Input
        class="max-w-sm"
        placeholder="Filter rucs..."
        :model-value="table.getColumn('ruc')?.getFilterValue() as string"
        @update:model-value=" table.getColumn('ruc')?.setFilterValue($event)"
      />
      <DropdownMenu>
        <DropdownMenuTrigger as-child>
          <Button variant="outline" class="ml-auto">
            Columns <ChevronDown class="ml-2 h-4 w-4" />
          </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
          <DropdownMenuCheckboxItem
            v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
            :key="column.id"
            class="capitalize"
            :model-value="column.getIsVisible()"
            @update:model-value="(value) => {
              column.toggleVisibility(!!value)
            }"
          >
            {{ column.id }}
          </DropdownMenuCheckboxItem>
        </DropdownMenuContent>
      </DropdownMenu>
    </div>
    <div class="rounded-md border">
      <Table>
        <TableHeader>
          <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
            <TableHead v-for="header in headerGroup.headers" :key="header.id">
              <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
            </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <template v-if="table.getRowModel().rows?.length">
            <template v-for="row in table.getRowModel().rows" :key="row.id">
              <TableRow :data-state="row.getIsSelected() && 'selected'">
                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                  <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                </TableCell>
              </TableRow>
              <TableRow v-if="row.getIsExpanded()">
                <TableCell :colspan="row.getAllCells().length">
                  {{ JSON.stringify(row.original) }}
                </TableCell>
              </TableRow>
            </template>
          </template>

          <TableRow v-else>
            <TableCell
              :colspan="columns.length"
              class="h-24 text-center"
            >
              No results.
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>

    <div class="flex items-center justify-end space-x-2 py-4">
      <div class="flex-1 text-sm text-muted-foreground">
        {{ table.getFilteredSelectedRowModel().rows.length }} of
        {{ table.getFilteredRowModel().rows.length }} row(s) selected.
      </div>
      <div class="space-x-2">
        <Button
          variant="outline"
          size="sm"
          :disabled="!table.getCanPreviousPage()"
          @click="table.previousPage()"
        >
          Anterior
        </Button>
        <Button
          variant="outline"
          size="sm"
          :disabled="!table.getCanNextPage()"
          @click="table.nextPage()"
        >
          Siguiente
        </Button>
      </div>
    </div>
  </div>

      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { ref } from 'vue'


const breadcrumbs = [
  { title: 'Prospectos', href: '/prospectos' },
]

// Estados de carga
const consultandoRuc = ref(false)
const guardando = ref(false)

const page = usePage()




/*
import { Table, TableBody, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { toast } from 'vue-sonner'

const page = usePage()
const prospectos = ref(page.props.prospectos ?? [])
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
*/


import type {
  ColumnDef,
  ColumnFiltersState,
  ExpandedState,
  SortingState,
  VisibilityState,
} from '@tanstack/vue-table'
import {
  FlexRender,
  getCoreRowModel,
  getExpandedRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
  getSortedRowModel,
  useVueTable,
} from '@tanstack/vue-table'
import { ArrowUpDown, ChevronDown } from 'lucide-vue-next'
import { h } from 'vue'
import { valueUpdater } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Input } from '@/components/ui/input'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import DropdownAction from './components/DataTableDemoColumn.vue'
import { Prospecto } from './types/prospecto'

const data = ref(page.props.prospectos ?? [])

const columns: ColumnDef<Prospecto>[] = [
  {
    id: 'select',
    header: ({ table }) => h(Checkbox, {
      'modelValue': table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
      'onUpdate:modelValue': value => table.toggleAllPageRowsSelected(!!value),
      'ariaLabel': 'Select all',
    }),
    cell: ({ row }) => h(Checkbox, {
      'modelValue': row.getIsSelected(),
      'onUpdate:modelValue': value => row.toggleSelected(!!value),
      'ariaLabel': 'Select row',
    }),
    enableSorting: false,
    enableHiding: false,
  },
  /*{
    accessorKey: 'ruc',
    header: 'Ruc',
    cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('ruc')),
  },*/
  {
    accessorKey: 'ruc',
    header: ({ column }) => {
      return h(Button, {
        variant: 'ghost',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
      }, () => ['RUC', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
    },
    cell: ({ row }) => h('div', { class: '' }, row.getValue('ruc')),
  },
  {
    accessorKey: 'business_name',
    header: ({ column }) => {
      return h(Button, {
        variant: 'ghost',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
      }, () => ['Razón Social', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
    },
    cell: ({ row }) => h('div', { class: '' }, row.getValue('business_name')),
  },
  {
    accessorKey: 'address',
    header: ({ column }) => {
      return h(Button, {
        variant: 'ghost',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
      }, () => ['Dirección', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
    },
    cell: ({ row }) => h('div', { class: '' }, row.getValue('address')),
  },
  /* {
    accessorKey: 'amount',
    header: () => h('div', { class: 'text-right' }, 'Amount'),
    cell: ({ row }) => {
      const amount = Number.parseFloat(row.getValue('amount'))

      // Format the amount as a dollar amount
      const formatted = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
      }).format(amount)

      return h('div', { class: 'text-right font-medium' }, formatted)
    },
  }, */
  {
    id: 'actions',
    enableHiding: false,
    cell: ({ row }) => {
      const payment = row.original

      return h(DropdownAction, {
        payment,
        onExpand: row.toggleExpanded,
      })
    },
  },
]

const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})
const rowSelection = ref({})
const expanded = ref<ExpandedState>({})

const table = useVueTable({
  data,
  columns,
  getCoreRowModel: getCoreRowModel(),
  getPaginationRowModel: getPaginationRowModel(),
  getSortedRowModel: getSortedRowModel(),
  getFilteredRowModel: getFilteredRowModel(),
  getExpandedRowModel: getExpandedRowModel(),
  onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
  onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
  onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
  onRowSelectionChange: updaterOrValue => valueUpdater(updaterOrValue, rowSelection),
  onExpandedChange: updaterOrValue => valueUpdater(updaterOrValue, expanded),
  state: {
    get sorting() { return sorting.value },
    get columnFilters() { return columnFilters.value },
    get columnVisibility() { return columnVisibility.value },
    get rowSelection() { return rowSelection.value },
    get expanded() { return expanded.value },
  },
})



















</script>