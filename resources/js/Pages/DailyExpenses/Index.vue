<template>
    <div class="">

        <div class="mb-8 flex justify-between items-center">
            <h1 class="font-bold text-3xl">দৈনন্দিন খরচ</h1>

            <inertia-link class="btn-indigo" :href="route('dailyexpense.create')">
                <span>নতুন</span>
                <span class="hidden md:inline">খরচ যোগ</span>
            </inertia-link>
        </div>

        <div class="mb-6 flex justify-between items-center">
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

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">তারিখ</th>
                    <th class="px-6 pt-6 pb-4">খরচের নাম</th>
                    <th class="px-6 pt-6 pb-4">&#x09F3; মোট</th>
                    <th class="px-6 pt-6 pb-4">&#x09F3; পরিষোধিত</th>
                    <th class="px-6 pt-6 pb-4">&#x09F3; বাকি</th>
                </tr>
                <tr
                    v-for="expense in expenses.data"
                    :key="expense.id"
                    class="hover:bg-gray-400 focus-within:bg-gray-100"
                >

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500"
                            :href="route('dailyexpense.edit', expense.id)"
                        >
                            {{ expense.created_at }}
                        </inertia-link>
                    </td>

                    
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center text-indigo-500"
                            :href="route('dailyexpense.edit', expense.id)"
                            tabindex="-1"
                        >
                            {{ expense.name }}
                        </inertia-link>
                    </td>
                    
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('dailyexpense.edit', expense.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ expense.amount }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('dailyexpense.edit', expense.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ expense.paid }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('dailyexpense.edit', expense.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ expense.due }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('dailyexpense.edit', expense.id)" tabindex="-1" >
                            <!-- <icon name="trash" class="block w-6 h-6 fill-red-400" /> -->
                            <icon name="cheveron-right" class="block w-6 h-6 fill-indigo-400" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="expenses.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">
                        No Expenses found.
                    </td>
                </tr>
            </table>
        </div>
        <pagination :links="expenses.links" />
    </div>
</template>

<script>
import Icon from "@/Shared/Icon";
import Layout from "@/Shared/Layout";
import mapValues from "lodash/mapValues";
import Pagination from "@/Shared/Pagination";
import pickBy from "lodash/pickBy";
import SearchFilter from "@/Shared/SearchFilter";
import throttle from "lodash/throttle";

export default {
    metaInfo: { title: "Expenses" },
    layout: Layout,
    components: {
        Icon,
        Pagination,
        SearchFilter
    },
    props: {
        expenses: Object,
        filters: Object
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                trashed: this.filters.trashed
            }
        };
    },
    watch: {
        form: {
            handler: throttle(function() {
                let query = pickBy(this.form);
                this.$inertia.replace(
                    this.route(
                        "expenses.dailyexpense",
                        Object.keys(query).length
                            ? query
                            : { remember: "forget" }
                    )
                );
            }, 150),
            deep: true
        }
    },
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null);
        }
    }
};
</script>
