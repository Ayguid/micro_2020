/**
* First we will load all of this project's JavaScript dependencies which
* includes Vue and other libraries. It is a great starting point when
* building robust, powerful web applications using Vue and Laravel.
*/

require('./bootstrap');

window.Vue = require('vue');

import fileTypeReader from './myFuncs/fileManager';
Vue.mixin(fileTypeReader);
/**
* The following block of code may be used to automatically register your
* Vue components. It will recursively scan this directory for the Vue
* components and automatically register them with their "basename".
*
* Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
*/

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('drop-zone', require('./components/DropZone.vue').default);
Vue.component('contact-mail-form', require('./components/ContactMailForm.vue').default);

Vue.component('products-portfolio', require('./components/views/ProductsPortfolio.vue').default);
Vue.component('product-view', require('./components/views/ProductView.vue').default);
Vue.component('filter-menu', require('./components/FilterMenu.vue').default);
Vue.component('search-component', require('./components/forms/SearchComponent.vue').default);
Vue.component('product-component', require('./components/ProductComponent.vue').default);

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);
// import 'bootstrap-vue/dist/bootstrap-vue.css';
/**
* Next, we will create a fresh Vue application instance and attach it to
* the page. Then, you may begin adding components to this application
* or customize the JavaScript scaffolding to fit your unique needs.
*/

/* Vue translations*/
//arreglar usando base de datos que pueda administrarl el admin!!!
var translations;
const lang = (document.documentElement.lang=='pt-BR')?'pt':document.documentElement.lang;
import VueInternationalization from 'vue-i18n';
switch (lang) {
  case 'en':
  translations = require('./lang/translations_en.json')
  break;
  case 'pt':
  translations = require('./lang/translations_pt.json')
  break;
  default:
}
Vue.use(VueInternationalization);
const i18n = new VueInternationalization({
  locale: lang,
  messages: translations,
  objectNotation: true,
  keySeparator:true,
  silentTranslationWarn: true
});
// console.log(translations[`${lang}`+'.values']);
//

const app = new Vue({
  el: '#app',
  i18n,
  data(){
    return  {
      local:lang,
      baseUrl:window.axios.defaults.baseURL,
      authuser:window.Laravel.user
    }
  },
  mounted(){
    console.log("Welcome tu MICRO, curious you!");
    // console.log(this.authuser);
  }
});
