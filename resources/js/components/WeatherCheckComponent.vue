<template>
    <div class="row justify-content-center mb-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ 'weather.check_weather_for_basketball' | trans }}
                </div>
                <div class="card-body">
                    <div class="alert alert-success text-center" role="alert" v-if="status === STATUS_OK">
                        {{ 'weather-rules.success' | trans }}
                    </div>
                    <div class="alert alert-danger" role="alert" v-if="status === STATUS_NOT_OK">
                        {{ 'weather-rules.error' | trans }}
                        <ul class="list">
                            <li v-for="warning in this.warnings">
                                {{ warning.translated_message }}
                            </li>
                        </ul>
                    </div>
                    <button class="btn btn-primary mb-2" @click="getWarnings">
                        {{ 'weather.check_weather' | trans }}
                    </button>
                </div>
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
            warnings: [],
            status: null,
        }
    },
    methods: {
        getWarnings() {
            this.loading = true;
            this.axios.get('/api/weather-warnings')
                .then(response => {
                    this.loading = false;
                    if (response.data) {
                        this.warnings = response.data;
                        this.status = STATUS_NOT_OK;
                    } else {
                        this.status = STATUS_OK;
                    }
                });
        },
    }
}
</script>
