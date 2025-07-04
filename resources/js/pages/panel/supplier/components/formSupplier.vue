<template>
  <Head title="Nuevo proveedor" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-1 flex-col gap-4 p-4">
      <Card class="mt-4">
        <CardHeader>
          <CardTitle>Nuevo Proveedor</CardTitle>
          <CardDescription>Complete los campos y consulte el RUC para autocompletar</CardDescription>
        </CardHeader>
        <CardContent>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- RUC (autocompleta) -->
            <div>
              <Label for="ruc">RUC</Label>
              <Input id="ruc" v-model="form.ruc" @blur="consultarRuc" class="w-full" />
            </div>

            <div>
              <Label for="razon">Razón Social</Label>
              <Input id="razon" v-model="form.business_name" class="w-full" readonly />
            </div>

            <div>
              <Label for="comercial">Nombre Comercial</Label>
              <Input id="comercial" v-model="form.trade_name" class="w-full" readonly />
            </div>

            <div>
              <Label for="direccion">Dirección</Label>
              <Input id="direccion" v-model="form.address" class="w-full" readonly />
            </div>

            <div>
              <Label for="actividad">Actividad Económica</Label>
              <Input id="actividad" v-model="form.economic_activity" class="w-full" readonly />
            </div>

            <div>
              <Label for="inicio">Inicio de Actividades</Label>
              <Input id="inicio" v-model="form.activity_start_date" type="date" class="w-full" readonly />
            </div>

            <!-- Otros campos editables -->
            <div>
              <Label for="email">Correo Electrónico</Label>
              <Input id="email" v-model="form.email" class="w-full" />
            </div>

            <div>
              <Label for="website">Sitio Web</Label>
              <Input id="website" v-model="form.website" class="w-full" />
            </div>

            <div>
              <Label for="sales">Ejecutivo de Ventas</Label>
              <Input id="sales" v-model="form.sales_executive" class="w-full" />
            </div>

            <div>
              <Label for="contacto">Persona de Contacto</Label>
              <Input id="contacto" v-model="form.contact_person" class="w-full" />
            </div>

            <div>
              <Label for="cargo">Cargo</Label>
              <Input id="cargo" v-model="form.position" class="w-full" />
            </div>

            <div>
              <Label for="tasa">Tasa Esperada (%)</Label>
              <Input id="tasa" v-model="form.expected_rate" class="w-full" />
            </div>

            <div>
              <Label for="comision">Comisión (%)</Label>
              <Input id="comision" v-model="form.commission" class="w-full" />
            </div>

            <!-- Notas -->
            <div class="md:col-span-2">
              <Label for="notas">Notas</Label>
              <Textarea id="notas" v-model="form.notes" rows="4" class="w-full" />
            </div>
          </div>

          <!-- Botones -->
          <div class="flex justify-end gap-4 mt-6">
            <Button variant="outline" @click="resetForm" class="bg-red-500 text-white hover:bg-red-600">
              Eliminar
            </Button>
            <Button @click="guardarProveedor" class="bg-blue-600 text-white hover:bg-blue-700">
              Enviar
            </Button>
          </div>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import axios from 'axios'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { toast } from 'vue-sonner'

import {
  Card,
  CardHeader,
  CardTitle,
  CardDescription,
  CardContent,
} from '@/components/ui/card'

import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import { Button } from '@/components/ui/button'

const breadcrumbs = [
  { title: 'Proveedores', href: '/Supplier' },
  { title: 'Crear proveedor', href: '/Supplier/create' },
]

const form = ref({
  ruc: '',
  business_name: '',
  trade_name: '',
  address: '',
  economic_activity: '',
  activity_start_date: '',
  email: '',
  website: '',
  sales_executive: '',
  contact_person: '',
  position: '',
  expected_rate: '',
  commission: '',
  notes: '',
})

const consultarRuc = async () => {
  const ruc = form.value.ruc
  if (!ruc || ruc.length !== 11) {
    toast.error('El RUC debe tener 11 dígitos')
    return
  }

  try {
    const { data } = await axios.get(`/api/consultas/ruc/${ruc}`)

    form.value.business_name = data.razonSocial
    form.value.trade_name = data.tipo || ''
    form.value.address = data.direccion
    form.value.economic_activity = data.actividadEconomica
    form.value.activity_start_date = '' // Si tu API trae esto, asigna aquí

    toast.success('Datos cargados correctamente')
  } catch (err) {
    toast.error('Error al consultar el RUC')
  }
}

const guardarProveedor = () => {
  // Aquí podrías hacer axios.post() o Inertia.post()
  console.log('Guardando proveedor:', form.value)
  toast.success('Proveedor guardado correctamente')
}

const resetForm = () => {
  Object.keys(form.value).forEach(k => form.value[k] = '')
  toast('Formulario reiniciado')
}
</script>
