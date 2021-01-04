<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('expenses.dailyexpense')">&#8678; Expneses</inertia-link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.name }}
        </h1>
        <trashed-message v-if="expense.deleted_at" class="mb-6" @restore="restore">
            This supplier has been deleted.
        </trashed-message>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input disabled v-model="form.created_at" :error="errors.created_at" class="pr-6 pb-8 w-full lg:w-1/2" label="Date Created" />

                    <!-- <select-input v-model="form.material_id" :error="errors.material_id" @input="getProductName($event)" class="pr-6 pb-8 w-full lg:w-1/2" label="Type" tabindex="1">
                      <option :value="null" />
                      <option v-for="product in products" :key="product.id" :value="product.name+' '+product.type">
                          {{ product.name }} - {{ product.type }}
                      </option>
                  </select-input> -->

                  <text-input disabled v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Expense type" />

                  <text-input disabled type="number" step="any" v-model="form.net_amount" @input="updateAmount" :error="errors.net_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="Amount" tabindex="2" />

                  <text-input type="number" step="any" v-model="form.paid_amount" @input="updateAmount" :error="errors.paid_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="Paid" tabindex="3"/>

                  <text-input type="number" step="any" v-model="form.due_amount" :error="errors.due_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="Due" tabindex="4" />


                  <text-input v-model="form.note" :error="errors.note" class="pr-6 pb-8 w-full lg:w-1/2" label="Note" tabindex="5" />

                  <text-input disabled v-model="form.invoice_number" :error="errors.invoice_number" class="pr-6 pb-8 w-full lg:w-1/2" label="Invoice number" />

                  

                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                    <button v-if="!expense.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete expense</button>
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
                name: this.expense.name,
                material_id: this.expense.material_id,
                net_amount: String(this.expense.net_amount),
                paid_amount: String(this.expense.paid_amount),
                due_amount: String(this.expense.due_amount),
                is_all_paid: this.expense.is_all_paid,
                note: this.expense.note,
                invoice_number: this.expense.invoice_number,
                created_at: this.expense.created_at,
            },
        }
    },
    methods: {
        created(){
            console.log('hello');
        },
        beforeMount(){
            console.log('before mount');
        },
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
            // this.$inertia.put(this.route('expenses.update', this.expense.id), this.form, {
            //     onStart: () => this.sending = true,
            //     onFinish: () => this.sending = false,
            // })
        },
        destroy() {
            console.log(this.expense.id)
            if (confirm('Are you sure you want to delete this supplier?')) {
                this.$inertia.delete(this.route('expenses.destroy', this.expense.id))
            }
        },
        restore() {
            if (confirm('Are you sure you want to restore this supplier?')) {
                this.$inertia.put(this.route('expenses.restore', this.supplier.id))
            }
        },
    },
}
</script>
