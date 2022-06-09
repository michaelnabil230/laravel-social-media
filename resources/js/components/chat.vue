<template>
    <div>

    </div>
</template>

<script>
export default {
    name: 'Chat',
    data() {
        return {
            message: '',
            messages: [],
            typing: false,
            timeout: null,
        }
    },
    methods: {
        sendMessage() {
            this.typing = false;
            this.messages.push({
                text: this.message,
                user: this.user,
            });
            axios.post('/api/chat', {
                message: this.message,
            }).then(response => {
                console.log(response);
                this.message = '';
            });
        },
        typingEvent() {
            if (this.timeout) {
                clearTimeout(this.timeout);
            }
            this.typing = true;
            this.timeout = setTimeout(() => {
                this.typing = false;
            }, 1000);
        },
    },
    created() {
    },
}
</script>