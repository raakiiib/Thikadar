<template>
    <div>
        <div class="mb-4">
            <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
                <icon name="dashboard" class="w-4 h-4 mr-2" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">ড্যাশবোর্ড</div>
            </inertia-link>
        </div>

        <div class="mb-4">
            <inertia-link class="flex items-center group py-3" :href="route('expenses.dailyexpense')">
                <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('expenses/regular') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('expenses/regular') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">দৈনন্দিন খরচ</div>
            </inertia-link>
        </div>

        <div class="mb-4">
            <inertia-link class="flex items-center group py-3" :href="route('expenses.products')">
                    <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('expenses/products') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('expenses/products') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">পণ্য ক্রয় </div>
            </inertia-link>
        </div>

        <div class="mb-4">
            <inertia-link class="flex items-center group py-3" :href="route('expenses.services')">
                    <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('expenses/services') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('expenses/services') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">ব্লক কাস্টিং </div>
            </inertia-link>
        </div>

        <div class="mb-4">
            <inertia-link class="flex items-center group py-3" :href="route('dumping.index')">
                    <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('expenses/dumping') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('expenses/dumping') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">ব্লক ডাম্পিং </div>
            </inertia-link>
        </div>

        <!-- <div class="mb-4">
            <inertia-link class="flex items-center group py-3" :href="route('settings')">
                    <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('settings') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('settings') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">সেটিংস </div>
            </inertia-link>
        </div> -->




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
        <div :class="isUrl('suppliers') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">সাপ্লায়ার</div>
    </inertia-link>
</div>

<div class="mb-4">
  <inertia-link class="flex items-center group py-3" :href="route('beneficiary')">
    <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('beneficiary') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
    <div :class="isUrl('beneficiary') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">পাওনাদার</div>
</inertia-link>
</div>

<div class="mb-4">
  <inertia-link class="flex items-center group py-3" :href="route('costs')">
    <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('costs') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
    <div :class="isUrl('costs') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">খরচের ধরন</div>
</inertia-link>
</div>

<div class="mb-4">
  <inertia-link class="flex items-center group py-3" :href="route('staffs')">
    <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('staffs') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
    <div :class="isUrl('staffs') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">স্টাফস</div>
</inertia-link>
</div>

<div class="mb-4">
  <inertia-link class="flex items-center group py-3" :href="route('materials')">
    <icon name="store-front" class="w-4 h-4 mr-2" :class="isUrl('materials') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
    <div :class="isUrl('materials') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">মালামাল</div>
</inertia-link>
</div>

<div class="mb-4">
  <inertia-link class="flex items-center group py-3" :href="route('services')">
    <icon name="store-front" class="w-4 h-4 mr-2" :class="isUrl('services') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
    <div :class="isUrl('services') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">ব্লক</div>
</inertia-link>
</div>

<div class="mb-4">
  <inertia-link class="flex items-center group py-3" :href="route('vehicles')">
    <icon name="book" class="w-4 h-4 mr-2" :class="isUrl('vehicles') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
    <div :class="isUrl('vehicles') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">গাড়ি-ঘোড়া</div>
</inertia-link>
</div>

<div class="mb-4">
    <inertia-link class="flex items-center group py-3" :href="route('contacts')">
        <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('contacts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('contacts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">যোগাযোগ</div>
    </inertia-link>
</div>


</div>
</template>

<script>
    import Icon from '@/Shared/Icon'
    import Dropdown from '@/Shared/Dropdown'
    export default {
      components: {
        Icon,
        Dropdown,
    },
    props: {
        url: String,
    },
    methods: {
        // url() {
        //     return location.pathname.substr(1)
        // },
        hideDropdownMenus() {
            this.showUserMenu = false
        },
        isUrl(...urls) {
          if (urls[0] === '') {
            return this.url === ''
        }

        return urls.filter(url => this.url.startsWith(url)).length
    },
}
}
</script>
