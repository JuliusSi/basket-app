<template>
    <div class="card card-default">
        <div class="card-header">
            <font-awesome-icon :icon="['fas', 'comments']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            {{ 'main.comments.header' | trans }}
        </div>
        <div class="card-body" v-if="!loading">
            <ul class="list-group mb-3" v-if="showOnlineUsers">
                <li class="list-group-item active">{{ 'main.comments.online_users' | trans }}</li>
                <li class="list-group-item" v-for="user in users">
                    {{ user.username }} <span v-if="user.typing">{{ 'main.comments.typing' | trans }}</span>
                    </li>
            </ul>
            <chat-messages :messages="messages"></chat-messages>
            <ul class="list-unstyled">
                <li v-for="typingUser in getTypingUsers">
                    {{ typingUser.username }}   {{ 'main.comments.typing' | trans }}
                </li>
            </ul>
        </div>
        <div class="card-footer">
            <div class="alert alert-danger fadeIn" role="alert" v-if="errors.length">
                <ul class="list">
                    <li v-for="error in this.errors">
                        {{ error }}
                    </li>
                </ul>
            </div>
            <chat-form
                @messagesent="addMessage"
                :user=user
            ></chat-form>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ['user'],

    data() {
        return {
            messages: [],
            users: [],
            errors: [],
            loading: true,
        }
    },
    computed: {
        getTypingUsers() {
            return this.users.filter(function (currentUser) {
                return currentUser.typing;
            });
        },
        showOnlineUsers() {
            return this.users.length > 1 && this.users.length < 6;
        },
    },
    created() {
        this.fetchMessages();

        Echo.join('chat')
            .here(users => {
                this.users = users;
            })
            .joining(user => {
                this.users.push(user);
            })
            .leaving(user => {
                this.users = this.users.filter(u => u.id !== user.id);
            })
            .listenForWhisper('typing', ({id, name}) => {
                this.users.forEach((user, index) => {
                    if (user.id === id) {
                        user.typing = true;
                        this.$set(this.users, index, user);
                    }
                });
            })
            .listenForWhisper('not-typing', ({id, name}) => {
                this.users.forEach((user, index) => {
                    if (user.id === id) {
                        user.typing = false;
                        this.$set(this.users, index, user);
                    }
                });
            })
            .listenForWhisper('message-sent', (message) => {
                this.fetchMessages();
                this.users.forEach((user, index) => {
                    if (user.id === message.user.id) {
                        user.typing = false;
                        this.$set(this.users, index, user);
                    }
                });
            });
    },

    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.loading = false;
                this.messages = response.data;
            });
        },

        addMessage(message) {
            axios.post('/message', message).then(response => {
                if (response.data.length) {
                    this.errors = response.data;
                } else {
                    this.fetchMessages();
                    Echo.join('chat').whisper('message-sent', message);
                }
            });
        },
    }
}
</script>
