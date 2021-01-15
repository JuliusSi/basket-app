<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            <font-awesome-icon :icon="['fas', 'radiation']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            {{ 'main.radiation.title' | trans }}
        </div>
        <div class="card-body" v-if="!loading">
            <p> {{ 'main.radiation.radiation_background' | trans }}: {{ radiationBackground }} μSv/h</p>
            <p> {{ 'main.updated' | trans }}: {{ updated }}</p>
            <p> {{ 'main.radiation.status' | trans }}: {{ 'main.radiation.status_' + radiationStatus | trans }}</p>
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
    mounted() {
        this.getRadiationInfo();
    },
    methods: {
        getRadiationInfo() {
            this.loading = true;
            this.axios.get('/api/radiation-info')
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
