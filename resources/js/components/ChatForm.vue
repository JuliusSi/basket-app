
<template>
    <div class="input-group">
                <textarea :placeholder="this.$t('main.comments.message_placeholder')"
                          type="text"
                          style="height: 50px;"
                          @keyup.enter="sendMessage"
                          @input="sendInputEvent"
                          v-model="newMessage" name="message"
                          class="form-control"
                          id="messageTextarea"></textarea>
        <span class="input-group-btn">
            <button :disabled="isAvailableToSaveMessage" class="btn btn-primary ml-2" id="btn-chat" @click="sendMessage">
                 <font-awesome-icon :icon="['fas', 'paper-plane']" class="fa-icon"
                                    fixed-width></font-awesome-icon>
            </button>
        </span>
    </div>
</template>

<script>

export default {
    props: ['user'],
    data() {
        return {
            newMessage: '',
        }
    },
    computed: {
        isAvailableToSaveMessage() {
            return this.newMessage === null || this.newMessage.length < 2;
        },
    },
    methods: {
        sendMessage() {
            this.$emit('messagesent', {
                user: this.user,
                message: this.newMessage
            });
            this.newMessage = ''
        },
        sendTypingEvent() {
            Echo.join('chat')
                .whisper('typing', this.user);
        },
        sendInputEvent() {
            if (this.newMessage === '') {
                Echo.join('chat')
                    .whisper('not-typing', this.user);
            } else {
                Echo.join('chat')
                    .whisper('typing', this.user);
            }
        },
    }
}
</script>
