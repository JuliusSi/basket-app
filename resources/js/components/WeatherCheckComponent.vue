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
        }
    },
    mounted() {
        this.getAvailablePlaces();
    },
    methods: {
        getWarnings() {
            this.loading = true;
            let place = {place: this.selectedPlace};
            this.axios.get('/api/weather/warnings', {
                params: place
            })
                .then(response => {
                    this.loading = false;
                    if (response.data.length) {
                        this.warnings = response.data;
                        this.status = STATUS_NOT_OK;
                    } else {
                        this.status = STATUS_OK;
                    }
                });
        },
        getAvailablePlaces() {
            this.loading = true;
            this.axios.get('/api/weather/available-places')
                .then(response => {
                    this.loading = false;
                    this.places = response.data;
                });
        },
    }
}
</script>
