<template>
    <div class="modal" v-show="show" transition="modal">
        <div class="modal__wrapper">
            <div class="modal__container">

                <div class="modal__header">
                    <slot name="header">
                    </slot>
                </div>
        
                <div class="modal__body">
                    <slot name="body">
                    </slot>
                </div>

                <div class="modal__footer">
                    <slot name="footer">
                    </slot>
                    <button class="button button--dark button--modal" @click="show = false, restoreScheme()">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            show: {
                type: Boolean,
                required: true,
                twoWay: true    
            }
        },
        methods: {
            restoreScheme: function () {
                this.$dispatch('restoreScheme');
            }
        }
    };
</script>