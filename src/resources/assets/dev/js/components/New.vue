<template>
    <modal :show.sync="show">
        <h3 slot="header">Create a New Scheme</h3>
        <div slot="body">
            <div class="modal__sub-modal-toggle" v-show="subModalToggle" transition="slide-fade-short">
                <div>Save current scheme first?</div>
                <button class="button button--dark button--modal modal__sub-modal-button" v-on:click="subModal = !subModal, subModalToggle = false">Save</button>
            </div>
            <div class="modal__sub-modal" v-show="subModal" transition="slide-fade">
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
                <button class="button button--dark button--modal modal__sub-modal-button" v-on:click="save(), subModal = false">Save</button>
            </div>
        </div>  
        <div slot="footer">
            <button class="button button--dark button--modal" v-on:click="createNewScheme(), close()">New</button>
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
                show: false,
                subModal: false,
                subModalToggle: true
            };
        },

        events: {
            openNewModal: function () {
                this.show = true;
            },
        },

        methods: {
            close: function () {
                this.$broadcast('close');
            },

            createNewScheme: function () {
                this.$dispatch('clearCurrentScheme');
            },

            save: function () {
                this.$dispatch('save', this.schemeName);
            }
        }
    };
</script>