<template>
    <div>
        <div class="columns">
            <div class="column is-one-third">
                <div class="notification" :class="[save_result ? 'is-success' : 'is-danger']" v-show="show_notif">
                    {{ save_message }}
                </div>
                <div class="field">
                    <label class="label">Amount</label>
                    <p class="control">
                        <input class="input" type="text" v-model="amount">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Equivalent Points</label>
                    <p class="control">
                        <input class="input" type="text" v-model="points">
                    </p>
                </div>
                <div class="field">
                    <button class="button is-primary" @click.prevent="saveSettings">Save Settings</button>
                </div>
            </div>
       </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                amount: '',
                points: '',
                show_notif: false,
                save_result: '',
                save_message: '',
            }
        },

        computed: {
            
        },

        methods: {
            saveSettings() {
                let vm = this
                let data = [{
                    'name': 'points_amount',
                    'value': {
                        'amount': vm.amount,
                        'points': vm.points
                    }
                }]
                vm.import_result = ''
                vm.import_message = ''
                vm.show_notif = false
                vm.$http.post('settings', data).then((response) => {
                    if (response.status == 200) {
                        let response_data = response.data
                        console.log(response_data)
                        vm.show_notif = true
                        vm.import_result = response_data.result
                        vm.import_message = response_data.message
                    }
                }).catch(function (error) {
                    vm.show_notif = true
                    vm.import_result = false
                    vm.import_message = error
                });
            }
            
        },

        created() {
            let vm = this
            let data = {
                'name': 'points_amount'
            }
            vm.$http.post('settings/fetch', data).then((response) => {
                if (response.status == 200) {
                    let response_data = response.data
                    let setting = JSON.parse(response_data.setting.value);
                    vm.amount = setting.amount
                    vm.points = setting.points
                }
            }).catch(function (error) {
                vm.show_notif = true
                vm.import_result = false
                vm.import_message = error
            });
        }
    }
</script>