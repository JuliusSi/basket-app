<template>
    <div class="card mb-3">
        <div class="card-header">
            <font-awesome-icon :icon="['fa', 'list']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            {{ this.$t('main.user_notifications.title') }}
            <span v-if="total">({{ total }})</span>
        </div>
        <div class="card-body text-left" v-if="!loading">
            <span v-if="notifications.length === 0"> {{ this.$t('main.user_notifications.no_notifications') }}</span>
            <ul class="list-unstyled" v-else>
                <li v-for="notification in notifications" class="fadeIn mb-5">
                    <div class="title pl-4 pt-3 pb-2 mt-2 mb-2 bg-title" style="margin-left: -20px; margin-right: -20px;">
                        <h2>
                            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
                            <font-awesome-icon :icon="['fas', 'bell']" class="fa-icon" style="color: #cc7a00"
                                               fixed-width></font-awesome-icon>

                            {{ notification.name }}
                        </h2>
                    </div>
                    <p class="mt-2 mb-1" style="text-align: justify">
                        <font-awesome-icon :icon="['fas', 'angle-double-right']" class="fa-icon"
                                           style="font-size: 10px; margin-right: 5px"
                                           fixed-width></font-awesome-icon>
                        {{ notification.description }}
                    </p>
                    <p>({{ formatDate(notification.created_at) }})</p>
                </li>
            </ul>
        </div>
        <div class="text-center mt-2 mb-2">
            <button v-if="1 < this.page" @click="fetchMessages(page - 1)" type="button"
                    class="btn btn-primary mb-2">

                <font-awesome-icon :icon="['fas', 'angle-double-left']" class="fa-icon"
                                   fixed-width></font-awesome-icon>
            </button>
            <button v-if="this.lastPage > this.page" @click="fetchMessages(page + 1)" type="button"
                    class="btn btn-primary mb-2">
                <font-awesome-icon :icon="['fas', 'angle-double-right']" class="fa-icon"
                                   fixed-width></font-awesome-icon>
            </button>
        </div>
    </div>
</template>

<script>

import moment from "moment/moment";

export default {
    props: ['user'],

    data() {
        return {
            notifications: [],
            loading: true,
            page: 1,
            lastPage: null,
            total: null
        }
    },
    created() {
        this.fetchMessages(1);
    },

    methods: {
        formatDate(date) {
            moment.locale("lt")
            let isToday = moment(date).isSame(moment().clone().startOf('day'), 'd');
            let isSameHour = moment(date).isSame(moment().clone().startOf('hour'), 'h');
            if (isToday && isSameHour) {
                return moment(date).startOf('minute').fromNow()
            } else if (isToday) {
                return moment(date).startOf('hour').fromNow()
            } else {
                return moment(date).format('ll LT');
            }
        },
        fetchMessages(page) {
            let params = {
                page: page,
            };
            axios.get('/api/user-notifications', {
                params: params,
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            }).then(response => {
                this.loading = false;
                this.page = page;
                this.total = response.data.total;
                if (response.data.data.length > 0) {
                    this.notifications = response.data.data;
                    this.lastPage = response.data.last_page;
                }
            });
        },
    }
}
</script>
