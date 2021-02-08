<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('services')">ব্লক</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" placeholder="Name(Dimension)" />

          <text-input v-model="form.dimension" @input="getActualSize" :error="errors.dimension" class="pr-6 pb-8 w-full lg:w-1/2" label="Dimension" placeholder="45x45x45" />

          <text-input v-model="form.size" :error="errors.size" class="pr-6 pb-8 w-full lg:w-1/2" label="Size" placeholder="2.14" />
          
          <text-input v-model="form.unit" disabled="true" :error="errors.unit" class="pr-6 pb-8 w-full lg:w-1/2" label="Unit" placeholder="CFT" />


          <text-input v-model="form.description" :error="errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" placeholder="Brief Description" />

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
        size: null,
        unit: null,
        dimension: null,
        description: null,
      },
    }
  },
  methods: {
    getActualSize: function(){
        const dimension = this.form.dimension
        const dimension_array = dimension.split('-')
        const size_of_dimenstion = dimension_array.length;

        if( size_of_dimenstion == 2 ){
            this.getSFT( dimension_array )
        }else if( size_of_dimenstion == 3 ) {
            this.getCFT( dimension_array )
        }
    },
    getCFT: function(arr){
        var total_meter, cubic_feet, length_meter, width_meter, height_meter
        length_meter = parseFloat( arr[0]/100 )
        width_meter = parseFloat( arr[1]/100 )
        height_meter = parseFloat( arr[2]/100 )

        total_meter = length_meter * width_meter * height_meter

        cubic_feet = total_meter * 35.3147
        cubic_feet = ((Math.round(cubic_feet * 100) / 100).toFixed(2))

        // this.form.dimension = arr
        this.form.size = cubic_feet
        this.form.unit = 'CFT'
        console.log( cubic_feet )
    },
    getSFT: function(arr){
        var width_meter, height_meter, total_meter, square_feet

        width_meter = parseFloat( arr[0]/100 )
        height_meter = parseFloat( arr[0]/100 )

        total_meter = width_meter * height_meter

        square_feet = total_meter * 3.2808
        square_feet = ((Math.round(square_feet * 100) / 100).toFixed(2))
        this.form.size = square_feet
        this.form.unit = 'SFT'
        console.log(total_meter);
    },
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
