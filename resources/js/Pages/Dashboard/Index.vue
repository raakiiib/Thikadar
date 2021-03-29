<template>
    <div>
        <div>
            <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>

            <!-- v-calendar -->

            <Calendar is-expanded show-weeknumbers :attributes="attributes" />

            <!-- date-picker -->

            <div class=" float-right">
                <div class="card">
                    <div class="card-header">CALENDAR</div>
                    <div class="card-body">
                        <Datepicker
                            v-model="date"
                            format="yyyy-MM-dd"
                            :inline="true"
                        ></Datepicker>
                    </div>
                </div>

                <!-- dropdownfor data  -->
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
                <BlockChart v-bind:block="block" v-if="showChart"></BlockChart>
                <BuyProduct
                    v-bind:expensesProduct="expensesProduct"
                    v-if="showChart"
                ></BuyProduct>

                <BlockDumpingChart
                    v-bind:blockDumping="blockDumping"
                    v-if="showChart"
                ></BlockDumpingChart>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import Vue from "vue";
import BlockChart from "./../../Components/BlockChart";
import DailyExpense from "./../../Components/DailyExpense";
import BuyProduct from "./../../Components/BuyProduct";
import BlockDumpingChart from "./../../Components/BlokDumpingChart";
import Datepicker from "vuejs-datepicker";
import Calendar from "v-calendar/lib/components/calendar.umd";
Vue.component("calendar", Calendar);

export default {
    name: "",
    metaInfo: { title: "Dashboard" },
    layout: Layout,
    props: {
        expenses7: "",
        expenses30: "",
        expenses7Product: "",
        expenses30Product: "",
        blockDumping7: "",
        blockDumping30: "",
        block7: "",
        block30: ""
    },
    data() {
        return {
            expenses: this.expenses7,
            expensesProduct: this.expenses7Product,
            blockDumping: this.blockDumping7,
            block: this.block7,
            showChart: true,
            date: new Date().toISOString().substr(0, 10), // 05/09/2019

            attributes: [
                {
                    // Attribute type definitions
                    highlight: true,

                    bar: true,
                    content: "red",
                    popover: {},

                    customData: {
                        // data will go here
                    },

                    dates: new Date()
                }
            ]
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
                    this.block = this.block7;
                    this.blockDumping = this.blockDumping7;
                } else if ($event.target.value == "30") {
                    console.log($event.target.value);
                    this.expenses = this.expenses30;
                    this.expensesProduct = this.expenses30Product;
                    this.block = this.block30;
                    this.blockDumping = this.blockDumping30;
                }
                this.showChart = true;
            }, 10);
        }
    },

    components: {
        BlockChart,
        DailyExpense,
        BuyProduct,
        BlockDumpingChart,
        Datepicker,
        Calendar
    }
};
</script>
