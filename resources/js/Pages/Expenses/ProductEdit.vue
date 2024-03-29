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
        <h2 class="mt-12 font-bold text-2xl">Contacts</h2>
        <div class="mt-6 bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Name</th>
                    <th class="px-6 pt-6 pb-4">City</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">Phone</th>
                </tr>
                <tr v-for="contact in supplier.contacts" :key="contact.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('contacts.edit', contact.id)">
                            {{ contact.name }}
                            <icon v-if="contact.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
                            {{ contact.city }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
                            {{ contact.phone }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="supplier.contacts.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No contacts found.</td>
                </tr>
            </table>
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
        created(){
            console.log('hello');
        },
        beforeMount(){
            console.log('before mount');
        },
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
