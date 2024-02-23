<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { ref, onMounted } from 'vue';
    import axios from 'axios';
    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css'

    const transactions = ref([]);
    const fromDate = ref('2010-01-01');
    const toDate = ref('2024-03-01');

    const { apiToken, title } = defineProps(['apiToken', 'title']);

    const getTransactions = async (page) => {
        return await axios.post('/get-transactions', {
            fromDate: fromDate.value,
            toDate: toDate.value,
            page
        });
    }

    const getSingleTransaction = async (transactionId) => {
        console.log('Get Single Transaction - ', transactionId);
    }

    const onClickPrevNext = async (page) => {
        if (page !== null && page !== undefined) {
            console.log('Show page - ', page);
        }
    }

    onMounted(async () => {
        const response = await getTransactions(1);

        transactions.value = response.data.data;

        console.log(transactions.value)
    });
</script>

<template>
    <Head title="Reports" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transactions</h2>
        </template>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center">
                    <VueDatePicker format="yyyy-MM-dd" v-model="fromDate" placeholder="Date From"></VueDatePicker>
                    <VueDatePicker format="yyyy-MM-dd" v-model="toDate" placeholder="Date To"></VueDatePicker>
                    <button class="filter">Filter</button>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <ul class="prevNext flex justify-center gap-5 mb-5">
                            <li @click="onClickPrevNext(transactions.prev_page_url)" :class="{'disabled': !transactions.prev_page_url}">{{ `< Prev` }}</li>
                            <li @click="onClickPrevNext(transactions.next_page_url)" :class="{'disabled': !transactions.next_page_url}">{{ `Next >` }}</li>
                        </ul>

                        <table class="table-auto min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th>FX</th>
                                    <th>Acquirer</th>
                                    <th>Merchant</th>
                                    <th>Refundable</th>
                                    <th>Transaction</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr :key="index" v-for="({ fx, acquirer, merchant, refundable, transaction, created_at }, index) in transactions.data">
                                    <td>
                                        <ul class="flex flex-col">
                                            <li><span>Original Amount</span>: {{ fx.merchant.originalAmount }}</li>
                                            <li><span>Original Currency</span>: {{ fx.merchant.originalCurrency }}</li>
                                            <li><span>Converted Amount</span>: {{ fx.merchant.convertedAmount }}</li>
                                            <li><span>Converted Currency</span>: {{ fx.merchant.convertedCurrency }}</li>
                                        </ul>
                                    </td>
                                    <td>{{ acquirer.name }}</td>
                                    <td>{{ merchant.name }}</td>
                                    <td class="text-center uppercase">{{ refundable }}</td>
                                    <td class="transactionId"><a @click="getSingleTransaction(transaction.merchant.transactionId)" class="cursor-pointer">{{ transaction.merchant.transactionId }}</a></td>
                                    <td>{{ created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
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

    ul.prevNext li {
        @apply cursor-pointer hover:text-blue-600;
    }

    ul.prevNext li.disabled {
        @apply cursor-not-allowed text-gray-400 hover:text-gray-400;
    }

    table tr td {
        @apply py-2 w-[20%];
    }

    table tr td li span {
        @apply font-bold;
    }

    table tr td.transactionId a {
        @apply cursor-pointer hover:underline;
    }
</style>