
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
$(document).ready(function() {
    var input = document.querySelector("#phone");
    var a = window.intlTelInput(input, {
        separateDialCode: true
    });
    $('#phone').keyup(function () {
        $('#phoneHidden').val(a.selectedCountryData.dialCode + $('#phone').val());
    });
});

$(document).ready(function () {
    $('#alertForm').bind('change keyup', function () {
        changeTextarea();
    });
});

function changeTextarea()
{
    setTimeout(function () {
        var market = $('#markets option:selected').text() ? $('#markets option:selected').text() : '';
        var type = $("select[name='conditions[metric]'] option:selected").text().toLowerCase() ? $("select[name='conditions[metric]'] option:selected").text().toLowerCase() : '';
        var direction = $("select[name='conditions[direction]'] option:selected").text() ? $("select[name='conditions[direction]'] option:selected").text() : '';
        var value = $("input[name='conditions[value]']").val() ? $("input[name='conditions[value]']").val() : '';
        var currencyValue = $('#currencyPrice').text() ? $('#currencyPrice').text() : '';
        var interval = $("select[name='conditions[interval]'] option:selected").text() ? $("select[name='conditions[interval]'] option:selected").text() : '';
        $('#setMarket').val(market);
        $('#setType').val(type);
        $('#setDirection').val(direction);
        $('#setValue').val(value);
        $('#setCurrencyValue').val(currencyValue);
        $('#setInterval').val(interval);
        var textarea = $('#alert_message').val();
        var find = ["{market}", "{type}", "{direction}", "{value}", "{price}", "{interval}"];
        var replace = [market, type, direction, value, currencyValue, interval];
        textarea = textarea.replaceArray(find, replace);
        $('.live-preview').text(textarea);
    }, 1000);
}

String.prototype.replaceArray = function(find, replace) {
    var replaceString = this;
    for (var i = 0; i < find.length; i++) {
        replaceString = replaceString.replace(find[i], replace[i]);
    }
    return replaceString;
};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
