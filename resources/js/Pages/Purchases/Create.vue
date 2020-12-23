<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('products')">PRODUCT</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> BUY
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">

                    <select-input v-model="form.country" :error="errors.country" class="pr-6 pb-8 w-full lg:w-1/2" label="Product">
                        <option value="CA">Cement</option>
                        <option value="US">Sand</option>
                        <option value="US">Stone</option>
                    </select-input>

                    <select-input v-model="form.country" :error="errors.country" class="pr-6 pb-8 w-full lg:w-1/2" label="Supplier">
                        <option value="CA">Mr Farid</option>
                        <option value="US">Bablu sordar</option>
                        <option value="US">Sajib mia</option>
                    </select-input>

                    <text-input type="number" step="0.01" v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Unit price" />

                    <text-input type="number" step="0.01" v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Quantity" />

                    <text-input disabled v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Total amount" />

                    <text-input disabled v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Invoice number" />

                   
                    <!-- <file-input v-model="form.photo_path" :error="errors.photo_path" class="pr-6 pb-8 w-full lg:w-1/2" type="file" accept="image/*" label="Photo" /> -->

                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <loading-button :loading="sending" class="btn-indigo" type="submit">Create staff</loading-button>
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
        metaInfo: { title: 'Create staff' },
        layout: Layout,
        components: {
            LoadingButton,
            SelectInput,
            TextInput,
            FileInput
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
                    email: null,
                    phone: null,
                    national_id: null,
                    date_of_birth: null,
                    salary: null,
                    address: null,
                    village: null,
                    district: null,
                    country: null,
                    postal_code: null,
                    photo_path: null,
                },
            }
        },
        methods: {
            submit() {
                const data = new FormData()
                data.append('name', this.form.name || '')
                data.append('email', this.form.email || '')
                data.append('phone', this.form.phone || '')
                data.append('national_id', this.form.national_id || '')
                data.append('date_of_birth', this.form.date_of_birth || '')

                data.append('salary', this.form.salary || '')
                data.append('address', this.form.address || '')
                data.append('village', this.form.village || '')
                data.append('district', this.form.district || '')
                data.append('country', this.form.country || '')
                data.append('postal_code', this.form.postal_code || '')
                data.append('photo_path', this.form.photo_path || '')

                this.$inertia.post(this.route('staffs.store'), data, {
                    onStart: () => this.sending = true,
                    onFinish: () => this.sending = false,
                })
            },
        },
    }
</script>
