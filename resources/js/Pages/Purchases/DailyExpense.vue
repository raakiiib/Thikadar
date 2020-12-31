<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('expenses.dailyexpense')">Daily Expense</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Add
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">

          <select-input v-model="form.material_id" :error="errors.material_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Type" tabindex="1">
              <option :value="null" />
              <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }} - {{ product.type }}</option>                        
          </select-input>

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
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'

export default {
  metaInfo: { title: 'CREATE MATERIAL' },
  layout: Layout,
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
  },
  props: {
    invoice_number: String,
    products: Array,
    errors: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: null,
        material_id: null,
        net_amount: null,
        paid_amount: null,
        due_amount: null,
        is_all_paid: false,
        note: null,
        invoice_number: this.invoice_number,
        created_at: new Date().toISOString().slice(0,10),
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
      console.log(this.form)

      this.$inertia.post(this.route('purchases.storeExpense'), this.form, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })

    },
  },
}
</script>
