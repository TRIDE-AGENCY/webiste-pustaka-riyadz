<template>

    <Head>
        <title>Dashboard − Admin {{ setting.site_title }}</title>
    </Head>

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar py-7 py-lg-8">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <div
                        class="page-title d-flex justify-content-between flex-column gap-6 flex-sm-row w-100"
                    >
                        <div class="flex-fill">
                            <h1 class="page-heading d-flex text-dark fw-bolder flex-column justify-content-center my-0 mb-2">
                                Selamat Datang {{ $page . props . auth . user . name }}
                            </h1>
                            <p class="fs-4 text-gray-600 m-0">Kelola website Anda: <a target="_blank" :href="setting.site_url" class="btn-link-myprimary fw-bolder text-myprimary">{{ setting.site_url }}</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl px-0">
                    <div class="row g-6">
                        <div v-for="card in dashboard.cards" :key="card.label" class="col-12 col-sm-6 col-xl-3">
                            <div class="card rounded-4 border border-gray-300 h-100 overflow-hidden">
                                <div class="card-body p-6">
                                    <div class="d-flex align-items-start justify-content-between gap-4">
                                        <div>
                                            <span class="text-dark fw-bolder fs-5 text-truncate-1">{{ card.label }}</span>
                                            <h2 class="text-dark fw-bold fs-3qx fs-sm-2qx fs-md-2qx fs-lg-2x mt-2 mb-4">{{ formatNumber(card.value) }}</h2>
                                            <p class="text-gray-600 fs-7 mb-0">
                                                {{ card.caption }}
                                            </p>
                                        </div>
                                        <div class="w-60px h-60px flex-shrink-0 bg-myprimary-light d-flex flex-center rounded-pill">
                                            <i :class="[card.icon, 'text-myprimary fs-3x fs-sm-2tx fs-md-2qx']"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6">
                            <div class="card rounded-4 border border-gray-300 h-100">
                                <div class="card-header p-6 d-flex flex-column border-bottom border-gray-300" style="min-height: unset;">
                                    <h3 class="mb-2 fw-bolder">Distribusi Data</h3>
                                    <p class="mb-0 text-gray-600 fs-7">Perbandingan jumlah data di seluruh modul utama.</p>
                                </div>
                                <div class="card-body p-6 h-300px h-xxl-350px d-flex align-items-center justify-content-center">
                                    <canvas ref="contentDistributionCanvas" class="mh-lg-300px"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6">
                            <div class="card rounded-4 border border-gray-300 h-100">
                                <div class="card-header p-6 d-flex flex-column border-bottom border-gray-300" style="min-height: unset;">
                                    <h3 class="mb-2 fw-bolder">Status Publikasi</h3>
                                    <p class="mb-0 text-gray-600 fs-7">Perbandingan FAQ dan Blog yang terbit/arsip.</p>
                                </div>
                                <div class="card-body p-6 h-300px h-xxl-350px d-flex align-items-center justify-content-center">
                                    <canvas ref="statusOverviewCanvas" class="mh-lg-300px"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card rounded-4 border border-gray-300 h-100">
                                <div class="card-header p-6 d-flex flex-column border-bottom border-gray-300" style="min-height: unset;">
                                    <h3 class="mb-2 fw-bolder">Aktivitas 12 Bulan Terakhir</h3>
                                    <p class="mb-0 text-gray-600 fs-7">Akumulasi pertumbuhan semua data dari bulan ke bulan.</p>
                                </div>
                                <div class="card-body p-6 h-350px h-xxl-400px d-flex align-items-center justify-content-center">
                                    <canvas ref="monthlyActivityCanvas" class="mh-lg-350px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LayoutAdmin from '../../../Layouts/Admin.vue';
    import { Head } from "@inertiajs/vue3";
    import { onMounted, onBeforeUnmount, ref } from "vue";
    import Chart from 'chart.js/auto';

    export default {
        layout: LayoutAdmin,

        components: {
            Head,
        },

        props: {
            setting: Object,
            dashboard: Object,
        },

        setup(props) {
            const contentDistributionCanvas = ref(null);
            const statusOverviewCanvas = ref(null);
            const monthlyActivityCanvas = ref(null);
            const charts = [];

            const palette = {
                primary: '#f97316',
                info: '#457B9D',
                success: '2B4162',
                warning: '#E9C46A',
                danger: '#6B4423',
                slate: '#94a3b8',
            };

            const formatNumber = (value) => {
                return new Intl.NumberFormat('id-ID').format(value ?? 0);
            };

            const buildCharts = () => {
                charts.push(new Chart(contentDistributionCanvas.value, {
                    type: 'doughnut',
                    data: {
                        labels: props.dashboard.charts.content_distribution.labels,
                        datasets: [{
                            data: props.dashboard.charts.content_distribution.data,
                            backgroundColor: [
                                palette.primary,
                                palette.info,
                                palette.success,
                                palette.warning,
                                palette.danger,
                                palette.slate,
                            ],
                            borderWidth: 0,
                            hoverOffset: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        size: 12,
                                    },
                                    color: '#000000',
                                },
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 8,
                                titleFont: { size: 12 },
                                bodyFont: { size: 11 },
                                borderColor: '#000000',
                                borderWidth: 1,
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((context.parsed || 0) / total * 100).toFixed(1);
                                        return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                    },
                                },
                            },
                        }
                    },
                }));

                charts.push(new Chart(statusOverviewCanvas.value, {
                    type: 'bar',
                    data: {
                        labels: props.dashboard.charts.status_overview.labels,
                        datasets: [
                            {
                                label: 'Terbit',
                                data: props.dashboard.charts.status_overview.datasets[0].data,
                                backgroundColor: palette.primary,
                                borderRadius: 8,
                                maxBarThickness: 40,
                            },
                            {
                                label: 'Arsip',
                                data: props.dashboard.charts.status_overview.datasets[1].data,
                                backgroundColor: palette.danger,
                                borderRadius: 8,
                                maxBarThickness: 40,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        size: 12,
                                    },
                                    color: '#000000',
                                },
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 8,
                                titleFont: { size: 12 },
                                bodyFont: { size: 11 },
                                borderColor: '#000000',
                                borderWidth: 1,
                                displayColors: true,
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                stacked: false,
                                ticks: {
                                    color: '#64748b',
                                    precision: 0
                                },
                            },
                            x: {
                                beginAtZero: true,
                                stacked: false,
                                ticks: {
                                    color: '#64748b',
                                    precision: 0
                                },
                            },
                        },
                    }
                }));

                charts.push(new Chart(monthlyActivityCanvas.value, {
                    type: 'line',
                    data: {
                        labels: props.dashboard.charts.monthly_activity.labels,
                        datasets: [{
                            label: 'Total Data Baru',
                            data: props.dashboard.charts.monthly_activity.data,
                            borderColor: palette.primary,
                            backgroundColor: 'rgba(255, 156, 46, 0.25)',
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#ffffff',
                            pointBorderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 8,
                            titleFont: { size: 12 },
                            bodyFont: { size: 11 },
                            borderColor: '#000000',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.parsed || 0) / total * 100).toFixed(1);
                                    return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                },
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                stacked: false,
                                ticks: {
                                    color: '#64748b',
                                    precision: 0
                                },
                            },
                            x: {
                                beginAtZero: true,
                                stacked: false,
                                ticks: {
                                    color: '#64748b',
                                    precision: 0
                                },
                            },
                        }
                    }
                }));

            };

            onMounted(() => {
                buildCharts();
            });

            onBeforeUnmount(() => {
                charts.forEach((chart) => chart.destroy());
            });

            return {
                contentDistributionCanvas,
                statusOverviewCanvas,
                monthlyActivityCanvas,
                formatNumber,
            };
        },
    };
</script>

<style scoped>
</style>
