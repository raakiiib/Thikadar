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
        gobagexpenses: ""
    },
    data() {
        let chart = {};
        this.gobagexpenses.map(expense => {
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
                        label: "জি ও ব্যাগ",
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
