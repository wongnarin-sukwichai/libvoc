<template>
    <!-- <div class="relative">
        <div class="h-[208px]">
            <canvas class="mt-3" ref="reportUserOne"></canvas>
        </div>
        <div
            class="flex flex-col justify-center items-center absolute w-full h-full top-0 left-0"
        >
            <div class="text-xl font-medium">63,044</div>
            <div class="text-slate-500 mt-0.5">คน</div>
        </div>
    </div> -->
</template>

<script>
import Chart from "chart.js/auto";

export default {
    mounted() {
        this.reportDonutChart();
    },
    data() {},
    methods: {
        reportDonutChart() {
            const ctx = this.$refs.reportUserOne;
            let myUserOne = new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: "",
                    datasets: [
                        {
                            label: "Data",
                            data: [22, 63, 10, 5],
                            backgroundColor: [
                                "#0ea5e9",
                                "#0d9488",
                                "#fb923c",
                                "#facc15",
                            ],
                            hoverBackgroundColor: ["#9BD0F5", "#9BD0F5"],
                            borderWidth: 5,
                            borderColor: "#fff",
                        },
                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    cutout: "80%",
                },
            });
        },
    },
};
</script>
