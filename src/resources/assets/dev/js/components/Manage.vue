<template>
    <modal :show.sync="show">
        <h3 slot="header">Manage Your Color Schemes</h3>
        <div slot="body">
            <div v-if="names.length > 0">
                <div>
                    <h5 class="modal__body-header">Saved Schemes</h5>
                    <div class="modal__saves">
                        <div class="modal__saved" v-on:click="openManager(name)" v-for="name in names">
                            {{ name }}
                        </div>
                    </div>
                </div>
                <h5 class="modal__body-header">Scheme: {{ managedScheme }}</h5>
                <div class="modal__mini-scheme">
                    <div class="modal__mini-scheme-column" v-bind:style="{ backgroundColor: color.hex }" v-for="color in temp"></div>
                </div>
                <div class="manage__action-container">
                    <div class="manage__actions" v-show="actionOpen" transition="fade">
                        <span class="manage__action" v-on:click="renameAction = true">Rename</span>
                        <span class="manage__action" v-on:click="deleteAction = true">Delete</span>
                    </div>
                    <div v-show="renameAction" transition="fade">
                        <span>Scheme Name: </span>
                        <input class="form form--modal manage__form" placeholder="Scheme name" v-model="schemeName">
                        <div class="manage__actions">
                            <span v-on:click="renameScheme(), renameAction = false">Rename</span>
                            <span v-on:click="renameAction = false">Cancel</span>
                        </div>
                    </div>
                    <div v-show="deleteAction" transition="fade">
                        <span>Do you really want to delete {{ managedScheme }}?</span>
                        <div class="manage__actions">
                            <span v-on:click="deleteScheme(), deleteAction = false">Delete</span>
                            <span v-on:click="deleteAction = false">Cancel</span>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <span>No color schemes saved.</span>
            </div>
        </div>
        <div slot="footer">
            <button class="button button--dark button--modal" v-on:click="close()">Close</button>
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
                deleteAction: false,
                managedScheme: '',
                renameAction: false,
                schemeName: '',
                show: false,
                subModal: false,
                subModalToggle: true,
                temp: []
            };
        },

        computed: {
            actionOpen: function () {
                if (!this.renameAction && !this.deleteAction) {
                    return true;
                }

                return false;
            }
        },

        events: {
            openManageModal: function () {
                this.show = true;

                this.managedScheme = this.names[0];

                this.temp = this.$root.getSchemeByName(this.names[0]);
            },
        },

        methods: {
            close: function () {
                this.$broadcast('close');
            },

            deleteScheme: function () {
                this.$dispatch('delete', this.managedScheme);

                this.managedScheme = '';

                this.temp = [];

                var that = this;

                setTimeout(function () {
                    that.managedScheme = that.names[0];

                    that.temp = that.$root.getSchemeByName(that.names[0]);
                }, 1000);

                this.managedScheme = this.names[0];
            },

            openManager: function (name) {
                this.managedScheme = name;

                this.temp = this.$root.getSchemeByName(name);

                this.toggleSubModal();
            },

            renameScheme: function () {
                this.$dispatch('rename', this.managedScheme, this.schemeName);

                this.managedScheme = this.schemeName;
            },

            toggleSubModal: function () {
                this.subModal = !this.subModal;

                this.subModalToggle = !this.subModalToggle;
            },
        }
    };
</script>