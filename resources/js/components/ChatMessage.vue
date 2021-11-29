<template>
    <div class="chat-message-root">
        <div class="chat-img mt-3">
            <img alt="Avatar" :src="message.user.image_path">
        </div>
        <div class="chat-body">
            <div class="chat-message">
                <span class="text-small">{{ formatDate(message.created_at)  }}</span>
                <h5>{{ message.user.username }}</h5>
                <p>
                    <img :class="{ full: fullWidthImage }" @click="fullWidthImage = !fullWidthImage"
                         v-if="isImagePath(message.message)" :src=message.message alt="image">
                    <span v-else>{{ message.message }}</span>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    props: ['message'],
    data() {
        return {
            'fullWidthImage': false
        }
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
                return moment(date).format('lll');
            }
        },
        isImagePath(message) {
            const acceptedImageExtensions = ['gif', 'jpeg', 'jpg', 'png'];

            return acceptedImageExtensions.includes(this.getExtension(message))
        },
        getExtension(url) {
            return url.split(/[#?]/)[0].split('.').pop().trim();
        },
    },
}
</script>
