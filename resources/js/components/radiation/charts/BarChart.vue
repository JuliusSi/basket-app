<template>
    <div class="text-center">
        <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="!loaded"/>
        <div v-if="loaded">
            <Bar :chart-data="chartData" :chart-options="chartOptions"/>
        </div>
    </div>
</template>

<script>
import moment from "moment";

import {Bar} from 'vue-chartjs';
import {Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    components: {Bar},
    data: () => ({
        loaded: false,
        chartData: null,
    }),
    computed: {
        chartOptions() {
            return {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: false,
                        suggestedMin: 0.2,
                        ticks: {
                            stepSize: 0.05
                        }
                    }
                },
            }
        },
    },
    props: ['user'],
    mounted() {
        this.getMaxRadiationToday();
    },
    methods: {
        getMaxRadiationToday() {
            let measuredFrom = moment().startOf('year').format('YYYY-MM-DD HH:mm:ss');
            let measuredTo = moment().endOf('month').format('YYYY-MM-DD HH:mm:ss');
            let params = {
                meter_names: ['alpha_charlie'],
                measured_from: measuredFrom,
                measured_to: measuredTo,
                min_usvph: 0.22,
            };
            this.axios.get('/api/radiation-history', {
                params: params,
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            })
                .then(response => {
                    this.loaded = true;
                    if (response.data !== null) {
                        let data = response.data.map(a => a.usvph);
                        let labels = response.data.map(a => moment(a.measured_at).format('MM-DD HH:mm'));
                        this.chartData = {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'alpha_charlie',
                                    backgroundColor: '#f87979',
                                    data: data
                                }
                            ]
                        };
                    }
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        },
    },
}
</script>
