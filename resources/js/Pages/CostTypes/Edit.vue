<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link
                class="text-indigo-400 hover:text-indigo-600"
                :href="route('costs')"
                >&#8678;
                {{
                    languageTranslation.getLanguage("bn").expensetype
                }}</inertia-link
            >
            <span class="text-indigo-400 font-medium">/</span>
            {{ form.name }}
        </h1>
        <trashed-message v-if="type.deleted_at" class="mb-6" @restore="restore">
            This type has been deleted.
        </trashed-message>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <label for="name" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").name }}
                        {{ languageTranslation.getLanguage("bn").ext }}
                        <text-input
                            id="name"
                            v-model="form.name"
                            :error="errors.name"
                        />
                    </label>
                    <label for="details" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").details }}
                        {{ languageTranslation.getLanguage("bn").ext }}
                        <text-input
                            id="details"
                            v-model="form.note"
                            :error="errors.note"
                        />
                    </label>
                </div>
                <div
                    class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center"
                >
                    <button
                        v-if="!type.deleted_at"
                        class="text-red-600 hover:underline"
                        tabindex="-1"
                        type="button"
                        @click="destroy"
                    >
                        <icon name="trash" class="block w-6 h-6 fill-red-600" />
                    </button>
                    <loading-button
                        :loading="sending"
                        class="btn-indigo ml-auto"
                        type="submit"
                    >
                        {{
                            languageTranslation.getLanguage("bn").edit
                        }}</loading-button
                    >
                </div>
            </form>
        </div>
        <!-- Showing all expenses under this item -->
        <h2 class="mt-12 font-bold text-2xl">
            {{ form.name }} {{ languageTranslation.getLanguage("bn").all }}
        </h2>
        <div class="mt-6 bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").date }}
                    </th>
                    <!-- <th class="px-6 pt-6 pb-4">Invoice</th> -->
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").details }}
                    </th>
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").total }}
                        {{ languageTranslation.getLanguage("bn").space }}
                        {{ languageTranslation.getLanguage("bn").taka }}
                    </th>
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").paid }}
                        {{ languageTranslation.getLanguage("bn").space }}
                        {{ languageTranslation.getLanguage("bn").taka }}
                    </th>
                    <th class="px-6 pt-6 pb-4" colspan="2">
                        {{ languageTranslation.getLanguage("bn").due }}
                        {{ languageTranslation.getLanguage("bn").space }}
                        {{ languageTranslation.getLanguage("bn").taka }}
                    </th>
                </tr>
                <tr
                    v-for="exp in type.expenses"
                    :key="exp.id"
                    class="hover:bg-gray-100 focus-within:bg-gray-100"
                >
                    <!-- {{ exp.net_amount }} -->
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500"
                            :href="route('dailyexpense.edit', exp.id)"
                        >
                            {{ exp.created_at | formatDate }}
                            <icon
                                v-if="exp.deleted_at"
                                name="trash"
                                class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2"
                            />
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('dailyexpense.edit', exp.id)"
                            tabindex="-1"
                        >
                            {{ exp.note }}
                        </inertia-link>
                    </td>
                    <!--                     <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('dailyexpense.edit', exp.id)" tabindex="-1">
                            {{ exp.invoice_number }}
                        </inertia-link>
                    </td> -->
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('dailyexpense.edit', exp.id)"
                            tabindex="-1"
                        >
                            {{ exp.net_amount }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('dailyexpense.edit', exp.id)"
                            tabindex="-1"
                        >
                            {{ exp.paid_amount }}
                        </inertia-link>
                    </td>

                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route('dailyexpense.edit', exp.id)"
                            tabindex="-1"
                        >
                            {{ exp.due_amount }}
                        </inertia-link>
                    </td>

                    <td class="border-t w-px">
                        <inertia-link
                            class="px-4 flex items-center"
                            :href="route('dailyexpense.edit', exp.id)"
                            tabindex="-1"
                        >
                            <icon
                                name="cheveron-right"
                                class="block w-6 h-6 fill-gray-400"
                            />
                        </inertia-link>
                    </td>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td>&nbsp;</td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            {{ languageTranslation.getLanguage("bn").total }}
                            {{ languageTranslation.getLanguage("bn").space }}
                            {{ languageTranslation.getLanguage("bn").count }}
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            {{ totalNetAmnt() }}
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            {{ totalPaidAmnt() }}
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="px-6 py-4 flex items-center">
                            {{ totalDueAmnt() }}
                        </span>
                    </td>
                </tr>
                <tr v-if="type.expenses.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">
                        No entry found.
                    </td>
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
import { LanguageTranslation as languageTranslation } from "./../../Language/LanguageTranslation";

export default {
    metaInfo() {
        return { title: this.form.name };
    },
    layout: Layout,
    components: {
        Icon,
        LoadingButton,
        SelectInput,
        TextInput,
        TrashedMessage
    },
    props: {
        errors: Object,
        type: Object
    },
    remember: "form",
    data() {
        return {
            sending: false,
            form: {
                name: this.type.name,
                note: this.type.note
            }
        };
    },
    methods: {
        totalNetAmnt: function() {
            let total = [];
            Object.entries(this.type.expenses).forEach(([key, val]) => {
                total.push(val.net_amount); // the value of the current key.
            });
            return total.reduce(function(total, num) {
                return total + num;
            }, 0);
        },
        totalPaidAmnt: function() {
            let total = [];
            Object.entries(this.type.expenses).forEach(([key, val]) => {
                total.push(val.paid_amount); // the value of the current key.
            });
            return total.reduce(function(total, num) {
                return total + num;
            }, 0);
        },
        totalDueAmnt: function() {
            let total = [];
            Object.entries(this.type.expenses).forEach(([key, val]) => {
                total.push(val.due_amount); // the value of the current key.
            });
            return total.reduce(function(total, num) {
                return total + num;
            }, 0);
        },
        created() {
            console.log("hello");
        },
        beforeMount() {
            console.log("before mount");
        },
        submit() {
            console.log(this.form);
            this.$inertia.put(
                this.route("costs.update", this.type.id),
                this.form,
                {
                    onStart: () => (this.sending = true),
                    onFinish: () => (this.sending = false)
                }
            );
        },
        destroy() {
            if (confirm("Are you sure you want to delete this type?")) {
                this.$inertia.delete(this.route("costs.destroy", this.type.id));
            }
        },
        restore() {
            if (confirm("Are you sure you want to restore this type?")) {
                this.$inertia.put(this.route("costs.restore", this.type.id));
            }
        }
    },
    created() {
        this.languageTranslation = languageTranslation;
    }
};
</script>
