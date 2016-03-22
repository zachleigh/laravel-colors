<template>
    <ul class="menu">
        <ul class="menu__section" transition="slide-down" v-show="open">
            <li class="menu__item menu__item--empty"></li>
            <li class="menu__item" @click="showMenuItem('Save')">Save Scheme</li>
            <li class="menu__item" @click="showMenuItem('Load')">Load Scheme</li>
        </ul>
        </ul>
    </ul>
</template>

<script>
    export default {
        data: function() {
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
            showMenuItem: function(name) {
                var prop = 'show' + name;

                this.$parent[prop] = true;

                this.open = false;
            }
        }
    };
</script>
