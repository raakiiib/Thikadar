<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('beneficiary')">&#8678; পাওনাদার</inertia-link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.name }}
        </h1>
        <trashed-message v-if="type.deleted_at" class="mb-6" @restore="restore">
            This type has been deleted.
        </trashed-message>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="নাম" />
                    <text-input v-model="form.note" :error="errors.note" class="pr-6 pb-8 w-full lg:w-1/2" label="বর্ণনা" />
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                    <button v-if="!type.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">
                        <icon name="trash" class="block w-6 h-6 fill-red-600"/> 
                    </button>
                    <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">হালনাগাদ</loading-button>
                </div>
            </form>
        </div>
        <!-- Showing all expenses under this item -->
        <h2 class="mt-12 font-bold text-2xl">{{ form.name }} এর সকল হিসাব</h2>
        <div class="mt-6 bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">তারিখ</th>
                    <th class="px-6 pt-6 pb-4">বর্ণনা</th>
                    <th class="px-6 pt-6 pb-4">মোট টাকা</th>
                    <th class="px-6 pt-6 pb-4">পরিষোধিত টাকা</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">বাকি টাকা</th>
                </tr>
                <tr v-for="exp in type.expenses" :key="exp.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('dailyexpense.edit', exp.id)">
                            {{ exp.created_at | formatDate }}
                            <icon v-if="exp.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('dailyexpense.edit', exp.id)" tabindex="-1">
                            {{ exp.note }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('dailyexpense.edit', exp.id)" tabindex="-1">
                            {{ exp.net_amount }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('dailyexpense.edit', exp.id)" tabindex="-1">
                            {{ exp.paid_amount }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('dailyexpense.edit', exp.id)" tabindex="-1">
                            {{ exp.due_amount }}
                        </inertia-link>
                    </td>

                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('dailyexpense.edit', exp.id)" tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                        </inertia-link>
                    </td>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td>&nbsp;</td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            মোট হিসাব
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            {{ totalNetAmnt() }}
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            {{ totalPaidAmnt() }}
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            {{ totalDueAmnt() }}
                        </span>
                    </td>
                </tr>
                <tr v-if="type.expenses.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No entry found.</td>
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
        type: Object,
    },
    remember: 'form',
    data() {
        return {
            sending: false,
            form: {
                name: this.type.name,
                note: this.type.note,
            },
        }
    },
    methods: {
        totalNetAmnt: function(){

            let total = [];
            Object.entries(this.type.expenses).forEach(([key, val]) => {
                total.push(val.net_amount) // the value of the current key.
            });
            return total.reduce(function(total, num){ return total + num }, 0);
        },
        totalPaidAmnt: function(){

            let total = [];
            Object.entries(this.type.expenses).forEach(([key, val]) => {
                total.push(val.paid_amount) // the value of the current key.
            });
            return total.reduce(function(total, num){ return total + num }, 0);
        },
        totalDueAmnt: function(){

            let total = [];
            Object.entries(this.type.expenses).forEach(([key, val]) => {
                total.push(val.due_amount) // the value of the current key.
            });
            return total.reduce(function(total, num){ return total + num }, 0);
        },
        created(){
            console.log('hello');
        },
        beforeMount(){
            console.log('before mount');
        },
        submit() {
            console.log(this.form)
            this.$inertia.put(this.route('beneficiary.update', this.type.id), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            })
        },
        destroy() {
            if (confirm('Are you sure you want to delete this type?')) {
                this.$inertia.delete(this.route('beneficiary.destroy', this.type.id))
            }
        },
        restore() {
            if (confirm('Are you sure you want to restore this type?')) {
                this.$inertia.put(this.route('beneficiary.restore', this.type.id))
            }
        },
    },
}
</script>
