<template>
    <ul class="chat">
        <li class="left clearfix" v-for="message in messages" :key="message.id">
            <div class="clearfix">
                <div class="header">
                    <strong>
                        {{ message.user.name }}
                    </strong>
                </div>
                <p>
                    {{ message.body }}
                </p>
            </div>
        </li>
    </ul>
</template>
<script>
export default {
    props: ["messages"],
};
</script>