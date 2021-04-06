<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link
                class="text-indigo-400 hover:text-indigo-600"
                :href="route('gobag.index')"
                >জি ও ব্যাগ</inertia-link
            >
            <span class="text-indigo-400 font-medium">/</span> নতুন
            <br />
        </h1>
        <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input
                        type="date"
                        value="28-12-2020"
                        v-model="form.created_at"
                        :error="errors.created_at"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Date"
                    />

                    <select-input
                        v-model="form.vendor_id"
                        :error="errors.vendor_id"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Supplier"
                    >
                        <option :value="null" />
                        <option
                            v-for="supplier in suppliers"
                            :key="supplier.id"
                            :value="supplier.id"
                            >{{ supplier.name }}</option
                        >
                    </select-input>

                    <text-input
                        type="number"
                        step="0.01"
                        v-model="form.quantity"
                        @input="updateNetAmout"
                        :error="errors.quantity"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Quantity"
                    />

                    <text-input
                        type="number"
                        step="any"
                        v-model="form.size"
                        @input="updateNetAmout"
                        :error="errors.size"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Size"
                    />

                    <text-input
                        type="number"
                        step="0.01"
                        v-model="form.unitprice"
                        @input="updateNetAmout"
                        :error="errors.unitprice"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Rate"
                    />

                    <text-input
                        type="number"
                        step="0.01"
                        v-model="form.net_amount"
                        :error="errors.net_amount"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Total"
                    />

                    <text-input
                        type="number"
                        step="0.01"
                        v-model="form.paid_amount"
                        @input="calculateDue"
                        :error="errors.paid_amount"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Paid"
                    />

                    <text-input
                        type="number"
                        step="-0.01"
                        v-model="form.due_amount"
                        @input="calculateDue"
                        :error="errors.due_amount"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Due"
                    />

                    <select-input
                        v-model="form.pay_type"
                        :error="errors.pay_type"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="খরচের ধরন"
                    >
                        <option
                            v-for="cost in pay_types.data"
                            :key="cost.id"
                            :value="cost.name"
                        >
                            {{ cost.name }}
                        </option>
                    </select-input>

                    <text-input
                        type="text"
                        v-model="form.note"
                        :error="errors.note"
                        class="pr-6 pb-8 w-full lg:w-1/2"
                        label="Note"
                    />
                </div>
                <div
                    class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center"
                >
                    <loading-button
                        :loading="sending"
                        class="btn-indigo"
                        type="submit"
                    >
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
    metaInfo: { title: "নতুন জি ও ব্যাগ যোগ করুন" },
    layout: Layout,
    components: {
        LoadingButton,
        SelectInput,
        TextInput
    },
    props: {
        suppliers: Array,
        invoice_number: String,
        errors: Object,
        pay_types: Object
    },
    remember: "form",
    data() {
        return {
            sending: false,
            service_data: null,
            form: {
                vendor_id: null,
                // invoice_number: this.invoice_number,
                expense_type: 5,
                invoice_number: this.invoice_number,
                quantity: null,
                unitprice: null,
                size: null,
                net_amount: null,
                paid_amount: null,
                due_amount: null,
                is_all_paid: false,
                created_at: new Date().toISOString().slice(0, 10)
            }
        };
    },
    methods: {
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
            this.$inertia.post(this.route("gobag.store"), this.form, {
                onStart: () => (this.sending = true),
                onFinish: () => (this.sending = false)
            });
        }
    }
};
</script>
