<template>
  <div>
    <!-- <h1 class="mb-8 font-bold text-3xl">Reports</h1> -->
    <h1 class="mb-8 font-bold text-3xl">
        <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('reports')">Reports</inertia-link>
        <span class="text-indigo-400 font-medium">/</span> Products
    </h1>

    <div class="mb-6 flex justify-between items-center">

    	<ul class="block">
	        <li class="inline-block">
	            <inertia-link class="p-2 border-2 border-indigo-400 inline-block" :href="route('reports')" >
	                <div class="caption">
	    				<h1>SUPPLIERS</h1>
	    			</div>
	            </inertia-link>
	        </li>
	        <li class="inline-block bg-indigo-600 ml-2">
	            <inertia-link class="p-2 border-2 border-indigo-400 inline-block text-white" :href="route('reports.products')" >
	                <div class="caption">
	    				<h1>PRODUCTS</h1>
	    			</div>
	            </inertia-link>
	        </li>
	    </ul>
    	
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
                <th class="px-6 pt-6 pb-4">Grade/ Type</th>
                <th class="px-6 pt-6 pb-4">Description</th>
                <th class="px-6 pt-6 pb-4">Unit</th>
            </tr>
            <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-400 focus-within:bg-gray-100">
                <td class="border-t">
                    <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', product.id)">
                        <img v-if="product.photo_path" class="block w-5 h-5 rounded-full mr-2 -my-2" :src="product.photo_path">
                        {{ product.name }}
                        <icon v-if="product.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                    </inertia-link>
                </td>
                
                <td class="border-t">
                    <inertia-link class="px-6 py-4 flex items-center" :href="route('', product.id)" tabindex="-1">
                        {{ product.type }}
                    </inertia-link>
                </td>

                <td class="border-t">
                    <inertia-link class="px-6 py-4 flex items-center" :href="route('', product.id)" tabindex="-1">
                        {{ product.description }}
                    </inertia-link>
                </td>

                <td class="border-t">
                    <inertia-link class="px-6 py-4 flex items-center" :href="route('', product.id)" tabindex="-1">
                        {{ product.unit }}
                    </inertia-link>
                </td>

                <td class="border-t w-px">
                    <inertia-link class="px-4 flex items-center" :href="route('', product.id)" tabindex="-1">
                        <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                    </inertia-link>
                </td>
            </tr>
            <tr v-if="products.data.length === 0">
                <td class="border-t px-6 py-4" colspan="4">No products found.</td>
            </tr>
        </table>
    </div>
    <pagination :links="products.links" />



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
  metaInfo: { title: 'Reports' },
  layout: Layout,
  components: {
  	Icon,
    Pagination,
    SearchFilter,
  },
  props: {
	products: Object,
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
  			this.$inertia.replace(this.route('products', Object.keys(query).length ? query : { remember: 'forget' }))
  		}, 150),
  		deep: true,
  	},
  },
  methods: {
  	url() {
        return location.pathname.substr(1)
    },
  	reset() {
  		this.form = mapValues(this.form, () => null)
  	}
  },
  created() {
  	console.log(this.url())
  },
}
</script>
