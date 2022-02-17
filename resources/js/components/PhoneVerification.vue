<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            <font-awesome-icon :icon="['fas', 'mobile-alt']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            {{ this.$t('verification.phone.verify_phone') }}
        </div>
        <div class="card-body">
            <div class="alert alert-success text-center fadeIn" role="alert" v-if="status === STATUS_OK">
                <h5 class="alert-heading">{{ this.$t('verification.phone.success') }}</h5>
            </div>
            <div class="alert alert-danger fadeIn" role="alert" v-if="status === STATUS_NOT_OK">
                <ul class="list">
                    <li v-for="error in this.errors">
                        {{ error }}
                    </li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                    <label for="phone" class="col-form-label">{{ this.$t('main.phone') }}</label>
                        <input class="form-control mb-3" placeholder="370" id="phone" type="text" name="phone" required autocomplete="phone">
                <button class="btn btn-primary mb-2" @click="getWarnings" :disabled="!phone">
                    {{ this.$t('verification.verify') }}
                    <font-awesome-icon :icon="['fas', 'angle-double-right']" class="fa-icon"
                                       fixed-width v-if="phone"></font-awesome-icon>
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
            loading: false,
            status: null,
            phone: null,
            errors: [],
        }
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
