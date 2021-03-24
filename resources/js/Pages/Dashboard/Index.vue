<template>
    <div>
        <div>
            <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>

            <div class=" float-right">
                <select
                    class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none"
                    @change="changeChart($event)"
                >
                    <option name="7" value="7">7Days Record</option>
                    <option name="30" value="30">30Days Record</option>
                </select>
            </div>

            <div class="mb-8 flex grid grid-cols-2 gap-5 ">
                <DailyExpense v-bind:expenses="expenses"> </DailyExpense>

                <BuyProduct></BuyProduct>
                <BlockChart></BlockChart>
            </div>

            <div class="mb-8 flex grid grid-cols-3 gap-3 ">
                <inertia-link
                    class="bg-indigo-900 text-indigo-300 flex items-center justify-between md:justify-center"
                    :href="route('suppliers')"
                >
                    <div class="thumbnail ">
                        <div class="icon">
                            <i class="fa fa-home"></i>
                        </div>
                        <div class="caption">
                            <h1>ADD NEW PURCHASE</h1>
                        </div>
                    </div>
                </inertia-link>

                <inertia-link
                    class="bg-purple-900 text-indigo-300 flex items-center justify-between md:justify-center"
                    :href="route('suppliers')"
                >
                    <div class="thumbnail ">
                        <div class="caption">
                            <h1>PAY SUPPLIER</h1>
                        </div>
                    </div>
                </inertia-link>

                <inertia-link
                    class="bg-indigo-900 text-indigo-300 flex items-center justify-between md:justify-center h-64"
                    :href="route('suppliers')"
                >
                    <div class="thumbnail ">
                        <div class="icon">
                            <i class="fa fa-home"></i>
                        </div>
                        <div class="caption">
                            <h1>PAY STAFFS</h1>
                        </div>
                    </div>
                </inertia-link>
            </div>
            <p class="leading-normal">
                👆 These links are intended to be broken to illustrate how error
                handling works with Inertia.js.
            </p>
        </div>
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import BlockChart from "./../../Components/BlockChart";
import DailyExpense from "./../../Components/DailyExpense";
import BuyProduct from "./../../Components/BuyProduct";

export default {
    metaInfo: { title: "Dashboard" },
    layout: Layout,
    props: {
        expenses7: "",
        expenses30: ""
    },
    data() {
        return {
            expenses: this.expenses7,
            visibility: true
        };
    },
    methods: {
        changeChart: function(event) {
            if (event.target.value == "7") {
                this.expenses = this.expenses7;
            } else if (event.target.value == "30") {
                this.expenses = this.expenses30;
            }
        }
    },
    components: {
        BlockChart,
        DailyExpense,
        BuyProduct
    }
};
</script>
