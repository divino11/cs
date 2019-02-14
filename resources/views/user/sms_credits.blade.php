@extends('layouts.user.account')

@section('title', 'SMS Credits')

@section('tabcontent')
    <div class="tab-pane active" id="credits">
        <div class="settings-section settings-credits-section">

            <p>SMS Credits allow Coinspy to send text messages to your mobile phone. We require 1 credit per 1 SMS. They can be purchased in packs of 100 credits for $2.00 USD. We support every country available through Twilio (221 countries).</p>

            <!-- blurb -->
            <div class="settings-credits-module">
                <div class="row">

                    <div class="col-md-6 col-sm-6">
                        <div class="pull-left">
                            <img src="{{ asset('images/credits_creditcard.svg') }}" alt=""/>
                        </div>
                        <div class="media-body">
                            <h3>Credit card</h3>
                            <p>100 credits for $ 2</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 settings-credits-module-right">
                        <a href="#" class="btn btn-primary bt-section" id="credit-button" data-toggle="modal"
                           data-target="#myModal">Pay with credit card
                        </a>
                    </div>

                </div>
            </div>
            <!-- END blurb -->

            <!-- blurb -->
            <div class="settings-credits-module">
                <div class="row">

                    <div class="col-md-6 col-sm-6">
                        <div class="pull-left">
                            <img src="{{ asset('images/credits_bitcoin.svg') }}" alt=""/>
                        </div>
                        <div class="media-body">
                            <h3>Bitcoin</h3>
                            <p>100 credits for $ 2</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 settings-credits-module-right">
                        <a href="{{ $link_transaction }}" class="btn btn-primary bt-section" target="_blank">Pay with Bitcoin</a>
                    </div>

                </div>
            </div>
            <!-- END blurb -->
        </div>
    </div>
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
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary bt-section" id="dropin-button">Pay 2$</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
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
                    $.get('{{ route('api.payments.braintree.sms') }}', payload, function (response) {
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