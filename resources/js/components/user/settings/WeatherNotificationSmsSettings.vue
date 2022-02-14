<template>
    <div class="col-md-12 fadeIn">
        <div class="title pl-2 pt-3 pb-2 mb-4 mt-2 bg-title">
            <h2>
                <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
                <font-awesome-icon :icon="['fas', 'chevron-right']" class="fa-icon" v-if="!loading" fixed-width/>
                {{ 'main.user_settings.basketball_weather_sms_notification' | trans }}
            </h2>
        </div>
        <div class="text-left">
            <div class="mt-4 alert alert-success text-center fadeIn" role="alert" v-if="status === STATUS_OK">
                <h2 class="alert-heading">{{ 'main.information_update_success' | trans }}</h2>
            </div>
            <div class="mt-4 alert alert-danger fadeIn" role="alert" v-if="status === STATUS_NOT_OK">
                <h2 class="alert-heading">{{ 'main.information_update_fail' | trans }}</h2>
            </div>
            <form
                id="app" @submit.prevent="updateUserAttributes" method="POST"
            >
                    <div class="row">
                        <div class="col-md-10">
                            {{ 'attributes.names.' + smsNotify.name | trans }}
                        </div>
                        <div class="col-md-2">
                            <div class="material-switch pull-right">
                                <input id="setting" name="setting"
                                       v-model="smsNotify.value"
                                       v-bind:true-value="'1'"
                                       v-bind:false-value="'0'"
                                       type="checkbox"/>
                                <label for="setting" class="bg-success"></label>
                            </div>
                        </div>
                    </div>
                    <div class="text-left fadeIn" v-if="smsNotify.value === '1'">
                        <div class="form-group row mt-4" v-if="time">
                            <div class="col-md-8">
                                <label for="date">{{ 'main.user_settings.select_time' | trans }}</label>

                                <input v-model="time.value" class="form-control" type="time" id="date" name="date"
                                       min="09:00" max="18:00" required>
                            </div>
                        </div>
                        <div class="form-group row"
                             v-if="place">
                            <div class="col-md-8">
                                <select v-model="place.value" class="form-control mb-1">
                                    <option :value="null" disabled>{{ 'weather.select_place' | trans }}</option>
                                    <option :value="place.code" v-for="place in places">
                                        {{ 'weather.place_codes.' + place.code | trans }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                <div class="form-group row mt-4">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                            {{ 'main.save' | trans }}
                        </button>
                    </div>
                </div>
            </form>
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
            loading: false,
            places: [],
            errors: [],
            status: null,
            smsNotify: null,
            time: null,
            place: null,
        }
    },
    props: ['user'],
    mounted() {
        this.smsNotify = this.getUserAttributeByName('notify_about_weather_for_basketball_by_sms');
        this.place = this.getUserAttributeByName('weather_for_basketball_notification_place_code');
        this.time = this.getUserAttributeByName('weather_for_basketball_notification_time');
        this.getAvailablePlaces();
    },
    methods: {
        getUserAttributeByName(attributeName) {
            return this.user.user_attributes.find(({name}) => name === attributeName);
        },
        getAvailablePlaces() {
            this.loading = true;
            this.axios.get('/api/weather/available-places', {
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            })
                .then(response => {
                    this.loading = false;
                    this.places = response.data;
                });
        },
        updateUserAttributes() {
            this.loading = true;
            let data = [
                {
                    id: this.smsNotify.id,
                    name: this.smsNotify.name,
                    value: this.smsNotify.value
                },
                {
                    id: this.place.id,
                    name: this.place.name,
                    value: this.place.value
                },
                {
                    id: this.time.id,
                    name: this.time.name,
                    value: this.time.value
                },
            ];
            this.axios.put('/api/update-current-user-attributes', data, {
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            })
                .then(response => {
                    this.loading = false;
                    this.status = STATUS_OK;
                    this.errors = [];
                })
                .catch(error => {
                    this.loading = false;
                    console.log(error.response.data);
                    this.errors = error.response.data.errors;
                    this.status = STATUS_NOT_OK;
                });
        },
    }
}
</script>
