<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link
                class="text-indigo-400 hover:text-indigo-600"
                :href="route('expenses.products')"
                >{{ languageTranslation.getLanguage("bn").ponno }}</inertia-link
            >
            <span class="text-indigo-400 font-medium">/</span>
            {{ expense.product_name }} {{ expense.product_type }}
        </h1>
        <trashed-message
            v-if="expense.deleted_at"
            class="mb-6"
            @restore="restore"
        >
            This entry has been deleted.
        </trashed-message>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <label for="serial" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").serial }}
                        {{ languageTranslation.getLanguage("bn").ext }}
                        <text-input
                            id="serial"
                            disabled
                            v-model="form.invoice_number"
                            :error="errors.invoice_number"
                        />
                    </label>
                    <label for="date" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").date }}
                        {{ languageTranslation.getLanguage("bn").ext }}

                        <text-input
                            type="date"
                            id="date"
                            v-model="form.created_at"
                            :error="errors.created_at"
                            tabindex="1"
                        />
                    </label>
                    <label for="ponno" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").ponno }}
                        {{ languageTranslation.getLanguage("bn").ext }}
                        <text-input
                            id="ponno"
                            disabled
                            v-model="form.product"
                            :error="errors.product"
                        />
                    </label>
                    <label for="supplier" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").supplier }}
                        {{ languageTranslation.getLanguage("bn").ext }}
                        <text-input
                            disabled
                            id="supplier"
                            v-model="form.supplier"
                            :error="errors.supplier"
                        />
                    </label>
                    <label for="price" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").price }}
                        {{ languageTranslation.getLanguage("bn").ext }}
                        <text-input
                            disabled
                            id="price"
                            type="number"
                            step="any"
                            v-model="form.unit_price"
                            :error="errors.unit_price"
                        />
                    </label>
                    <label for="quantity" class="pr-6 pb-8 w-full lg:w-1/2">
                        {{ languageTranslation.getLanguage("bn").quantity }}
                        {{ languageTranslation.getLanguage("bn").ext }}
                        <text-input
                            disabled
                            id="quantity"
                            type="number"
                            step="any"
                            v-model="form.quantity"
                            :error="errors.quantity"
                        />
                    </label>
                    <label for="totalmoney" class="pr-6 pb-8 w-full lg:w-1/3">
                        {{ languageTranslation.getLanguage("bn").total }}
                        {{ languageTranslation.getLanguage("bn").totalmoney }}
                        {{ languageTranslation.getLanguage("bn").ext }}
                        <text-input
                            disabled
                            id="totalmoney"
                            type="number"
                            step="any"
                            v-model="form.net_amount"
                            :error="errors.net_amount"
                        />
                    </label>
                    <label for="duemoney" class="pr-6 pb-8 w-full lg:w-1/3">
                        {{ languageTranslation.getLanguage("bn").due }}
                        {{ languageTranslation.getLanguage("bn").totalmoney }}
                        {{ languageTranslation.getLanguage("bn").ext }}
                        <text-input
                            type="number"
                            id="duemoney"
                            disabled
                            step="any"
                            v-model="form.due_amount"
                            :error="errors.due_amount"
                        />
                    </label>
                    <label for="paid" class="pr-6 pb-8 w-full lg:w-1/3">
                        {{ languageTranslation.getLanguage("bn").paid }}
                        {{ languageTranslation.getLanguage("bn").ext }}

                        <text-input
                            id="paid"
                            v-if="!expense.is_all_paid"
                            type="number"
                            :min="1"
                            :max="expense.due_amount"
                            step="any"
                            v-model="form.paid_amount"
                            @input="updateDueAmount"
                            :error="errors.paid_amount"
                            tabindex="2"
                        />
                    </label>
                    <label for="expensetype" class="pr-6 pb-8 w-full lg:w-1/4">
                        {{ languageTranslation.getLanguage("bn").expensetype }}
                        {{ languageTranslation.getLanguage("bn").ext }}

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
                    <label for="details" class="pr-6 pb-8 w-full lg:w-3/4">
                        {{ languageTranslation.getLanguage("bn").details }}
                        {{ languageTranslation.getLanguage("bn").ext }}

                        <text-input
                            id="details"
                            v-if="!expense.is_all_paid"
                            v-model="form.note"
                            :error="errors.note"
                            tabindex="3"
                        />
                    </label>
                </div>
                <div
                    class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center content-center"
                >
                    <button
                        v-if="!expense.deleted_at"
                        class="text-red-600 hover:underline"
                        tabindex="-1"
                        type="button"
                        @click="destroy"
                    >
                        <icon name="trash" class="block w-6 h-6 fill-red-600" />
                    </button>

                    <loading-button
                        :loading="sending"
                        v-if="!expense.is_all_paid"
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

        <!-- Showing payments -->
        <h2 class="mt-12 font-bold text-2xl">Payments</h2>
        <div class="mt-6 bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").date }}
                    </th>
                    <th class="px-6 pt-6 pb-4">
                        {{ languageTranslation.getLanguage("bn").expensetype }}
                    </th>
                    <!-- <th class="px-6 pt-6 pb-4">বর্ণনা</th> -->
                    <th class="px-6 pt-6 pb-4" colspan="2">
                        {{ languageTranslation.getLanguage("bn").paid
                        }}{{ languageTranslation.getLanguage("bn").totalmoney }}
                    </th>
                </tr>
                <tr
                    v-for="payment in expense.payments"
                    :key="payment.id"
                    class="hover:bg-gray-100 focus-within:bg-gray-100"
                >
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center focus:text-indigo-500"
                            :href="route()"
                        >
                            {{ payment.created_at | formatDate }}
                            <icon
                                v-if="payment.deleted_at"
                                name="trash"
                                class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2"
                            />
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route()"
                            tabindex="-1"
                        >
                            {{ payment.payment_type }}
                        </inertia-link>
                    </td>
                    <!--                     <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route()" tabindex="-1">
                            {{ payment.note }}
                        </inertia-link>
                    </td> -->
                    <td class="border-t">
                        <inertia-link
                            class="px-6 py-4 flex items-center"
                            :href="route()"
                            tabindex="-1"
                        >
                            {{ payment.paid_amount }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link
                            class="px-4 flex items-center"
                            :href="route()"
                            tabindex="-1"
                        >
                            <icon
                                name="cheveron-right"
                                class="block w-6 h-6 fill-gray-400"
                            />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="expense.payments.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">
                        No contacts found.
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
        expense: Object,
        pay_types: Object
    },
    remember: "form",
    data() {
        return {
            sending: false,
            form: {
                expense_id: this.expense.id,
                product:
                    this.expense.product_name + " " + this.expense.product_type,
                invoice_number: this.expense.invoice_number,
                supplier: this.expense.supplier,
                unit_price: String(this.expense.unit_price),
                quantity: String(this.expense.quantity),
                pay_type: null,
                created_at: new Date().toISOString().slice(0, 10),
                net_amount: String(this.expense.net_amount),
                total_paid: null,
                paid_amount: null,
                due_amount: String(this.expense.due_amount),
                is_all_paid: this.expense.is_all_paid,
                note: null
            }
        };
    },
    methods: {
        updateDueAmount: function() {
            var due = this.expense.due_amount;
            var paid = this.form.paid_amount;
            var now = due - paid;
            now = now.toFixed(2);
            this.form.due_amount = String(now);
            this.form.total_paid =
                Number(this.form.paid_amount) + this.expense.paid_amount;
            console.log(this.form.total_paid);

            this.updateDueStat(now);
        },
        updateDueStat: function(due) {
            var stat = false;
            if (due == 0) {
                stat = true;
            }
            this.form.is_all_paid = Boolean(stat);
        },
        submit() {
            console.log(this.form);
            this.$inertia.put(
                this.route("product.update", this.expense.id),
                this.form,
                {
                    onStart: () => (this.sending = true),
                    onFinish: () => (this.sending = false)
                }
            );
        },
        destroy() {
            console.log(this.expense.id);
            if (confirm("Are you sure you want to delete this entry?")) {
                this.$inertia.delete(
                    this.route("product.destroy", this.expense.id)
                );
            }
        },
        restore() {
            if (confirm("Are you sure you want to restore this entry?")) {
                this.$inertia.put(
                    this.route("product.restore", this.expense.id)
                );
            }
        }
    },
    created() {
        this.languageTranslation = languageTranslation;
    }
};
</script>
