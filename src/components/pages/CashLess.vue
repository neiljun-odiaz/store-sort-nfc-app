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
            <div class="column is-one-third">
                <div class="notification" :class="[save_result ? 'is-success' : 'is-danger']" v-show="show_notif">
                    {{ save_message }}
                </div>
                <div class="field">
                    <label class="label">Amount:</label>
                    <p class="control">
                        <input class="input has-text-right is-medium" type="number" v-model="amount">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Earned Points:</label>
                    <p class="control">
                        <input class="input has-text-right is-medium" type="text" v-model="pointsAcc" readonly="readonly">
                    </p>
                </div>
                <div class="field">
                    <p class="has-text-right">
                        <button class="button is-primary is-medium" @click="saveCashPoints">Save</button>
                    </p>
                </div>
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
                amount: 0,
                pointsAcc: 0,
                current_user_id: '',
                points_settings: {},
                show_notif: false,
                save_result: '',
                save_message: '',
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
            saveCashPoints() {
                // Save Transaction
                // Update card 
                let vm = this

                vm.show_notif = true
                vm.save_result = true
                vm.save_message = 'Saved!'

                vm.updateCardInfo()
            },

            updateCardInfo() {
                let vm = this

                /**
                 * Write initial data to NFC card
                 * Format: {points};{amount};{timestamp};{storeid};{expiry}
                 * Format: {points};{amount};{timestamp};{storeid};{day-month-year}
                 */

                let c_points = parseInt(vm.pointsAcc) + parseInt(vm.cardinfo.points)
                let c_amount = parseInt(vm.amount) + parseInt(vm.cardinfo.amount)
                let store_id = vm.cardinfo.store_id
                let exp_date = vm.cardinfo.expiry
                let datenow = Date.now()

                let nfc_data = c_points + ';' + c_amount + ';' + datenow + ';' + store_id + ';' + exp_date

                vm.$nfc.writeNdefTag('text', nfc_data)
            },

            detectCard() {
                this.$nfc.enumerateDevices()
                this.readCard()
            },

            readCard() {
                this.$nfc.runTagChecker()
            }
        },

        watch: {
            cardinfo() {
                let vm = this
                let data = {
                    'uid': vm.cardinfo.tag_id
                }

                if (!vm.current_user_id){
                    vm.$http.post('customer/card', data).then((response) => {
                        if (response.status == 200) {
                            let response_data = response.data
                            if (response_data.result) {
                                vm.current_user_id = response_data.customer.id
                            }
                        }
                    }).catch(function (error) {
                        console.log(error)
                    });
                }
            },

            amount() {
                let vm = this
                let points = this.points_settings.points
                let amount = this.points_settings.amount

                vm.pointsAcc = (Math.floor(vm.amount / amount) * points)
            }
        },

        created() {
            let vm = this
            vm.detectCard()
            // Get out points settings
            let data = {
                'name': 'points_amount'
            }
            vm.$http.post('settings/fetch', data).then((response) => {
                if (response.status == 200) {
                    let response_data = response.data
                    if (response_data.result) {
                        let setting = JSON.parse(response_data.setting.value);
                        vm.points_settings = setting
                    }
                }
            }).catch(function (error) {
                console.log(error)
            });
        },

        destroyed() {
            this.$nfc.destroyCheck()
        }
    }
</script>