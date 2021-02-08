<template>
    <div class="">

        <!-- <div class="p-1 mr-1 mb-4 flex flex-wrap">
            <button class="p-1 w-full lg:w-1/3">
                <inertia-link class="block p-3 text-blue-600 bg-gray-300 border-2 border-blue-200"  :href="route('expenses.dailyexpense')">
                    <h1>দৈনন্দিন খরচ</h1>
                </inertia-link>
            </button>
            <button class="p-1 w-full lg:w-1/3">
                <inertia-link class="block p-3 text-blue-600 bg-gray-300 border-2 border-blue-200"  :href="route('expenses.products')">
                    <h1>পণ্য</h1>
                </inertia-link>
            </button>
            <button class="p-1 w-full lg:w-1/3">
                <inertia-link class="block p-3 bg-indigo-600 text-white border-2 border-blue-700"  :href="route('expenses.services')">
                    <h1>সেবা</h1>
                </inertia-link>
            </button>
        </div> -->


        <div class="mb-8 flex justify-between items-center">
            <h1 class="font-bold text-3xl">ব্লক কাস্টিং </h1>
            <inertia-link class="btn-indigo" :href="route('expenses.service')">
                <span>নতুন ব্লক কাস্টিং</span>
                <span class="hidden md:inline"> যোগ করুন</span>
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
                    <th class="px-6 pt-6 pb-4">পণ্য/ সেবা</th>
                    <th class="px-6 pt-6 pb-4">সাপ্লায়ার</th>
                    <th class="px-6 pt-6 pb-4">পরিমান</th>
                    <th class="px-6 pt-6 pb-4">সাইজ</th>
                    <th class="px-6 pt-6 pb-4">একক মূল্য</th>
                    <th class="px-6 pt-6 pb-4">মোট</th>
                    <th class="px-6 pt-6 pb-4">বাকি</th>
                </tr>
                <tr
                    v-for="service in services.data"
                    :key="service.id"
                    class="hover:bg-gray-400 focus-within:bg-gray-100"
                >
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500"
                            :href="route('', service.id)"
                        >
                            {{ service.created_at }}
                        </inertia-link>
                    </td>

                    <!-- <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500"
                            :href="route('', service.id)"
                        >
                            <img
                                v-if="service.photo_path"
                                class="block w-5 h-5 rounded-full mr-2 -my-2"
                                :src="service.photo_path"
                            />
                            {{ service.invoice }}
                            <icon
                                v-if="service.deleted_at"
                                name="trash"
                                class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2"
                            />
                        </inertia-link>
                    </td> -->

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500 text-indigo-500"
                            :href="route('single.service.show', service.service_id)"
                        >
                            {{ service.service }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500 text-indigo-500"
                            :href="route('single.supplier.show', service.supplier_id)"
                            tabindex="-1"
                        >
                            {{ service.supplier }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('service.edit', service.id)"
                            tabindex="-1"
                        >
                            {{ service.quantity }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('service.edit', service.id)"
                            tabindex="-1"
                        >
                            {{ service.size }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('service.edit', service.id)"
                            tabindex="-1"
                        >
                            {{ service.unitprice }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('service.edit', service.id)"
                            tabindex="-1"
                        >
                            {{ service.total }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('service.edit', service.id)"
                            tabindex="-1"
                        >
                            {{ service.due }}
                        </inertia-link>
                    </td>

                    <td class="border-t w-px">
                        <inertia-link
                            class="px-4 flex items-center"
                            :href="route('service.edit', service.id)"
                            tabindex="-1"
                        >
                            <icon
                                name="cheveron-right"
                                class="block w-6 h-6 fill-gray-400"
                            />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="services.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">
                        No services found.
                    </td>
                </tr>
            </table>
        </div>
        <pagination :links="services.links" />
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
    metaInfo: { title: "সেবা সমূহ" },
    layout: Layout,
    components: {
        Icon,
        Pagination,
        SearchFilter
    },
    props: {
        services: Object,
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
                        "expenses.services",
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
