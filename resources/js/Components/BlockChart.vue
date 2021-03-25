<template>
    <div class="chart">
        <line-chart :chartdata="datacollection" :options="options"></line-chart>
    </div>
</template>

<script>
import LineChart from "./LineChart.js";

export default {
    name: "Chart",
    components: {
        LineChart
    },
    props: {
        block: ""
    },
    data() {
        let chart = {};
        this.block.map(expense => {
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
                        label: " ব্লক কাস্টিং",
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
