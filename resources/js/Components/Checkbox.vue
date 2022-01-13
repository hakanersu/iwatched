<template>
    <div class="tg-list-item">
        <input class="tgl tgl-flat" :id="`checkbox-${name}`" type="checkbox" :checked="isChecked" :value="value" @change="updateInput"/>
        <label class="tgl-btn" :for="`checkbox-${name}`"></label>
    </div>
</template>

<script>
export default {
    model: {
        prop: 'modelValue',
        event: 'change'
    },
    props: {
        name: {
            type: String,
            default: 'checkbox'
        },
        value: { type: String },
        modelValue: { default: "" },
        label: { type: String, required: true},
        trueValue: { default: true },
        falseValue: { default: false }
    },
    computed: {
        isChecked() {
            if (this.modelValue instanceof Array) {
                return this.modelValue.includes(this.value)
            }
            // Note that `true-value` and `false-value` are camelCase in the JS
            return this.modelValue === this.trueValue
        }
    },
    methods: {
        updateInput(event) {
            let isChecked = event.target.checked
            if (this.modelValue instanceof Array) {
                let newValue = [...this.modelValue]
                if (isChecked) {
                    newValue.push(this.value)
                } else {
                    newValue.splice(newValue.indexOf(this.value), 1)
                }
                this.$emit('input', newValue)
            } else {
                this.$emit('input', isChecked ? this.trueValue : this.falseValue)
            }
        }
    }
}
</script>

<style scoped>
.tgl {
    display: none;
}
.tgl, .tgl:after, .tgl:before, .tgl *, .tgl *:after, .tgl *:before, .tgl + .tgl-btn {
    box-sizing: border-box;
}
.tgl::-moz-selection, .tgl:after::-moz-selection, .tgl:before::-moz-selection, .tgl *::-moz-selection, .tgl *:after::-moz-selection, .tgl *:before::-moz-selection, .tgl + .tgl-btn::-moz-selection {
    background: none;
}
.tgl::selection, .tgl:after::selection, .tgl:before::selection, .tgl *::selection, .tgl *:after::selection, .tgl *:before::selection, .tgl + .tgl-btn::selection {
    background: none;
}
.tgl + .tgl-btn {
    outline: 0;
    display: block;
    width: 4em;
    height: 2em;
    position: relative;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.tgl + .tgl-btn:after, .tgl + .tgl-btn:before {
    position: relative;
    display: block;
    content: "";
    width: 50%;
    height: 100%;
}
.tgl + .tgl-btn:after {
    left: 0;
}
.tgl + .tgl-btn:before {
    display: none;
}
.tgl:checked + .tgl-btn:after {
    left: 50%;
}
.tgl-flat + .tgl-btn {
    padding: 2px;
    transition: all 0.2s ease;
    background: #fff;
    border: 4px solid #f2f2f2;
    border-radius: 2em;
}
.tgl-flat + .tgl-btn:after {
    transition: all 0.2s ease;
    background: #f2f2f2;
    content: "";
    border-radius: 1em;
}
.tgl-flat:checked + .tgl-btn {
    border: 4px solid #7fc6a6;
}
.tgl-flat:checked + .tgl-btn:after {
    left: 50%;
    background: #7fc6a6;
}

</style>
