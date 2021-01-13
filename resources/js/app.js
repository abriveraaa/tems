require('./bootstrap');

//require vue
window.Vue = require('vue');

//require component
Vue.component('card', require('./components/dashboard/Card.vue').default);

//call the app id
const app = new Vue({
    el : '#app',
});