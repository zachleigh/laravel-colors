<template>
    <modal :show.sync="show">
        <h3 slot="header">Save Your Scheme</h3>
        <div slot="body">
            <span>Scheme Name: </span>
            <input class="form form--modal" placeholder="Enter scheme name" v-model="schemeName">
            <div v-show="names.length > 0">
                <h5 class="modal__body-header">Saved Schemes</h5>
                <div class="modal__saves">
                    <div class="modal__saved" v-on:click="schemeName = name" v-for="name in names">
                        {{ name }}
                    </div>
                </div>
            </div>
        </div>
        <div slot="footer">
            <button class="button button--dark button--modal" v-on:click="saveScheme(), close()">Save</button>
            <button class="button button--dark button--modal" v-on:click="close()">Cancel</button>
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
            openSaveModal: function () {
                this.show = true;
            },
        },

        methods: {
            close: function () {
                this.$broadcast('close');
            },

            saveScheme: function () {
                this.$dispatch('save', this.schemeName);
            }
        }
    };
</script>