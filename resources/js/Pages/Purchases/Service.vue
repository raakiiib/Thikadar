<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('expenses.services')">SERVICES</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> NEW CONTRACT
            <br/>
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <select-input v-model="form.service_id" :error="errors.service_id" @input="calculateTotalPrice" class="pr-6 pb-8 w-full lg:w-1/2" label="Service">
                        <option :value="null" />
                        <option v-for="service in services" :key="service.id" :value="service.id">{{ service.name }}</option>                        
                    </select-input>

                    <select-input v-model="form.supplier_id" :error="errors.supplier_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Supplier">
                        <option :value="null" />
                        <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{ supplier.name }}</option>                        
                    </select-input>

                    <text-input type="number" step="0.01" v-model="form.unitprice" @input="updateNetAmout" :error="errors.unitprice" class="pr-6 pb-8 w-full lg:w-1/2" label="Rate/ CFT" />

                    <text-input type="number" step="0.01" v-model="form.quantity" @input="updateNetAmout" :error="errors.quantity" 
                     class="pr-6 pb-8 w-full lg:w-1/2" label="Quantity" />

                    <text-input disabled type="number" step="any" v-model="form.size" @input="updateNetAmout" :error="errors.size" class="pr-6 pb-8 w-full lg:w-1/2" label="Size in CFT" />


                    <text-input type="number" step="0.01" v-model="form.net_amount" :error="errors.net_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="Total amount"/>
                    
                    <text-input type="date" value="28-12-2020" v-model="form.created_at" :error="errors.created_at" class="pr-6 pb-8 w-full lg:w-1/2" label="Date"/>

                    <text-input v-model="form.invoice_number" :error="errors.invoice_number" class="pr-6 pb-8 w-full lg:w-1/2" label="Invoice number" />
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <loading-button :loading="sending" class="btn-indigo" type="submit">PROCEED</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Layout from '@/Shared/Layout'
    import LoadingButton from '@/Shared/LoadingButton'
    import SelectInput from '@/Shared/SelectInput'
    import TextInput from '@/Shared/TextInput'
    import FileInput from '@/Shared/FileInput'
    import axios from 'axios'

    export default {
        metaInfo: { title: 'Buy product' },
        layout: Layout,
        components: {
            LoadingButton,
            SelectInput,
            TextInput,
        },
        props: {
            suppliers: Array,
            services: Array,
            invoice_number: String,
            errors: Object,
        },
        remember: 'form',
        data() {
            return {
                sending: false,
                service_data: null,
                form: {
                    service_id: null,
                    supplier_id: null,
                    invoice_number: this.invoice_number,
                    quantity: null,
                    unitprice: null,
                    size: null,
                    net_amount: null,
                    size: null,
                    created_at: new Date().toISOString().slice(0,10),
                },
                service: Array,
            }
        },
        methods: {
            calculateTotalPrice: function() {
                this.updateNetAmout();
                axios
                  .get(this.route('purchase.getService', this.form.service_id))
                  .then(
                    response => (

                        this.converter(
                            response.data.service.unit, 
                            response.data.service.convert_to, 
                            response.data.service.size,
                        )
                    ))

            },
            converter: function( unit, convert, size ){
                var cft, meter, feet, first, second, third;
                const usingSplit = size.split('x');
                
                first = parseFloat(usingSplit[0]);
                second = parseFloat(usingSplit[1]);
                third = parseFloat(usingSplit[2]);
                
                first = (first/ 100); // meter from cm
                second = (second/ 100);
                third = (third/ 100);
                
                meter = first * second * third;
                
                feet = meter*35.3147;
                feet = feet.toFixed(4);
                this.form.size = feet
            },
            updateNetAmout: function() {
                var total = (this.form.unitprice * this.form.quantity * this.form.size)
                total = total.toFixed(2);
                this.form.net_amount = String(total);
            },
            submit() {
                console.log(this.form);
                this.$inertia.post(this.route('purchases.storeService'), this.form, {
                    onStart: () => this.sending = true,
                    onFinish: () => this.sending = false,
                })

            },
        },
        created(){
            // console.log('created ...');
        }
    }
</script>
