<template>
    <ul class="chat-list">
        <li v-for="message in messages" class="fadeIn">
            <chat-message :message=message></chat-message>
        </li>
    </ul>
</template>

<script>
export default {
    props: ['messages']
}
</script>
