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
            <search-filter class="w-full max-w-md mr-4">
                <label class="block text-gray-700">Trashed:</label>
                <select class="mt-1 w-full form-select">
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
            </table>
        </div>
    </div>
</template>

<script>
import Icon from "@/Shared/Icon";
import Layout from "@/Shared/Layout";
import SearchFilter from "@/Shared/SearchFilter";

export default {
    metaInfo: { title: "GO BAG" },
    layout: Layout,
    components: {
        Icon,
        SearchFilter
    }
};
</script>

<style></style>
