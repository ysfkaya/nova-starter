<template>
    <loading-view :loading="loading">
        <heading class="mb-6">Ayarlar</heading>
        <form @submit.prevent="save" autocomplete="off">
            <tabs>
                <span :key="tabIndex" v-for="(tab, tabIndex) in availableTabs">
                    <tab
                        :id="tab.hash()"
                        :isError="tab.error"
                        :key="tab.id"
                        :name="tab.formattedName()"
                    >
                        <component
                            :class="{
                                'remove-bottom-border':index == tab.fields.length - 1
                            }"
                            :show-help-text="field.helpText != null"
                            :errors="validationErrors"
                            :field="field"
                            :is="'form-' + field.component"
                            :key="index"
                            v-for="(field, index) in tab.fields"
                        />
                    </tab>
                </span>
            </tabs>

            <progress-button
                :disabled="saving"
                :processing="saving"
                dusk="create-button"
                type="submit"
            >Kaydet
            </progress-button>
        </form>
    </loading-view>
</template>

<script>
import {Errors, Minimum} from 'laravel-nova';

export default {
    data: () => ({
        loading: true,
        saving: false,
        tabs: [],
        validationErrors: new Errors(),
    }),
    metaInfo() {
        return {
            title: 'Ayarlar',
        };
    },
    created() {
        this.fetchTabs();
    },
    computed: {
        /**
         * Get the available field panels.
         */
        availableTabs() {
            return this.tabs.map(tab => {
                let newTab = this.createTab(tab);

                newTab['fields'] = tab.fields.map(field => {
                    if(this.validationErrors.has(field.attribute)) {
                        newTab.error = true;
                    }

                    if(
                        field.component === 'boolean-group-field' &&
                        typeof field.value === 'string'
                    ) {
                        field.value = JSON.parse(field.value);
                    }

                    return field;
                });

                return newTab;
            });
        },
    },
    methods: {
        createTab(tab) {
            return {
                fields: tab.fields,
                name: tab.name,
                key: tab.key,
                id: 'tab-' + tab.key,
                error: false,
                hash() {
                    return tab.key.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/ /g, '-');
                },
                formattedName() {
                    if(this.error) {
                        return (
                            '<span class="text-danger bounce">' +
                            this.name +
                            '</span>'
                        );
                    }

                    return this.name;
                },
            };
        },
        async fetchTabs() {
            this.loading = true;

            const {data} = await Minimum(
                Nova.request().get('/nova-vendor/nova-settings/tabs'),
            );

            this.tabs = data;

            this.loading = false;
        },
        async save() {
            this.saving = true;

            try {
                const {data} = await Nova.request().post(
                    '/nova-vendor/nova-settings/save',
                    this.createResourceFormData(),
                );

                this.fetchTabs();

                Nova.success('Ayarlar kaydedildi');

                this.validationErrors = new Errors();

                if(data.reload) {
                    window.location.reload();
                }
            } catch(e) {
                if(e.response.status === 422) {
                    this.validationErrors = new Errors(e.response.data.errors);
                    Nova.error(
                        this.__('There was a problem submitting the form.'),
                    );
                }
            }

            this.saving = false;
        },
        /**
         * Create the form data for creating the resource.
         */
        createResourceFormData() {
            return _.tap(new FormData(), formData => {
                _.each(this.availableTabs, tab => {
                    _.each(tab.fields, field => {
                        field.fill(formData);
                    });
                });
            });
        },
    },
};
</script>

<style>
/* Scoped Styles */
</style>
