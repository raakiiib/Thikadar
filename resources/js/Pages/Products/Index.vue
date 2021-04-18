<template>
    <div class="">
        <!-- <div class="p-1 mr-1 mb-4 flex flex-wrap">
            <button class="p-1 w-full lg:w-1/3">
                <inertia-link class="block p-3 text-blue-600 bg-gray-300 border-2 border-blue-200"  :href="route('expenses.dailyexpense')">
                    <h1>দৈনন্দিন খরচ</h1>
                </inertia-link>
            </button>
            <button class="p-1 w-full lg:w-1/3">
                <inertia-link class="block p-3 bg-indigo-600 text-white border-2 border-blue-700"  :href="route('expenses.products')">
                    <h1>পণ্য</h1>
                </inertia-link>
            </button>
            <button class="p-1 w-full lg:w-1/3">
                <inertia-link class="block p-3 text-blue-600 bg-gray-300 border-2 border-blue-200"  :href="route('expenses.services')">
                    <h1>সেবা</h1>
                </inertia-link>
            </button>
        </div> -->

        <div class="mb-8 flex justify-between items-center">
            <h1 class="font-bold text-3xl">
                {{ languageTranslation.getLanguage("bn").ponno }}
            </h1>

            <inertia-link class="btn-indigo" :href="route('purchase.product')">
                <span> {{ languageTranslation.getLanguage("bn").new }} </span>
                <span class="hidden md:inline">
                    {{ languageTranslation.getLanguage("bn").ponno }}
                    {{ languageTranslation.getLanguage("bn").space }}
                    {{ languageTranslation.getLanguage("bn").add }}
                </span>
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
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").date }}
                    </th>
                    <!-- <th class="px-6 pt-6 pb-4">সিরিয়াল</th> -->
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").ponnosheba }}
                    </th>
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").supplier }}
                    </th>
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").quantity }}
                    </th>
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").total }}
                    </th>
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").paid }}
                    </th>
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").due }}
                    </th>
                </tr>
                <tr
                    v-for="product in products.data"
                    :key="product.id"
                    class="hover:bg-gray-400 focus-within:bg-gray-100"
                >
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500"
                            :href="route('product.edit', product.id)"
                        >
                            {{ product.created_at }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center text-indigo-600 focus:text-indigo-500"
                            :href="
                                route(
                                    'single.products.show',
                                    product.product_id
                                )
                            "
                        >
                            <strong>{{ product.material }}</strong>
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center text-blue-600 focus:text-blue-500"
                            :href="
                                route('vendor.expense.show', product.vendor_id)
                            "
                            tabindex="-1"
                        >
                            <strong>{{ product.supplier }}</strong>
                        </inertia-link>
                    </td>
                    <!-- <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('product.edit', product.id)"
                            tabindex="-1"
                        >
                            {{ product.quantity }} {{ product.unit }}
                        </inertia-link>
                    </td> -->
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('product.edit', product.id)"
                            tabindex="-1"
                        >
                            {{ product.unitprice * product.quantity }}
                            {{ product.unit }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('product.edit', product.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ product.total }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('product.edit', product.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ product.paid }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('product.edit', product.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ product.due }}
                        </inertia-link>
                    </td>

                    <td class="border-t w-px">
                        <inertia-link
                            class="px-4 flex items-center"
                            :href="route('', product.id)"
                            tabindex="-1"
                        >
                            <icon
                                name="cheveron-right"
                                class="block w-6 h-6 fill-indigo-400"
                            />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="products.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">
                        No products found.
                    </td>
                </tr>
            </table>
        </div>
        <pagination :links="products.links" />
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
import { LanguageTranslation as languageTranslation } from "./../../Language/LanguageTranslation";

export default {
    metaInfo: { title: "products" },
    layout: Layout,
    components: {
        Icon,
        Pagination,
        SearchFilter
    },
    props: {
        products: Object,
        filters: Object
    },
    data() {
        return {
            isPaid: Boolean(this.products.data.is_all_paid),
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
                        "expenses.products",
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
    },
    created() {
        this.languageTranslation = languageTranslation;
    }
};
</script>
