<template>
    <div class="">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="font-bold text-3xl">Materials</h1>

            <inertia-link class="btn-indigo" :href="route('materials.create')">
                <span>Add</span>
                <span class="hidden md:inline">Material</span>
            </inertia-link>
        </div>
        <div class="mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
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
                    <th class="px-6 pt-6 pb-4">Name</th>
                    <th class="px-6 pt-6 pb-4">Type</th>
                    <th class="px-6 pt-6 pb-4">Unit</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">Description</th>
                </tr>
                <tr v-for="material in materials.data" :key="material.id" class="hover:bg-gray-400 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('materials.edit', material.id)">
                            {{ material.name }}
                            <icon v-if="material.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('materials.edit', material.id)" tabindex="-1">
                            {{ material.type }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('materials.edit', material.id)" tabindex="-1">
                            {{ material.unit }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('materials.edit', material.id)" tabindex="-1">
                            {{ material.description }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('materials.edit', material.id)" tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="materials.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No materials found.</td>
                </tr>
            </table>
        </div>
        <pagination :links="materials.links" />
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
    created() {
        console.log(this.materials)
    },
    metaInfo: { title: 'MATERIALS' },
    layout: Layout,
    components: {
        Icon,
        Pagination,
        SearchFilter,
    },
    props: {
        materials: Object,
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
                this.$inertia.replace(this.route('materials', Object.keys(query).length ? query : { remember: 'forget' }))
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
