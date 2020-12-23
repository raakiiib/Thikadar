<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('staffs')">staffs</inertia-link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.name }}
        </h1>
        <trashed-message v-if="staff.deleted_at" class="mb-6" @restore="restore">
            This staff has been deleted.
        </trashed-message>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
                    <text-input v-model="form.email" :error="errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />

                    <text-input v-model="form.phone" :error="errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />

                    <text-input type="date" v-model="form.date_of_birth" :error="errors.date_of_birth" class="pr-6 pb-8 w-full lg:w-1/2" name="date_of_birth" label="Date of birth" />

                    <text-input type="number" v-model="form.national_id" :error="errors.national_id" class="pr-6 pb-8 w-full lg:w-1/2" label="NID" />

                    <text-input type="number" v-model="form.salary" :error="errors.salary" class="pr-6 pb-8 w-full lg:w-1/2" label="Salary" />

                    <text-input v-model="form.address" :error="errors.address" class="pr-6 pb-8 w-full lg:w-1/2" label="Address" />

                    <text-input v-model="form.village" :error="errors.village" class="pr-6 pb-8 w-full lg:w-1/2" label="Village" />

                    <text-input v-model="form.district" :error="errors.district" class="pr-6 pb-8 w-full lg:w-1/2" label="District" />

                    <select-input v-model="form.country" :error="errors.country" class="pr-6 pb-8 w-full lg:w-1/2" label="Country">
                        <option :value="null" />
                        <option value="CA">Canada</option>
                        <option value="US">United States</option>
                    </select-input>

                    <text-input v-model="form.postal_code" :error="errors.postal_code" class="pr-6 pb-8 w-full lg:w-1/2" label="Postal code" />

                    <!-- <file-input v-model="form.photo_path" :error="errors.photo_path" class="pr-6 pb-8 w-full lg:w-1/2" type="file" accept="image/*" label="Photo" /> -->

                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                    <button v-if="!staff.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete staff</button>
                    <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Update staff</loading-button>
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
// import FileInput from '@/Shared/FileInput'

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
        // FileInput
    },
    props: {
        errors: Object,
        staff: Object,
    },
    remember: 'form',
    data() {
        return {
            sending: false,
            form: {
                name: this.staff.name,
                email: this.staff.email,
                phone: this.staff.phone,
                date_of_birth: this.staff.date_of_birth,
                national_id: this.staff.national_id,
                salary: this.staff.salary,
                address: this.staff.address,
                village: this.staff.village,
                district: this.staff.district,
                country: this.staff.country,
                postal_code: this.staff.postal_code,
                // photo_path: this.staff.photo_path,
            },
        }
    },
    methods: {
        created(){
            console.log('hello');
        },
        mounted(){
            console.log('mounted....');
        },
        updated(){
            console.log('updated....');
        },
        submit() {
            this.$inertia.put(this.route('staffs.update', this.staff.id), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            })
        },
        destroy() {
            if (confirm('Are you sure you want to delete this staff?')) {
                this.$inertia.delete(this.route('staffs.destroy', this.staff.id))
            }
        },
        restore() {
            if (confirm('Are you sure you want to restore this staff?')) {
                this.$inertia.put(this.route('staffs.restore', this.staff.id))
            }
        },
    },
}
</script>
