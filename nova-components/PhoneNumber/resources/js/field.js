Nova.booting((Vue, router) => {
    Vue.component('index-intl-phone-number', require('./components/IndexField.vue'));
    Vue.component('detail-intl-phone-number', require('./components/DetailField.vue'));
    Vue.component('form-intl-phone-number', require('./components/FormField.vue'));
})
