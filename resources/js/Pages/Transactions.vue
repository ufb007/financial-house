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

    const loading = ref(false);

    const modalActive = ref(false);
    const modalContentSelected = ref('client');
    const singleTransaction = ref({
        client: {},
        transaction: {}
    });

    const getTransactions = async (page) => {
        return await axios.post('/get-transactions', {
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

        transactions.value = [];

        const response = await getTransactions(1);

        loading.value = false;

        transactions.value = response.data.data;
    }

    const getSingleTransaction = async (transactionId) => {
        modalActive.value = true;

        const $response = await axios.post('/get-transaction', { transactionId});

        if ($response.statusText === 'OK') {
            singleTransaction.value = {
                client: $response.data.data.customerInfo,
                transaction: $response.data.data.transaction.merchant,
            };
        }
    }

    const onClickPrevNext = async (page) => {
        if (page !== null && page !== undefined) {
            loading.value = true;

            transactions.value = [];

            const getPageFromString = Number(page.substring(page.indexOf('page=') + 5));

            const response = await getTransactions(getPageFromString);

            loading.value = false;

            transactions.value = response.data.data;
        }
    }

    onMounted(async () => {
        loading.value = true;
        
        const response = await getTransactions(1);
        
        loading.value = false;

        transactions.value = response.data.data;
    });
</script>

<template>
    <Head title="Reports" />

    <AuthenticatedLayout>
        <div class="modal flex flex-col items-center" v-if="modalActive">
            <button @click="modalActive = false" class="absolute top-5 right-5">Close X</button>

            <ul class="flex gap-5 mt-5">
                <li @click="modalContentSelected = 'client'" :class="{'active': modalContentSelected === 'client'}">Client</li>
                <li @click="modalContentSelected = 'transaction'" :class="{'active': modalContentSelected === 'transaction'}">Transaction</li>
            </ul>

            <div class="w-full p-10 mt-5 overflow-auto">
                <h2 class="capitalize text-2xl">{{ modalContentSelected }} Details</h2>
                <div class="w-full">
                    <table v-if="modalContentSelected === 'client'" class="divide-y divide-gray-200">
                        <tr>
                            <td>ID:</td>
                            <td>{{ singleTransaction.client.id }}</td>
                        </tr>
                        <tr>
                            <td>Billing Address:</td>
                            <td>{{ singleTransaction.client.billingAddress1 }}</td>
                        </tr>
                        <tr>
                            <td>Billing City:</td>
                            <td>{{ singleTransaction.client.billingCity }}</td>
                        </tr>
                        <tr>
                            <td>Billing Company:</td>
                            <td>{{ singleTransaction.client.billingCompany }}</td>
                        </tr>
                        <tr>
                            <td>Billing Name:</td>
                            <td>{{ singleTransaction.client.billingFirstName }} {{ singleTransaction.client.billingLastName }}</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>{{ singleTransaction.client.email }}</td>
                        </tr>
                        <tr>
                            <td>Created:</td>
                            <td>{{ singleTransaction.client.created_at }}</td>
                        </tr>
                        <tr>
                            <td>Updated:</td>
                            <td>{{ singleTransaction.client.updated_at }}</td>
                        </tr>
                    </table>

                    <table v-if="modalContentSelected === 'transaction'" class="divide-y divide-gray-200">
                        <tr>
                            <td>Acquirer Transaction Id:</td>
                            <td>{{ singleTransaction.transaction.acquirerTransactionId }}</td>
                        </tr>
                        <tr>
                            <td>Channel:</td>
                            <td>{{ singleTransaction.transaction.channel }}</td>
                        </tr>
                        <tr>
                            <td>Merchand ID:</td>
                            <td>{{ singleTransaction.transaction.merchantId }}</td>
                        </tr>
                        <tr>
                            <td>Message:</td>
                            <td>{{ singleTransaction.transaction.message }}</td>
                        </tr>
                        <tr>
                            <td>Reference:</td>
                            <td>{{ singleTransaction.transaction.referenceNo }}</td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td>{{ singleTransaction.transaction.status }}</td>
                        </tr>
                        <tr>
                            <td>Type:</td>
                            <td>{{ singleTransaction.transaction.type }}</td>
                        </tr>
                        <tr>
                            <td>Created:</td>
                            <td>{{ singleTransaction.transaction.created_at }}</td>
                        </tr>
                        <tr>
                            <td>Updated:</td>
                            <td>{{ singleTransaction.transaction.updated_at }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transactions</h2>
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
                        <ul class="prevNext flex justify-center gap-5 mb-5">
                            <li @click="onClickPrevNext(transactions.prev_page_url)" :class="{'disabled': !transactions.prev_page_url}">{{ `< Prev` }}</li>
                            <li @click="onClickPrevNext(transactions.next_page_url)" :class="{'disabled': !transactions.next_page_url}">{{ `Next >` }}</li>
                        </ul>

                        <div class="text-center" v-if="loading">...LOADING</div>
                        <div class="text-center" v-else-if="!transactions.data">No Data</div>

                        <table v-if="transactions.data" class="table-auto min-w-full divide-y divide-gray-200">
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
                                    <td>{{ acquirer?.name }}</td>
                                    <td>{{ merchant?.name }}</td>
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
    div.modal {
        @apply w-[80%] h-[80%] bg-white rounded-3xl shadow-2xl shadow-gray-500/20 border border-gray-400 z-10 fixed overflow-hidden;
        top: 50%; 
        left: 50%; 
        transform: translate(-50%, -50%);
    }

    div.modal ul li.active {
        @apply underline;
    }

    div.modal ul li {
        @apply cursor-pointer hover:underline;
    }

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