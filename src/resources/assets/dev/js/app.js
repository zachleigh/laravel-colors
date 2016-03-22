var Vue = require('vue');

Vue.use(require('vue-resource'));

var dragula = require('dragula');

var Menu = require('./components/Menu.vue');

var Modal = require('./components/Modal.vue');

var Color = require('./components/Color.vue');

var vm = new Vue({
    el: '#app',

    components: { Menu, Modal, Color },

    props: ['colors', 'saves'],

    props: {
        colors: {
            type: Array
        },
        saves: {
            type: Array
        }
      },

    data: {
        showSave: false,
        showLoad: false,
        schemeName: '',
        colorScheme: []
    },

    computed: {
        names: function () {
            var names = [];

            for(var index in this.saves) names.push(this.saves[index]['name']);

            return names;
        }
    },

    created: function() {
        this.colorScheme = this.colors.concat([]);
    },

    ready: function() {
        var self = this;

        var from = null;

        var drake = dragula([document.querySelector('#draggable')], {
            moves: function (el, container, handle) {
                return handle.className === 'color__handle';
            }
        });

        drake.on('drag', function(element, source) {
            var index = [].indexOf.call(element.parentNode.children, element);

            from = index;
        });

        drake.on('drop', function(element, target, source, sibling) {
            var index = [].indexOf.call(element.parentNode.children, element);

            self.colorScheme.splice(index, 0, self.colorScheme.splice(from, 1)[0]);
        });
    },

    events: {
        test: function (color) {
            this.colorScheme.$remove(color);
        }
    },

    methods: {
        toggleMenu: function () {
            this.$broadcast('toggleMenu');
        },

        addColor: function (event) {
            this.colorScheme.unshift({index: 0, name: 'white', hex: '#ffffff'});
        },

        sendSave: function () {
            this.$broadcast('syncColors');

            this.$http.post('/laravel-colors/save', {name: this.schemeName, data: JSON.stringify(this.colorScheme)}).then(function (response) {
                this.saves = response.data;

                console.log(this.saves);
            }, function (response) {
                // error
                console.log('crap...');
            });

            this.showSave = false;
        },

        loadScheme: function (name) {
            var scheme = this.saves.filter(function(obj) {
                return obj.name == name;
            });

            this.schemeName = name;

            this.colorScheme = JSON.parse(scheme[0].colors);
        }
    }
});