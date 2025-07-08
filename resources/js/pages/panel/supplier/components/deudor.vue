<template>
    <Head title="Deudor/Adeudante" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6 space-y-6">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="font-semibold">RUC</p>
                        <Input placeholder="API SUNAT" class="w-full" />
                    </div>
                    <div>
                        <p class="font-semibold">Razón Social</p>
                        <Input placeholder="API SUNAT" class="w-full" />
                    </div>
                </div>

                <!-- Tabla de Información Financiera -->
                <div class="overflow-auto border rounded-xl">
                    <table class="min-w-full text-sm text-left border-collapse">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="px-4 py-2 border-r" colspan="2">M s/.</th>
                                <th class="px-4 py-2 border-r">Informes Comerciales</th>
                                <th class="px-4 py-2 border-r">Deuda Bancos</th>
                                <th class="px-4 py-2 border-r">Top 10 mil</th>
                                <th class="px-4 py-2 border-r">Tipo de Empresa</th>
                                <th class="px-4 py-2">Riesgo Sentinel</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            <tr class="bg-sky-200 font-semibold text-center">
                                <td class="px-2 py-1 border-r">F/L</td>
                                <td class="px-2 py-1 border-r">N°</td>
                                <td class="px-2 py-1 border-r">M s/.</td>
                                <td class="px-2 py-1 border-r">Clasif.</td>
                                <td class="px-2 py-1 border-r">Vta s/. MM<br />Rank</td>
                                <td class="px-2 py-1 border-r">Lógica</td>
                                <td class="px-2 py-1">API EXPERIAN</td>
                            </tr>
                            <tr class="text-center">
                                <td class="px-2 py-1 border-r">s/. 300</td>
                                <td class="px-2 py-1 border-r">0</td>
                                <td class="px-2 py-1 border-r">s/. 251</td>
                                <td class="px-2 py-1 border-r">
                                    s/. 3,875,237 <br />NOR
                                </td>
                                <td class="px-2 py-1 border-r">
                                    s/. 40,000.00 <br />4,261
                                </td>
                                <td class="px-2 py-1 border-r text-left">
                                    =SI(N32*12/4.4<=150;"Micro";<br />
                                    SI(Y(N32*12/4.4>150;N32*12/4.4<=1700);"Pequeña";<br />
                                    SI(Y(N32*12/4.4>1700;N32*12/4.4<=2300);"Mediana";<br />
                                    SI(N32*12/4.4>2300;"Grande";""))))
                                </td>
                                <td class="px-2 py-1 text-left">
                                    API EXPERIAN <br />
                                    Parámetro "Calificativo" <br />
                                    Calificativo promedio de todas las entidades <br />
                                    financieras (Reguladas y no reguladas)
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tabla de Factoring -->
                <div>
                    <p class="font-semibold">Factoring que operan</p>
                    <div class="overflow-auto border rounded-xl">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-blue-800 text-white">
                                <tr>
                                    <th class="px-4 py-2 border-r">Nombre</th>
                                    <th class="px-4 py-2">Línea Aprobada</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td class="px-4 py-2 border-r">—</td>
                                    <td class="px-4 py-2">—</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Observaciones -->
                <div>
                    <p class="font-semibold">Observaciones</p>
                    <Textarea
                        placeholder="Información escrita de forma manual"
                        class="w-full min-h-[100px]"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Input } from '@/components/ui/input'
import { Textarea } from '@/components/ui/textarea'

const breadcrumbs = [
    { title: 'Prospecto', href: '/Supplier' },
    { title: 'Crear prospecto', href: '/Supplier/create' },
    { title: 'Comité prospecto', href: '/Panel/comite' },
    { title: 'Deudor o adeudante', href: '/Panel/deudor' }
]
</script>
