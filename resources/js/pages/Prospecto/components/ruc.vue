<template>
    <form @submit.prevent="guardarProspecto" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          

          <!-- <p class="text-black-fincore text-sm mb-0">Selecciona el tipo de producto:</p>
          <Select v-model="tipoProductoElegido">
            <FormField name="tipo">
              <SelectTrigger className="w-full border border-gray-200 rounded-lg focus:border-gray-200 text-start h-[36px] py-[4px] px-3 mb-[20px] active:border-gray-200 col-span-1 md:col-span-2 lg:col-span-3">
                <SelectValue placeholder="Tipo de producto"/>
              </SelectTrigger>
              <SelectContent>
                <SelectGroup>
                  <SelectLabel>Elige el tipo</SelectLabel>
                  <SelectItem v-for="item in tipoProducto" :key="item" :value="item" class="">
                    {{ item }}
                  </SelectItem>
                </SelectGroup>
              </SelectContent>
            </FormField>
          </Select> -->
          <FormField name="tipo" v-slot="{ componentField }">
            <FormItem class="col-span-1 md:col-span-2 lg:col-span-3">
              <FormLabel class="block">Selecciona el tipo de producto:</FormLabel>
              <FormControl>
                <Select v-model="tipoProductoElegido">
                  <SelectTrigger className="w-full border border-gray-200 rounded-lg text-start h-[36px] py-[4px] px-3 mb-[20px] active:border-gray-200">
                    <SelectValue placeholder="Tipo de producto"/>
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectLabel>Elige el tipo</SelectLabel>
                      <SelectItem v-for="item in tipoProducto" :key="item" :value="item">
                        {{ item }}
                      </SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
              </FormControl>
              <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                {{ componentField.errorMessage }}
              </p>
            </FormItem>
          </FormField>

            <FormField name="ruc" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">RUC <span class="text-red-600">*</span></FormLabel>
                <FormControl>
                  <Input id="ruc" v-bind="componentField" @blur="consultarRuc" @keyup.enter="consultarRuc"
                    class="w-full shadow-none rounded-lg border-gray-200" :disabled="consultandoRuc" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
                <p v-if="consultandoRuc" class="text-blue-600 text-sm mt-1">
                  Consultando RUC...
                </p>
              </FormItem>
            </FormField>



            <FormField name="activity_start_date" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Fecha de Inscripción</FormLabel>
                <FormControl>
                  <Input type="date" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>


            
            <FormField name="sales_executive" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Ejecutivo Comercial</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>


            

            <FormField  name="business_name" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Razón Social <span class="text-red-600">*</span></FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" disabled v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>


            <FormField  name="trade_name" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Nombre Comercial</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" disabled v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>


            <!-- SIN CAMPO -->
            <FormField  name="activity_start_date" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Inicio de actividad</FormLabel>
                <FormControl>
                  <Input type="date" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>



            

            <FormField  name="address" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Dirección <span class="text-red-600">*</span></FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" disabled v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>

            <FormField  name="economic_activity" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Actividad Económica</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" disabled v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>

            

        
            

            <FormField name="expected_rate" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Tasa Esperada (%)</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" type="number" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>
            
            <FormField name="commission" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Comisión (%)</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" type="number" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>


      <div class="border-b border-gray-100 py-3 col-span-1 md:col-span-2 lg:col-span-3 mb-2">
        <h3 class="m-0 text-purple-fincore text-xl font-bold">Datos de contacto</h3>
      </div>


            <FormField name="dni" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">DNI</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>

            
            <FormField name="nombre" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Nombres y Apellidos</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>




            <FormField name="position" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Cargo</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>


            <FormField name="email" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Correo Electrónico</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
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
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>

            <FormField name="numero_movil" v-slot="{ componentField }">
              <FormItem>
                <FormLabel class="block">Número Móvil</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>
            
            
            
            <FormField  name="notes" v-slot="{ componentField }">
              <FormItem class="col-span-1 md:col-span-2 lg:col-span-3">
                <FormLabel class="block">Observaciones</FormLabel>
                <FormControl>
                  <Textarea rows="4" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>

            <!-- Botones -->
            <div class="col-span-1 md:col-span-2 lg:col-span-3 mt-3 text-center">
              <!--- <Button type="reset" variant="destructive" class="bg" @click="resetForm">Eliminar</Button> -->
              <Button type="submit" :disabled="guardando" class="bg-skyblue-fincore">
                {{ guardando ? 'Guardando...' : 'Guardar' }}
              </Button>

              <Button v-if="botonSubirReporte" type="button" class="ms-5 bg-skyblue-fincore" @click="router.visit(`/prospectos/prospecto/reporte/${idProspecto}`)">
                {{ guardando ? 'Guardando...' : 'Subir Reporte' }}
              </Button>
              <Button v-if="botonAceptante" type="button" class="ms-5 bg-skyblue-fincore" @click="router.visit(`/prospectos/prospecto/aceptante/${idProspecto}`)">
                {{ guardando ? 'Guardando...' : 'Aceptante' }}
              </Button>
            </div>
          </form>


</template>

<script setup lang="ts">
import {  router } from '@inertiajs/vue3'
import { toast } from 'vue-sonner'
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import axios from 'axios'
import { ref } from 'vue'

import {
  FormField, FormItem, FormLabel, FormControl
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { Textarea } from '@/components/ui/textarea'
import { Button } from '@/components/ui/button'
//import type { ProspectoRequest, ProspectoCreateResponse } from '@/prospecto/types/prospecto'

import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select"
import { UploadCloud } from 'lucide-vue-next'
import type { ProspectoRucRequest, ProspectoCreateResponse } from '../types/prospecto'

const breadcrumbs = [
  { title: 'Prospecto', href: '/prospecto' },
]

// Estados de carga
const consultandoRuc = ref(false)
const guardando = ref(false)

const tipoDocumentoElegido = ref('')
const tipoDocumento = ref(
  ['DNI', 'RUC', 'Carnet Extranjería']
)
const tipoProducto = ref(
  ['Factoring', 'Confirming']
)
const tipoProductoElegido = ref('')
const name = ref('')

const formSchema = toTypedSchema(z.object({
  tipo: z.string(),
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

  dni: z.string().optional(), //tony
  nombre: z.string().optional(), //tony
  numero_movil: z.string().optional(), //tony
}))

const { handleSubmit, resetForm, values, setFieldValue, setFieldError } = useForm<ProspectoRucRequest>({
  validationSchema: formSchema,
  initialValues: {
    ruc: '',
    tipo: '',
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

    dni: '', //tony
    nombre: '', //tony
    numero_movil: '', //tony
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

const idProspecto = ref(0)
const botonSubirReporte = ref(false)
const botonAceptante = ref(false)

const guardarProspecto = handleSubmit(async (formData) => {
  guardando.value = true

  try {
    const res = await axios.post<ProspectoCreateResponse>('/api/prospecto/guardar_ruc', formData)

    if (res.status === 200 || res.status === 201) {
      toast.success(res.data.message || 'Prospecto guardado exitosamente')
      idProspecto.value = res.data.id
      botonSubirReporte.value = true
      botonAceptante.value = true
      //router.visit(`/prospectos/prospecto/reporte/${res.data.id}`)
    }
  } catch (err: any) {
    console.error('Error al guardar prospecto:', err)

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
      toast.error('El prospecto ya existe en el sistema')
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
      toast.error(err?.response?.data?.message || 'Error al guardar el prospecto')
    }
  } finally {
    guardando.value = false
  }
})
</script>