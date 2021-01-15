<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('expenses.products')">&#8678; PRODUCTS</inertia-link>
            <span class="text-indigo-400 font-medium">/</span>
            {{expense.product_name}} {{expense.product_type}}
        </h1>
        <trashed-message v-if="expense.deleted_at" class="mb-6" @restore="restore">
            This entry has been deleted.
        </trashed-message>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">

                    <text-input disabled v-model="form.invoice_number" :error="errors.invoice_number" class="pr-6 pb-8 w-full lg:w-1/2" label="Invoice number" />

                    <text-input type="date" v-model="form.created_at" :error="errors.created_at" class="pr-6 pb-8 w-full lg:w-1/2" label="Date" tabindex="1" />

                    <text-input disabled v-model="form.product" :error="errors.product" class="pr-6 pb-8 w-full lg:w-1/2" label="Product" />

                    <text-input disabled v-model="form.supplier" :error="errors.supplier" class="pr-6 pb-8 w-full lg:w-1/2" label="Supplier" />

                    <text-input disabled type="number" step="any" v-model="form.unit_price" :error="errors.unit_price" class="pr-6 pb-8 w-full lg:w-1/2" label="Unit price" />

                    <text-input disabled type="number" step="any" v-model="form.quantity" :error="errors.quantity" class="pr-6 pb-8 w-full lg:w-1/2" label="Quantity" />
                    
                    <text-input disabled type="number" step="any" v-model="form.net_amount" :error="errors.net_amount" class="pr-6 pb-8 w-full lg:w-1/3" label="Total" />

                    <text-input type="number" disabled step="any" v-model="form.due_amount" :error="errors.due_amount" class="pr-6 pb-8 w-full lg:w-1/3" label="Due" />

                    <text-input  
                        v-if="!expense.is_all_paid"
                        type="number" 
                        :min=1
                        :max='expense.due_amount'
                        step="any" 
                        v-model="form.paid_amount" 
                        @input="updateDueAmount"
                        :error="errors.paid_amount" 
                        class="pr-6 pb-8 w-full lg:w-1/3" 
                        label="Pay" 
                        tabindex="2" />

                    <select-input v-if="!expense.is_all_paid" v-model="form.pay_type" :error="errors.pay_type" class="pr-6 pb-8 w-full lg:w-1/4" label="Payment type">
                        <!-- <option :value="null" /> -->
                        <option value="Product price">Product price</option>
                        <option value="Transport cost">Transport cost</option>
                        <option value="Tips">Tips</option>
                        <option value="Others">Others</option>
                    </select-input>

                    <text-input v-if="!expense.is_all_paid" v-model="form.note" :error="errors.note" class="pr-6 pb-8 w-full lg:w-3/4" label="Note" tabindex="3" />

                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center content-center">
                    <button v-if="!expense.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">
                        <icon name="trash" class="block w-6 h-6 fill-red-600"/> 
                    </button>

                    <loading-button :loading="sending" v-if="!expense.is_all_paid" class="btn-indigo ml-auto" type="submit">Update</loading-button>
                </div>
            </form>
        </div>

        <!-- Showing payments -->
        <h2 class="mt-12 font-bold text-2xl">Payments</h2>
        <div class="mt-6 bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Date</th>
                    <th class="px-6 pt-6 pb-4">Payment type</th>
                    <th class="px-6 pt-6 pb-4">Amount paid</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">Note</th>
                </tr>
                <tr v-for="payment in expense.payments" :key="payment.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route()">
                            {{ payment.created_at | formatDate }}
                            <icon v-if="payment.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route()" tabindex="-1">
                            {{ payment.payment_type }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route()" tabindex="-1">
                            {{ payment.paid_amount }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route()" tabindex="-1">
                            {{ payment.note }}
                        </inertia-link>
                    </td>                    
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route()" tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="expense.payments.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No contacts found.</td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
    metaInfo() {
        return { title: this.form.name }
    },
    layout: Layout,
    components: {
        Icon,
        LoadingButton,
        SelectInput,
        TextInput,
        TrashedMessage,
    },
    props: {
        errors: Object,
        expense: Object,
    },
    remember: 'form',
    data() {
        return {
            sending: false,
            form: {
                expense_id: this.expense.id,
                product: this.expense.product_name+' '+this.expense.product_type,
                invoice_number: this.expense.invoice_number,
                supplier: this.expense.supplier,
                unit_price: String(this.expense.unit_price),
                quantity: String(this.expense.quantity),
                pay_type: null,
                created_at: new Date().toISOString().slice(0,10),
                net_amount: String(this.expense.net_amount),
                total_paid: null,
                paid_amount: null,
                due_amount: String(this.expense.due_amount),
                is_all_paid: this.expense.is_all_paid,
                note: null,
            },
        }
    },
    methods: {

        updateDueAmount: function() {
            var due = this.expense.due_amount
            var paid = this.form.paid_amount
            var now = (due - paid)
            now = now.toFixed(2);
            this.form.due_amount = String(now);
            this.form.total_paid = Number(this.form.paid_amount) + this.expense.paid_amount;
            console.log(this.form.total_paid)

            this.updateDueStat(now)
        },
        updateDueStat: function(due){
            var stat = false;
            if( due == 0 ){
                stat = true
            }
            this.form.is_all_paid = Boolean(stat);
        },
        submit() {
            console.log(this.form)
            this.$inertia.put(this.route('product.update', this.expense.id), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            })
        },
        destroy() {
            console.log(this.expense.id)
            if (confirm('Are you sure you want to delete this entry?')) {
                this.$inertia.delete(this.route('product.destroy', this.expense.id))
            }
        },
        restore() {
            if (confirm('Are you sure you want to restore this entry?')) {
                this.$inertia.put(this.route('product.restore', this.expense.id))
            }
        },
    },
}
</script>
