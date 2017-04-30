<template>
    <div>
        <div class="columns is-mobile is-centered">
            <div class="column has-text-centered">
                <button class="button is-primary" @click.prevent="goTo('/customer-reg')">Customer Registration</button>
                <button class="button is-primary" @click.prevent="goTo('/card-details')">Card Details</button>
                <button class="button is-primary" @click.prevent="goTo('/card-details')">Card Tool</button>
                <button class="button is-primary" @click.prevent="goTo('/card-details')">Cashless Loading</button>
                <button class="button is-primary" @click.prevent="goTo('/card-details')">Reward Redemption</button>
                <button class="button is-primary" @click.prevent="goTo('/card-details')">POS</button>
                <button class="button is-primary" @click.prevent="goTo('/card-details')">Reports</button>
            </div>
        </div>
        <div class="columns is-mobile is-centered">
            <div class="column has-text-centered">
                <button class="button is-warning" @click.prevent="goTo('/products')">Product</button>
                <button class="button is-warning" @click.prevent="goTo('/import-card')">Import Cards</button>
                <button class="button is-warning" @click.prevent="goTo('/points-setup')">Points Setup</button>
                <button class="button is-warning" @click.prevent="goTo('/rewards-setup')">Rewards Setup</button>
                <button class="button is-warning" @click.prevent="goTo('/admin-reports')">Reports</button>
                <button class="button is-warning" @click.prevent="goTo('/user-setup')">Users</button>
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