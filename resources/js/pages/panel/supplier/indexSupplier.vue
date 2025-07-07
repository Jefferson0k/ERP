<template>
    <Head title="Supplier"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <tableSupplier/>
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import tableSupplier from './components/tableSupplier.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crear proveedor',
        href: '/Supplier/create',
    },
    {
        title: 'Proveedor',
        href: '/Supplier',
    },
];
</script>