<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('services')">Services</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />

          <text-input v-model="form.type" :error="errors.type" class="pr-6 pb-8 w-full lg:w-1/2" label="Type" />
          <text-input v-model="form.type" :error="errors.type" class="pr-6 pb-8 w-full lg:w-1/2" label="Size" />

          <select-input v-model="form.country" :error="errors.country" class="pr-6 pb-8 w-full lg:w-1/2" label="Unit">
            <option value="CFT">Cubic feet(CFT)</option>
            <option value="SFT">Square feet(SFT)</option>
            <option value="FT">FEET</option>
            <option value="M">METER</option>
          </select-input>
          <text-input v-model="form.description" :error="errors.description" class="pr-6 pb-8 w-full lg:w-1/1" label="Description" />

        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
          <loading-button :loading="sending" class="btn-indigo" type="submit">ADD SERVICE</loading-button>
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
  metaInfo: { title: 'Create service' },
  layout: Layout,
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
  },
  props: {
    errors: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: null,
        type: null,
        size: null,
        unit: null,
        description: null,
      },
    }
  },
  methods: {
    submit() {
      console.log(this.form)
      this.$inertia.post(this.route('services.store'), this.form, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })
    },
  },
}
</script>
