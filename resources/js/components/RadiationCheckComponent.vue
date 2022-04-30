<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            <font-awesome-icon :icon="['fas', 'radiation']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            {{ this.$t('main.radiation.title') }}
        </div>
        <div class="card-body" v-if="!loading">
            <ul class="list-unstyled">
                <li v-for="info in this.radiationInfo" class="mb-3 pt-3">
                    <p> {{ this.$t('main.radiation.meter_name') }}: {{ info.meterName }}</p>
                    <p> {{ this.$t('main.radiation.radiation_background') }}: {{ info.radiationBackground }} μSv/h</p>
                    <p> {{ this.$t('main.radiation.measured_at') }}: {{ info.updatedAt }}</p>
                    <p> {{ this.$t('main.radiation.status') }}: {{ this.$t('main.radiation.statuses.' + info.status) }}</p>
                </li>
            </ul>

            <p class="pt-3 font-weight-bold">{{ this.$t('main.radiation.notes') }}</p>
        </div>
    </div>
    <max-radiation-check :user="user"></max-radiation-check>
</template>
<script>
export default {
    data() {
        return {
            loading: false,
            radiationInfo: [],
        }
    },
    props: ['user'],
    mounted() {
        this.getRadiationInfo();
    },
    methods: {
        getRadiationInfo() {
            this.loading = true;
            this.axios.get('/api/radiation-info', {
                headers : {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            })
                .then(response => {
                    this.loading = false;
                    if (response.data !== null) {
                        this.radiationInfo = response.data;
                    }
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        },
    }
}
</script>
