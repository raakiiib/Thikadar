<template>
    <div>
        <h2 class="font-bold text-2xl">
            <inertia-link
                class="text-indigo-400 hover:text-indigo-600"
                :href="route('gobag.index')"
            >
                <h1 v-for="service in services.data" :key="service.id">
                    {{ service.supplier }}
                </h1>

                /</inertia-link
            >
            এর সকল হিসাব
        </h2>

        <div class="mt-6 bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">তারিখ</th>
                    <th class="px-6 pt-6 pb-4">পরিমান</th>
                    <th class="px-6 pt-6 pb-4">মোট</th>
                    <th class="px-6 pt-6 pb-4">পরিষোধিত</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">বাকি</th>
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
                            class="px-6 py-4 flex items-center"
                            :href="route('')"
                            tabindex="-1"
                        >
                            {{ service.quantity }}
                            পিস
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('')"
                            tabindex="-1"
                        >
                            &#x09F3;
                            {{ service.total }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('')"
                            tabindex="-1"
                        >
                            &#x09F3;
                            {{ service.paid }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('')"
                            tabindex="-1"
                        >
                            &#x09F3;
                            {{ service.due }}
                        </inertia-link>
                    </td>

                    <td
                        v-if="service.length === 0"
                        class="border-t px-6 py-4"
                        colspan="4"
                    >
                        No entry found.
                    </td>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <th class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            মোট
                        </span>
                    </th>
                    <th class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            পিস
                        </span>
                    </th>
                    <th class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            &#x09F3;
                        </span>
                    </th>
                    <th class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            &#x09F3;
                        </span>
                    </th>
                    <th class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            &#x09F3;
                        </span>
                    </th>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
import Icon from "@/Shared/Icon";
import Layout from "@/Shared/Layout";
import LoadingButton from "@/Shared/LoadingButton";
import SelectInput from "@/Shared/SelectInput";
import TextInput from "@/Shared/TextInput";
import TrashedMessage from "@/Shared/TrashedMessage";
import SearchFilter from "@/Shared/SearchFilter";

export default {
    metaInfo() {},
    layout: Layout,
    components: {
        Icon,
        LoadingButton,
        SelectInput,
        TextInput,
        TrashedMessage,
        SearchFilter
    },
    props: {
        services: Object
    },
    data() {
        console.log(this.services);
        return this.services;
    }
};
</script>
