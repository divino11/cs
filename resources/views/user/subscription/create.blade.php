@extends('layouts.user.account')

@section('title', 'Plan')

@section('tabcontent')
    <div class="tab-pane active" id="plan">
        <div class="settings-plan-section advancedplan-section">
            <h3>Advanced plan</h3>
            <p>Please select from our payment options:</p>

            <!-- blurb -->
            <div class="settings-credits-module advancedplan-module">
                <div class="row">

                    <div class="col-md-4 col-sm-4">
                        <h3>Yearly</h3>
                    </div>

                    <div class="col-md-8 col-sm-8 advancedplan-module-right">
                        <a href="#" class="btn btn-primary bt-section d-inline-flex" id="bitcoin-button" data-toggle="modal"
                                data-target="#myModal"><i class="material-icons">credit_card</i>Credit card: $100
                        </a>
                        <a href="{{ $link_transaction }}" class="btn btn-primary bt-section d-inline-flex" target="_blank"><i class="material-icons">monetization_on</i> Bitcoin: $100</a>
                    </div>

                </div>
            </div>
            <!-- END blurb -->

            <div class="advancedplan-bottom">
                <a class="btn btn-default bt-section-out" href="{{ route('user.subscription.index') }}" role="button">Back to all plans</a>
            </div>

        </div>
    </div>
    <!-- END plan -->
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
                                <button class="btn btn-primary bt-section   " id="dropin-button">Pay 100$</button>
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
                    $.get('{{ route('api.payments.braintree.subscribe') }}', payload, function (response) {
                        if (response.success) {
                            $('#dropin-button').remove();
                            window.location.href = '{{ route('user.subscription.index') }}';
                        } else {
                            alert('Payment failed. Please contact us');
                        }
                    }, 'json');
                });
            });
        });
    </script>
@endpush