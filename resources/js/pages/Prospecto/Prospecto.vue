<template>

  <Head title="Nuevo Prospecto" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col rounded-xl p-10 mt-[67px]">

      <div class="bg-purple-fincore rounded-t-xl p-5">
        <h1 class="m-0 text-white text-3xl font-bold">Nuevo Prospecto</h1>
      </div>

      <Card class="flex flex-col gap-0 inset-ring inset-ring-gray-50 shadow-none rounded-t-none rounded-b-xl mb-10 py-5">
        <CardHeader>
          <CardDescription class="text-black-fincore font-medium">Selecciona el tipo de documento:</CardDescription>
        </CardHeader>
        <CardContent>

          <Select v-model="tipoDocumentoElegido">
            <SelectTrigger className="w-full border border-gray-200 rounded-lg focus:border-gray-200 text-start h-[36px] py-[4px] px-3 mb-[20px] active:border-gray-200 col-span-1 md:col-span-2 lg:col-span-3">
              <SelectValue placeholder="Tipo de documento"/>
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectLabel>Elige el tipo</SelectLabel>
                <SelectItem v-for="item in tipoDocumento" :key="item" :value="item" class="">
                  {{ item }}
                </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>

          <Ruc v-if="tipoDocumentoElegido === 'RUC'" class="col-span-1 md:col-span-2 lg:col-span-3" />
          <Dni v-if="tipoDocumentoElegido === 'DNI'" class="col-span-1 md:col-span-2 lg:col-span-3" />
          <Ce v-if="tipoDocumentoElegido === 'Carnet Extranjería'" class="col-span-1 md:col-span-2 lg:col-span-3" />

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
import type { ProspectoRequest, ProspectoCreateResponse } from '@/types/prospecto'

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
import Ruc from './components/ruc.vue'
import Dni from './components/dni.vue'
import Ce from './components/ce.vue'

const breadcrumbs = [
  { title: 'Prospectos', href: '/prospectos' },
  { title: 'Prospecto', href: '/prospectos/prospecto' },
]

// Estados de carga
const consultandoRuc = ref(false)
const guardando = ref(false)


const tipoDocumento = ref(
  ['DNI', 'RUC', 'Carnet Extranjería']
)
const tipoDocumentoElegido = ref('')
const tipoProducto = ref(
  ['Factoring', 'Confirming']
)
const tipoProductoElegido = ref('')
const name = ref('')

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

  dni: z.string().length(8, 'DNI debe tener 8 dígitos').optional(), //tony
  ce: z.string().optional(), //tony
}))

const { handleSubmit, resetForm, values, setFieldValue, setFieldError } = useForm<ProspectoRequest>({
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

    dni: '', //tony
    ce: '', //tony
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

const guardarProspecto = handleSubmit(async (formData) => {
  guardando.value = true

  try {
    const res = await axios.post<ProspectoCreateResponse>('/Supplier', formData)

    if (res.status === 200 || res.status === 201) {
      toast.success(res.data.message || 'Prospecto guardado exitosamente')
      //setTimeout(() => {
        router.visit('/prospectos/prospecto/reporte')
      //}, 1500)
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