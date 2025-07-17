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
            <FormField name="fecha_reporte_tributario" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Fecha Reporte Tributario</FormLabel>
                <FormControl>
                  <Input type="date" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].fecha_reporte_tributario" />
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
                  <Input type="date" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].fecha_sentinel" />
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


            
            <!-- <FormField name="entidad_apefac" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Entidad Apefac</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].entidad_apefac"/>
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="endeudamiento_apefac" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Endeud. Apefac</FormLabel>
                <FormControl>
                  <Input type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].endeudamiento_apefac"/>
                </FormControl>
              </FormItem>
            </FormField><FormField name="endeudamiento_pomedio_6_apefac" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Endeud. Prom. 6 M. Apefac</FormLabel>
                <FormControl>
                  <Input type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].endeudamiento_pomedio_6_apefac"/>
                </FormControl>
              </FormItem>
            </FormField>-->
            <FormField name="cliente_situacion_sf" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Cliente Situación SF</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="prospecto[0].cliente_situacion_sf" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="endeudamiento_bancario" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Endeud. Bancario</FormLabel>
                <FormControl>
                  <Input type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="prospecto[0].endeudamiento_bancario" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="cuenta_con_protestos" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Cuenta con Protestos</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="prospecto[0].cuenta_con_protestos" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="protestos" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Protestos</FormLabel>
                <FormControl>
                  <Input type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="prospecto[0].protestos" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="rl_nombre" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">RL Nombre</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="prospecto[0].rl_nombre" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="situacion_sf" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Situación SF</FormLabel>
                <FormControl>
                  <Input class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="prospecto[0].situacion_sf" />
                </FormControl>
              </FormItem>
            </FormField>
            <FormField name="edad" v-slot="{ componentField }">
              <FormItem class="col-span-2">
                <FormLabel class="block">Edad</FormLabel>
                <FormControl>
                  <Input type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="prospecto[0].edad" />
                </FormControl>
              </FormItem>
            </FormField>

            <div class="col-span-2 md:col-span-4 lg:col-span-6"></div>

            <div class="col-span-2">


              <div class="border-b border-gray-100 py-3 col-span-1 md:col-span-2 lg:col-span-3 mb-4">
                <h3 class="m-0 text-purple-fincore text-xl font-bold">Comentarios</h3>
              </div>

              <FormField  name="comentarios_area_riesgos" v-slot="{ componentField }">
                <FormItem class="col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                  <FormLabel class="block">Comentarios Área de Riesgos</FormLabel>
                  <FormControl>
                    <Textarea rows="4" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField"  v-model="prospecto[0].comentarios_area_riesgos" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField  name="comentarios_area_comercial" v-slot="{ componentField }">
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
            </div>

            <div class="col-span-2">


              <div class="border-b border-gray-100 py-3 col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                <h3 class="m-0 text-purple-fincore text-xl font-bold">Parametros Sugeridos</h3>
              </div>
              <FormField name="linea_cliente_sugerido" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Línea Cliente</FormLabel>
                  <FormControl>
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].linea_cliente_sugerido" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="anticipo_sugerido" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">% Anticipo</FormLabel>
                  <FormControl>
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].anticipo_sugerido" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="monto_comision_sugerido" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Monto Comisión</FormLabel>
                  <FormControl>
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].monto_comision_sugerido" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="tasa_tem_sugerido" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Tasa (TEM)</FormLabel>
                  <FormControl>
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].tasa_tem_sugerido" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="adelanto_sugerido" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Adelanto</FormLabel>
                  <FormControl>
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].adelanto_sugerido" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="linea_adelanto_sugerido" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Línea Adelanto</FormLabel>
                  <FormControl>
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].linea_adelanto_sugerido" />
                  </FormControl>
                </FormItem>
              </FormField>
            </div>

            <div class="col-span-2">

              <div class="border-b border-gray-100 py-3 col-span-2 md:col-span-4 lg:col-span-6 mb-4">
                <h3 class="m-0 text-purple-fincore text-xl font-bold">Parametros Definitivos</h3>
              </div>
              <FormField name="linea_cliente_definitivo" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Línea Cliente</FormLabel>
                  <FormControl>
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].linea_cliente_definitivo" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="anticipo_definitivo" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">% Anticipo</FormLabel>
                  <FormControl>
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].anticipo_definitivo" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="monto_comision_definitivo" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Monto Comisión</FormLabel>
                  <FormControl>
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].monto_comision_definitivo" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="tasa_tem_definitivo" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Tasa (TEM)</FormLabel>
                  <FormControl>
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].tasa_tem_definitivo" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="adelanto_definitivo" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Adelanto</FormLabel>
                  <FormControl>
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].adelanto_definitivo" />
                  </FormControl>
                </FormItem>
              </FormField>
              <FormField name="linea_adelanto_definitivo" v-slot="{ componentField }">
                <FormItem class="col-span-2 mb-4">
                  <FormLabel class="block">Línea Adelanto</FormLabel>
                  <FormControl>
                    <Input  type="number" class="w-full shadow-none rounded-lg border-gray-200" v-bind="componentField" v-model="prospecto[0].linea_adelanto_definitivo" />
                  </FormControl>
                </FormItem>
              </FormField>
            </div>





            <div class="col-span-2 md:col-span-4 lg:col-span-6 mt-3 text-center">
              <Button type="button" :disabled="guardando" class="bg-skyblue-fincore me-5" @click="actualizarProspecto">
                {{ guardando ? 'Guardando...' : 'Guardar' }}
              </Button>
              <!-- <Button type="button" :disabled="guardando" class="bg-purple-fincore" @click="router.visit(`/comite/factoring/aceptante/${prospecto[0].id_factoring}`)"> -->
              <Button type="button" :disabled="guardando" class="bg-purple-fincore" @click="router.visit(`/comite/factoring/aceptante/${id}`)">
                {{ guardando ? 'Guardando...' : 'Aceptante(s)' }}
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
import axios from 'axios'


const breadcrumbs = [
  { title: 'Listado de Prospectos', href: '/comite' },
  { title: 'Comité Factoring Cliente', href: '/comite/factoring/cliente' },
]

// Estados de carga
const guardando = ref(false)

const page = usePage()
const id = ref(page.props.id ?? [])
const prospecto = ref(page.props.prospecto ?? [])
const reporte = ref(page.props.reporte ?? [])


const actualizarProspecto = async () =>  {
    try {
        const res = await axios.post(`/api/comite/actualizar/${id.value}`, {
          fecha_reporte_tributario : prospecto.value[0].fecha_reporte_tributario,
          fecha_sentinel: prospecto.value[0].fecha_sentinel,
          /*entidad_apefac: prospecto.value[0].entidad_apefac,
          endeudamiento_apefac: prospecto.value[0].endeudamiento_apefac,
          endeudamiento_pomedio_6_apefac: prospecto.value[0].endeudamiento_pomedio_6_apefac,*/
          cliente_situacion_sf: prospecto.value[0].cliente_situacion_sf,
          endeudamiento_bancario: prospecto.value[0].endeudamiento_bancario,
          cuenta_con_protestos: prospecto.value[0].cuenta_con_protestos,
          protestos: prospecto.value[0].protestos,
          rl_nombre: prospecto.value[0].rl_nombre,
          situacion_sf: prospecto.value[0].situacion_sf,
          edad: prospecto.value[0].edad,
          comentarios_area_riesgos: prospecto.value[0].comentarios_area_riesgos,
          comentarios_area_comercial: prospecto.value[0].comentarios_area_comercial,
          comentarios_area_operaciones: prospecto.value[0].comentarios_area_operaciones,
          linea_cliente_sugerido: prospecto.value[0].linea_cliente_sugerido,
          anticipo_sugerido: prospecto.value[0].anticipo_sugerido,
          monto_comision_sugerido: prospecto.value[0].monto_comision_sugerido,
          tasa_tem_sugerido: prospecto.value[0].tasa_tem_sugerido,
          adelanto_sugerido: prospecto.value[0].adelanto_sugerido,
          linea_adelanto_sugerido: prospecto.value[0].linea_adelanto_sugerido,
          linea_cliente_definitivo: prospecto.value[0].linea_cliente_definitivo,
          anticipo_definitivo: prospecto.value[0].anticipo_definitivo,
          monto_comision_definitivo: prospecto.value[0].monto_comision_definitivo,
          tasa_tem_definitivo: prospecto.value[0].tasa_tem_definitivo,
          adelanto_definitivo: prospecto.value[0].adelanto_definitivo,
          linea_adelanto_definitivo: prospecto.value[0].linea_adelanto_definitivo,
        })

        if (res.status === 200 || res.status === 201) {
            //router.visit('/comite/factoring/aceptante')
        }
    } catch (err: any) {
        console.error('Error al guardar reporte:', err)
    }
}


</script>