<template>
    <div>
        <div class="w-full py-5 pb-20" ref="messagesContainer">
            <div v-for="message in messages" :key="message.id" class="w-full mb-5 flex"
                :class="message.user.id == formattedUser.id ? '' : 'flex-row-reverse'">
                <div :class="message.from_id == formattedUser.id ? 'rounded-bl-none bg-blue-300' : 'rounded-br-none bg-green-500'"
                    class="break-words text-gray-100 px-3 py-5 w-8/12 rounded-3xl text-sm">
                    <button v-if="message.deleted_at == null && message.from_id == formattedUser.id"
                        @click="removeMessage(message)"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    {{ message.from_id == formattedUser.id ? 'You' : message.user.name }}
                    <div v-if="message.deleted_at == null">
                        {{ message.body }}
                    </div>
                    <div v-else class="text-red-500">
                        Message deleted
                    </div>
                </div>
            </div>
        </div>
        <div class="fixed bottom-0 left-0 right-0">
            <div
                class="bg-primary items-center p-5 w-full md:px-28 lg:p-5 lg:w-4/12 md:mx-auto xl:w-3/12 px-5 flex justify-between">
                <div class="w-10/12 px-3 py-1 flex items-center rounded-xl">
                    <textarea rows="2" v-model="newMessage" @keyup.enter="addMessage" type="text"
                        placeholder="Your message" class="w-full px-2 py-1 rounded-xl"></textarea>
                </div>
                <button @click="addMessage" class="active:scale-90 duration-300 text-3xl">
                    <i class="fa fa-paper-plane"></i>
                    Send
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: [],
            newMessage: "",
        }
    },
    props: ['user', 'community'],
    computed: {
        formattedUser: function () {
            return JSON.parse(this.user);
        },
        formattedCommunity: function () {
            return JSON.parse(this.community);
        },
    },
    mounted() {
        this.fetchMessages();
    },
    created: function () {
        let channel = window.Echo.channel('chat-channel.' + this.formattedCommunity.id);
        channel.listen('.message.created', (e) => {
            this.messages.push(e.message);
        });
        channel.listen('.message.deleted', (e) => {
            this.messages.find(e.message).deleted_at = e.message.deleted_at;
            this.$forceUpdate();
        });
    },
    updated() {
        this.$nextTick(() => this.scrollToEnd());
    },
    methods: {
        removeMessage(message) {
            if (!confirm('Are you sure you want to delete this message?')) {
                return;
            }
            axios.delete('/delete-message/' + message.id);
            message.deleted_at = Date.now();
            this.$forceUpdate();
        },
        scrollToEnd() {
            this.$refs
                .messagesContainer
                .scrollIntoView({ behavior: "smooth", block: "end", inline: "nearest" });
        },
        fetchMessages() {
            axios.get('/messages/' + this.formattedCommunity.slug).then(response => {
                this.messages = response.data;
            });
        },
        addMessage() {
            let message = {
                user: this.user,
                body: this.newMessage,
            };
            axios.post('/send-message/' + this.formattedCommunity.slug, message).then(response => {
                this.messages.push(response.data.message);
                this.newMessage = "";
            });
            this.newMessage = "";
        }
    }
}
</script>