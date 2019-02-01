@extends('layouts.user.account')

@section('title', 'SMS Credits')

@section('tabcontent')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="account-heading">SMS Credits</h3>
                <p>SMS Credits allow Coindera to send text messages to your mobile phone. We require 1 credit per 1 SMS.
                    They can be purchased in packs of 100 credits for $2.00 USD. We support every country available
                    through <a target="_blank" href="https://www.twilio.com/sms/coverage">Twilio</a> (221 countries).
                    All text messages will come from a United States California San Francisco based number.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <h3>Pay with a Credit Card</h3>
                <button class="btn btn-primary" id="bitcoin-button" type="button" data-toggle="modal"
                        data-target="#myModal">Pay with Card
                </button>
            </div>
            <div class="col-lg-6">
                <h3>Pay with Cryptocurrency</h3>
                <a href="{{ $link_transaction }}" class="btn btn-primary" target="_blank">Pay with Cryptocurrency</a>
            </div>
        </div>
    </div>
@endsection
<div class="my-modal-base">
    <div class="my-modal-cont">
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Pay with Card</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="dropin-container"></div>
                                <button class="btn btn-success" id="dropin-button">Pay 100$ annually</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Done</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="https://js.braintreegateway.com/web/dropin/1.14.1/js/dropin.min.js"></script>
    <script>
        var submitButton = document.querySelector('#dropin-button');

        braintree.dropin.create({
            authorization: "{{ Braintree_ClientToken::generate() }}",
            selector: '#dropin-container',
            paypal: {
                flow: 'vault'
            }
        }, function (createErr, instance) {
            submitButton.addEventListener('click', function () {
                $('#dropin-button').attr('disabled', 'disabled').text('Loading ...');
                instance.requestPaymentMethod(function (err, payload) {
                    $.get('{{ route('payments.braintree.sms') }}', payload, function (response) {
                        if (response.success) {
                            $('#dropin-button').remove();
                            window.location.href = '{{ route('user.sms_credits') }}';
                        } else {
                            alert('Payment failed. Please contact us');
                        }
                    }, 'json');
                });
            });
        });
    </script>
@endpush