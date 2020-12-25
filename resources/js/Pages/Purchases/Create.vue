<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('products')">PRODUCT</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> BUY
            <br/>
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">

                    <select-input v-model="form.material_id" :error="errors.material_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Product">
                        <option :value="null" />
                        <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</option>                        
                    </select-input>

                    <select-input v-model="form.supplier_id" :error="errors.supplier_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Supplier">
                        <option :value="null" />
                        <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{ supplier.name }}</option>                        
                    </select-input>

                    <text-input type="number" step="0.01" v-model="form.unitprice" :error="errors.unitprice" @input="updateNetAmout" class="pr-6 pb-8 w-full lg:w-1/2" label="Unit price" />

                    <text-input type="number" step="0.01" v-model="form.quantity" :error="errors.quantity" @input="updateNetAmout" class="pr-6 pb-8 w-full lg:w-1/2" label="Quantity" />

                    <text-input disabled type="number" step="0.01" v-model="form.net_amount" :error="errors.net_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="Total amount"/>

                    <text-input disabled v-model="form.invoice_number" :error="errors.invoice_number" class="pr-6 pb-8 w-full lg:w-1/2" label="Invoice number" />

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
            products: Array,
            invoice_number: String,
            errors: Object,
        },
        remember: 'form',
        data() {
            return {
                sending: false,
                form: {
                    supplier_id: null,
                    material_id: null,
                    unitprice: null,
                    quantity: null,
                    net_amount: null,
                    invoice_number: this.invoice_number,
                },
            }
        },
        methods: {
            updateNetAmout: function() {
                this.form.net_amount = String(this.form.unitprice * this.form.quantity)
            },
            submit() {

                // console.log(this.form)
                this.$inertia.post(this.route('products.store'), this.form, {
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
