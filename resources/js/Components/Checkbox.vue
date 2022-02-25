<template>
    <div class="tg-list-item" @click="toggle">
        <input class="tgl tgl-flat" :id="`checkbox-${name}`"  :name="`checkbox-${name}`" type="checkbox" :value="value" v-model="proxyChecked"/>
        <label class="tgl-btn" :for="`checkbox-${name}`"></label>
    </div>
</template>

<script>
export default {
    model: {
        prop: "checked",
        event: "change"
    },
    props: {
        checked: {
            type: [Array, Boolean],
            default: false
        },
        value: {
            default: null
        },
        name: {
            type: String,
            default: 'checkbox'
        }
    },
    computed: {
        proxyChecked: {
            get() {
                return this.checked;
            },
            set(val) {
                this.$emit("change", val);
            }
        }
    },
    methods: {
        toggle () {
            this.proxyChecked = !this.checked
        }
    }
}
</script>


