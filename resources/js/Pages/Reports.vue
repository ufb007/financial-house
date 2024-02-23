<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { ref, onMounted } from 'vue';
    import axios from 'axios';
    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';

    const fromDate = ref('2010-01-01');
    const toDate = ref('2024-03-01');

    const reports = ref([]);
    const loading = ref(false);

    defineProps({
        'reports': {
            type: Array
        }
    });

    const getRports = async (page) => {
        return await axios.post('/get-reports', {
            fromDate: fromDate.value,
            toDate: toDate.value,
            page
        });
    }

    const dateFilterHandler = async () => {
        loading.value = true;

        const dateFrom = new Date(fromDate.value);
        const dateTo = new Date(toDate.value);

        fromDate.value = `${dateFrom.getFullYear()}-${(dateFrom.getMonth() + 1).toString().padStart(2, '0')}-${dateFrom.getDate().toString().padStart(2, '0')}`;
        toDate.value = `${dateTo.getFullYear()}-${(dateTo.getMonth() + 1).toString().padStart(2, '0')}-${dateTo.getDate().toString().padStart(2, '0')}`;

        reports.value = [];

        const response = await getRports(1);

        loading.value = false;

        reports.value = response.data.data;

        console.log(response)
    }

    onMounted(async () => {
        loading.value = true;

        const response = await getRports(1);

        loading.value = false;

       if (response.statusText === 'OK') {
           reports.value = response.data.data;
       }
       
       console.log(response)
    });
</script>

<template>
    <Head title="Reports" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transaction Reports ({{ reports.length }})</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center">
                    <VueDatePicker format="yyyy-MM-dd" v-model="fromDate" placeholder="Date From"></VueDatePicker>
                    <VueDatePicker format="yyyy-MM-dd" v-model="toDate" placeholder="Date To"></VueDatePicker>
                    <button @click="dateFilterHandler" class="filter">Filter</button>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table v-if="reports.length > 0" class="table-auto min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-center">
                                    <th>Currency</th>
                                    <th>Count</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr :key="index" v-for="({ currency, count, total }, index) in reports" class="text-center">
                                    <td class="py-2">{{ currency }}</td>
                                    <td>{{ count }}</td>
                                    <td>{{ total }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="text-center" v-if="loading">...LOADING</div>
                        <div class="text-center" v-else-if="reports.length === 0">No Data</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
    button.filter {
        @apply 
            py-1 
            px-3 
            bg-white 
            rounded 
            border 
            border-gray-200
            hover:bg-green-700
            hover:text-white
            transition
            duration-500;
    }
</style>