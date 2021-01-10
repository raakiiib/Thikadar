<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('expenses.dailyexpense')">&#8678; Expneses</inertia-link>
            <span class="text-indigo-400 font-medium">/</span>
            {{expense.note}}
        </h1>
        <trashed-message v-if="expense.deleted_at" class="mb-6" @restore="restore">
            This supplier has been deleted.
        </trashed-message>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">

                    <text-input disabled v-model="form.invoice_number" :error="errors.invoice_number" class="pr-6 pb-8 w-full lg:w-1/2" label="Invoice number" />

                    <text-input disabled v-model="form.created_at" :error="errors.created_at" class="pr-6 pb-8 w-full lg:w-1/2" label="Date" />
                    

                    <text-input disabled v-model="form.expense_name" :error="errors.expense_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Expense name" />

                    <text-input v-model="form.note" :error="errors.note" class="pr-6 pb-8 w-full lg:w-1/2" label="Note" tabindex="5" />

                    <text-input disabled type="number" step="any" v-model="form.net_amount" @input="updateAmount" :error="errors.net_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="Amount" tabindex="2" />

                    <text-input :disabled="expense.is_all_paid == 1" type="number" step="any" v-model="form.paid_amount" @input="updateAmount" :error="errors.paid_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="Paid" tabindex="3"/>

                    <text-input type="number" disabled step="any" v-model="form.due_amount" :error="errors.due_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="Due" tabindex="4" />

                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center content-center">
                    <button v-if="!expense.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">
                        <icon name="trash" class="block w-6 h-6 fill-red-600"/> 
                        <!-- <span >REMOVE</span> -->
                    </button>

                    <loading-button :loading="sending" v-if="!expense.is_all_paid" class="btn-indigo ml-auto" type="submit">Update expense</loading-button>
                </div>
            </form>
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
                invoice_number: this.expense.invoice_number,
                created_at: this.expense.date,
                expense_name: this.expense.name,
                net_amount: String(this.expense.net_amount),
                paid_amount: String(this.expense.paid_amount),
                due_amount: String(this.expense.due_amount),
                is_all_paid: this.expense.is_all_paid,
                note: this.expense.note,
            },
        }
    },
    computed: {
        getPayBtn: function(){
            if( this.expense.due_amount == 0 ){
                this.form.paid_amount.prop(disabled)
            }
        }
    },
    methods: {

        updateAmount: function() {
            var total = this.form.net_amount
            var paid = this.form.paid_amount
            var due = (total - paid)
            due = due.toFixed(2);
            this.form.due_amount = String(due);
            this.updateDueStat(due);
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
            this.$inertia.put(this.route('expenses.update', this.expense.id), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            })
        },
        destroy() {
            console.log(this.expense.id)
            if (confirm('Are you sure you want to delete this entry?')) {
                this.$inertia.delete(this.route('expenses.destroy', this.expense.id))
            }
        },
        restore() {
            if (confirm('Are you sure you want to restore this entry?')) {
                this.$inertia.put(this.route('expenses.restore', this.expense.id))
            }
        },
    },
}
</script>
