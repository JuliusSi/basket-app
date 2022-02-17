<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            <font-awesome-icon :icon="['fas', 'radiation']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            {{ this.$t('main.radiation.title') }}
        </div>
        <div class="card-body" v-if="!loading">
            <p> {{ this.$t('main.radiation.radiation_background') }}: {{ radiationBackground }} μSv/h</p>
            <p> {{ this.$t('main.updated') }}: {{ updated }}</p>
            <p> {{ this.$t('main.radiation.status') }}: {{ this.$t('main.radiation.status_' + radiationStatus) }}</p>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            loading: false,
            updated: null,
            radiationBackground: null,
            radiationStatus: null,
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
                        this.radiationBackground = response.data.radiationBackground;
                        this.updated = response.data.updatedAt;
                        this.radiationStatus = response.data.status;
                    }
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        },
    }
}
</script>
