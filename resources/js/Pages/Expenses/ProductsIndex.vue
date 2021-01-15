<template>
    <div class="">

        <div class="p-1 mr-1 mb-4 flex flex-wrap">
            
            <button class="p-1 w-full lg:w-1/3">
                <inertia-link class="block p-3 text-blue-600 bg-gray-300 border-2 border-blue-200"  :href="route('expenses.dailyexpense')">
                    <h1>DAILY EXPENSES</h1>
                </inertia-link>
            </button>
            <button class="p-1 w-full lg:w-1/3">
                <inertia-link class="block p-3 bg-indigo-600 text-white border-2 border-blue-700"  :href="route('expenses.products')">
                    <h1>PRODUCTS</h1>
                </inertia-link>
            </button>
            <button class="p-1 w-full lg:w-1/3">
                <inertia-link class="block p-3 text-blue-600 bg-gray-300 border-2 border-blue-200"  :href="route('expenses.services')">
                    <h1>SERVICES</h1>
                </inertia-link>
            </button>
        </div>

        <div class="mb-8 flex justify-between items-center">
            <h1 class="font-bold text-3xl">PRODUCTS</h1>

            <inertia-link class="btn-indigo" :href="route('purchase.product')">
                <span>BUY</span>
                <span class="hidden md:inline">PRODUCT</span>
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
                    <th class="px-6 pt-6 pb-4">সিরিয়াল</th>
                    <th class="px-6 pt-6 pb-4">পণ্য/ সেবা</th>
                    <th class="px-6 pt-6 pb-4">সাপ্লায়ার</th>
                    <th class="px-6 pt-6 pb-4">&#35; পরিমান</th>
                    <th class="px-6 pt-6 pb-4">&#x09F3; প্রতিটির দাম</th>
                    <th class="px-6 pt-6 pb-4">&#x09F3; মোট টাকার পরিমান</th>
                    <th class="px-6 pt-6 pb-4">&#x09F3; বাকি টাকার পরিমান</th>
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
                            class="px-6 py-4 flex items-center focus:text-indigo-500"
                            :href="route('product.edit', product.id)"
                        >
                            <img
                                v-if="product.photo_path"
                                class="block w-5 h-5 rounded-full mr-2 -my-2"
                                :src="product.photo_path"
                            />
                            {{ product.invoice }}
                            <icon
                                v-if="product.deleted_at"
                                name="trash"
                                class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2"
                            />
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500"
                            :href="route('product.edit', product.id)"
                        >
                            {{ product.material }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('product.edit', product.id)"
                            tabindex="-1"
                        >
                            {{ product.supplier }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('product.edit', product.id)"
                            tabindex="-1"
                        >
                            {{ product.quantity }} {{ product.unit }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('product.edit', product.id)"
                            tabindex="-1"
                        >
                            {{ product.unitprice }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('product.edit', product.id)"
                            tabindex="-1"
                        >
                            {{ product.total }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('product.edit', product.id)"
                            tabindex="-1"
                        >
                            {{ product.due }}
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
            this.form = mapValues(this.form, () => null)
        },
    }
};
</script>
