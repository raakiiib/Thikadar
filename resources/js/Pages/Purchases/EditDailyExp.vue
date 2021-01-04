<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('expenses')">expensess</inertia-link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.name }}
        </h1>
        <trashed-message v-if="expenses.deleted_at" class="mb-6" @restore="restore">
            This expenses has been deleted.
        </trashed-message>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">

                  <!-- <select-input v-model="form.material_id" :error="errors.material_id" @input="getProductName($event)" class="pr-6 pb-8 w-full lg:w-1/2" label="Type" tabindex="1">
                      <option :value="null" />
                      <option v-for="product in products" :key="product.id" :value="product.name+' '+product.type">
                          {{ product.name }} - {{ product.type }}
                      </option>
                  </select-input> -->

                  <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />

                  <text-input type="number" step="any" v-model="form.net_amount" @input="updateAmount" :error="errors.net_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="Amount" tabindex="2" />

                  <text-input type="number" step="any" v-model="form.paid_amount" @input="updateAmount" :error="errors.paid_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="Paid" tabindex="3"/>

                  <text-input type="number" step="any" v-model="form.due_amount" :error="errors.due_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="Due" tabindex="4" />

                  <!-- <text-input type="hidden" v-model="form.is_all_paid" :error="errors.is_all_paid" /> -->

                  <text-input v-model="form.note" :error="errors.note" class="pr-6 pb-8 w-full lg:w-1/2" label="Note" tabindex="5" />

                  <text-input v-model="form.invoice_number" :error="errors.invoice_number" class="pr-6 pb-8 w-full lg:w-1/2" label="Invoice number" />

                  <text-input type="date" value="28-12-2020" v-model="form.created_at" :error="errors.created_at" class="pr-6 pb-8 w-full lg:w-1/2" label="Date" />

              </div>
              <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                  <loading-button :loading="sending" class="btn-indigo" type="submit">ADD EXPENSE</loading-button>
              </div>

          </form>
        </div>
        <h2 class="mt-12 font-bold text-2xl">expenses</h2>
        <div class="mt-6 bg-white rounded shadow overflow-x-auto">
            <!-- <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Name</th>
                    <th class="px-6 pt-6 pb-4">City</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">Phone</th>
                </tr>
                <tr v-for="expense in expenses.expenses" :key="expense.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('expenses.edit', expense.id)">
                            {{ expense.name }}
                            <icon v-if="expense.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('expenses.edit', expense.id)" tabindex="-1">
                            {{ expense.city }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('expenses.edit', expense.id)" tabindex="-1">
                            {{ expense.phone }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('expenses.edit', expense.id)" tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="expenses.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No expenses found.</td>
                </tr>
            </table> -->
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
        expenses: Object,
    },
    remember: 'form',
    data() {
        return {
            sending: false,
            form: {
                name: this.expenses.name,
                material_id: this.expenses.material_id,
                net_amount: this.expenses.net_amount,
                paid_amount: this.expenses.paid_amount,
                due_amount: this.expenses.due_amount,
                is_all_paid: this.expenses.is_all_paid,
                note: this.expenses.note,
                invoice_number: this.expenses.invoice_number,
                created_at: new Date(this.expenses.created_at).toISOString().slice(0,10),
            },
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
            this.$inertia.put(this.route('expensess.update', this.expenses.id), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            })
        },
        destroy() {
            if (confirm('Are you sure you want to delete this expenses?')) {
                this.$inertia.delete(this.route('expensess.destroy', this.expenses.id))
            }
        },
        restore() {
            if (confirm('Are you sure you want to restore this expenses?')) {
                this.$inertia.put(this.route('expensess.restore', this.expenses.id))
            }
        },
    },
        created: function(){
        console.log(this.expenses.name)
    }
}
</script>
