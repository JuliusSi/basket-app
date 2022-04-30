<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            <font-awesome-icon :icon="['fas', 'line-chart']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            {{ this.$t('main.highest_radiation.title') }}
        </div>
        <div class="card-body">
            <div class="pt-3" v-if="!loading && maxRadiationToday">
                <p>{{ this.$t('main.highest_radiation.today') }}</p>
                <p> {{ this.$t('main.radiation.meter_name') }}: {{ maxRadiationToday.meter }}</p>
                <p> {{ this.$t('main.radiation.radiation_background') }}: {{ maxRadiationToday.usvph }} μSv/h</p>
                <p> {{ this.$t('main.radiation.measured_at') }}: {{ maxRadiationToday.measured_at }}</p>
                <p> {{ this.$t('main.radiation.status') }}:
                    {{ this.$t('main.radiation.statuses.' + maxRadiationToday.status) }}</p>
            </div>
            <div class="pt-3" v-if="!loading && maxRadiationAllTime">
                <p>{{ this.$t('main.highest_radiation.all_time') }}</p>
                <p> {{ this.$t('main.radiation.meter_name') }}: {{ maxRadiationAllTime.meter }}</p>
                <p> {{ this.$t('main.radiation.radiation_background') }}: {{ maxRadiationAllTime.usvph }} μSv/h</p>
                <p> {{ this.$t('main.radiation.measured_at') }}: {{ maxRadiationAllTime.measured_at }}</p>
                <p> {{ this.$t('main.radiation.status') }}:
                    {{ this.$t('main.radiation.statuses.' + maxRadiationAllTime.status) }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    data() {
        return {
            loading: false,
            maxRadiationToday: null,
            maxRadiationAllTime: null,
        }
    },
    props: ['user'],
    mounted() {
        this.getMaxRadiationToday();
        this.getMaxRadiationAllTime();
    },
    methods: {
        getMaxRadiationToday() {
            this.loading = true;
            let params = {
                meter_names: ['alpha_charlie', 'golf_charlie'],
                measured_from: moment().startOf('day').format('YYYY-MM-DD HH:mm:ss'),
                measured_to: moment().endOf('day').format('YYYY-MM-DD HH:mm:ss'),
            };
            this.axios.get('/api/highest-radiation', {
                params: params,
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            })
                .then(response => {
                    this.loading = false;
                    if (response.data !== null) {
                        this.maxRadiationToday = response.data;
                    }
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        },
        getMaxRadiationAllTime() {
            this.loading = true;
            let params = {
                meter_names: ['alpha_charlie', 'golf_charlie'],
            };
            this.axios.get('/api/highest-radiation', {
                params: params,
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            })
                .then(response => {
                    this.loading = false;
                    if (response.data !== null) {
                        this.maxRadiationAllTime = response.data;
                    }
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        },
    },
}
</script>
