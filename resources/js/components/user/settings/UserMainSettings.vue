<template>
    <div class="col-md-12 fadeIn">
        <div class="title pl-4 pt-3 pb-2 mt-2 mb-2 bg-title">
            <h2>
                <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
                <font-awesome-icon :icon="['fas', 'chevron-right']" class="fa-icon" v-if="!loading" fixed-width/>
                {{ this.$t('main.user_settings.personal_information') }}
            </h2>
        </div>
        <div class="text-left">
            <div class="mt-4 alert alert-success text-center fadeIn" role="alert" v-if="status === STATUS_OK">
                <h2 class="alert-heading">{{ this.$t('main.information_update_success') }}</h2>
            </div>
            <div class="mt-4 alert alert-danger fadeIn" role="alert" v-if="status === STATUS_NOT_OK">
                <h2 class="alert-heading">{{ this.$t('main.information_update_fail') }}</h2>
                <ul class="list">
                    <li v-for="(errorMessages, index) in errors">
                        <span>{{ this.$t('validation.error_in_input') }} {{ this.$t('validation.attributes.' + index) }}</span>
                        <ul class="list-unstyled">
                            <li v-for="errorMessage in errorMessages">
                                {{ errorMessage }}
                            </li>
                        </ul>

                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <form
                        id="app" @submit.prevent="updateUserData" method="post"
                    >
                        <div class="form-group row mb-4">
                            <div class="col-md-8">
                                <label class="col-form-label text-md-right" for="phone">{{
                                        this.$t('main.phone')
                                    }}</label>
                                <input v-model="phone" class="form-control" maxlength="11" type="tel" id="phone"
                                       name="phone" placeholder="370..."
                                       pattern="[0-9]{11}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ this.$t('main.save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <weather-notification-settings v-show="canShowWeatherSettings" :user="user"></weather-notification-settings>
</template>

<script>

const STATUS_OK = 'OK';
const STATUS_NOT_OK = 'NOT_OK';
export default {
    props: ['user'],
    data() {
        return {
            STATUS_NOT_OK: STATUS_NOT_OK,
            STATUS_OK: STATUS_OK,
            loading: false,
            status: null,
            errors: [],
            phone: null,
            canShowWeatherSettings: false,
        }
    },
    mounted() {
        if (this.user.phone) {
            this.phone = this.user.phone;
            this.canShowWeatherSettings = true;
        }
    },
    methods: {
        updateUserData() {
            this.loading = true;
            let data = {
                phone: this.phone,
            };
            this.axios.put('/api/current-user', data, {
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            })
                .then(response => {
                    this.loading = false;
                    this.status = STATUS_OK;
                    this.errors = [];
                    this.canShowWeatherSettings = true;
                })
                .catch(error => {
                    this.loading = false;
                    console.log(error.response.data);
                    this.errors = error.response.data.errors;
                    this.status = STATUS_NOT_OK;
                });
        },
    },
}
</script>
