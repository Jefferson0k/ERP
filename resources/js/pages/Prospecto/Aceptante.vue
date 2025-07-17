<template>
  <Head title="Comité" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="px-10 pb-10 mt-[67px]">

      <div id="divParaCopiar" class="mt-10">

      <div class="bg-purple-fincore rounded-t-xl p-5">
        <h1 class="m-0 text-white text-3xl font-bold inline-block">Nuevo Aceptante</h1>
        <Button @click="copiarAceptante" class="float-right text-white" variant="link" aria-label="Mostrar Billetera">
          +
        </Button>
        <Button v-if="aceptante" @click="mostrarAceptante" class="float-right" variant="link" aria-label="Mostrar Billetera">
          <ChevronUp class="w-4 h-4 mr-2 text-white" />
        </Button>
        <Button v-else @click="mostrarAceptante" class="float-right" variant="link" aria-label="Mostrar Billetera">
          <ChevronDown class="w-4 h-4 mr-2 text-white" />
        </Button>
      </div>
      
      <div class="inset-ring inset-ring-gray-100 rounded-t-none rounded-b-xl p-5">


          <!-- <form @submit.prevent="guardarProspecto" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"> -->

	        <div v-if="aceptante" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">

                    
            
            <FormField name="nombre" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Aceptante (Nombre)</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="nombre"/>
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>
            <FormField name="business_name" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Razón Social</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="business_name" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>
            <FormField name="activity_start_date" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Fecha de Inicio</FormLabel>
                <FormControl>
                  <Input type="date" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="activity_start_date" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>
            <FormField name="fecha_sentinel" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Fecha Sentinel</FormLabel>
                <FormControl>
                  <Input type="date" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="fecha_sentinel" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>
            <FormField name="cliente_situacion_sf" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Cliente Situación SF</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="cliente_situacion_sf" />
                </FormControl>
              </FormItem>
            </FormField>

            <FormField name="endeudamiento_bancario" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Endeud. Bancario</FormLabel>
                <FormControl>
                  <Input type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="endeudamiento_bancario" />
                </FormControl>
              </FormItem>
            </FormField>

            <FormField name="cuenta_con_protestos" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Protestos Si o No</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="cuenta_con_protestos" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="protestos" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Protestos</FormLabel>
                <FormControl>
                  <Input type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="protestos" />
                </FormControl>
              </FormItem>
            </FormField>

            
            <FormField name="rl_nombre" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">RL Nombre</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="rl_nombre" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="situacion_sf" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Situación SF</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="situacion_sf" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="edad" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Edad</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="edad" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="top" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Top</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="top" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="ventas_aproximadas" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Ventas Aprox.</FormLabel>
                <FormControl>
                  <Input type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="ventas_aproximadas" />
                </FormControl>
              </FormItem>
            </FormField>


            
            <FormField name="website" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Página Web</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="website"/>
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="entidad_apefac" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Entidades Apefac</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="entidad_apefac"/>
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="endeudamiento_apefac" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Endeud. Apefac</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="endeudamiento_apefac"/>
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="endeudamiento_pomedio_6_apefac" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Endeud. Prom. 6 M. Apefac</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="endeudamiento_pomedio_6_apefac"/>
                </FormControl>
              </FormItem>
            </FormField>

            <div class="col-span-2 md:col-span-4 lg:col-span-6 mt-3 text-center">
              <Button type="button" :disabled="guardando" class="bg-skyblue-fincore" @click="actualizarProspecto">
                {{ guardando ? 'Guardando...' : 'Guardar' }}
              </Button>
            </div>
          </div>
        </div>
      </div>
    </div>
        
<!--
      <div class="inset-ring inset-ring-gray-100 rounded-xl p-5 mt-10">

	        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">

            <div class="col-span-4">


              <div class="border-b border-gray-100 py-3 col-span-1 md:col-span-2 lg:col-span-3 mb-4">
                <h3 class="m-0 text-purple-fincore text-xl font-bold">Comentarios</h3>
              </div>

              <FormField name="comentarios_area_riesgos" v-slot="{ componentField }">
                <FormItem class="col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                  <FormLabel class="block">Comentarios Área de Riesgos</FormLabel>
                  <FormControl>
                    <Textarea rows="4" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="comentarios_area_riesgos" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="comentarios_area_comercial" v-slot="{ componentField }">
                <FormItem class="col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                  <FormLabel class="block">Comentarios Área de Comercial</FormLabel>
                  <FormControl>
                    <Textarea rows="4" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="comentarios_area_comercial" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField  name="comentarios_area_operaciones" v-slot="{ componentField }">
                <FormItem class="col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                  <FormLabel class="block">Comentarios Área de Operaciones</FormLabel>
                  <FormControl>
                    <Textarea rows="4" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="comentarios_area_operaciones" />
                  </FormControl>
                </FormItem>
              </FormField>
              
              <FormField  name="comentarios_area_operaciones" v-slot="{ componentField }">
                <FormItem class="col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                  <FormLabel class="block">Comentarios Remite Respuesta</FormLabel>
                  <FormControl>
                    <Textarea rows="4" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="comentarios_area_operaciones" />
                  </FormControl>
                </FormItem>
              </FormField>
            </div>

            <div class="col-span-2">

              <div class="border-b border-gray-100 py-3 col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                <h3 class="m-0 text-purple-fincore text-xl font-bold">Parametros Sugeridos</h3>
              </div>
              <FormField name="linea_cliente_sugerido" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Línea Aceptante</FormLabel>
                  <FormControl>
                    <Input type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="linea_cliente_sugerido" />
                  </FormControl>
                </FormItem>
              </FormField>

              <div class="border-b border-gray-100 py-3 col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                <h3 class="m-0 text-purple-fincore text-xl font-bold">Parametros Definitivos</h3>
              </div>
              <FormField name="linea_cliente_definitivo" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Línea Aceptante</FormLabel>
                  <FormControl>
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="linea_cliente_definitivo" />
                  </FormControl>
                </FormItem>
              </FormField>
            </div>
          
          -->












  </AppLayout>
</template>
<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { onMounted, ref } from 'vue'
import { FormField } from '@/components/ui/form'
import FormItem from '@/components/ui/form/FormItem.vue'
import FormLabel from '@/components/ui/form/FormLabel.vue'
import FormControl from '@/components/ui/form/FormControl.vue'
import Button from '@/components/ui/button/Button.vue'
import Input from '@/components/ui/input/Input.vue'
import { Textarea } from '@/components/ui/textarea'
import { useRoute } from 'ziggy-js'
import axios from 'axios'
import { ChevronDown, ChevronUp } from 'lucide-vue-next'


const breadcrumbs = [
  { title: 'Prospectos', href: '/prospectos' },
  { title: 'Prospecto', href: '/prospectos/prospecto' },
  { title: 'Aceptante', href: '/prospectos/prospecto/aceptante' },
]

const aceptante = ref(true)
const mostrarAceptante = () => {
    if (aceptante.value) {
        aceptante.value = false
    } else {
        aceptante.value = true
    }
}

const divToCopy = ref<HTMLElement | null>(null)

onMounted(() => {
  divToCopy.value = document.getElementById("divParaCopiar")
})

const copiarAceptante = () => {
  if (divToCopy.value) {
    const clonedDiv = divToCopy.value.cloneNode(true)
    const parent = divToCopy.value.parentNode
    if (parent) {
      parent.insertBefore(clonedDiv, divToCopy.value.nextSibling)
    }
  } else {
    console.error("No se encontró el div con ID 'divParaCopiar'")
  }
}


// Estados de carga
const guardando = ref(false)

const page = usePage()
const id = ref(page.props.id ?? [])
const prospecto = ref(page.props.prospecto ?? [])
const reporte = ref(page.props.reporte ?? [])


const nombre = ref()
const business_name = ref()
const activity_start_date = ref()
const fecha_sentinel = ref()
const cliente_situacion_sf = ref()
const endeudamiento_bancario = ref()
const cuenta_con_protestos = ref()
const protestos = ref()
const rl_nombre = ref()
const situacion_sf = ref()
const edad = ref()
const top = ref()
const ventas_aproximadas = ref()
const website = ref()
const entidad_apefac = ref()
const endeudamiento_apefac = ref()
const endeudamiento_pomedio_6_apefac = ref()
/*const comentarios_area_riesgos = ref()
const comentarios_area_comercial = ref()
const linea_cliente_sugerido = ref()
const linea_cliente_definitivo = ref()*/

const actualizarProspecto = async () =>  {
    try {
        const res = await axios.post(`/api/prospecto/guardar-aceptante/${id.value}`, {
          nombre: nombre.value,
          business_name: business_name.value,
          activity_start_date: activity_start_date.value,
          fecha_sentinel: fecha_sentinel.value,
          cliente_situacion_sf: cliente_situacion_sf.value,
          endeudamiento_bancario: endeudamiento_bancario.value,
          cuenta_con_protestos: cuenta_con_protestos.value,
          protestos: protestos.value,
          rl_nombre: rl_nombre.value,
          situacion_sf: situacion_sf.value,
          edad: edad.value,
          top: top.value,
          ventas_aproximadas: ventas_aproximadas.value,
          website: website.value,
          entidad_apefac: entidad_apefac.value,
          endeudamiento_apefac: endeudamiento_apefac.value,
          endeudamiento_pomedio_6_apefac: endeudamiento_pomedio_6_apefac.value,
          /*comentarios_area_riesgos: comentarios_area_riesgos.value,
          comentarios_area_comercial: comentarios_area_comercial.value,
          linea_cliente_sugerido: linea_cliente_sugerido.value,
          linea_cliente_definitivo: linea_cliente_definitivo.value,*/
        })

        if (res.status === 200 || res.status === 201) {
            //router.visit('/comite')
        }
    } catch (err: any) {
        console.error('Error al guardar reporte:', err)
    }
}


</script>