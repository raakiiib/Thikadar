<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">খরচের ধরন</h1>
        <div class="mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
                <label class="block text-gray-700">Trashed:</label>
                <select v-model="form.trashed" class="mt-1 w-full form-select">
                    <option :value="null" />
                    <option value="with">With Trashed</option>
                    <option value="only">Only Trashed</option>
                </select>
            </search-filter>
            <inertia-link class="btn-indigo" :href="route('costs.create')">
                <span>নতুন</span>
                <span class="hidden md:inline">খরচের ধরন যোগ</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">নাম</th>
                    <th class="px-6 pt-6 pb-4">বিবরণী</th>
                </tr>
                <tr v-for="type in costs.data" :key="type.id" class="hover:bg-gray-400 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('costs.edit', type.id)">
                            {{ type.name }}
                            <icon v-if="type.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                        </inertia-link>
                    </td>
                    
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('costs.edit', type.id)" tabindex="-1">
                            {{ type.note }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('costs.edit', type.id)" tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="costs.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No costs found.</td>
                </tr>
            </table>
        </div>
        <pagination :links="costs.links" />
    </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import pickBy from 'lodash/pickBy'
import SearchFilter from '@/Shared/SearchFilter'
import throttle from 'lodash/throttle'

export default {
    metaInfo: { title: 'Suppliers' },
    layout: Layout,
    components: {
        Icon,
        Pagination,
        SearchFilter,
    },
    props: {
        costs: Object,
        filters: Object,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                trashed: this.filters.trashed,
            },
        }
    },
    watch: {
        form: {
            handler: throttle(function() {
                let query = pickBy(this.form)
                this.$inertia.replace(this.route('costs', Object.keys(query).length ? query : { remember: 'forget' }))
            }, 150),
            deep: true,
        },
    },
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null)
        },
    },
}

</script>
