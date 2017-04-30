<template>
    <div>
        <div class="modal is-active">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="box">
                    <h1 class="title is-4"><slot name="title"></slot></h1>
                    <slot name="content"></slot>
                    <div class="field modal__footer">
                        <p class="control">
                            <button class="button is-danger" @click.prevent="$emit('proceedModal')">
                                <slot name="proceed-name"></slot>
                            </button>
                            <button class="button" @click.prevent="$emit('closeModal')">Close</button>
                        </p>
                    </div>
                </div>
            </div>
            <button class="modal-close" @click="$emit('closeModal')"></button>
        </div>
    </div>
</template>
<style>
    .modal__footer {
        margin-top: 20px;
    }
</style>
<script>
    export default{
    }
</script>