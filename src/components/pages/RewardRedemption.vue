<template>
    <div>
        <div class="columns">
            <div class="column is-one-third">
                <nav class="panel">
                    <div class="panel-heading">Rewards</div>
                    <div class="panel-block">
                        <p class="control has-icons-left">
                            <input class="input" type="text" placeholder="Search">
                        </p>
                    </div>
                    <a class="panel-block" v-for="(reward, index) in rewards" @click="chooseReward(reward)">
                        <span class="panel-icon">
                          <i class="fa fa-cube"></i>
                        </span>
                        <span>{{reward.description}}</span>
                    </a>
                </nav>
            </div>
            <div class="column is-two-thirds">
                <div class="columns">
                    <div class="column is-two-thirds">
                        <table class="table is-striped is-bordered is-narrow">
                            <thead>
                                <tr>
                                    <th class="desc">Description</th>
                                    <th class="points">Points</th>
                                    <th class="action"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(reward, index) in chosen_rewards">
                                    <td>{{reward.description}}</td>
                                    <td>{{reward.points}}</td>
                                    <td class="action"><button class="button is-small is-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="column is-one-third">
                        <div class="field is-flex level Inputs__level">
                            <label class="label">TOTAL</label>
                            <p class="control Inputs__control">
                                <input class="input" type="number" step="any" readonly="true" v-model="totalPoints">
                            </p>
                        </div>
                        <div class="field is-flex level Inputs__level">
                            <label class="label" for="isPoints">Points</label>
                            <p class="control Inputs__control">
                                <input class="input" type="number" step="any" v-model="points" :disabled="isCashless">
                            </p>
                        </div>
                        <div class="field is-flex level Inputs__level">
                            <label class="label" for="isCashless">CashLess</label>
                            <input type="checkbox" id="isCashless" v-model="isCashless">
                            <p class="control Inputs__control">
                                <input class="input" type="number" step="any" v-model="cashLess" :disabled="!isCashless">
                            </p>
                        </div>
                        <div class="field is-flex level Inputs__level">
                            <label class="label">Change</label>
                            <p class="control Inputs__control">
                                <input class="input" type="number" step="any" readonly="true">
                            </p>
                        </div>
                        <div class="field">
                            <p class="control">
                                <button class="button is-primary is-medium">Redeem Reward</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .table .desc{
        width: 68%;
    }
    .table .points{
        width: 20%;
    }
    .table .action {
        width: 12%;
        text-align: center;
    }
    .level.Inputs__level {
        margin-bottom: 0.5em;
        justify-content: space-between;
    }
    .Inputs__level .Inputs__control {
        width: 50%;
        text-align: right;
        margin: 0 0 0 auto;
    }
    .Inputs__level .label {
        margin: 0 8px 0 0;
    }
    .button .fa {
        font-size: 1.3em;
    }
</style>
<script>
    export default{
        data(){
            return{
                rewards: [],
                chosen_rewards: [{
                    description: '-',
                    points: '-'
                }],
                totalPoints: 0,
                cashLess: '',
                points: '',
                isCashless: false,
                isPoints: false
            }
        },

        methods: {
            chooseReward(reward) {
                let vm = this
                let has_dup = false
                let tmp_chosen_rewards = []

                // Check if chosen_rewards have default items
                if ( vm.chosen_rewards[0].description == '-' ) {
                    vm.chosen_rewards = []
                }

                tmp_chosen_rewards = vm.chosen_rewards

                // Check if reward already chosen
                for (var x=0; x<vm.chosen_rewards.length; x++) {
                    let current_r = tmp_chosen_rewards[x]
                    if (current_r.id == reward.id) {
                        has_dup = true
                    }
                }

                if (!has_dup) {
                    tmp_chosen_rewards.push(reward)
                    vm.totalPoints += parseFloat(reward.points)
                }
            }
        },

        watch: {
            totalPoints() {
                this.points = this.totalPoints
            }
        },

        created() {
            let vm = this
            vm.$http.get('rewards').then((response) => {
                if (response.status) {
                    vm.rewards = response.data
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    }

</script>