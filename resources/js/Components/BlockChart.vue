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
    data() {
        return {
            datacollection: {
                labels: [
                    "1/3/2021",
                    "2/3/2021",
                    "3/3/2021",
                    "4/3/2021",
                    "5/3/2021",
                    "6/3/2021",
                    "7/3/2021"
                ],
                datasets: [
                    {
                        label: "ব্লক কাস্টিং ",
                        backgroundColor:
                            "#" +
                            ((Math.random() * 0xffffff) << 0).toString(16),
                        data: [5400, 200, 9450, 7800, 6340, 780, 10900]
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
