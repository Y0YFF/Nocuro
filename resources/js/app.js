/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vuetify, {
    VCard, VBtn, VIcon, VTextField, VApp, 
    VAppBar, VMain, VFooter, VBottomNavigation, 
    VProgressLinear, VDialog 
} from 'vuetify/lib';
import 'vuetify/dist/vuetify.min.css';
Vue.use(Vuetify);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import LessonsForm from './components/LessonsFormComponent.vue';
import Lessons from './components/LessonsComponent.vue';
import NameInput from './components/NameInputComponent.vue';
import EmailInput from './components/EmailInputComponent.vue';
import AccountIdInput from './components/AccountIdInputComponent.vue';
import PasswordInput from './components/PasswordInputComponent.vue';
import PasswordConfirmationInput from './components/PasswordConfirmationInputComponent.vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    components: {
        VCard, VBtn, VIcon, VTextField, VApp, 
        VAppBar, VMain, VFooter, VBottomNavigation, 
        VProgressLinear, VDialog,
        Lessons, LessonsForm, 
        NameInput, EmailInput, 
        AccountIdInput, PasswordInput, 
        PasswordConfirmationInput, 
    }
});
