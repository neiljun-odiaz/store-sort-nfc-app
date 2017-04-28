<template>
    <div>
        <div class="columns">
            <div class="column is-one-third">
                <div class="notification" :class="[import_result ? 'is-success' : 'is-danger']" v-show="show_notif">
                    {{ import_message }}
                </div>
                <div class="field">
                    <label class="label">Store Key</label>
                    <p class="control">
                        <input class="input" type="text" v-model="store_key">
                    </p>
                </div>
                <div class="field">
                    <button class="button is-primary" @click.prevent="fetchCard">Import</button>
                    <p v-show="!show_notif">{{import_message}}</p>
                </div>
            </div>
       </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                store_key: '',
                show_notif: false,
                import_result: '',
                import_message: '',
            }
        },

        computed: {
            
        },

        methods: {
            fetchCard() {
                let vm = this
                let admin_card_api = 'http://localhost:9010/api/store/cards'
                let data = {
                    store_key: vm.store_key
                }
                vm.import_result = ''
                vm.import_message = 'Importing cards...'
                vm.$http.post(admin_card_api, data).then((response) => {
                    if (response.status == 200) {
                        let cards = response.data
                        if (cards.length > 0){
                            vm.importCards(cards)
                            console.log(cards)
                        } else {
                            vm.show_notif = true
                            vm.import_result = false
                            vm.import_message = 'No cards available for import.'
                        }
                    }
                }).catch(function (error) {
                    vm.show_notif = true
                    vm.import_result = false
                    vm.import_message = error
                });
            },

            importCards(cards) {
                let vm = this
                vm.$http.post('card/import', cards).then((response) => {
                    if (response.status == 200) {
                        console.log(response.data)
                        vm.returnImportResult(cards)
                        vm.show_notif = true
                        vm.import_result = response.data.result
                        vm.import_message = response.data.message
                    }
                }).catch(function (error) {
                    vm.show_notif = true
                    vm.import_result = false
                    vm.import_message = error
                });
            },

            returnImportResult(cards) {
                let vm = this
                let admin_card_api = 'http://localhost:9010/api/cards/import-result'
                vm.$http.post(admin_card_api, cards).then((response) => {
                    if (response.status == 200) {
                        console.log(response.data)
                    }
                }).catch(function (error) {
                    console.log(error)
                });
            }
        },

        created() {
            
        }
    }
</script>