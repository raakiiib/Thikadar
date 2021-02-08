<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('suppliers')">Suppliers</inertia-link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.name }}
        </h1>
        <trashed-message v-if="supplier.deleted_at" class="mb-6" @restore="restore">
            This supplier has been deleted.
        </trashed-message>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
                    <text-input v-model="form.email" :error="errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />
                    <text-input v-model="form.phone" :error="errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
                    <text-input v-model="form.address" :error="errors.address" class="pr-6 pb-8 w-full lg:w-1/2" label="Address" />
                    <text-input v-model="form.city" :error="errors.city" class="pr-6 pb-8 w-full lg:w-1/2" label="City" />
                    <text-input v-model="form.region" :error="errors.region" class="pr-6 pb-8 w-full lg:w-1/2" label="Province/State" />
                    <select-input v-model="form.country" :error="errors.country" class="pr-6 pb-8 w-full lg:w-1/2" label="Country">
                        <option :value="null" />
                        <option value="CA">Canada</option>
                        <option value="US">United States</option>
                    </select-input>
                    <text-input v-model="form.postal_code" :error="errors.postal_code" class="pr-6 pb-8 w-full lg:w-1/2" label="Postal code" />
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                    <button v-if="!supplier.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete supplier</button>
                    <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Update supplier</loading-button>
                </div>
            </form>
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
        supplier: Object,
    },
    remember: 'form',
    data() {
        return {
            sending: false,
            form: {
                name: this.supplier.name,
                email: this.supplier.email,
                phone: this.supplier.phone,
                address: this.supplier.address,
                city: this.supplier.city,
                region: this.supplier.region,
                country: this.supplier.country,
                postal_code: this.supplier.postal_code,
            },
        }
    },
    methods: {
        submit() {
            this.$inertia.put(this.route('suppliers.update', this.supplier.id), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            })
        },
        destroy() {
            if (confirm('Are you sure you want to delete this supplier?')) {
                this.$inertia.delete(this.route('suppliers.destroy', this.supplier.id))
            }
        },
        restore() {
            if (confirm('Are you sure you want to restore this supplier?')) {
                this.$inertia.put(this.route('suppliers.restore', this.supplier.id))
            }
        },
    },
}
</script>
