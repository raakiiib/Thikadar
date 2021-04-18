<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link
                class="text-indigo-400 hover:text-indigo-600"
                :href="route('expenses.dailyexpense')"
                >{{
                    languageTranslation.getLanguage("bn").dailyexpense
                }}</inertia-link
            >
            <span class="text-indigo-400 font-medium">/</span>
            {{ languageTranslation.getLanguage("bn").add }}
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <label for="date" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").date }}
                        {{ languageTranslation.getLanguage("bn").ext }}

                        <text-input
                            type="date"
                            id="date"
                            value="28-12-2020"
                            v-model="form.created_at"
                            :error="errors.created_at"
                            tabindex="1"
                        />
                    </label>
                    <label for="expensename" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").expensename }}
                        {{ languageTranslation.getLanguage("bn").ext }}

                        <select-input
                            v-model="form.product_id"
                            :error="errors.product_id"
                            id="expensename"
                            tabindex="3"
                        >
                            <option :value="null" />
                            <option
                                v-for="product in products.data"
                                :key="product.id"
                                :value="product.id"
                            >
                                {{ product.name }}
                            </option>
                        </select-input>
                    </label>
                    <label for="expensetype" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").expensetype }}
                        {{ languageTranslation.getLanguage("bn").ext }}

                        <select-input
                            v-model="form.pay_type"
                            :error="errors.pay_type"
                            id="expensetype"
                            tabindex="3"
                        >
                            <option :value="null" />
                            <option
                                v-for="cost in costs.data"
                                :key="cost.id"
                                :value="cost.name"
                            >
                                {{ cost.name }}
                            </option>
                        </select-input>
                    </label>
                    <label for="totalmoney" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").total }}
                        {{ languageTranslation.getLanguage("bn").space }}

                        {{ languageTranslation.getLanguage("bn").totalmoney }}
                        {{ languageTranslation.getLanguage("bn").ext }}

                        <text-input
                            type="number"
                            step="any"
                            v-model="form.net_amount"
                            @input="updateAmount"
                            :error="errors.net_amount"
                            id="totalmoney"
                            tabindex="4"
                        />
                    </label>
                    <label for="paid" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").paid }}
                        {{ languageTranslation.getLanguage("bn").ext }}
                        <text-input
                            type="number"
                            step="any"
                            v-model="form.paid_amount"
                            @input="updateAmount"
                            :error="errors.paid_amount"
                            id="paid"
                            tabindex="5"
                        />
                    </label>
                    <label for="due" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").due }}
                        {{ languageTranslation.getLanguage("bn").space }}
                        {{ languageTranslation.getLanguage("bn").totalmoney }}

                        {{ languageTranslation.getLanguage("bn").ext }}
                        <text-input
                            disabled
                            type="number"
                            step="any"
                            id="due"
                            v-model="form.due_amount"
                            :error="errors.due_amount"
                            tabindex="6"
                        />
                    </label>
                    <label for="expensename" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").expensename }}
                        {{ languageTranslation.getLanguage("bn").ext }}
                        <text-input
                            v-model="form.note"
                            :error="errors.note"
                            tabindex="2"
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
                        {{ languageTranslation.getLanguage("bn").add }}
                    </loading-button>
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
import FileInput from "@/Shared/FileInput";
import { LanguageTranslation as languageTranslation } from "./../../Language/LanguageTranslation";

export default {
    metaInfo: { title: languageTranslation.getLanguage("bn").date },
    layout: Layout,
    components: {
        LoadingButton,
        SelectInput,
        TextInput,
        FileInput
    },
    props: {
        invoice_number: String,
        // expenses: Object,
        suppliers: Array,
        products: Object,
        errors: Object,
        costs: Object
    },
    remember: "form",
    data() {
        return {
            sending: false,
            form: {
                expense_type: Number(3),
                product_id: null,
                // vendor_id: null,
                invoice_number: this.invoice_number,
                net_amount: null,
                paid_amount: null,
                due_amount: null,
                is_all_paid: false,
                pay_type: null,
                note: null,
                photo_path: null,
                created_at: new Date().toISOString().slice(0, 10)
            }
        };
    },
    methods: {
        updateAmount: function() {
            var total = this.form.net_amount;
            var paid = this.form.paid_amount;
            var due = total - paid;
            due = due.toFixed(2);
            this.form.due_amount = String(due);
            this.updateDueStat(due);
        },
        updateDueStat: function(due) {
            var stat = false;
            if (due == 0) {
                stat = true;
            }
            this.form.is_all_paid = Boolean(stat);
        },
        submit() {
            const formData = new FormData();
            formData.append("invoice_number", this.form.invoice_number || "");
            formData.append("created_at", this.form.created_at || "");
            formData.append("expense_type", this.form.expense_type || "");
            formData.append("product_id", this.form.product_id || "");
            // formData.append('vendor_id', this.form.vendor_id || '')
            formData.append("net_amount", this.form.net_amount || "");
            formData.append("due_amount", this.form.due_amount || "");
            formData.append("pay_type", this.form.pay_type || "");
            formData.append("paid_amount", this.form.paid_amount || "");
            formData.append("note", this.form.note || "");

            if (this.form.is_all_paid) {
                formData.append("is_all_paid", 1);
            } else {
                formData.append("is_all_paid", 0);
            }

            formData.append("photo_path", this.form.photo_path || "");

            console.log(formData);

            this.$inertia.post(this.route("dailyexpense.store"), formData, {
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
