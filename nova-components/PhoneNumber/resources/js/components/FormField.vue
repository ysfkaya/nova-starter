<template>
    <default-field :field="field">
        <template slot="field">
            <input
                ref="input"
                type="tel"
                class="w-full form-control form-input form-input-bordered"
                :class="errorClasses"
                v-model="displayValue"
            />

            <help-text class="error-text mt-2 text-danger" v-if="hasError">
                {{ firstError }}
            </help-text>
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ["resourceName", "resourceId", "field"],

    data() {
        return {
            input: null,
            displayValue: null,
            validValue: null,
            validatedValueLoading: false
        };
    },

    watch: {
        displayValue(val) {
            if (this.validatedValueLoading) {
                return;
            }

            this.setValue();
        },
        validValue(val) {
            this.validatedValueLoading = true;

            this.displayValue = val;

            setTimeout(
                function() {
                    this.validatedValueLoading = false;
                }.bind(this),
                300
            );
        }
    },

    methods: {
        setInitialValue() {
            this.value = this.field.value || "";
        },

        fill(formData) {
            formData.append(this.field.attribute, this.value || "");
        },

        handleChange(value) {
            this.value = value;
        },
        setValue(initial = false) {
            let value = this.input.getNumber(
                intlTelInputUtils.numberFormat.INTERNATIONAL
            );

            if (initial && this.value) {
                this.input.setNumber(this.value);
            } else if (value) {
                this.value = value;

                this.input.setNumber(value);
            } else {
                this.value = null;
            }

            this.setValidValue();
        },
        setValidValue() {
            if (this.input.isValidNumber()) {
                this.validValue = this.input.getNumber(
                    intlTelInputUtils.numberFormat.INTERNATIONAL
                );
            }
        },
        display() {
            this.input = window.intlTelInput(this.$refs.input, {
                autoHideDialCode: false,
                initialCountry: "tr",
                formatOnDisplay: false,
                utilsScript: "/assets/plugin/intltelinput/js/utils.js"
            });

            this.$nextTick(() => {
                setTimeout(() => {
                    this.setValue(true);
                }, 1000);
            });
        }
    },
    mounted() {
        this.display();
    },
    beforeDestroy() {
        this.input.destroy();
    }
};
</script>
<style>
.iti {
    width: 100%;
}
</style>
