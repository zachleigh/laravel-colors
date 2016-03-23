<template>
    <div v-bind:style="{ backgroundColor: rgb }" :class="[name, 'color']">
        <div class="color__handle">
        </div>
        <div class="color__overlay">
            <span class="color__delete" v-on:click="removeColor(color)">&#x2717;</span>
            <div class="color__text color__name">{{ name }}</div>
            <div v-show="!open">
                <div class="color__text color__value">{{ hex }}</div>
                <div class="color__text color__value">{{ rgb }}</div>
            </div>
            <div class="color__edit" v-show="open">
                <input class="form" v-model="name">
                <div class="color__text color__value">{{ hex }}</div>
                <input class="form form--color" v-show="open" type="color" v-model="hex">
                <div class="form--rgb">
                    <label class="form__label">r</label>
                    <label class="form__label">g</label>
                    <label class="form__label">b</label>
                </div>
                <div class="form--rgb">
                    <input class="form button button--rgb" type="number" max="255" v-model="r">
                    <input class="form button button--rgb" type="number" max="255" v-model="g">
                    <input class="form button button--rgb" type="number" max="255" v-model="b">
                </div>
            </div>
            <div class="color__text">
                <button v-bind:class="['button', name]" v-on:click="open = !open">{{ button }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['color', 'name', 'hex'],

        data: function () {
            return {
                open: false
            }
        },

        computed: {
            button: function () {
                if (this.open) {
                    return 'Done';
                } else {
                    return 'Edit';
                }
            },

            rgb: function () {
                return 'rgb(' + this.r + ', ' + this.g + ', ' + this.b + ')';
            },

            r: {
                get: function () {
                    return this.hexToRgb(this.hex, 'r');
                },
                set: function (r) {
                    this.updateHex(parseInt(r), this.g, this.b);
                }
            },

            g: {
                get: function () {
                    return this.hexToRgb(this.hex, 'g');
                },
                set: function (g) {
                    this.updateHex(this.r, parseInt(g), this.b);
                }
            },

            b: {
                get :function () {
                    return this.hexToRgb(this.hex, 'b');
                },
                set: function (b) {
                    this.updateHex(this.r, this.g, parseInt(b));
                }
            }
        },

        events: {
            syncColors: function () {
                var element = this.$el.parentNode;

                var index = [].indexOf.call(element.parentNode.children, element);

                this.color.name = this.name;

                this.color.hex = this.hex;

                this.$parent.colors.splice(index, 1, this.color);

                return true;
            }
        },

        methods: {
            hexToRgb: function (hex, value) {
                var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;

                hex = hex.replace(shorthandRegex, function(m, r, g, b) {
                    return r + r + g + g + b + b;
                });

                var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);

                var resultArray = result ? {
                    r: parseInt(result[1], 16),
                    g: parseInt(result[2], 16),
                    b: parseInt(result[3], 16)
                } : null;

                return resultArray[value];
            },
            
            removeColor: function (color) {
                this.$dispatch('removeColor', color);
            },

            updateHex: function (r, g, b) {
                if (r <= 255 && g <= 255 && b <= 255) {
                    this.hex = '#' + this.valueToHex(r) + this.valueToHex(g) + this.valueToHex(b);
                }
            },

            updateRGB: function (operator, value) {
                var r = value === 'r' ? this.updateValue(operator, value) : this.r;
                var g = value === 'g' ? this.updateValue(operator, value) : this.g;
                var b = value === 'b' ? this.updateValue(operator, value) : this.b;

                this.updateHex(r, g, b);
            },

            updateValue: function (operator, value) {
                if (operator === '+') {
                    return this[value] + 1;
                } else if (operator === '-') {
                    return this[value] - 1;
                }
            },

            valueToHex: function (value) {
                var hex = value.toString(16);

                return hex.length == 1 ? "0" + hex : hex;
            }
        }
    };
</script>