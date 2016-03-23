<template>
    <ul class="menu">
        <ul class="menu__section" transition="slide-down" v-show="open">
            <li class="menu__item menu__item--empty"></li>
            <li class="menu__item" @click="showMenuItem('New')">New Scheme</li>
            <li class="menu__item" @click="showMenuItem('Save')">Save Scheme</li>
            <li class="menu__item" @click="showMenuItem('Load')">Load Scheme</li>
            <li class="menu__item" @click="showMenuItem('Manage')">Manage Schemes</li>
        </ul>
    </ul>
    <new :names="names"></new>
    <save :names="names"></save>
    <load :names="names"></load>
    <manage :names="names"></manage>
</template>

<script>
    import New from './New.vue';
    import Save from './Save.vue';
    import Load from './Load.vue';
    import Manage from './Manage.vue';

    export default {
        components: { New, Save, Load, Manage },

        props: ['names'],

        data: function () {
            return {
                open: false
            }
        },

        events: {
            toggleMenu: function () {
                this.open = !this.open;
            }
        },

        methods: {
            showMenuItem: function (name) {
                var method = 'open' + name + 'Modal';

                this.$broadcast(method);

                this.open = false;
            }
        }
    };
</script>
