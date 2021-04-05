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
                            <img slot="image" :src="court.image_path" class="img-fluid fadeIn img"
                                 :alt="court.name">
                            <img :style="{height: '50px'}" alt="loader" slot="preloader"
                                 class="mt-5" src="/img/spinner.png"/>
                        </vue-load-image>
                        <button class="btn btn-primary mb-2">
                        <font-awesome-icon style="color: #cc7a00;" :icon="['fas', 'basketball-ball']" class="fa-icon fa-pulse"
                                           fixed-width v-if="!loading"/>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="title pl-2 pt-3 pb-2 mb-3 mt-3 bg-title">
                            <h2>
                                <font-awesome-icon :icon="['fas', 'chevron-right']" class="fa-icon" fixed-width/>
                                {{ 'main.basketball-courts.court_information' | trans }}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <dt>{{ 'main.name' | trans }}</dt>
                        <dd>{{ court.name }}</dd>
                        <dt>{{ 'main.city' | trans }}</dt>
                        <dd>{{ court.city }}</dd>
                        <dt>{{ 'main.address' | trans }}</dt>
                        <dd><a :href="getGoogleAddressLink(court.address)"> {{ court.address }}</a></dd>
                        <dt>{{ 'main.updated' | trans }}</dt>
                        <dd>{{ formatDate(court.updated_at) }}</dd>
                    </div>
                    <div class="col-md-6">
                        <dt>{{ 'main.description' | trans }}</dt>
                        <dd>{{ court.description }}</dd>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="title pl-2 pt-3 pb-2 mb-3 mt-3 bg-title">
                            <h2>
                                <font-awesome-icon :icon="['fas', 'chevron-right']" class="fa-icon" fixed-width/>
                                {{ 'main.basketball-courts.weather_in_court' | trans }}
                            </h2>
                        </div>
                        <div class="text-center fadeIn" role="alert" v-if="!weatherWarnings.length">
                            <h2 class="alert-heading">{{ 'weather-rules.success' | trans }}</h2>
                        </div>
                        <div class="fadeIn" role="alert" v-if="weatherWarnings.length">
                            <h2 class="alert-heading">{{ 'weather-rules.error' | trans }}</h2>
                            <ul class="list-unstyled">
                                <li v-for="warning in this.weatherWarnings">
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
            court: null,
            weatherWarnings: [],
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
            this.loading = true;
            let startDate = moment().format('YYYY-MM-DD HH:mm:ss');
            let endDate = moment(startDate).add(4, 'hours').format('YYYY-MM-DD HH:mm:ss');
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
                    this.loading = false;
                    if (response.data.length) {
                        this.weatherWarnings = response.data;
                        this.status = STATUS_NOT_OK;
                    } else {
                        this.status = STATUS_OK;
                    }
                })
                .catch(error => {
                    console.log(error.response);
                });
        },
    },
}
</script>
