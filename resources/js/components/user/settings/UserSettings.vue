<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            <font-awesome-icon :icon="['fas', 'user-cog']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            {{ this.$t('main.user_settings.title') }}
        </div>
        <div class="card-body">
            <user-main-settings :user="user"></user-main-settings>
            <weather-notification-settings v-if="user.phone" :user="user"></weather-notification-settings>
        </div>
    </div>
</template>

<script>
export default {
    props: ['user'],
    data() {
        return {
            loading: false,
            settings: [],
        }
    },
    mounted() {
    },
    methods: {
    }
}
</script>
