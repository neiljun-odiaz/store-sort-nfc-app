<template>
    <div>
        <div class="columns">
            <div class="column">
                <div class="List">
                    <table class="table is-striped is-bordered is-narrow">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Card UID</th>
                                <th>Points</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(customer, index) in customers">
                                <td>{{ customer.firstname }}</td>
                                <td>{{ customer.lastname }}</td>
                                <td>{{ customer.card_id }}</td>
                                <td>{{ customer.points }}</td>
                                <td>{{ customer.amount }}</td>
                                <td class="List__item--action">
                                    <button class="button is-info is-small" @click.prevent="showUpdateModal(customer, index)"><i class="fa fa-edit"></i></button>
                                    <button class="button is-danger is-small" @click.prevent="showDeleteModal(customer, index)"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</template>
<style>
    .List {
        padding: 0 2em;
    }
    .List__item--action .fa{
        font-size: 16px;
    }
</style>
<script>
    export default {
        data() {
            return {
                customers: []
            }
        },

        computed: {
            
        },

        methods: {
            
        },

        created() {
            this.$http.get('customers').then((response) => {
                if (response.status) {
                    this.customers = response.data
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
</script>