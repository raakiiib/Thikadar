<template>
    <div class="chart">
        <bar-chart :chartdata="datacollection" :options="options"> </bar-chart>
    </div>
</template>

<script>
import BarChart from "./BarChart.js";

export default {
    name: "Chart",
    components: {
        BarChart
    },
    props: {
        expenses: ""
    },
    data() {
        let chart = {};
        this.expenses.map(expense => {
            if (chart[expense.created_at]) {
                chart[expense.created_at] += expense.paid;
            } else {
                chart[expense.created_at] = expense.paid;
            }
        });

        return {
            datacollection: {
                labels: Object.keys(chart),
                datasets: [
                    {
                        label: "দৈনন্দিন খরচ",
                        backgroundColor:
                            "#" +
                            ((Math.random() * 0xffffff) << 0).toString(16),
                        data: Object.values(chart)
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        };
    }
};
</script>

<style></style>
