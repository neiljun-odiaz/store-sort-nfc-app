<template>
    <div>
        <div class="columns">
            <div class="column is-one-third">
                <div class="notification" :class="[save_result ? 'is-success' : 'is-danger']" v-show="show_notif">
                    {{ save_message }}
                </div>
                <div class="field">
                    <label class="label">Reward Description</label>
                    <p class="control">
                        <input class="input" type="text" v-model="reward.desc">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Points</label>
                    <p class="control">
                        <input class="input" type="number" v-model="reward.points">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Inventory</label>
                    <p class="control">
                        <input class="input" type="number" v-model="reward.inventory">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Rewarded</label>
                    <p class="control">
                        <input class="input" type="number" v-model="reward.rewarded">
                    </p>
                </div>
                <div class="field">
                    <button class="button is-primary" @click.prevent="saveReward">Save Reward</button>
                </div>
            </div>
            <div class="column is-two-thirds">
                <div class="List">
                    <table class="table is-striped">
                        <thead>
                            <tr>
                                <th>Reward Desc.</th>
                                <th>Points</th>
                                <th>Inventory</th>
                                <th>Rewarded</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(reward, index) in rewards">
                                <td>{{ reward.description }}</td>
                                <td>{{ reward.points }}</td>
                                <td>{{ reward.inventory }}</td>
                                <td>{{ reward.rewarded }}</td>
                                <td class="List__item--action">
                                    <button class="button is-info is-small" @click.prevent="showUpdateModal(reward, index)"><i class="fa fa-edit"></i></button>
                                    <button class="button is-danger is-small" @click.prevent="showDeleteModal(reward, index)"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--Update Modal-->
        <modal v-if="isUpdating" @closeModal="closeModal" @proceedModal="updateReward">
            <span slot="title">Edit Reward</span>
            <form slot="content">
                <div class="field">
                    <label class="label">Description</label>
                    <p class="control">
                        <input class="input" type="text" v-model="tmp_reward.description">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Points</label>
                    <p class="control">
                        <input class="input" type="number" min="0" v-model="tmp_reward.points">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Inventory</label>
                    <p class="control">
                        <input class="input" type="number" min="0" v-model="tmp_reward.inventory">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Rewarded</label>
                    <p class="control">
                        <input class="input" type="number" min="0" v-model="tmp_reward.rewarded">
                    </p>
                </div>
            </form>
            <span slot="proceed-name">Update Reward</span>
        </modal>

        <!--Delete Modal-->
        <modal v-if="isDeleting" @closeModal="closeModal" @proceedModal="deleteReward">
            <span slot="title">Delete Reward</span>
            <p slot="content">Do you want to delete <strong>{{ tmp_reward.description }}</strong>?</p>
            <span slot="proceed-name">Delete</span>
        </modal>

    </div>
</template>
<style>

</style>
<script>
    export default{
        data() {
            return {
                reward: {
                    desc: '',
                    points: 0,
                    inventory: 0,
                    rewarded: 0
                },
                tmp_reward: {},
                rewards: [],
                show_notif: false,
                save_result: '',
                save_message: '',
                isUpdating: false,
                isDeleting: false
            }
        },

        methods: {
            saveReward() {
                let vm = this
                this.$http.post('reward', vm.reward).then((response) => {
                    if (response.status) {
                        this.rewards = response.data
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },

            showUpdateModal(reward, index) {
                let vm = this
                vm.tmp_reward = reward
                vm.isUpdating = true
            },

            showDeleteModal(reward, index) {
                let vm = this
                vm.tmp_reward = reward
                vm.isDeleting = true
            },

            updateReward() {
                this.closeModal()
            },

            deleteReward() {
                this.closeModal()
            },

            closeModal() {
                let vm = this
                vm.isUpdating = false
                vm.isDeleting = false
            }
        },

        created() {
            this.$http.get('reward/all').then((response) => {
                if (response.status) {
                    this.rewards = response.data
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    }

</script>