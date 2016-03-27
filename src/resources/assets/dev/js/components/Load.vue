<template>
    <modal :show.sync="show">
        <h3 slot="header">Load Scheme</h3>
        <div slot="body">
            <div v-if="names.length > 0">
                <h5 class="modal__body-header">Saved Schemes</h5>
                <div class="modal__saves">
                    <div class="modal__saved" v-on:click="loadScheme(name)" v-for="name in names">
                        {{ name }}
                    </div>
                </div>
            </div>
            <div v-else>
                <span>No color schemes saved.</span>
            </div>
        </div>
        <div slot="footer">
            <button class="button button--dark button--modal" v-show="names.length > 0" v-on:click="close()">Ok</button>
            <button class="button button--dark button--modal" v-on:click="close(), loadScheme('temp')">Cancel</button>
        </div>
    </modal>
</template>

<script>
    import Modal from './Modal.vue';

    export default {
        components: { Modal },

        props: ['names'],

        data: function () {
            return {
                schemeName: '',
                show: false
            };
        },

        events: {
            openLoadModal: function () {
                this.show = true;

                this.$dispatch('saveSchemeToTemp');
            },
        },

        methods: {
            close: function () {
                this.$broadcast('close');
            },

            loadScheme: function (name) {
                this.$dispatch('setScheme', name);
            }
        }
    };
</script>