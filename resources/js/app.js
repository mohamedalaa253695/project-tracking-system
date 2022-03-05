/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import VModal from 'vue-js-modal';
import VueRouter from 'vue-router';

Vue.use(VModal);
Vue.use(VueRouter)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('logo', require('./components/Logo.vue').default );
Vue.component('theme-switcher', require('./components/ThemeSwitcher.vue').default);

Vue.component('new-project-modal', require('./components/NewProjectModal.vue').default);
Vue.component('dropdown', require('./components/Dropdown.vue').default);
//  Vue.component('new-project-modal', require('./components/NewProjectModal.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const router = new VueRouter({

// });
window.Event = new Vue();

const app = new Vue({
    el: '#app',
 
    
});
