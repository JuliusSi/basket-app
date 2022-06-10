<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            <font-awesome-icon :icon="['fas', 'cloud-sun']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            {{ this.$t('weather.check_weather_for_basketball') }}
        </div>
        <div class="card-body">
            <div class="info" v-if="warningResponse">
                <div class="alert alert-success text-center fadeIn" role="alert" v-if="warningResponse.warnings.length === 0">
                    <h2 class="alert-heading">{{ this.$t('weather-rules.success_static') }}</h2>
                    <p class="mt-4 mb-1">{{ this.$t('main.updated') }} {{ warningResponse.updatedAt }}</p>
                </div>
                <div class="alert alert-danger fadeIn text-center" role="alert" v-if="exception">
                    <h2 class="alert-heading">{{ exception }}</h2>
                </div>
                <div class="alert alert-danger fadeIn" role="alert" v-if="warningResponse.warnings.length > 0">
                    <h2 class="alert-heading">{{ this.$t('weather-rules.error') }}</h2>
                    <p class="mt-4">{{ this.$t('main.updated') }} {{ warningResponse.updatedAt }}</p>
                    <ul class="list">
                        <li v-for="warning in this.warningResponse.warnings">
                            {{ warning.translatedMessage }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="form-group col-md-6">
                {{ this.$t('weather.select_start_date') }}
                <datetime
                    class="mb-3"
                    v-model="selectedStartDate" format="Y-MM-dd HH:mm"
                    :clearable="false"
                    type="datetime"></datetime>
                {{ this.$t('weather.select_end_date') }}
                <datetime
                    format="Y-MM-dd HH:mm"
                    :clearable="false"
                    type="datetime" v-model="selectedEndDate"></datetime>
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

export default {
    data() {
        return {
            selectedPlace: null,
            loading: false,
            warningResponse: null,
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
                    this.warningResponse = response.data;
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
