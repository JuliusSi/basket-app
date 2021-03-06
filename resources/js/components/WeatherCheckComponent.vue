<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            <font-awesome-icon :icon="['fas', 'cloud-sun']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            {{ 'weather.check_weather_for_basketball' | trans }}
        </div>
        <div class="card-body">
            <div class="alert alert-success text-center fadeIn" role="alert" v-if="status === STATUS_OK">
                <h5 class="alert-heading">{{ 'weather-rules.success' | trans }}</h5>
            </div>
            <div class="alert alert-danger fadeIn" role="alert" v-if="status === STATUS_NOT_OK">
                <h5 class="alert-heading">{{ 'weather-rules.error' | trans }}</h5>
                <ul class="list">
                    <li v-for="warning in this.warnings">
                        {{ warning.translatedMessage }}
                    </li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                {{ 'weather.select_start_date' | trans }}
                <input v-model="selectedStartDate" type="date" class="form-control mb-3">
            {{ 'weather.select_end_date' | trans }}
            <input v-model="selectedEndDate" type="date" class="form-control mb-3">
        </div>
            <div class="form-group col-md-8">
                <select v-model="selectedPlace" class="form-control mb-3">
                    <option :value="null" disabled>{{ 'weather.select_place' | trans }}</option>
                    <option :value="name" v-for="(value, name) in this.places">{{ value }}</option>
                </select>
                <button class="btn btn-primary mb-2" @click="getWarnings" :disabled="!selectedPlace">
                    {{ 'weather.check_weather' | trans }}
                    <font-awesome-icon :icon="['fas', 'angle-double-right']" class="fa-icon"
                                       fixed-width v-if="selectedPlace"></font-awesome-icon>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
const STATUS_OK = 'OK';
const STATUS_NOT_OK = 'NOT_OK';
export default {
    data() {
        return {
            STATUS_NOT_OK: STATUS_NOT_OK,
            STATUS_OK: STATUS_OK,
            selectedPlace: null,
            loading: false,
            warnings: [],
            status: null,
            places: null,
            selectedStartDate: null,
            selectedEndDate: null,
        }
    },
    props: ['user'],
    mounted() {
        this.getAvailablePlaces();
        this.getDate();
    },
    methods: {
        getWarnings() {
            this.loading = true;
            let params = {
                place: this.selectedPlace,
                start_date: this.selectedStartDate,
                end_date: this.selectedEndDate
            };
            this.axios.get('/api/weather/warnings', {
                params: params,
                headers : {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            })
                .then(response => {
                    this.loading = false;
                    if (response.data.length) {
                        this.warnings = response.data;
                        this.status = STATUS_NOT_OK;
                    } else {
                        this.status = STATUS_OK;
                    }
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        },
        getAvailablePlaces() {
            this.loading = true;
            this.axios.get('/api/weather/available-places', {
                headers : {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            })
                .then(response => {
                    this.loading = false;
                    this.places = response.data;
                });
        },
        getDate() {
            const date = new Date();
            this.selectedStartDate = date.toLocaleString('lt-LT', { timeZone: 'Europe/Vilnius' }).slice(0, 10);

            date.setDate(date.getDate() + 1);
            this.selectedEndDate = date.toLocaleString('lt-LT', { timeZone: 'Europe/Vilnius' }).slice(0, 10);
        },
    }
}
</script>
