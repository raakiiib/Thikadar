<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link
                class="text-indigo-400 hover:text-indigo-600"
                :href="route('dumping.index')"
                >{{ languageTranslation.getLanguage("bn").blockdumping }}
            </inertia-link>

            <span class="text-indigo-400 font-medium">/</span>
            {{ languageTranslation.getLanguage("bn").new }}
            <br />
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <label class="pr-6 pb-8 w-full lg:w-1/2" for="date"
                        >{{ languageTranslation.getLanguage("bn").date }}
                        <text-input
                            type="date"
                            id="date"
                            value="28-12-2020"
                            v-model="form.created_at"
                            :error="errors.created_at"
                        />
                    </label>
                    <label class="pr-6 pb-8 w-full lg:w-1/2" for="service"
                        >{{ languageTranslation.getLanguage("bn").service }}

                        <select-input
                            id="service"
                            v-model="form.product_id"
                            :error="errors.product_id"
                        >
                            <option :value="null" />
                            <option
                                v-for="service in services"
                                :key="service.id"
                                :value="service.id"
                                >{{ service.name }} (
                                {{ service.dimension }} )</option
                            >
                        </select-input>
                    </label>
                    <label class="pr-6 pb-8 w-full lg:w-1/2" for="supplier">
                        {{ languageTranslation.getLanguage("bn").supplier }}
                        <select-input
                            id="supplier"
                            v-model="form.vendor_id"
                            :error="errors.vendor_id"
                        >
                            <option :value="null" />
                            <option
                                v-for="supplier in suppliers"
                                :key="supplier.id"
                                :value="supplier.id"
                                >{{ supplier.name }}</option
                            >
                        </select-input>
                    </label>
                    <label class="pr-6 pb-8 w-full lg:w-1/2" for="quantity">
                        {{ languageTranslation.getLanguage("bn").quantity }}
                        <text-input
                            id="quantity"
                            type="number"
                            step="0.01"
                            v-model="form.quantity"
                            @input="updateNetAmout"
                            :error="errors.quantity"
                        />
                    </label>
                    <label class="pr-6 pb-8 w-full lg:w-1/2" for="size">
                        {{ languageTranslation.getLanguage("bn").size }}

                        <text-input
                            id="size"
                            type="number"
                            step="any"
                            v-model="form.size"
                            @input="updateNetAmout"
                            :error="errors.size"
                        />
                    </label>
                    <label class="pr-6 pb-8 w-full lg:w-1/2" for="rate">
                        {{ languageTranslation.getLanguage("bn").rate }}
                        <text-input
                            id="rate"
                            type="number"
                            step="0.01"
                            v-model="form.unitprice"
                            @input="updateNetAmout"
                            :error="errors.unitprice"
                        />
                    </label>
                    <label class="pr-6 pb-8 w-full lg:w-1/2" for="total">
                        {{ languageTranslation.getLanguage("bn").total }}

                        <text-input
                            id="total"
                            type="number"
                            step="0.01"
                            v-model="form.net_amount"
                            :error="errors.net_amount"
                        />
                    </label>
                    <label class="pr-6 pb-8 w-full lg:w-1/2" for="paid">
                        {{ languageTranslation.getLanguage("bn").paid }}

                        <text-input
                            id="paid"
                            type="number"
                            step="0.01"
                            v-model="form.paid_amount"
                            @input="calculateDue"
                            :error="errors.paid_amount"
                        />
                    </label>
                    <label class="pr-6 pb-8 w-full lg:w-1/2" for="due">
                        {{ languageTranslation.getLanguage("bn").due }}
                        <text-input
                            id="due"
                            type="number"
                            step="-0.01"
                            v-model="form.due_amount"
                            @input="calculateDue"
                            :error="errors.due_amount"
                        />
                    </label>
                    <label class="pr-6 pb-8 w-full lg:w-1/2" for="expensetype">
                        {{ languageTranslation.getLanguage("bn").expensetype }}

                        <select-input
                            id="expensetype"
                            v-model="form.pay_type"
                            :error="errors.pay_type"
                        >
                            <option
                                v-for="cost in pay_types.data"
                                :key="cost.id"
                                :value="cost.name"
                            >
                                {{ cost.name }}
                            </option>
                        </select-input>
                    </label>
                    <label class="pr-6 pb-8 w-full lg:w-1/2" for="note">
                        {{ languageTranslation.getLanguage("bn").note }}*
                        <text-input
                            id="note"
                            type="text"
                            v-model="form.note"
                            :error="errors.note"
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
import FileInput from "@/Shared/FileInput";
import axios from "axios";
import { LanguageTranslation as languageTranslation } from "./../../Language/LanguageTranslation.js";

export default {
    metaInfo: { title: languageTranslation.getLanguage("bn").titlesheba },
    layout: Layout,
    components: {
        LoadingButton,
        SelectInput,
        TextInput
    },
    props: {
        suppliers: Array,
        services: Array,
        invoice_number: String,
        errors: Object,
        pay_types: Object
    },
    remember: "form",
    data() {
        return {
            sending: false,
            service_data: null,
            title: {},
            form: {
                product_id: null,
                vendor_id: null,
                // invoice_number: this.invoice_number,
                expense_type: 4,
                quantity: null,
                unitprice: null,
                size: null,
                net_amount: null,
                paid_amount: null,
                due_amount: null,
                is_all_paid: false,
                created_at: new Date().toISOString().slice(0, 10)
            },
            service: Array
        };
    },
    methods: {
        // calculateTotalPrice: function() {
        //     this.updateNetAmout();
        //     axios
        //       .get(this.route('expenses.service.single', this.form.product_id))
        //       .then(
        //         response => (
        //             this.form.size = response.data.service.size
        //         ))
        // },
        calculateDue: function() {
            var total = this.form.net_amount;
            var paid = this.form.paid_amount;
            var due = total - paid;
            this.form.due_amount = String(due);
            this.updateDueStat(due);
            console.log(paid);
        },
        updateDueStat: function(due) {
            var stat = false;
            if (due == 0) {
                stat = true;
            }
            this.form.is_all_paid = Boolean(stat);
        },
        updateNetAmout: function() {
            var total = this.form.unitprice * this.form.quantity;
            total = total.toFixed(2);
            total = (Math.round(total * 100) / 100).toFixed(2);
            this.form.net_amount = String(total);
        },
        submit() {
            console.log(this.form);
            this.$inertia.post(this.route("dumping.store"), this.form, {
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
