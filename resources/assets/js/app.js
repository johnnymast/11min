
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


window.Clipboard = require('clipboard/dist/clipboard');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the pages. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

window.Event = new class {
  constructor() {
    this.vue = new Vue;
  }

  fire(event, data = null) {
    this.vue.$emit(event, data);
  }

  listen(event, callback) {
    this.vue.$on(event, callback);
  }
}

Vue.component('modal', require('./components/Modal.vue'));
Vue.component('mailbox', require('./components/Mailbox.vue'));
Vue.component('countdown', require('./components/Countdown.vue'));

// Comment these three for local build.
Vue.config.devtools = false
Vue.config.debug = false
Vue.config.silent = true

var _app = new Vue({
  el: '#root'
});

require('./home/home');
require('./bulma-extensions');
