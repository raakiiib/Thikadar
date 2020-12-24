<template>
	<div>
		<h1 class="mb-8 font-bold text-3xl">
			<inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('materials')">materials</inertia-link>
			<span class="text-indigo-400 font-medium">/</span>
			{{ form.name }}
		</h1>
		<trashed-message v-if="material.deleted_at" class="mb-6" @restore="restore">
			This material has been deleted.
		</trashed-message>
		<div class="bg-white rounded shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="submit">
				<div class="p-8 -mr-6 -mb-8 flex flex-wrap">
					<text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Product name" />
					
					<text-input v-model="form.type" :error="errors.type" class="pr-6 pb-8 w-full lg:w-1/2" label="Type" />

					<text-input v-model="form.unit" :error="errors.unit" class="pr-6 pb-8 w-full lg:w-1/2" label="Measure Unit" />

					<text-input v-model="form.description" :error="errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
				</div>
				<div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
					<button v-if="!material.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete material</button>
					<loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Update material</loading-button>
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
		console.log(this.material)
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
		material: Object,
	},
	remember: 'form',
	data() {
		return {
			sending: false,
			form: {
				name: this.material.name,
				type: this.material.type,
				unit: this.material.unit,
				description: this.material.description,
			},
		}
	},
	methods: {
		submit() {
			this.$inertia.put(this.route('materials.update', this.material.id), this.form, {
				onStart: () => this.sending = true,
				onFinish: () => this.sending = false,
			})
		},
		destroy() {
			if (confirm('Are you sure you want to delete this material?')) {
				this.$inertia.delete(this.route('materials.destroy', this.material.id))
			}
		},
		restore() {
			if (confirm('Are you sure you want to restore this material?')) {
				this.$inertia.put(this.route('materials.restore', this.material.id))
			}
		},
	},
}
</script>
