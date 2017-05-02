<template>
    <div>
        <div class="columns">
            <div class="column">

            </div>
        </div>
        <div class="columns">
            <div class="column is-one-third">
                <nav class="panel">
                    <div class="panel-heading">Products</div>
                    <div class="panel-block">
                        <p class="control has-icons-left">
                            <input class="input is-medium" type="text" placeholder="Search">
                        </p>
                    </div>
                    <a class="panel-block" v-for="(product, index) in products" @click="choseProduct(product)">
                        <span class="panel-icon">
                          <i class="fa fa-cube"></i>
                        </span>
                        <span>{{product.name}}</span>
                    </a>
                </nav>
            </div>
            <div class="column is-two-thirds">
                <div class="notification" :class="[save_result ? 'is-success' : 'is-danger']" v-show="show_notif">
                    {{ save_message }}
                </div>
                <table class="table is-striped is-bordered is-narrow">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in chosen_products">
                            <td>{{product.name}}</td>
                            <td>{{product.price}}</td>
                            <td>{{product.qty}}</td>
                            <td>Remove</td>
                        </tr>
                    </tbody>
                </table>
                <div class="columns level-right Inputs">
                    <div class="column is-one-third">
                        <div class="field is-flex level Inputs__level">
                            <label class="label">TOTAL</label>
                            <p class="control Inputs__control">
                                <input class="input" type="text" v-model="totalamount">
                            </p>
                        </div>
                        <div class="field is-flex level Inputs__level">
                            <label class="label">Points</label>
                            <p class="control Inputs__control">
                                <input class="input" type="text" v-model="pointsAcc">
                            </p>
                        </div>
                        <div class="field is-flex level Inputs__level">
                            <label class="label">CASH</label>
                            <p class="control Inputs__control">
                                <input class="input" type="text" v-model="cash">
                            </p>
                        </div>
                        <div class="field is-flex level">
                            <label class="label">Change</label>
                            <p class="control Inputs__control">
                                <input class="input" type="text" v-model="change">
                            </p>
                        </div>
                        <div class="field is-flex level-right">
                            <button class="button is-primary is-medium" @click.prevent="savePurchase">Save Purchase</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .Inputs .Inputs__level {
        margin: 0;
    }
    .Inputs .Inputs__control {
        width: 65%;
    }
</style>
<script>
    export default {
        data() {
            return {
                cash: '',
                products: [],
                chosen_products: [{
                    name: '-',
                    price: 0,
                    qty: 0,
                }],
                points_settings: {},
                show_notif: false,
                save_result: '',
                save_message: '',
                current_user_id: 0
            }
        },

        computed: {
            cardinfo() {
                return this.$store.state.card_info;
            },

            totalamount() {
                let total = 0
                if (this.chosen_products.length > 0){
                    for (var x=0; x<this.chosen_products.length; x++) {
                        var current_p = this.chosen_products[x]
                        var current_qty = parseInt(current_p.qty)
                        var price = parseFloat(current_p.price)
                        total += (current_qty * price)
                    }
                }
                return parseFloat(total).toFixed(2)
            },

            change() {
                let change = 0
                if (this.cash) {
                    change = parseFloat(this.cash - this.totalamount).toFixed(2)
                }
                return change
            },

            pointsAcc() {
                let points = this.points_settings.points
                let amount = this.points_settings.amount

                return (Math.floor(this.totalamount / amount) * points)
            }
        },

        methods: {
            detectCard() {
                this.$nfc.enumerateDevices()
                this.readCard()
            },

            readCard() {
                this.$nfc.runTagChecker()
            },

            choseProduct(product) {
                let vm = this
                let has_dup = false
                let tmp_chosen_products = []

                // Check if chosen_products have default items
                if ( vm.chosen_products[0].name == '-' ) {
                    vm.chosen_products = []
                }

                tmp_chosen_products = vm.chosen_products

                // Check if prodcut already on the list, then add qty
                for (var x=0; x<vm.chosen_products.length; x++) {
                    var current_p = tmp_chosen_products[x]
                    var current_qty = current_p.qty
                    if (current_p.name == product.name) {
                        current_qty++
                        current_p.qty = current_qty
                        tmp_chosen_products[x] = current_p
                        has_dup = true
                    }
                }

                vm.chosen_products = tmp_chosen_products

                if (!has_dup){
                    product.qty = 1
                    vm.chosen_products.push(product)
                } else {
                    return vm.chosen_products
                }
            },

            savePurchase() {
                let vm = this

                let data = {
                    'products': vm.chosen_products,
                    'amount': vm.totalamount,
                    'cash': vm.cash,
                    'points': vm.pointsAcc,
                    'customer': vm.current_user_id
                }

                vm.show_notif = false;
                vm.save_result = '';
                vm.save_message = '';

                vm.$http.post('purchase', data).then((response) => {
                    if (response.status == 200) {
                        let response_data = response.data
                        if (response_data.result) {
                            vm.show_notif = true
                            vm.save_result = response_data.result
                            vm.save_message = response_data.message
                            vm.updateCardInfo()
                        }
                    }
                }).catch(function (error) {
                    console.log(error)
                    vm.show_notif = true;
                    vm.save_result = false;
                    vm.save_message = error;
                });
            },

            updateCardInfo() {
                let vm = this

                /**
                 * Write initial data to NFC card
                 * Format: {points};{amount};{timestamp};{storeid};{expiry}
                 * Format: {points};{amount};{timestamp};{storeid};{day-month-year}
                 */

                let c_points = vm.pointsAcc + vm.cardinfo.points
                let c_amount = vm.cardinfo.points
                let store_id = vm.cardinfo.store_id
                let exp_date = vm.cardinfo.expiry
                let datenow = Date.now()

                let nfc_data = c_points + ';' + c_amount + ';' + datenow + ';' + store_id + ';' + exp_date

                vm.$nfc.writeNdefTag('text', nfc_data)
            }

        },

        watch: {
            cardinfo: function() {
                let vm = this
                let data = {
                    'uid': vm.cardinfo.tag_id
                }
                vm.$http.post('customer/card', data).then((response) => {
                    if (response.status == 200) {
                        let response_data = response.data
                        if (response_data.result) {
                            console.log(response_data)
                            vm.current_user_id = response_data.customer.id
                        }
                    }
                }).catch(function (error) {
                    console.log(error)
                });
            }
        },

        created() {
            let vm = this
            vm.$http.get('product/all').then((response) => {
                if (response.status) {
                    let r_products = response.data
                    for (var x=0; x<r_products.length; x++) {
                        r_products[x].qty = 1
                    }
                    vm.products = r_products
                }
            }).catch(function (error) {
                console.log(error);
            });

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

            this.detectCard()
        },

        destroyed() {
            this.$nfc.destroyCheck()
        }
    }


</script>