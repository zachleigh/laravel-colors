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
            },
            subModal: {
                type: Boolean,
                required: false,
                twoWay: true    
            },
            subModalToggle: {
                type: Boolean,
                required: false,
                twoWay: true    
            }
        },

        events: {
            close: function () {
                this.show = false;

                var that = this;

                setTimeout(function () {
                    that.subModal = false;
                    that.subModalToggle = true;
                }, 500);
            },
        }
    };
</script>