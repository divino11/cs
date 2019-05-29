
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap-notify');
const flatpickr = require("flatpickr/dist/flatpickr");
require('select2');
require('jquery-autocomplete');
window.intlTelInput = require('intl-tel-input');
require('clockpicker/src/clockpicker');

window.Vue = require('vue');

import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '825ad4919731c1c3e402',
    cluster: 'eu',
    encrypted: true,
});

window.Echo.private(`user.${userId}`)
    .notification((data) => {
        let notification = new Notification('New post alert!', {
            body: data.alert_message,
            icon: data.logo
        });
        notification.onclick = () => {
            window.open(window.location.href);
        };
    });

//window.Pusher.logToConsole = true;
$(document).ready(function() {
    var countryData = window.intlTelInputGlobals.getCountryData(),
        input = document.querySelector("#phone");

    for (var i = 0; i < countryData.length; i++) {
        var country = countryData[i];
        country.name = country.name.replace(/(\[.*?\]|\(.*()?\)) */g, "");
    }

    var a = window.intlTelInput(input, {
        separateDialCode: true,
        placeholder: 'Phone number',
    });
    $('#phone').keyup(function () {
        $('#phoneHidden').val(a.selectedCountryData.dialCode + $('#phone').val());
    });
});

var mouseflowPath = window.location.hostname + window.location.pathname;
var mouseflowCrossDomainSupport = true;
window._mfq = window._mfq || [];
(function() {
    var mf = document.createElement("script");
    mf.type = "text/javascript"; mf.async = true;
    mf.src = "//cdn.mouseflow.com/projects/53094351-7046-4529-b05a-ce9d225240ab.js";
    document.getElementsByTagName("head")[0].appendChild(mf);
})();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
