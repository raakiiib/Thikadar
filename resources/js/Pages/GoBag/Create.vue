<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link
                class="text-indigo-400 hover:text-indigo-600"
                :href="route('gobag.index')"
                >GO BAG</inertia-link
            >
            <span class="text-indigo-400 font-medium">/</span> নতুন
            <br />
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input
                        type="date"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Date"
                    />

                    <select-input
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Supplier"
                    >
                        <option :value="null" />
                        <option> </option>
                    </select-input>

                    <text-input
                        type="number"
                        step="0.01"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Quantity"
                    />

                    <text-input
                        type="number"
                        step="any"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Size"
                    />

                    <text-input
                        type="number"
                        step="0.01"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Rate"
                    />

                    <text-input
                        type="number"
                        step="0.01"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Total"
                    />

                    <text-input
                        type="number"
                        step="0.01"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Paid"
                    />

                    <text-input
                        type="number"
                        step="-0.01"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Due"
                    />

                    <select-input
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="খরচের ধরন"
                    >
                        <option> </option>
                    </select-input>

                    <text-input
                        type="text"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Note"
                    />
                </div>
                <div
                    class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center"
                >
                    <loading-button :loading="sending" class="btn-indigo">
                        যোগ করুন</loading-button
                    >
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import LoadingButton from "@/Shared/LoadingButton";
import SelectInput from "@/Shared/SelectInput";
import TextInput from "@/Shared/TextInput";

export default {
    metaInfo: { title: "নতুন go bag যোগ করুন" },
    layout: Layout,
    components: {
        LoadingButton,
        SelectInput,
        TextInput
    },
    props: {},

    data() {
        return {
            sending: false
        };
    }
};
</script>
