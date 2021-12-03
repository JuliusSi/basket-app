<template>
    <div class="card card-default">
        <div class="card-header">
            <font-awesome-icon :icon="['fas', 'comments']" class="fa-icon"
                               fixed-width v-if="!loading"/>
            <font-awesome-icon icon="spinner" spin class="fa-icon" v-if="loading"/>
            {{ 'main.comments.header' | trans }}
        </div>
        <div class="card-body" v-if="!loading">
            <ul class="list-group mb-4" v-if="showOnlineUsers">
                <li class="list-group-item active">
                    <font-awesome-icon :icon="['fa', 'users']" style="color: green;" class="fa-icon"
                                       fixed-width/>
                    {{ 'main.comments.online_users' | trans }} ({{ this.users.length }})</li>
                <li v-if="users.length < 6" class="list-group-item" v-for="user in users">
                    <font-awesome-icon :icon="['fa', 'user']" class="fa-icon"
                                       fixed-width/>  {{ user.username }} <span v-if="user.typing">{{ 'main.comments.typing' | trans }}</span>
                </li>
            </ul>
            <chat-messages :messages="messages"></chat-messages>
            <ul class="list-unstyled">
                <li v-for="typingUser in getTypingUsers">
                    {{ typingUser.username }} {{ 'main.comments.typing' | trans }}
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
import lang from "../lang";

let newMessageTrack = new Audio('sound/received.mp3');
let joinedTrack = new Audio('sound/joined.wav');

let tracks = [newMessageTrack];
let MESSAGE_COUNT = 12;

export default {
    props: ['user'],

    data() {
        return {
            messages: [],
            users: [],
            errors: [],
            loading: true,
            page: 1,
            lastPage: null,
        }
    },
    computed: {
        getTypingUsers() {
            return this.users.filter(function (currentUser) {
                return currentUser.typing;
            });
        },
        showOnlineUsers() {
            return this.users.length > 1;
        },
    },
    created() {
        this.fetchMessages(1);

        Echo.private('chat')
            .listen('ChatMessageSent', (e) => {
                newMessageTrack.play();
                this.messages.push({
                    message: e.message.message,
                    user: e.user
                });
                if (this.messages.length > 1) {
                    this.messages.shift();
                }
                if (this.messages.length > MESSAGE_COUNT) {
                    this.fetchMessages();
                }
                this.users.forEach((user, index) => {
                    if (user.id === e.user.id) {
                        user.typing = false;
                        this.$set(this.users, index, user);
                    }
                });
            });

        Echo.join('chat')
            .here(users => {
                this.users = users;
            })
            .joining(user => {
                this.users.push(user);
                const content = lang.get('main.comments.joined')  + ': ' + user.username + '';
                const bot = { username: 'Bot',  image_path:"img/bot.png"};
                const message = { message: content, user: bot };
                this.messages.push(message);
                joinedTrack.play();
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
    },

    methods: {
        fetchMessages(page) {
            let params = {
                page: page,
                name: this.name,
                city: this.city,
            };
            axios.get('api/comments', {
                params: params,
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            }).then(response => {
                this.loading = false;
                this.page = page;
                if (response.data.data.length) {
                    this.messages = response.data.data.sort((a, b) => a.id - b.id);
                    this.lastPage = response.data.last_page;
                }
            });
        },
        addMessage(message) {
            axios.post('api/comment', message, {
                headers: {
                    Authorization: `Bearer ${this.user.api_token}`,
                    Accept: 'application/json',
                },
            }).then(response => {
                this.errors = [];
                this.messages.push(message);
                if (this.messages.length > 1) {
                    this.messages.shift();
                }
                if (this.messages.length > MESSAGE_COUNT) {
                    this.fetchMessages();
                }
            }).catch(error => {
                this.errors = error.response.data.errors.message;
            });
        },
    }
}
</script>
