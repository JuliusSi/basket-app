<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            <font-awesome-icon :icon="['fas', 'basketball-ball']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            <span v-if="!loading">{{ court.name }}</span>
        </div>
        <div class="card-body" v-if="!loading">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <vue-load-image class="mb-3">
                            <template v-slot:image>
                            <img slot="image" :src="court.image_path" class="img-fluid fadeIn img"
                                 :alt="court.name">
                            </template>
                            <template v-slot:preloader>
                            <img :style="{height: '50px'}" alt="loader" slot="preloader"
                                 class="mt-5" src="/img/spinner.png"/>
                            </template>
                        </vue-load-image>
                        <div class="center mb-2">
                        <button @click="showCreateArrivalModal = true" class="btn btn-primary mr-1">
                        <font-awesome-icon :icon="['fas', 'calendar']" class="fa-icon"
                                           fixed-width/>
                        </button>
                        <button @click="showCreateArrivalModal = true" class="btn btn-primary">
                            <font-awesome-icon :icon="['fas', 'bell']" class="fa-icon"
                                               fixed-width/>
                        </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="title pl-4 pt-3 pb-2 mb-3 mt-3 bg-title">
                            <h2>
                                <font-awesome-icon :icon="['fas', 'chevron-right']" class="fa-icon" fixed-width/>
                                {{ this.$t('main.basketball-courts.court_information') }}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <dt>{{ this.$t('main.name') }}</dt>
                        <dd>{{ court.name }}</dd>
                        <dt>{{ this.$t('main.city') }}</dt>
                        <dd>{{ court.city }}</dd>
                        <dt>{{ this.$t('main.address') }}</dt>
                        <dd><a style="text-decoration: underline" :href="getGoogleAddressLink(court.address)"> {{ court.address }}</a></dd>
                        <dt>{{ this.$t('main.updated') }}</dt>
                        <dd>{{ formatDate(court.updated_at) }}</dd>
                    </div>
                    <div class="col-md-6">
                        <dt>{{ this.$t('main.description') }}</dt>
                        <dd>{{ court.description }}</dd>
                    </div>
                </div>
                <div class="row" v-if="weatherInformation">
                    <div class="col-md-12">
                        <div class="title pl-4 pt-3 pb-2 mb-3 mt-3 bg-title">
                            <h2>
                                <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loadingWeatherInfo"/>
                                <font-awesome-icon :icon="['fas', 'chevron-right']" class="fa-icon" fixed-width v-if="!loadingWeatherInfo"/>
                                {{ this.$t('main.basketball-courts.weather_in_court') }}
                            </h2>
                        </div>
                            <ul class="list-unstyled">
                                <li v-for="info in weatherInformation.forecasts">
                                    <ul class="list-unstyled" style="margin-bottom: 10px;">
                                        <li>{{ info.forecastTimeUtc }} </li>
                                        <li>
                                            {{ this.$t('weather.air_temperature') }}:
                                            {{ info.airTemperature }} °C
                                        </li>
                                        <li>
                                            {{ this.$t('weather.precipitation') }}:
                                            {{ info.totalPrecipitation }} mm
                                        </li>
                                        <li>
                                            {{ this.$t('weather.wind_speed') }}:
                                            {{ info.windSpeed }} m/s
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                    </div>
                </div>
                <div class="row" v-if="warningResponse">
                    <div class="col-md-12">
                        <div class="title pl-4 pt-3 pb-2 mb-3 mt-3 bg-title">
                            <h2>
                                <font-awesome-icon :icon="['fas', 'chevron-right']" class="fa-icon" fixed-width/>
                                {{ this.$t('main.basketball-courts.is_weather_available_for_basketball') }}
                            </h2>
                        </div>
                        <div class="text-center fadeIn" role="alert" v-if="warningResponse.warnings.length === 0">
                            <h2 class="alert-heading">{{ this.$t('weather-rules.success_static') }}</h2>
                        </div>
                        <div class="fadeIn text-center" role="alert" v-if="exception">
                            <h2 class="alert-heading">{{ exception }}</h2>
                        </div>
                        <div class="fadeIn" role="alert" v-if="warningResponse.warnings.length > 0">
                            <h2 class="alert-heading">{{ this.$t('weather-rules.error') }}</h2>
                            <p class="mt-4">{{ this.$t('main.updated') }} {{ warningResponse.updatedAt }}</p>
                            <ul class="list-unstyled">
                                <li v-for="warning in warningResponse.warnings">
                                    {{ warning.translatedMessage }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueLoadImage from 'vue-load-image';
import moment from "moment";

export default {
    data() {
        return {
            loading: false,
            loadingWeatherInfo: false,
            court: null,
            warningResponse: null,
            weatherInformation: null,
            showCreateArrivalModal: false,
            exception: null,
        }
    },
    components: {
        'vue-load-image': VueLoadImage,
    },
    created() {
        this.getCourt();
    },
    props: ['user'],
    methods: {
        getGoogleAddressLink(address) {
            return 'https://www.google.com/maps/search/?api=1&query=' + address;
        },
        getCourt() {
            this.loading = true;
            this.axios.get('/api/basketball-courts/' + this.$route.params.id, {
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            }).then(response => {
                this.court = response.data;
                this.loading = false;
                this.getWeatherInformation();
                this.getWarnings();
            }).catch(error => {
                console.log(error.response);
            });
        },
        formatDate(date) {
            moment.locale("lt")
            let isToday = moment(date).isSame(moment().clone().startOf('day'), 'd');
            let isSameHour = moment(date).isSame(moment().clone().startOf('hour'), 'h');

            return isToday && isSameHour ? moment(date).startOf('minute').fromNow() : moment(date).format('lll');
        },
        getWarnings() {
            let startDate = moment().format('YYYY-MM-DD HH:mm:ss');
            let endDate = moment(startDate).add(8, 'hours').format('YYYY-MM-DD HH:mm:ss');
            let params = {
                place: this.court.place_code_id,
                start_date: startDate,
                end_date: endDate,
            };
            this.axios.get('/api/weather/warnings', {
                params: params,
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            })
                .then(response => {
                    this.warningResponse = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                    this.exception = error.response.data.message;
                });
        },
        getWeatherInformation() {
            this.loadingWeatherInfo = true;
            let startDate = moment().format('YYYY-MM-DD HH:mm:ss');
            let endDate = moment(startDate).add(8, 'hours').format('YYYY-MM-DD HH:mm:ss');
            let params = {
                place: this.court.place_code_id,
                start_date: startDate,
                end_date: endDate,
            };
            this.axios.get('/api/weather/information', {
                params: params,
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            })
                .then(response => {
                    this.loadingWeatherInfo = false;
                    this.weatherInformation = response.data;
                })
                .catch(error => {
                    this.loadingWeatherInfo = false;
                    console.log(error.response.data);
                    this.exception = error.response.data.message;
                });
        },
    },
}
</script>
