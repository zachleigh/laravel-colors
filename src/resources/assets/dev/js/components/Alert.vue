<template>
    <div class="alert alert--{{ type }}" v-show="show" transition="slide">
        <span class="alert__close" v-on:click="close()">&#x2717;</span>
        <span>{{ message }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            type: { default: 'info' },
            important: {
                type: Boolean,
                default: false
            }
        },

        data: function () {
            return {
                show: false,
                message: ''
            }
        },

        events: {
            showAlert: function (message, type, important) {
                this.message = message;

                if (type) {
                    this.type = type;
                }

                if (typeof important != 'undefined') {
                    this.important = important;
                }

                this.show = true;

                var that = this;

                if (!this.important) {
                    setTimeout(function () {
                        that.show = false;
                    }, 3000);

                    setTimeout(function () {
                        that.resetDefaults();
                    }, 4000);
                }
            }
        },

        methods: {
            resetDefaults: function () {
                this.important = false;

                this.type = 'info';
            },

            close: function () {
                this.show = false;

                var that = this;

                setTimeout(function () {
                    that.resetDefaults();
                }, 1000);
            }
        }
    };
</script>