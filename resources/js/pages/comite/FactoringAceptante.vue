<template>
  <Head title="Comité" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="px-10 pb-10 mt-[67px]">

      <div id="divParaCopiar" class="mt-10">

      <div class="bg-purple-fincore rounded-t-xl p-5">
        <h1 class="m-0 text-white text-3xl font-bold inline-block">Comité Factoring Aceptante(s)</h1>
      </div>
      
      <div class="inset-ring inset-ring-gray-100 rounded-t-none rounded-b-xl p-5">

  <Accordion type="single" class="w-full" collapsible>
    <AccordionItem v-for="item in prospecto" :key="item.id" :value="item.id">
      <AccordionTrigger class="text-lg">Aceptante: {{ item.nombre }}</AccordionTrigger>
      <AccordionContent class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <FormField name="nombre" v-slot="{ componentField }">
          <FormItem class="col-span-2">
            <FormLabel class="block">Aceptante (Nombre)</FormLabel>
            <FormControl>
              <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.nombre"/>
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
              <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.business_name" />
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
              <Input type="date" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="item.activity_start_date" />
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
              <Input type="date" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.fecha_sentinel" />
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
              <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.cliente_situacion_sf" />
            </FormControl>
          </FormItem>
        </FormField>
        <FormField name="endeudamiento_bancario" v-slot="{ componentField }">
          <FormItem class="col-span-2">
            <FormLabel class="block">Endeud. Bancario</FormLabel>
            <FormControl>
              <Input type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.endeudamiento_bancario" />
            </FormControl>
          </FormItem>
        </FormField>
        <FormField name="cuenta_con_protestos" v-slot="{ componentField }">
          <FormItem class="col-span-2">
            <FormLabel class="block">Protestos Si o No</FormLabel>
            <FormControl>
              <Input type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.cuenta_con_protestos" />
            </FormControl>
          </FormItem>
        </FormField>
        <FormField name="protestos" v-slot="{ componentField }">
          <FormItem class="col-span-2">
            <FormLabel class="block">Protestos</FormLabel>
            <FormControl>
              <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.protestos" />
            </FormControl>
          </FormItem>
        </FormField>
        <FormField name="rl_nombre" v-slot="{ componentField }">
          <FormItem class="col-span-2">
            <FormLabel class="block">RL Nombre</FormLabel>
            <FormControl>
              <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.rl_nombre" />
            </FormControl>
          </FormItem>
        </FormField>
        <FormField name="situacion_sf" v-slot="{ componentField }">
          <FormItem class="col-span-2">
            <FormLabel class="block">Situación SF</FormLabel>
            <FormControl>
              <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.situacion_sf" />
            </FormControl>
          </FormItem>
        </FormField>
        <FormField name="edad" v-slot="{ componentField }">
          <FormItem class="col-span-2">
            <FormLabel class="block">Edad</FormLabel>
            <FormControl>
              <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.edad" />
            </FormControl>
          </FormItem>
        </FormField>
        <FormField name="top" v-slot="{ componentField }">
          <FormItem class="col-span-2">
            <FormLabel class="block">Top</FormLabel>
            <FormControl>
              <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.top" />
            </FormControl>
          </FormItem>
        </FormField>
        <FormField name="ventas_aproximadas" v-slot="{ componentField }">
          <FormItem class="col-span-2">
            <FormLabel class="block">Ventas Aprox.</FormLabel>
            <FormControl>
              <Input type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.ventas_aproximadas" />
            </FormControl>
          </FormItem>
        </FormField>
        <FormField name="website" v-slot="{ componentField }">
          <FormItem class="col-span-2">
            <FormLabel class="block">Página Web</FormLabel>
            <FormControl>
              <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.website"/>
            </FormControl>
          </FormItem>
        </FormField>
        <FormField name="entidad_apefac" v-slot="{ componentField }">
          <FormItem class="col-span-2">
            <FormLabel class="block">Entidades Apefac</FormLabel>
            <FormControl>
              <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.entidad_apefac"/>
            </FormControl>
          </FormItem>
        </FormField>
        <FormField name="endeudamiento_apefac" v-slot="{ componentField }">
          <FormItem class="col-span-2">
            <FormLabel class="block">Endeud. Apefac</FormLabel>
            <FormControl>
              <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.endeudamiento_apefac"/>
            </FormControl>
          </FormItem>
        </FormField>
        <FormField name="endeudamiento_pomedio_6_apefac" v-slot="{ componentField }">
          <FormItem class="col-span-2">
            <FormLabel class="block">Endeud. Prom. 6 M. Apefac</FormLabel>
            <FormControl>
              <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="item.endeudamiento_pomedio_6_apefac"/>
            </FormControl>
          </FormItem>
        </FormField>
      </AccordionContent>
    </AccordionItem>
  </Accordion>

 
        </div>



      </div>
        

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
                    <Textarea rows="4" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="prospecto[0].comentarios_area_riesgos" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="comentarios_area_comercial" v-slot="{ componentField }">
                <FormItem class="col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                  <FormLabel class="block">Comentarios Área de Comercial</FormLabel>
                  <FormControl>
                    <Textarea rows="4" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="prospecto[0].comentarios_area_comercial" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField  name="comentarios_area_operaciones" v-slot="{ componentField }">
                <FormItem class="col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                  <FormLabel class="block">Comentarios Área de Operaciones</FormLabel>
                  <FormControl>
                    <Textarea rows="4" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="prospecto[0].comentarios_area_operaciones" />
                  </FormControl>
                </FormItem>
              </FormField>
              
              <FormField  name="comentarios_area_operaciones" v-slot="{ componentField }">
                <FormItem class="col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                  <FormLabel class="block">Comentarios Remite Respuesta</FormLabel>
                  <FormControl>
                    <Textarea rows="4" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="prospecto[0].comentarios_area_operaciones" />
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
                    <Input type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].linea_cliente_sugerido" />
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
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].linea_cliente_definitivo" />
                  </FormControl>
                </FormItem>
              </FormField>
            </div>





            <div class="col-span-2 md:col-span-4 lg:col-span-6 mt-3 text-center">
              <Button type="button" :disabled="guardando" class="bg-skyblue-fincore" @click="actualizarProspecto">
                {{ guardando ? 'Guardando...' : 'Guardar' }}
              </Button>
            </div>
          </div>



</div>



    </div>
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
import ListaAceptantes from './components/listaAceptantes.vue'
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion'

const breadcrumbs = [
  { title: 'Listado de Prospectos', href: '/comite' },
  { title: 'Comité Factoring Cliente', href: '/comite/factoring/cliente' },
]


// Estados de carga
const guardando = ref(false)

const page = usePage()
const id = ref(page.props.id ?? [])
const prospecto = ref(page.props.prospecto ?? [])

//const defaultValue = 'item-1'

const actualizarProspecto = async () =>  {
    console.log(prospecto.value[0].id)
    console.log(prospecto.value[1].id)
    console.log(prospecto.value.length)
    try {
        const res = await axios.post(`/api/comite/actualizar/${id.value}`, {
          /*nombre: prospecto.value[0].nombre,
          business_name: prospecto.value[0].business_name,
          activity_start_date: prospecto.value[0].activity_start_date,
          fecha_sentinel: prospecto.value[0].fecha_sentinel,
          cliente_situacion_sf: prospecto.value[0].cliente_situacion_sf,
          endeudamiento_bancario: prospecto.value[0].endeudamiento_bancario,
          cuenta_con_protestos: prospecto.value[0].cuenta_con_protestos,
          protestos: prospecto.value[0].protestos,
          rl_nombre: prospecto.value[0].rl_nombre,
          situacion_sf: prospecto.value[0].situacion_sf,
          edad: prospecto.value[0].edad,
          top: prospecto.value[0].top,
          ventas_aproximadas: prospecto.value[0].ventas_aproximadas,
          website: prospecto.value[0].website,
          entidad_apefac: prospecto.value[0].entidad_apefac,
          endeudamiento_apefac: prospecto.value[0].endeudamiento_apefac,
          endeudamiento_pomedio_6_apefac: prospecto.value[0].endeudamiento_pomedio_6_apefac,
          comentarios_area_riesgos: prospecto.value[0].comentarios_area_riesgos,
          comentarios_area_comercial: prospecto.value[0].comentarios_area_comercial,
          comentarios_area_operaciones: prospecto.value[0].comentarios_area_operaciones,
          linea_cliente_sugerido: prospecto.value[0].linea_cliente_sugerido,
          linea_cliente_definitivo: prospecto.value[0].linea_cliente_definitivo,*/
          prospecto: prospecto.value,
        })

        if (res.status === 200 || res.status === 201) {
            //router.visit('/comite')
        }
    } catch (err: any) {
        console.error('Error al guardar reporte:', err)
    }
}


</script>