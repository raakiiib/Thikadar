<template>
    <div>
        <h2 class="font-bold text-2xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('dumping.index')">{{ form.name }}</inertia-link>
             এর সকল হিসাব
        </h2>

        <div class="mb-6 mt-8 flex justify-between items-center">
            <search-filter
                v-model="form.search"
                class="w-full max-w-md mr-4"
                @reset="reset"
            >
                <label class="block text-gray-700">Trashed:</label>
                <select v-model="form.trashed" class="mt-1 w-full form-select">
                    <option :value="null" />
                    <option value="with">With Trashed</option>
                    <option value="only">Only Trashed</option>
                </select>
            </search-filter>
        </div>

        <div class="mt-6 bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">তারিখ</th>
                    <th class="px-6 pt-6 pb-4">পরিমান </th>
                    <th class="px-6 pt-6 pb-4">মোট</th>
                    <th class="px-6 pt-6 pb-4">পরিষোধিত</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">বাকি</th>
                </tr>
                <tr v-for="product in vendor.expenses" :key="product.id" class="hover:bg-gray-100 focus-within:bg-gray-100">

                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', product.id)">
                            {{ product.created_at | formatDate }}
                            <icon v-if="product.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('', product.id)" tabindex="-1">
                            {{ product.quantity }} পিস
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('', product.id)" tabindex="-1">
                            &#x09F3; {{ product.net_amount }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('', product.id)" tabindex="-1">
                            &#x09F3; {{ product.paid_amount }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('', product.id)" tabindex="-1">
                            &#x09F3; {{ product.due_amount }}
                        </inertia-link>
                    </td>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <th class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            মোট
                        </span>
                    </th>
                    <th class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            {{ totalQuantity() }} পিস
                        </span>
                    </th>
                    <th class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            &#x09F3; {{ totalNetAmnt() }}
                        </span>
                    </th>
                    <th class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            &#x09F3; {{ totalPaidAmnt() }}
                        </span>
                    </th>
                    <th class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            &#x09F3; {{ totalDueAmnt() }}
                        </span>
                    </th>
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
import SearchFilter from "@/Shared/SearchFilter";


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
        SearchFilter

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
        totalQuantity: function(){
            let total = [];
            Object.entries(this.vendor.expenses).forEach(([key, val]) => {
                total.push(val.quantity)
            });
            return total.reduce(function(total, num){ return total + num }, 0);
        },
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
        reset() {
            this.form = mapValues(this.form, () => null);
        }
    },
}
</script>
