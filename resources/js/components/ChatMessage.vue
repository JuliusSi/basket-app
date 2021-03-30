<template>
    <div class="chat-message-root">
        <div class="chat-img mt-3">
            <img alt="Avatar" :src="message.user.image_path">
        </div>
        <div class="chat-body">
            <div class="chat-message">
                <span class="text-small">{{ formatDate(message.created_at)  }}</span>
                <h5>{{ message.user.username }}</h5>
                <p>{{ message.message }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    props: ['message'],

    methods: {
        formatDate(date) {
            moment.locale("lt")
            let isToday = moment(date).isSame(moment().clone().startOf('day'), 'd');
            let isSameHour = moment(date).isSame(moment().clone().startOf('hour'), 'h');

            return isToday && isSameHour ? moment(date).startOf('minute').fromNow() : moment(date).format('lll');
        },
    },
}
</script>
