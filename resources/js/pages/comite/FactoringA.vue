<template>
  <Head title="Comité" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-10 mt-[67px]">

      <div class="bg-purple-fincore rounded-t-xl p-5">
        <h1 class="m-0 text-white text-3xl font-bold">Comité Factoring Cliente</h1>
      </div>
      
      <div class="inset-ring inset-ring-gray-100 rounded-t-none rounded-b-xl p-5">



<!-- <form @submit.prevent="guardarProspecto" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"> -->
	<form class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            
            <FormField name="sales_executive" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Cliente (Razón Social)</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="prospecto[0].business_name" />
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
                  <Input type="date" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="prospecto[0].activity_start_date" />
                </FormControl>
                <p v-if="componentField.errorMessage" class="text-red-600 text-sm mt-1">
                  {{ componentField.errorMessage }}
                </p>
              </FormItem>
            </FormField>
            <FormField name="total_activos" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Activos</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="reporte.total_activos" />
                </FormControl>
              </FormItem>
            </FormField>

            <FormField name="total_pasivo" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Pasivos</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="reporte.total_pasivo" />
                </FormControl>
              </FormItem>
            </FormField>

            <FormField name="capital_social" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Capital Social</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="reporte.capital_social" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="total_patrimonio" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Patrimonio</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="reporte.total_patrimonio" />
                </FormControl>
              </FormItem>
            </FormField>

            
            <FormField name="ingresos_netos" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Ingr. Últi. Año</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="reporte.ingresos_netos" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="resultado_bruto" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Utilidad</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="reporte.resultado_bruto" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="ingreso_12_meses" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Ingreso 12 Meses</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="reporte.ingreso_12_meses" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="ingreso_6meses" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Ingreso 6 Meses</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="reporte.ingreso_6_meses" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="promedio_ingreso_12_meses" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Prom. Ingre. 12 Meses</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="reporte.promedio_ingreso_12_meses" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="promedio_ingreso_6_meses" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Prom. Ingre. 6 Meses</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" disabled v-model="reporte.promedio_ingreso_6_meses" />
                </FormControl>
              </FormItem>
            </FormField>


            
            <FormField name="nombre" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Entidad Apefac</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="nombre" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Endeud. Apefac</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="nombre" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Endeud. Prom. 6 M. Apefac</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="nombre" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Cliente Situación SF</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="nombre" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Endeud. Bancario</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="nombre" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Cuenta con Protestos</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="nombre" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Protestos</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="nombre" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">RL Nombre</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="nombre" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Situación SF</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="nombre" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Edad</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                </FormControl>
              </FormItem>
            </FormField>

            <div class="col-span-2 md:col-span-4 lg:col-span-6"></div>

            <div class="col-span-2">


              <div class="border-b border-gray-100 py-3 col-span-1 md:col-span-2 lg:col-span-3 mb-4">
                <h3 class="m-0 text-purple-fincore text-xl font-bold">Comentarios</h3>
              </div>

              <FormField  name="notes" v-slot="{ componentField }">
                <FormItem class="col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                  <FormLabel class="block">Comentarios Área de Riesgos</FormLabel>
                  <FormControl>
                    <Textarea rows="4" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField  name="notes" v-slot="{ componentField }">
                <FormItem class="col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                  <FormLabel class="block">Comentarios Área de Comercial</FormLabel>
                  <FormControl>
                    <Textarea rows="4" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField  name="faltabd" v-slot="{ componentField }">
                <FormItem class="col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                  <FormLabel class="block">Comentarios Área de Operaciones</FormLabel>
                  <FormControl>
                    <Textarea rows="4" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
            </div>

            <div class="col-span-2">


              <div class="border-b border-gray-100 py-3 col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                <h3 class="m-0 text-purple-fincore text-xl font-bold">Parametros Sugeridos</h3>
              </div>
              <FormField name="faltabd" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Línea Cliente</FormLabel>
                  <FormControl>
                    <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="faltabd" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">% Anticipo</FormLabel>
                  <FormControl>
                    <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="faltabd" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Monto Comisión</FormLabel>
                  <FormControl>
                    <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="faltabd" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Tasa (TEM)</FormLabel>
                  <FormControl>
                    <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="faltabd" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Adelanto</FormLabel>
                  <FormControl>
                    <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="faltabd" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Línea Adelanto</FormLabel>
                  <FormControl>
                    <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
            </div>

            <div class="col-span-2">

              <div class="border-b border-gray-100 py-3 col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                <h3 class="m-0 text-purple-fincore text-xl font-bold">Parametros Definitivos</h3>
              </div>
              <FormField name="faltabd" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Línea Cliente</FormLabel>
                  <FormControl>
                    <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="faltabd" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">% Anticipo</FormLabel>
                  <FormControl>
                    <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="faltabd" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Monto Comisión</FormLabel>
                  <FormControl>
                    <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="faltabd" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Tasa (TEM)</FormLabel>
                  <FormControl>
                    <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="faltabd" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Adelanto</FormLabel>
                  <FormControl>
                    <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="faltabd" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Línea Adelanto</FormLabel>
                  <FormControl>
                    <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" />
                  </FormControl>
                </FormItem>
              </FormField>
            </div>





            <div class="col-span-2 md:col-span-4 lg:col-span-6 mt-3 text-center">
              <Button type="submit" :disabled="guardando" class="bg-skyblue-fincore" @click="router.visit('/comite/factoring-b')">
                {{ guardando ? 'Guardando...' : 'Guardar' }}
              </Button>
            </div>
          </form>





        
      </div>

    </div>
  </AppLayout>
</template>
<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { ref } from 'vue'
import { FormField } from '@/components/ui/form'
import FormItem from '@/components/ui/form/FormItem.vue'
import FormLabel from '@/components/ui/form/FormLabel.vue'
import FormControl from '@/components/ui/form/FormControl.vue'
import Button from '@/components/ui/button/Button.vue'
import Input from '@/components/ui/input/Input.vue'
import { Textarea } from '@/components/ui/textarea'
import { useRoute } from 'ziggy-js'


const breadcrumbs = [
  { title: 'Listado de Prospectos', href: '/comite' },
  { title: 'Comité Factoring Cliente', href: '/comite/factoring-a' },
]

/*
const route = useRoute()
//const id = route.params.id

const ruta = route.params

console.log(ruta);

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

// Obtener el valor de un parámetro específico
const id = urlParams.get('id');
const nombre = urlParams.get('nombre');

console.log('ID:', id);
console.log('Nombre:', nombre);
*/

// Estados de carga
const guardando = ref(false)



const page = usePage()
const id = ref(page.props.id ?? [])
const prospecto = ref(page.props.prospecto ?? [])
const reporte = ref(page.props.reporte ?? [])
/*
		const entidad_apefac = ref(entidad_apefac)
		const endeudamiento_apefac = ref(endeudamiento_apefac)
		const endeudamiento_pomedio_6_apefac = ref(endeudamiento_pomedio_6_apefac)
		const entidadcliente_situacion_sf_apefac = ref(entidadcliente_situacion_sf_apefac)
		const endeudamiento_bancario = ref(endeudamiento_bancario)
		const cuenta_con_protestos = ref(cuenta_con_protestos)
		const protestos = ref(protestos)
		const rl_nombre = ref(rl_nombre)
		const situacion_sf = ref(situacion_sf)
		const edad = ref(edad)
		const comentarios_area_riesgos = ref(comentarios_area_riesgos)
		const comentarios_area_comercial = ref(comentarios_area_comercial)

*/

</script>