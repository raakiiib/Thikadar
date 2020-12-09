<template>
	<div>
		<h1 class="mb-8 font-bold text-3xl">
			<inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('vehicles')">Vehicles</inertia-link>
			<span class="text-indigo-400 font-medium">/</span>
			{{ form.driver_name }}
		</h1>
		<trashed-message v-if="vehicles.deleted_at" class="mb-6" @restore="restore">
			This vehicle has been deleted.
		</trashed-message>
		<div class="bg-white rounded shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="submit">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<text-input v-model="form.driver_name" :error="errors.driver_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Driver name" />
					<text-input v-model="form.driver_phone" :error="errors.driver_phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Driver phone" />

					<text-input v-model="form.chassis_number" :error="errors.chassis_number" class="pr-6 pb-8 w-full lg:w-1/2" label="Chassis number" />
					
					<text-input v-model="form.registration_number" :error="errors.registration_number" class="pr-6 pb-8 w-full lg:w-1/2" label="Registration number" />

					<text-input v-model="form.description" :error="errors.description" class="pr-6 pb-8 w-full lg:w-1/1" label="Description" />
				</div>



				<div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
					<button v-if="!vehicles.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete vehicle</button>
					<loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">UPDATE VEHICLE</loading-button>
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
	metaInfo() {
		return {
			title: `${this.form.driver_name}`,
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
		vehicles: Object,
	},
	remember: 'form',
	data() {
		return {
			sending: false,
			form: {
				driver_name: this.vehicles.driver_name,
				driver_phone: this.vehicles.driver_phone,
				chassis_number: this.vehicles.chassis_number,
				registration_number: this.vehicles.registration_number,
				description: this.vehicles.description,
			},
		}
	},
	methods: {
		created(){
			// console.log(this.vehicles);
		},
		submit() {
			this.$inertia.put(this.route('vehicles.update', this.vehicles.id), this.form, {
				onStart: () => this.sending = true,
				onFinish: () => this.sending = false,
			})
		},
		destroy() {
			if (confirm('Are you sure you want to delete this vehicle?')) {
				this.$inertia.delete(this.route('vehicles.destroy', this.vehicles.id))
			}
		},
		restore() {
			if (confirm('Are you sure you want to restore this vehicle?')) {
				this.$inertia.put(this.route('vehicles.restore', this.vehicles.id))
			}
		},
	},
}
</script>
