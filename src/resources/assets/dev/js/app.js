var Vue = require('vue');

Vue.use(require('vue-resource'));

var dragula = require('dragula');

var Menu = require('./components/Menu.vue');

var Modal = require('./components/Modal.vue');

var Color = require('./components/Color.vue');

Vue.config.debug = true;

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
        colorScheme: [],
        temp: []
    },

    computed: {
        names: function () {
            var names = [];

            for(var index in this.saves) names.push(this.saves[index]['name']);

            return names;
        }
    },

    created: function () {
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

        drake.on('drag', function (element, source) {
            var index = [].indexOf.call(element.parentNode.children, element);

            from = index;
        });

        drake.on('drop', function (element, target, source, sibling) {
            var index = [].indexOf.call(element.parentNode.children, element);

            self.colorScheme.splice(index, 0, self.colorScheme.splice(from, 1)[0]);
        });
    },

    events: {
        clearCurrentScheme: function () {
            this.colorScheme = [];
        },

        delete: function (name) {
            this.sendDelete(name);
        },

        removeColor: function (color) {
            this.colorScheme.$remove(color);
        },

        rename: function (name, newName) {
            this.sendRename(name, newName);
        },

        save: function (schemeName) {
            this.sendSave(schemeName);
        },

        saveSchemeToTemp: function () {
            this.temp = this.colorScheme;
        },

        setScheme: function (name) {
            this.loadScheme(name);
        }
    },

    methods: {
        addColor: function (event) {
            this.colorScheme.unshift({name: 'white', hex: '#ffffff'});
        },

        getSchemeByName: function (name) {
            var scheme = this.saves.filter(function(obj) {
                return obj.name == name;
            });

            this.schemeName = name;

            return JSON.parse(scheme[0].colors);
        },

        loadScheme: function (name) {
            if (name === 'temp') {
                this.colorScheme = this.temp;

                this.temp = [];
            } else {
                this.colorScheme = this.getSchemeByName(name);
            }
        },

        sendDelete: function (name) {
            this.$http.post('/laravel-colors/delete', {name: name}).then(function(response) {
                this.saves = response.data;
            }, function(response) {
                // error
                console.log('crap...');
            });
        },

        sendRename: function (name, newName) {
            this.$http.post('/laravel-colors/update', {name: name, newName: newName}).then(function(response) {
                this.saves = response.data;
            }, function(response) {
                // error
                console.log('crap...');
            });
        },

        sendSave: function (schemeName) {
            this.$broadcast('syncColors');

            this.$http.post('/laravel-colors/save', {name: schemeName, data: JSON.stringify(this.colorScheme)}).then(function(response) {
                this.saves = response.data;
            }, function (response) {
                // error
                console.log('crap...');
            });
        },

        setSchemeToTemp: function (name) {
            this.temp = this.getSchemeByName(name);
        },

        toggleMenu: function () {
            this.$broadcast('toggleMenu');
        }
    }
});