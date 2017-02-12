
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

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

