<template>
    <div class="chat-message-root">
        <div class="chat-img">
            <img alt="Avatar" src="img/user.svg">
        </div>
        <div class="chat-body">
            <div class="chat-message">
                <h5>{{ message.user.username }} <span class="text-small">({{ getDate(message.created_at) }})</span></h5>
                <p>{{ message.message }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['message'],

    methods: {
        getDate(date) {
            let todayDate = new Date().toLocaleString('lt-LT', { timeZone: 'Europe/Vilnius' }).slice(0, 10);
            let convertedDate = new Date(date).toLocaleString('lt-LT', { timeZone: 'Europe/Vilnius' });
            let isToday = convertedDate.slice(0, 10) === todayDate;

            return isToday ? convertedDate.slice(11, 16) : convertedDate.slice(0, 10);
        },
    },
}
</script>
