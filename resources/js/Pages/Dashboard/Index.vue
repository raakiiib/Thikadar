<template>
    <div>
        <div>
            <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>

            <div class=" float-right">
                <select
                    class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none"
                    @change="changeChart($event)"
                >
                    <option value="7">7Days Record</option>
                    <option value="30">30Days Record</option>
                </select>
            </div>

            <div class="mb-8 flex grid grid-cols-1 gap-5 ">
                <DailyExpense v-bind:expenses="expenses" v-if="showChart">
                </DailyExpense>
                <BlockChart></BlockChart>
                <BuyProduct
                    v-bind:expensesProduct="expensesProduct"
                    v-if="showChart"
                ></BuyProduct>

                <BlockDumpingChart></BlockDumpingChart>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import BlockChart from "./../../Components/BlockChart";
import DailyExpense from "./../../Components/DailyExpense";
import BuyProduct from "./../../Components/BuyProduct";
import BlockDumpingChart from "./../../Components/BlokDumpingChart";

export default {
    metaInfo: { title: "Dashboard" },
    layout: Layout,
    props: {
        expenses7: "",
        expenses30: "",
        expenses7Product: "",
        expenses30Product: ""
    },
    data() {
        return {
            expenses: this.expenses7,
            expensesProduct: this.expenses7Product,
            showChart: true
        };
    },
    methods: {
        changeChart: function($event) {
            console.log($event.target.value);
            this.showChart = false;
            setTimeout(() => {
                if ($event.target.value == "7") {
                    this.expenses = this.expenses7;
                    this.expensesProduct = this.expenses7Product;
                } else if ($event.target.value == "30") {
                    console.log($event.target.value);
                    this.expenses = this.expenses30;
                    this.expensesProduct = this.expenses30Product;
                }
                this.showChart = true;
            }, 10);
        }
    },
    components: {
        BlockChart,
        DailyExpense,
        BuyProduct,
        BlockDumpingChart
    }
};
</script>
