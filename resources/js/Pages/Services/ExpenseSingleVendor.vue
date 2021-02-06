<template>
    <div>
        <h2 class="mt-12 font-bold text-2xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('expenses.services')">{{ form.name }}</inertia-link>
             এর সকল হিসাব
        </h2>
        <div class="mt-6 bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">তারিখ</th>
                    <!-- <th class="px-6 pt-6 pb-4">বর্ণনা</th> -->
                    <th class="px-6 pt-6 pb-4">মোট টাকা</th>
                    <th class="px-6 pt-6 pb-4">পরিষোধিত টাকা</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">বাকি টাকা</th>
                </tr>
                <tr v-for="product in vendor.expenses" :key="product.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', product.id)">
                            {{ product.created_at | formatDate }}
                            <icon v-if="product.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                        </inertia-link>
                    </td>
                    <!-- <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('', product.id)" tabindex="-1">
                            {{ product.note }}
                        </inertia-link>
                    </td> -->

                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('', product.id)" tabindex="-1">
                            {{ product.net_amount }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('', product.id)" tabindex="-1">
                            {{ product.paid_amount }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('', product.id)" tabindex="-1">
                            {{ product.due_amount }}
                        </inertia-link>
                    </td>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <!-- <td>&nbsp;</td> -->
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            মোট
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
                <tr v-if="vendor.expenses.length === 0">
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
        vendor: Object,
    },
    remember: 'form',
    data() {
        return {
            sending: false,
            form: {
                name: this.vendor.name,
                note: this.vendor.note,
            },
        }
    },
    methods: {
        totalNetAmnt: function(){

            let total = [];
            Object.entries(this.vendor.expenses).forEach(([key, val]) => {
                total.push(val.net_amount) // the value of the current key.
            });
            return total.reduce(function(total, num){ return total + num }, 0);
        },
        totalPaidAmnt: function(){

            let total = [];
            Object.entries(this.vendor.expenses).forEach(([key, val]) => {
                total.push(val.paid_amount) // the value of the current key.
            });
            return total.reduce(function(total, num){ return total + num }, 0);
        },
        totalDueAmnt: function(){

            let total = [];
            Object.entries(this.vendor.expenses).forEach(([key, val]) => {
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
            this.$inertia.put(this.route('exptypes.update', this.vendor.id), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            })
        },
        destroy() {
            if (confirm('Are you sure you want to delete this type?')) {
                this.$inertia.delete(this.route('exptypes.destroy', this.vendor.id))
            }
        },
        restore() {
            if (confirm('Are you sure you want to restore this type?')) {
                this.$inertia.put(this.route('exptypes.restore', this.vendor.id))
            }
        },
    },
}
</script>
