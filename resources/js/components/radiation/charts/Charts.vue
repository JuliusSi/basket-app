<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon :icon="['fas', 'chart-simple']" class="fa-icon"
                               fixed-width/>
            {{ this.$t('main.charts') }}
        </div>
        <div class="card-body">
            <radiation-bar-chart :user="user"></radiation-bar-chart>
            <golf-charlie-bar-chart :user="user"></golf-charlie-bar-chart>
        </div>
    </div>
</template>

<script>
import GolfCharlieBarChart from './GolfCharlieBarChart';
export default {
    components: {GolfCharlieBarChart},
    props: ['user'],
}
</script>

<style scoped>

</style>
