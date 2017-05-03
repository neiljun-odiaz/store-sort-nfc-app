<template>
    <div>
        <div class="columns">
            <div class="column is-one-third">
                <div class="field">
                    <label class="label">Card ID</label>
                    <p class="control">
                        {{ cardinfo.tag_id }}
                    </p>
                </div>
                <div class="field">
                    <label class="label">Points</label>
                    <p class="control">
                        {{ cardinfo.points }}
                    </p>
                </div>
                <div class="field">
                    <label class="label">Amount</label>
                    <p class="control">
                        {{ cardinfo.amount }}
                    </p>
                </div>
                <div class="field">
                    <label class="label">Store ID</label>
                    <p class="control">
                        {{ cardinfo.store_id }}
                    </p>
                </div>
                <div class="field">
                    <label class="label">Last Updated</label>
                    <p class="control">
                        {{ cardinfo.last_updated }}
                    </p>
                </div>
                <div class="field">
                    <label class="label">Expiration</label>
                    <p class="control">
                        {{ cardinfo.expiry }}
                    </p>
                </div>
            </div>
            <div class="column is-two-thirds">
                pasdasd
            </div>
        </div>
    </div>
</template>
<style>
    
</style>
<script>
    export default {
        data() {
            return {
                
            }
        },

        computed: {
            cardinfo() {
                return this.$store.state.card_info;
            },

            deviceinfo() {
                return this.$store.state.device_info;
            }
        },

        methods: {
            detectCard() {
                this.$nfc.enumerateDevices()
                this.readCard()
            },

            readCard() {
                this.$nfc.runTagChecker()
            }
        },

        created() {
            this.detectCard()
        },

        destroyed() {
            this.$nfc.destroyCheck()
        }
    }
</script>