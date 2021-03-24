<template>
    <div class="chart">
        <bar-chart :chartdata="datacollection" :options="options"></bar-chart>
    </div>
</template>

<script>
import BarChart from "./BarChart.js";

export default {
    name: "Chart",
    components: {
        BarChart
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
                        label: "পণ্য খরচ",
                        backgroundColor:
                            "#" +
                            ((Math.random() * 0xffffff) << 0).toString(16),
                        data: [2000, 4000, 5450, 700, 634, 780, 7900]
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
