<template>
    <div>
        <div class="columns">
            <div class="column is-one-third">
                <div class="field">
                    <label class="label">Card ID</label>
                    <p class="control">
                        <input class="input" type="text" v-model="cardinfo.card_id">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Points:</label>
                    <p class="control">
                        {{ 0 }}
                    </p>
                </div>
                <div class="field">
                    <label class="label">Amount:</label>
                    <p class="control">
                        {{ 0 }}
                    </p>
                </div>
                <div class="field">
                    <label class="label">Registration Date:</label>
                    <p class="control">
                        {{ date_registration }}
                    </p>
                </div>
                <div class="field">
                    <label class="label">Expiration Date:</label>
                    <p class="control">
                        {{ date_expiration }}
                    </p>
                </div>
            </div>
            <div class="column is-one-third">
                <div class="field">
                    <label class="label">Customer First Name</label>
                    <p class="control">
                        <input class="input" type="text" v-model="card.firstname">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Customer Last Name</label>
                    <p class="control">
                        <input class="input" type="text" v-model="card.lastname">
                    </p>
                </div>
                <div class="field">
                    <label class="label">PIN</label>
                    <p class="control">
                        <input class="input" type="text" v-model="card.pin">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Re-enter PIN</label>
                    <p class="control">
                        <input class="input" type="text" v-model="card.repin">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Contact No.</label>
                    <p class="control">
                        <input class="input" type="text" v-model="card.contact">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Email Address</label>
                    <p class="control">
                        <input class="input" type="text" v-model="card.email">
                    </p>
                </div>
            </div>
            <div class="column is-one-third">
                <div class="field">
                    <label class="label">Address</label>
                    <p class="control">
                        <input class="input" type="text" v-model="card.address">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Age</label>
                    <p class="control">
                        <input class="input" type="text" v-model="card.age">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Sex</label>
                    <p class="control">
                        <span class="select">
                            <select v-model="card.sex" required>
                                <option value=""></option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </span>
                    </p>
                </div>
                <div class="field">
                    <label class="label">Birthdate</label>
                    <p class="control">
                        <input class="input" type="text" v-model="card.birthdate">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Civil Status</label>
                    <p class="control">
                        <span class="select">
                            <select v-model="card.civilstatus" required>
                                <option value=""></option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed ">Widowed</option>
                            </select>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="field">
                    <p class="control level-right">
                        <button class="button is-primary is-medium" @click.prevent="saveCard">Register Card</button>
                    </p>
                    <br>
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
                store_id: '',
                card: {
                    uid: '',
                    firstname: '',
                    lastname: '',
                    pin: '',
                    repin: '',
                    contact: '',
                    email: '',
                    address: '',
                    age: '',
                    sex: '',
                    birthdate: '',
                    civilstatus: ''
                },
            }
        },

        computed: {
            cardinfo() {
                return this.$store.state.card_info;
            },

            deviceinfo() {
                return this.$store.state.device_info;
            },

            date_registration() {
                var d = new Date();
                var year = d.getFullYear();
                var month = d.getMonth();
                var day = d.getDate();
                return day + '/' + month + '/' + year
            },

            date_expiration() {
                var aYearFromNow = new Date();
                aYearFromNow.setFullYear(aYearFromNow.getFullYear() + 1);
                var year = aYearFromNow.getFullYear();
                var month = aYearFromNow.getMonth();
                var day = aYearFromNow.getDate();
                return day + '/' + month + '/' + year
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

            saveCard() {
                let vm = this
                vm.card.uid = vm.cardinfo.card_id
                let card_info = vm.card
                console.log(card_info)

                let datenow = Date.now()
                let current_date = new Date();

                let nextyear = current_date.getFullYear() + 1
                    nextyear = nextyear.toString()
                    nextyear = nextyear.slice(-2)

                let now_minute = current_date.getMinutes()
                    now_minute = ('0' + now_minute).slice(-2)
                let now_day = current_date.getDate()
                    now_day = ('0' + now_day).slice(-2)
                let now_month = current_date.getMonth() + 1
                    now_month = ('0' + now_month).slice(-2)
                let now_year = current_date.getFullYear()
                    now_year = now_year.toString()
                    now_year = now_year.slice(-2)

                let exp_date = now_day + now_month + nextyear

                let lastdateupdate = now_minute + '' + now_day + '' + now_month + '' + now_year

                /**
                 * Write initial data to NFC card
                 * Format: {userid};{points};{amount};{timestamp};{storeid};{expiry}
                 * Format: {userid};{points};{amount};{min-day-month-year};{storeid};{day-month-year}
                 */
                let nfc_data = '1213;1000;1000;' + lastdateupdate + ';1000;' + exp_date

                vm.$http.post('api/customer', card_info).then((response) => {
                    console.log(response.data)
                    if (response.status == 200) {
                        if (response.data.result){
                            this.$nfc.writeNdefTag('text', nfc_data)
                        } else {
                            alert(response.data.message)
                        }
                    }
                }).catch(function (error) {
                    console.log(error);
                });
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