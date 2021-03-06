<template>
    <div>
        <div class="columns">
            <div class="column is-one-third">
                <div class="field">
                    <label class="label">Product Name</label>
                    <p class="control">
                        <input class="input" type="text" v-model="product.name">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Price</label>
                    <p class="control">
                        <input class="input" type="number" min="0" step="any" v-model="product.price">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Inventory</label>
                    <p class="control">
                        <input class="input" type="number" min="0" v-model="product.inventory">
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <button class="button is-primary" @click.prevent="saveProduct">Save Product</button>
                    </p>
                </div>
                <div class="notification" :class="[reg_result ? 'is-success' : 'is-danger']" v-show="show_notif">
                    {{ reg_message }}
                </div>
            </div>
            <div class="column is-two-thirds">
                <div class="List">
                    <table class="table is-striped is-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Inventory</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, index) in products">
                                <td>{{ product.name }}</td>
                                <td>{{ product.price }}</td>
                                <td>{{ product.inventory }}</td>
                                <td class="List__item--action">
                                    <button class="button is-info is-small" @click.prevent="showUpdateModal(product, index)"><i class="fa fa-edit"></i></button>
                                    <button class="button is-danger is-small" @click.prevent="showDeleteModal(product, index)"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Update Modal -->
        <modal v-if="isUpdating" @closeModal="closeModal" @proceedModal="updateProduct">
            <span slot="title">Edit Product</span>
            <form slot="content">
                <div class="field">
                    <label class="label">Product Name</label>
                    <p class="control">
                        <input class="input" type="text" v-model="tmp_product.name">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Price</label>
                    <p class="control">
                        <input class="input" type="number" min="0" step="any" v-model="tmp_product.price">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Inventory</label>
                    <p class="control">
                        <input class="input" type="number" min="0" step="any" v-model="tmp_product.inventory">
                    </p>
                </div>
            </form>
            <span slot="proceed-name">Update Product</span>
        </modal>

        <!--Delete Modal-->
        <modal v-if="isDeleting" @closeModal="closeModal" @proceedModal="deleteProduct">
            <span slot="title">Delete Product</span>
            <p slot="content">Do you want to delete <strong>{{ tmp_product.name }}</strong>?</p>
            <span slot="proceed-name">Delete</span>
        </modal>


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
                product: {
                    name: '',
                    price: '',
                    inventory: ''
                },
                tmp_product: {},
                products: [],
                product_index: '',
                show_notif: false,
                reg_result: '',
                reg_message: '',
                isUpdating: false,
                isDeleting: false
            }
        },

        computed: {
            
        },

        methods: {
            saveProduct() {
                this.show_notif = false

                this.$http.post('product', this.product).then((response) => {
                    if (response.status) {
                        this.products.push(response.data.product)
                        this.product = {
                            name: '',
                            price: '',
                            inventory: ''
                        }
                    }
                    this.show_notif = true
                    this.reg_result = response.data.result
                    this.reg_message = response.data.message
                }).catch(function (error) {
                    this.show_notif = true
                    this.reg_result = false
                    this.reg_message = error
                });
            },

            updateProduct() {
                let index = this.product_index
                this.$http.post('product/update', this.tmp_product).then((response) => {
                    if (response.status) {
                        this.products[index] = response.data.product
                        this.closeModal()
                    }
                    this.show_notif = true
                    this.reg_result = response.data.result
                    this.reg_message = response.data.message
                }).catch(function (error) {
                    this.show_notif = true
                    this.reg_result = false
                    this.reg_message = error
                });
            },

            deleteProduct() {
                let index = this.product_index
                this.$http.post('product/delete', this.tmp_product).then((response) => {
                    if (response.status) {
                        this.products.splice(index, 1)
                        this.closeModal()
                    }
                    this.show_notif = true
                    this.reg_result = response.data.result
                    this.reg_message = response.data.message
                }).catch(function (error) {
                    this.show_notif = true
                    this.reg_result = false
                    this.reg_message = error
                });
            },

            showUpdateModal(product, index) {
                this.tmp_product = product
                this.product_index = index
                this.isUpdating = true
            },

            showDeleteModal(product, index) {
                this.tmp_product = product
                this.product_index = index
                this.isDeleting = true
            },

            closeModal() {
                this.isUpdating = false
                this.isDeleting = false
                this.product_index = ''
                this.tmp_product = {}
            }
        },

        created() {
            this.$http.get('product/all').then((response) => {
                if (response.status) {
                    this.products = response.data
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
</script>