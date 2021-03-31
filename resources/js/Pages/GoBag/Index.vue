<template>
    <div class="">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="font-bold text-3xl">GO BAG</h1>
            <inertia-link class="btn-indigo" :href="route('gobag.create')">
                <span>নতুন GO BAG </span>
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
                    <th class="px-6 pt-6 pb-4">সাপ্লায়ার</th>
                    <th class="px-6 pt-6 pb-4">পরিমান</th>
                    <th class="px-6 pt-6 pb-4">সাইজ</th>
                    <th class="px-6 pt-6 pb-4">প্রতিটির মূল্য</th>
                    <th class="px-6 pt-6 pb-4">মোট</th>
                    <th class="px-6 pt-6 pb-4">পরিষোধিত</th>
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

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500 text-indigo-500"
                            :href="route('', service.supplier_id)"
                            tabindex="-1"
                        >
                            {{ service.supplier }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('', service.id)"
                            tabindex="-1"
                        >
                            {{ service.quantity }} পিস
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('', service.id)"
                            tabindex="-1"
                        >
                            {{ service.size }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('', service.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ service.unitprice }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('', service.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ service.total }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('', service.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ service.paid }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('', service.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ service.due }}
                        </inertia-link>
                    </td>

                    <td class="border-t w-px">
                        <inertia-link
                            class="px-4 flex items-center"
                            :href="route('', service.id)"
                            tabindex="-1"
                        >
                            <icon
                                name="cheveron-right"
                                class="block w-6 h-6 fill-gray-400"
                            />
                        </inertia-link>
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
    metaInfo: { title: "GO BAG" },
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
                        "gobag.index",
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

<style></style>
