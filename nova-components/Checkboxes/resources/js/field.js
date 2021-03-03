Nova.booting((Vue, router, store) => {
  Vue.component('index-checkboxes', require('./components/IndexField'))
  Vue.component('detail-checkboxes', require('./components/DetailField'))
  Vue.component('form-checkboxes', require('./components/FormField'))
})
