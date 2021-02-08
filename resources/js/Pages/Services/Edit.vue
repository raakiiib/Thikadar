<template>
	<div>
		<h1 class="mb-8 font-bold text-3xl">
			<inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('services')">ব্লক</inertia-link>
			<span class="text-indigo-400 font-medium">/</span>
			{{ form.name }}
		</h1>
		<trashed-message v-if="service.deleted_at" class="mb-6" @restore="restore">
			This service has been deleted.
		</trashed-message>
		<div class="bg-white rounded shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="submit">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="নাম" />

					<text-input v-model="form.dimension" :error="errors.dimension" @input="getActualSize" class="pr-6 pb-8 w-full lg:w-1/2" label="আকার" />
					
					<text-input v-model="form.size" :error="errors.size" class="pr-6 pb-8 w-full lg:w-1/2" label="পরিমাপ" />

					<text-input v-model="form.unit" disabled="true" :error="errors.unit" class="pr-6 pb-8 w-full lg:w-1/2" label="একক" placeholder="CFT" />
					
					<text-input v-model="form.description" :error="errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="বিবরণ" />
				</div>
				<div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
					<button v-if="!service.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete service</button>
					<loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Update service</loading-button>
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
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
	created() {
		console.log(this.service)
	},
	metaInfo() {
		return {
			title: `${this.form.name}`,
		}
	},
	layout: Layout,
	components: {
		LoadingButton,
		SelectInput,
		TextInput,
		TrashedMessage,
	},
	props: {
		errors: Object,
		service: Object,
	},
	remember: 'form',
	data() {
		return {
			sending: false,
			form: {
				name: this.service.name,
		        dimension: this.service.dimension,
		        size: this.service.size,
		        unit: this.service.unit,
				description: this.service.description,
			},
		}
	},
	methods: {
		getActualSize: function(){
	        const dimension = this.form.dimension
	        const dimension_array = dimension.split(',')
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
			this.$inertia.put(this.route('services.update', this.service.id), this.form, {
				onStart: () => this.sending = true,
				onFinish: () => this.sending = false,
			})
		},
		destroy() {
			if (confirm('Are you sure you want to delete this service?')) {
				this.$inertia.delete(this.route('services.destroy', this.service.id))
			}
		},
		restore() {
			if (confirm('Are you sure you want to restore this service?')) {
				this.$inertia.put(this.route('services.restore', this.service.id))
			}
		},
	},
}
</script>
