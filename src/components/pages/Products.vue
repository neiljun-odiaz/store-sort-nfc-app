<template>
    <div>
        <div class="columns">
            <div class="column is-one-third">
                <div class="notification" :class="[reg_result ? 'is-success' : 'is-danger']" v-show="show_notif">
                    {{ reg_message }}
                </div>
                <div class="field">
                    <label class="label">Product Name</label>
                    <p class="control">
                        <input class="input" type="text" v-model="product.name">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Price</label>
                    <p class="control">
                        <input class="input" type="text" v-model="product.price">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Points</label>
                    <p class="control">
                        <input class="input" type="text" v-model="product.points">
                    </p>
                </div>
            </div>
            <div class="column is-two-thirds">
                <div class="List">
                    <table class="table is-striped is-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Points</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
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
                product: {
                    name: '',
                    price: '',
                    points: ''
                },
                show_notif: false,
                reg_result: '',
                reg_message: '',
            }
        },

        computed: {
            
        },

        methods: {
            
        },

        created() {
            
        }
    }
</script>