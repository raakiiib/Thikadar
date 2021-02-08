<template>
	<div>
		<h1 class="mb-8 font-bold text-3xl">
			<inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('services')">services</inertia-link>
			<span class="text-indigo-400 font-medium">/</span>
			{{ form.name }}
		</h1>
		<trashed-message v-if="service.deleted_at" class="mb-6" @restore="restore">
			This service has been deleted.
		</trashed-message>
		<div class="bg-white rounded shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="submit">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />

					<text-input v-model="form.dimension" :error="errors.dimension" class="pr-6 pb-8 w-full lg:w-1/2" label="Size" />
					
					<text-input v-model="form.size" :error="errors.size" class="pr-6 pb-8 w-full lg:w-1/2" label="Size" />

					

					<text-input v-model="form.description" :error="errors.description" class="pr-6 pb-8 w-full lg:w-1/1" label="Description" />
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
