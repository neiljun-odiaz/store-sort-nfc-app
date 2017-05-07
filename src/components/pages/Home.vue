<template>
    <div>
        <div class="columns is-mobile is-centered">
            <div class="column has-text-centered">
                <div class="section">
                    <div class="page-buttons" @click.prevent="goTo('/customer-reg')">
                        <p>Customer Registration</p>
                    </div>
                    <div class="page-buttons" @click.prevent="goTo('/card-details')">
                        <p>Card Tool</p>
                    </div>
                    <div class="page-buttons" @click.prevent="goTo('/cashless-loading')">
                        <p>Cashless Loading</p>
                    </div>
                    <div class="page-buttons" @click.prevent="goTo('/rewards-redeem')">
                        <p>Reward Redemption</p>
                    </div>
                    <div class="page-buttons" @click.prevent="goTo('/pos')">
                        <p>POS</p>
                    </div>
                    <div class="page-buttons" @click.prevent="goTo('/customer-list')">
                        <p>Customer List</p>
                    </div>
                    <div class="page-buttons" @click.prevent="goTo('/card-details')">
                        <p>Reports</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    ul {
        margin: 0;
        padding: 0;
    }
    ul li {
        display: block;
        margin: 0;
        padding: 0;
    }
    p {
        margin: 0 0 10px;
        padding: 0;
    }

</style>
<script>
    export default {
        data() {
            return {
                
            }
        },

        computed: {
            
        },

        methods: {
            goTo(route) {
                this.$router.push(route)
            }
        },

        created() {
            
        }
    }

</script>