<template>
    <modal :show.sync="show" :sub-modal.sync="subModal" :sub-modal-toggle.sync="subModalToggle">
        <h3 slot="header">Create a New Scheme</h3>
        <div slot="body">
            <div class="modal__sub-modal-toggle" v-show="subModalToggle" transition="slide-fade-short">
                <div class="modal__text">Save current scheme first?</div>
                <span class="hover__underline--green modal__action" v-on:click="subModal = !subModal, subModalToggle = false">Save</span>
            </div>
            <div class="modal__sub-modal" v-show="subModal" transition="slide-fade">
                <span>Scheme Name: </span>
                <input class="form form--modal" placeholder="Enter scheme name" v-model="schemeName">
                <div v-show="names.length > 0">
                    <h5 class="modal__body-header">Saved Schemes</h5>
                    <div class="modal__saves modal__text">
                        <div class="modal__saved" v-on:click="schemeName = name" v-for="name in names">
                            {{ name }}
                        </div>
                    </div>
                </div>
                <div class="hover__underline--green modal__action" v-on:click="save(), subModal = false">Save</div>
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