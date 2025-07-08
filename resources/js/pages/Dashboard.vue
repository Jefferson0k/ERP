<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const consultarRuc = async () => {
    try {
        const response = await axios.get('http://127.0.0.1:8000/api/consultar-ruc/10763936711');
        console.log('consultar-ruc');
        console.log(response);
    } catch (e) {
        const error = 'Fallo al llamar al api ' + e;
        console.log(error);
    }
}

const consultarDni = async () => {
    try {
        const response = await axios.get('http://127.0.0.1:8000/api/consultar-dni/76393671');
        console.log('consultar-dni');
        console.log(response);
    } catch (e) {
        const error = 'Fallo al llamar al api ' + e;
        console.log(error);
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-10">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="bg-purple-fincore text-grey-fincore">adfasdfadsfads</div>
                <div class="text-skyblue-fincore">adfasdfadsfads</div>

                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" @click="consultarRuc()">
                    Consultar RUC
                </button>
                <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" @click="consultarDni()">
                    Consultar DNI
                </button>


                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <span>sfadsf1241324123</span>adfadsfadsfasdfads

                    
                    
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
