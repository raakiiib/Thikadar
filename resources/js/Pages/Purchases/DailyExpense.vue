<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('expenses.dailyexpense')">&#8678; দৈনন্দিন খরচ</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> যোগ
  </h1>
  <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">

          <text-input v-model="form.invoice_number" :error="errors.invoice_number" class="pr-6 pb-8 w-full lg:w-1/2" label="সিরিয়াল" />

          <text-input type="date" value="28-12-2020" v-model="form.created_at" :error="errors.created_at" class="pr-6 pb-8 w-full lg:w-1/2" label="তারিখ" />

          <select-input v-model="form.product_id" :error="errors.product_id" class="pr-6 pb-8 w-full lg:w-1/2" label="প্রাপক" tabindex="1">
              <option :value="null" />
              <option v-for="expense in expenses.data" :key="expense.id" :value="expense.id">
                  {{ expense.name }}
              </option>
          </select-input>

          <!-- <select-input v-model="form.vendor_id" :error="errors.vendor_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Receiver">
            <option :value="null" />
            <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{ supplier.name }}</option>
        </select-input> -->

        <text-input type="number" step="any" v-model="form.net_amount" @input="updateAmount" :error="errors.net_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="মোট টাকার পরিমান" tabindex="3" />

        <text-input type="number" step="any" v-model="form.paid_amount" @input="updateAmount" :error="errors.paid_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="পরিষোধ" tabindex="4"/>

        <text-input disabled type="number" step="any" v-model="form.due_amount" :error="errors.due_amount" class="pr-6 pb-8 w-full lg:w-1/2" label="বাকি টাকার পরিমান" tabindex="5" />
        
        <select-input v-model="form.pay_type" :error="errors.pay_type" class="pr-6 pb-8 w-full lg:w-1/4" label="খরচের ধরন">
            <option value="মূল্য/ দাম">মূল্য/ দাম</option>
            <option value="গাড়ি ভাড়া">গাড়ি ভাড়া</option>
            <option value="মজুরি">মজুরি</option>
            <option value="ক্রয়">ক্রয়</option>
            <option value="মেরামত">মেরামত</option>
            <option value="বেতন">বেতন</option>
            <option value="চাঁদা">চাঁদা</option>
            <option value="অন্যান্য">অন্যান্য</option>
        </select-input>
        
        <text-input v-model="form.note" :error="errors.note" class="pr-6 pb-8 w-full lg:w-3/4" label="বর্ণনা" tabindex="2" />

        <!-- <file-input v-model="form.photo_path" :error="errors.photo_path" class="pr-6 pb-8 w-full lg:w-1/2" type="file" accept="image/*" label="Money receipt" tabindex="6" /> -->

    </div>
    <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
      <loading-button :loading="sending" class="btn-indigo" type="submit">যোগ</loading-button>
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
  metaInfo: { title: 'CREATE MATERIAL' },
  layout: Layout,
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
    FileInput
},
props: {
    invoice_number: String,
    expenses: Object,
    suppliers: Array,
    errors: Object,
},
remember: 'form',
data() {
    return {
      sending: false,
      form: {
        expense_type: Number(3), // Daily expense
        product_id: null,
        vendor_id: null,
        invoice_number: this.invoice_number,
        net_amount: null,
        paid_amount: null,
        due_amount: null,
        is_all_paid: false,
        pay_type: null,
        note: null,
        photo_path: null,
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

      const formData = new FormData()
      formData.append('invoice_number', this.form.invoice_number || '')
      formData.append('created_at', this.form.created_at || '')
      formData.append('expense_type', this.form.expense_type || '')
      formData.append('product_id', this.form.product_id || '')
      formData.append('vendor_id', this.form.vendor_id || '')
      formData.append('net_amount', this.form.net_amount || '')
      formData.append('due_amount', this.form.due_amount || '')
      formData.append('pay_type', this.form.pay_type || '')
      formData.append('paid_amount', this.form.paid_amount || '')
      formData.append('note', this.form.note || '')

      if( this.form.is_all_paid ){
        formData.append('is_all_paid', 1)
    }else{
        formData.append('is_all_paid', 0)
    }

    formData.append('photo_path', this.form.photo_path || '')

    console.log(this.formData)

    this.$inertia.post(this.route('dailyexpense.store'), formData, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
    })

},
},
}
</script>
