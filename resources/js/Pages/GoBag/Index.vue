<template>
    <div class="">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="font-bold text-3xl">
                {{ languageTranslation.getLanguage("bn").gobag }}
            </h1>
            <inertia-link class="btn-indigo" :href="route('gobag.create')">
                <span
                    >{{ languageTranslation.getLanguage("bn").new }}
                    {{ languageTranslation.getLanguage("bn").space }}
                    {{ languageTranslation.getLanguage("bn").gobag }}
                </span>
                <span class="hidden md:inline"
                    >{{ languageTranslation.getLanguage("bn").add }}
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
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").supplier }}
                    </th>
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").quantity }}
                    </th>
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").size }}
                    </th>
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").price }}
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
                    v-for="service in services.data"
                    :key="service.id"
                    class="hover:bg-gray-400 focus-within:bg-gray-100"
                >
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500"
                            :href="route('gobag.edit', service.id)"
                        >
                            {{ service.created_at }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500 text-indigo-500"
                            :href="route('gobag.vendor', service.supplier_id)"
                            tabindex="-1"
                        >
                            {{ service.supplier }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('gobag.edit', service.id)"
                            tabindex="-1"
                        >
                            {{ service.quantity
                            }}{{ languageTranslation.getLanguage("bn").piece }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('gobag.edit', service.id)"
                            tabindex="-1"
                        >
                            {{ service.size }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('gobag.edit', service.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ service.unitprice }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('gobag.edit', service.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ service.total }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('gobag.edit', service.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ service.paid }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('gobag.edit', service.id)"
                            tabindex="-1"
                        >
                            &#x09F3; {{ service.due }}
                        </inertia-link>
                    </td>

                    <td class="border-t w-px">
                        <inertia-link
                            class="px-4 flex items-center"
                            :href="route('gobag.edit', service.id)"
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
import { LanguageTranslation as languageTranslation } from "./../../Language/LanguageTranslation";
export default {
    metaInfo: { title: languageTranslation.getLanguage("bn").gobag },
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
    },
    created() {
        this.languageTranslation = languageTranslation;
    }
};
</script>

<style></style>
