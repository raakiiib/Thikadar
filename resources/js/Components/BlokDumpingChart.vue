<template>
    <div class="chart">
        <line-chart :chartdata="datacollection" :options="options"></line-chart>
    </div>
</template>

<script>
import LineChart from "./LineChart.js";

export default {
    name: "blockChart",
    components: {
        LineChart
    },
    props: {
        blockDumping: ""
    },
    data() {
        let chart = {};
        this.blockDumping.map(expense => {
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
                        label: "ব্লক ডাম্পিং",
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
