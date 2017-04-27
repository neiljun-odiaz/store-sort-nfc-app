<template>
    <div>
        <div class="columns is-mobile">
            <div class="column is-one-half is-offset-one-quarter">
               <button class="button is-primary" @click.prevent="goTo('/customer-reg')">Customer Registration</button>
               <button class="button is-primary" @click.prevent="goTo('/products')">Product</button>
               <button class="button is-primary" @click.prevent="goTo('/import-card')">Import Cards</button>
               <button class="button is-primary" @click.prevent="goTo('/card-details')">Card Details</button>
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