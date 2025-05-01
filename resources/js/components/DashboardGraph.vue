<template>
    <div class="p-6 bg-white shadow-lg rounded-xl">
      <h2 class="text-xl font-semibold mb-4">Dashboard Analytics</h2>

      <Dropdown
        v-model="selectedView"
        :options="viewOptions"
        optionLabel="label"
        class="w-48 mb-4"
        @change="updateChartData"
      />

      <Chart type="bar" :data="chartData" :options="chartOptions" class="w-full h-80" />
    </div>
  </template>

<script setup>
import { ref, computed, watch } from "vue";
import Chart from "primevue/chart";
import Dropdown from "primevue/dropdown";

const selectedView = ref({ value: "monthly", label: "Monthly" });

const viewOptions = [
  { value: "monthly", label: "Monthly" },
  { value: "yearly", label: "Yearly" }
];

const props = defineProps({
    FormattedData:Array
})

const GenerateMonthData = () => {
  return props.FormattedData[5]?.data.map(monthData => monthData.total) || [];
};
const GenerateYearData = () => {
  return props.FormattedData.map(yearlyData =>
    yearlyData.data.reduce((sum, month) => sum + month.total, 0)
  ) || [];
};

const monthlyData = computed(() => ({
  labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
  datasets: [
    { label: "Calls", backgroundColor: "#f80759", data: GenerateMonthData(12) },
  ]
}));

const yearlyData = computed(() => ({
  labels: props.FormattedData.map(year => year.year) || ['2020', '2021', '2022', '2023', '2025'],
  datasets: [
    { label: "Calls", backgroundColor: "#f80759", data: GenerateYearData() },
  ]
}));

const chartData = ref(monthlyData.value);

const updateChartData = () => {
  chartData.value = selectedView.value.value === "monthly" ? monthlyData.value : yearlyData.value;
};

watch(selectedView, updateChartData);

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  plugins: { legend: { labels: { color: "#495057" } } },
  scales: {
    x: { ticks: { color: "#495057" }, grid: { color: "#ebedef" } },
    y: { ticks: { color: "#495057" }, grid: { color: "#ebedef" } }
  }
});
</script>
