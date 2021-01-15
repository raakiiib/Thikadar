<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('expenses.products')">PRODUCTS</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> BUY
            <br/>
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">

                    <text-input v-model="form.invoice_number" :error="errors.invoice_number" class="pr-6 pb-8 w-full lg:w-1/3" label="Invoice number" />
                    
                    <text-input type="date" value="28-12-2020" v-model="form.created_at" :error="errors.created_at" class="pr-6 pb-8 w-full lg:w-1/3" label="Date" />

                    <select-input v-model="form.product_id" :error="errors.product_id" class="pr-6 pb-8 w-full lg:w-1/3" label="Product">
                        <option :value="null" />
                        <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }} - {{ product.type }}</option>                        
                    </select-input>

                    <select-input v-model="form.vendor_id" :error="errors.vendor_id" class="pr-6 pb-8 w-full lg:w-1/3" label="Supplier">
                        <option :value="null" />
                        <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{ supplier.name }}</option>                        
                    </select-input>

                    <text-input type="number" step="0.01" v-model="form.unitprice" :error="errors.unitprice" @input="updateNetAmout" class="pr-6 pb-8 w-full lg:w-1/3" label="Unit price" />

                    <text-input type="number" step="0.01" v-model="form.quantity" :error="errors.quantity" @input="updateNetAmout" class="pr-6 pb-8 w-full lg:w-1/3" label="Quantity" />

                    <text-input disabled type="number" step="0.01" v-model="form.net_amount" @input="calculateDue" :error="errors.net_amount" class="pr-6 pb-8 w-full lg:w-1/3" label="Total amount"/>

                    <text-input type="number" step="0.01" v-model="form.paid_amount" @input="calculateDue" :error="errors.paid_amount" class="pr-6 pb-8 w-full lg:w-1/3" label="Paid amount"/>
                    
                    <text-input disabled type="number" step="0.01" v-model="form.due_amount" :error="errors.due_amount" class="pr-6 pb-8 w-full lg:w-1/3" label="Due amount"/>

                    <select-input v-model="form.pay_type" :error="errors.pay_type" class="pr-6 pb-8 w-full lg:w-1/4" label="Payment type">
                        <option value="Product price">Product price</option>
                        <option value="Transport cost">Transport cost</option>
                        <option value="Tips">Tips</option>
                        <option value="Others">Others</option>
                    </select-input>
                    
                    <text-input v-model="form.note" :error="errors.note" class="pr-6 pb-8 w-full lg:w-3/4" label="Note"/>

                    <!-- <file-input v-model="form.photo_path" :error="errors.photo_path" class="pr-6 pb-8 w-full lg:w-1/2" type="file" accept="image/*" label="Money receipt" tabindex="6" /> -->

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
            FileInput,
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
                    vendor_id: null,
                    product_id: null,
                    unitprice: null,
                    quantity: null,
                    net_amount: null,
                    paid_amount: null,
                    expense_type: Number(1),
                    due_amount: null,
                    is_all_paid: false,
                    invoice_number: this.invoice_number,
                    created_at: new Date().toISOString().slice(0,10),
                    photo_path: null,
                    pay_type: null,
                    note: null,
                },
            }
        },
        methods: {
            updateNetAmout: function() {
                this.form.net_amount = String(this.form.unitprice * this.form.quantity)
            },
            calculateDue: function () {
                var total = this.form.net_amount
                var paid = this.form.paid_amount
                var due = total - paid
                this.form.due_amount = String(due)
                this.updateDueStat(due)
                console.log(paid)
            },
            updateDueStat: function(due){
                var stat = false;
                if( due == 0 ){
                    stat = true
                }
                this.form.is_all_paid = Boolean(stat);
            },
            submit() {

                const formData = new FormData()
                formData.append('invoice_number', this.form.invoice_number || '')
                formData.append('created_at', this.form.created_at || '')
                formData.append('vendor_id', this.form.vendor_id || '')
                formData.append('product_id', this.form.product_id || '')
                formData.append('unitprice', this.form.unitprice || '')
                formData.append('quantity', this.form.quantity || '')
                formData.append('net_amount', this.form.net_amount || '')
                formData.append('paid_amount', this.form.paid_amount || '')
                formData.append('due_amount', this.form.due_amount || '')
                formData.append('pay_type', this.form.pay_type || '')
                formData.append('note', this.form.note || '')
                formData.append('expense_type', this.form.expense_type || '')
                if( this.form.is_all_paid ){
                    formData.append('is_all_paid', 1)
                }else{
                    formData.append('is_all_paid', 0)
                }
                formData.append('photo_path', this.form.photo_path || '')
                // console.log(this.formData)
                console.log(this.form)
                this.$inertia.post(this.route('product.store'), this.form, {
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
