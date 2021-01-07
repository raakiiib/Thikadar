<template>
  <div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
        <icon name="dashboard" class="w-4 h-4 mr-2" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">DASHBOARD</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('expenses.products')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('expenses.products') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('expenses') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">EXPENSES</div>
      </inertia-link>
    </div>

    <!-- <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('invoices')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('invoices') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('invoices') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">INVOICES</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('reports')">
        <icon name="printer" class="w-4 h-4 mr-2" :class="isUrl('reports') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('reports') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">REPORTS</div>
      </inertia-link>
    </div>
    
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('purchases')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('purchases') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('purchases') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">PRODUCTS</div>
      </inertia-link>
    </div> -->

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('suppliers')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('suppliers') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('suppliers') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">SUPPLIERS</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('exptypes')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('exptypes') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('exptypes') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">EXPENSE TYPES</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('staffs')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('staffs') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('staffs') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">STAFFS</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('materials')">
        <icon name="store-front" class="w-4 h-4 mr-2" :class="isUrl('materials') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('materials') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">MATERIALS</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('services')">
        <icon name="store-front" class="w-4 h-4 mr-2" :class="isUrl('services') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('services') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">SERVICES</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('vehicles')">
        <icon name="book" class="w-4 h-4 mr-2" :class="isUrl('vehicles') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('vehicles') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">VEHICLES</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('contacts')">
        <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('contacts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('contacts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">CONTACTS</div>
      </inertia-link>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
  },
  props: {
    url: String,
  },
  methods: {
    isUrl(...urls) {
      if (urls[0] === '') {
        return this.url === ''
      }

      return urls.filter(url => this.url.startsWith(url)).length
    },
  }
}
</script>
