<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            <font-awesome-icon :icon="['fas', 'cloud-sun']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            {{ this.$t('weather.check_weather_for_basketball') }}
        </div>
        <div class="card-body">
            <div class="alert alert-success text-center fadeIn" role="alert" v-if="status === STATUS_OK">
                <h2 class="alert-heading">{{ this.$t('weather-rules.success') }}</h2>
            </div>
            <div class="alert alert-danger fadeIn text-center" role="alert" v-if="exception">
                <h2 class="alert-heading">{{ exception }}</h2>
            </div>
            <div class="alert alert-danger fadeIn" role="alert" v-if="status === STATUS_NOT_OK">
                <h2 class="alert-heading">{{ this.$t('weather-rules.error') }}</h2>
                <ul class="list">
                    <li v-for="warning in this.warnings">
                        {{ warning.translatedMessage }}
                    </li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                {{ this.$t('weather.select_start_date') }}
                <datetime
                    v-model="selectedStartDate" format="Y-m-d HH:m:s"
                    input-class="form-control mb-3" type="datetime"></datetime>
                {{ this.$t('weather.select_end_date') }}
                <datetime
                    format="Y-m-d HH:m:s"
                    input-class="form-control mb-3" type="datetime" v-model="selectedEndDate"></datetime>
        </div>
            <div class="form-group col-md-8">
                <select v-model="selectedPlace" class="form-control mb-3">
                    <option :value="null" disabled>{{ this.$t('weather.select_place') }}</option>
                    <option :value="place.id" v-for="place in places">{{ this.$t('weather.place_codes.' + place.code) }}</option>
                </select>
                <button class="btn btn-primary mb-2" @click="getWarnings" :disabled="!selectedPlace">
                    {{ this.$t('weather.check_weather') }}
                    <font-awesome-icon :icon="['fas', 'angle-double-right']" class="fa-icon"
                                       fixed-width v-if="selectedPlace"></font-awesome-icon>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import { ref, onMounted } from 'vue';

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
            exception: null,
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
                start_date: moment(this.selectedStartDate).format('YYYY-MM-DD HH:mm:ss'),
                end_date: moment(this.selectedEndDate).format('YYYY-MM-DD HH:mm:ss')
            };
            this.axios.get('/api/weather/warnings', {
                params: params,
                headers: {
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
                    this.loading = false;
                    console.log(error.response.data);
                    this.exception = error.response.data.message;
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
            moment.locale("lt");
            this.selectedStartDate = moment().format();
            this.selectedEndDate = moment().add(1, 'day').format();
        },
    }
}
</script>
