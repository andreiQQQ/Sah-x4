<template>
    <div class="float-right" v-on:update-subscribers="updateSubscribers()">
        <span class="badge badge-success" v-for="subscriber in subscribers">
            {{ subscriber.name }}
        </span>
    </div>
</template>

<script>
    export default {
        data: () => ({
           subscribers: [],
        }),

        props: {
            subscribersUri: {
                type: String,
            },
            gameSession: {
                type: Number,
            }
        },

        mounted() {
            this.updateSubscribers();
            Echo.private(`sah.subscriber.${this.gameSession}`)
                .listen('SubscribeEvent', (e) => {
                    console.log('zbs');
                    this.subscribers.push(e.user);
                });
        },

        methods: {
            updateSubscribers() {
                axios.get(this.subscribersUri).then(response => {
                    this.subscribers = response.data;
                });
            }
        }
    }
</script>
