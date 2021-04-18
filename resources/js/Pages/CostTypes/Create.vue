<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link
                class="text-indigo-400 hover:text-indigo-600"
                :href="route('costs')"
                >{{
                    languageTranslation.getLanguage("bn").expensetype
                }}</inertia-link
            >
            <span class="text-indigo-400 font-medium">/</span>
            {{ languageTranslation.getLanguage("bn").add }}
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <label for="name" class="pr-6 pb-8 w-full lg:w-1/1">
                        {{ languageTranslation.getLanguage("bn").name }}
                        <text-input
                            id="name"
                            v-model="form.name"
                            :error="errors.name"
                        />
                    </label>
                    <label for="details" class="pr-6 pb-8 w-full lg:w-1/1">
                        {{ languageTranslation.getLanguage("bn").details }}
                        <text-input
                            v-model="form.note"
                            :error="errors.address"
                        />
                    </label>
                </div>
                <div
                    class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center"
                >
                    <loading-button
                        :loading="sending"
                        class="btn-indigo"
                        type="submit"
                    >
                        {{
                            languageTranslation.getLanguage("bn").add
                        }}</loading-button
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

import { LanguageTranslation as languageTranslation } from "./../../Language/LanguageTranslation";

export default {
    metaInfo: { title: "Create supplier" },
    layout: Layout,
    components: {
        LoadingButton,
        SelectInput,
        TextInput
    },
    props: {
        errors: Object
    },
    remember: "form",
    data() {
        return {
            sending: false,
            form: {
                name: null,
                note: null
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.post(this.route("costs.store"), this.form, {
                onStart: () => (this.sending = true),
                onFinish: () => (this.sending = false)
            });
        }
    },
    created() {
        this.languageTranslation = languageTranslation;
    }
};
</script>
