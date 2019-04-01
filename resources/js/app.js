
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
        if (data.user.sound_enable) {
            var audio = new Audio(data.alert_sound);
            window.focus();
            audio.play();
        }
        $.notify({
            message: 'Alert Triggered - ' + data.alert_name + '. The ' + data.alert_type + ' is currently ' + data.value,
        },{
            type: 'success',
            placement: {
                from: "bottom",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            delay: 0,
            animate: {
                enter: 'animated slideInUp',
                exit: 'animated slideInDown'
            },
        });
    });

//window.Pusher.logToConsole = true;

$(document).ready(function () {
    changeTextarea();
    if ($('#alert_message').keyup()) {
        $('#alertForm').change(function () {
            changeTextarea();
        });
        return false;
    }
});

function changeTextarea()
{
    setTimeout(function () {
        var market = $('#markets option:selected').text();
        var type = $("select[name='conditions[metric]'] option:selected").text().toLowerCase();
        var value = $('#currencyPrice').text();
        $('#alert_message').text(market + ' ' + type + ' ' + value);
    }, 1000);
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
