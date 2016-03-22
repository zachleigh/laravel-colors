<template>
    <ul class="menu">
        <ul class="menu__section" transition="slide-down" v-show="open">
            <li class="menu__item menu__item--empty"></li>
            <li class="menu__item" @click="showMenuItem('New')">New Scheme</li>
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
            toggleMenu: function() {
                this.open = !this.open;
            }
        },

        methods: {
            showMenuItem: function(name) {
                var method = 'open' + name + 'Module';

                this.$dispatch(method);

                this.open = false;
            },

            createNewScheme: function() {
                console.log(7);
            }
        }
    };
</script>
