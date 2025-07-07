<template>

  <Head title="Nuevo proveedor" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-2">
      <Card class="mt-4 flex flex-col gap-4">
        <CardHeader>
          <CardTitle>Nuevo Proveedor</CardTitle>
          <CardDescription>Complete los campos y consulte el RUC para autocompletar</CardDescription>
        </CardHeader>
        <CardContent>
          <form @submit.prevent="guardarProveedor" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- RUC -->
            <FormField name="ruc" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">RUC <span class="text-red-600">*</span></FormLabel>
                <FormControl>
                  <Input id="ruc" v-bind="componentField" @blur="consultarRuc" @keyup.enter="consultarRuc"
                    class="w-full" :disabled="consultandoRuc" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
                <p v-if="consultandoRuc" class="text-blue-600 text-sm mt-1">
                  Consultando RUC...
                </p>
              </FormItem>
            </FormField>

            <!-- Campos autocompletados -->
            <FormField name="business_name" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Razón Social <span class="text-red-600">*</span></FormLabel>
                <FormControl>
                  <Input class="w-full" disabled v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>

            <FormField name="trade_name" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Nombre Comercial</FormLabel>
                <FormControl>
                  <Input class="w-full" disabled v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>

            <FormField name="address" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Dirección <span class="text-red-600">*</span></FormLabel>
                <FormControl>
                  <Input class="w-full" disabled v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>

            <FormField name="economic_activity" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Actividad Económica</FormLabel>
                <FormControl>
                  <Input class="w-full" disabled v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>

            <FormField name="activity_start_date" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Fecha de Inicio de Actividades</FormLabel>
                <FormControl>
                  <Input type="date" class="w-full" v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>

            <!-- Campos editables -->
            <FormField name="email" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Correo Electrónico</FormLabel>
                <FormControl>
                  <Input class="w-full" v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>

            <FormField name="website" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Sitio Web</FormLabel>
                <FormControl>
                  <Input class="w-full" v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>

            <FormField name="sales_executive" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Ejecutivo de Ventas</FormLabel>
                <FormControl>
                  <Input class="w-full" v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>

            <FormField name="contact_person" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Persona de Contacto</FormLabel>
                <FormControl>
                  <Input class="w-full" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>

            <FormField name="position" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Cargo</FormLabel>
                <FormControl>
                  <Input class="w-full" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>

            <FormField name="expected_rate" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Tasa Esperada (%)</FormLabel>
                <FormControl>
                  <Input class="w-full" type="number" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>

            <FormField name="commission" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Comisión (%)</FormLabel>
                <FormControl>
                  <Input class="w-full" type="number" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>

            <FormField name="notes" v-slot="{ componentField }">
              <FormItem class="md:col-span-2">
                <FormLabel class="block">Notas</FormLabel>
                <FormControl>
                  <Textarea rows="4" class="w-full" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>

            <!-- Botones -->
            <div class="flex justify-end gap-4 md:col-span-2 mt-4">
              <Button type="reset" variant="destructive" @click="resetForm">Eliminar</Button>
              <Button type="submit" :disabled="guardando">
                {{ guardando ? 'Guardando...' : 'Enviar' }}
              </Button>
            </div>
          </form>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { toast } from 'vue-sonner'
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import axios from 'axios'
import { ref } from 'vue'

import {
  Card, CardHeader, CardTitle, CardDescription, CardContent,
} from '@/components/ui/card'
import {
  FormField, FormItem, FormLabel, FormControl
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { Textarea } from '@/components/ui/textarea'
import { Button } from '@/components/ui/button'
import type { SupplierRequest, SupplierCreateResponse } from '@/types/supplier'

const breadcrumbs = [
  { title: 'Proveedores', href: '/Supplier' },
  { title: 'Crear proveedor', href: '/Supplier/create' },
]

// Estados de carga
const consultandoRuc = ref(false)
const guardando = ref(false)

const formSchema = toTypedSchema(z.object({
  ruc: z.string().length(11, 'RUC debe tener 11 dígitos'),
  business_name: z.string().min(1, 'Requerido'),
  trade_name: z.string().optional(),
  address: z.string().min(1, 'Requerido'),
  economic_activity: z.string().optional(),
  activity_start_date: z.string().optional(),
  email: z.string().email('Correo inválido').optional().or(z.literal('')),
  website: z.string().url('URL inválida').optional().or(z.literal('')),
  sales_executive: z.string().min(1, 'Requerido'),
  contact_person: z.string().optional(),
  position: z.string().optional(),
  expected_rate: z.coerce.number().optional(),
  commission: z.coerce.number().optional(),
  notes: z.string().optional(),
}))

const { handleSubmit, resetForm, values, setFieldValue, setFieldError } = useForm<SupplierRequest>({
  validationSchema: formSchema,
  initialValues: {
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
    expected_rate: 0,
    commission: 0,
    notes: '',
  }
})

const consultarRuc = async () => {
  if (!values.ruc || values.ruc.length !== 11) {
    toast.error('El RUC debe tener 11 dígitos')
    return
  }

  if (!/^\d{11}$/.test(values.ruc)) {
    toast.error('El RUC debe contener solo números')
    return
  }

  consultandoRuc.value = true

  try {
    const { data } = await axios.get(`/api/consultas/ruc/${values.ruc}`)

    if (!data || Object.keys(data).length === 0) {
      toast.error('RUC no encontrado o no existe')
      return
    }

    if (data.estado && data.estado.toLowerCase() === 'inactivo') {
      toast.warning('El RUC está inactivo')
    }

    if (!data.razonSocial && !data.tipo && !data.direccion) {
      toast.error('No se encontró información para este RUC')
      return
    }

    if (data.razonSocial) {
      setFieldValue('business_name', data.razonSocial)
    }
    if (data.tipo) {
      setFieldValue('trade_name', data.tipo)
    }
    if (data.direccion) {
      setFieldValue('address', data.direccion)
    }
    if (data.actividadEconomica) {
      setFieldValue('economic_activity', data.actividadEconomica)
    }
    if (data.inicioActividades) {
      setFieldValue('activity_start_date', data.inicioActividades)
    }

    toast.success('Datos del RUC cargados correctamente')
  } catch (err: any) {
    console.error('Error al consultar RUC:', err)

    if (err?.response?.status === 404) {
      toast.error('RUC no encontrado')
    } else if (err?.response?.status === 429) {
      toast.error('Demasiadas consultas. Intente más tarde')
    } else if (err?.response?.status === 500) {
      toast.error('Error del servidor. Intente más tarde')
    } else if (err?.code === 'NETWORK_ERROR' || !navigator.onLine) {
      toast.error('Error de conexión. Verifique su internet')
    } else {
      toast.error(err?.response?.data?.message || 'Error al consultar el RUC')
    }
  } finally {
    consultandoRuc.value = false
  }
}

const guardarProveedor = handleSubmit(async (formData) => {
  guardando.value = true

  try {
    const res = await axios.post<SupplierCreateResponse>('/Supplier', formData)

    if (res.status === 200 || res.status === 201) {
      toast.success(res.data.message || 'Proveedor guardado exitosamente')
      setTimeout(() => {
        router.visit('/Panel/comite')
      }, 1500)
    }
  } catch (err: any) {
    console.error('Error al guardar proveedor:', err)

    if (err?.response?.status === 422) {
      if (err?.response?.data?.errors) {
        const errors = err.response.data.errors

        Object.keys(errors).forEach(field => {
          const errorMessage = Array.isArray(errors[field]) ? errors[field][0] : errors[field]
          setFieldError(field, errorMessage)
        })

        toast.error('Por favor corrija los errores en el formulario')
      } else {
        toast.error('Datos inválidos. Verifique la información')
      }
    }
    else if (err?.response?.status === 409) {
      toast.error('El proveedor ya existe en el sistema')
    }
    else if (err?.response?.status === 500) {
      toast.error('Error del servidor. Intente más tarde')
    }
    else if (err?.code === 'NETWORK_ERROR' || !navigator.onLine) {
      toast.error('Error de conexión. Verifique su internet')
    }
    else if (err?.code === 'TIMEOUT') {
      toast.error('La operación tomó demasiado tiempo. Intente de nuevo')
    }
    else {
      toast.error(err?.response?.data?.message || 'Error al guardar el proveedor')
    }
  } finally {
    guardando.value = false
  }
})
</script>