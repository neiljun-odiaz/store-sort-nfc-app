<template>
    <div>
        <div class="columns is-mobile is-centered">
            <div class="column has-text-centered">
                <div class="section admin-section">
                    <div class="page-buttons" @click.prevent="goTo('/products')">
                        <p>Product</p>
                    </div>
                    <div class="page-buttons" @click.prevent="goTo('/import-card')">
                        <p>Import Cards</p>
                    </div>
                    <div class="page-buttons" @click.prevent="goTo('/points-setup')">
                        <p>Points Setup</p>
                    </div>
                    <div class="page-buttons" @click.prevent="goTo('/rewards-setup')">
                        <p>Rewards Setup</p>
                    </div>
                    <div class="page-buttons" @click.prevent="goTo('/admin-reports')">
                        <p>Reports</p>
                    </div>
                    <div class="page-buttons" @click.prevent="goTo('/user-setup')">
                        <p>Users</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
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