<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('expenses.dailyexpense')">Daily Expense</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Add
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">

          <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />

          <text-input v-model="form.type" :error="errors.type" class="pr-6 pb-8 w-full lg:w-1/2" label="Type" />

          <text-input type="number" step="any" v-model="form.amount" :error="errors.amount" class="pr-6 pb-8 w-full lg:w-1/2" label="Amount" />

          <text-input v-model="form.note" :error="errors.note" class="pr-6 pb-8 w-full lg:w-1/2" label="Note" />

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
    errors: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: null,
        type: null,
        amount: null,
        note: null,
        invoice_number: this.invoice_number,
        created_at: new Date().toISOString().slice(0,10),
      },
    }
  },
  methods: {
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
