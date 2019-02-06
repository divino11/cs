@extends('layouts.user.account')

@section('title', 'Plan')

@section('tabcontent')
    <div>
        <div class="col-lg-12">
            <h3>Plan details</h3>
            <p class="text-muted">Current plan: <strong>free</strong></p>
            <p class="text-muted" style="margin-left: 20px">5 Active Alerts, Price Point, All Channels, 30+ Markets, 11,000+ Cryptocurrencies</p>
            <p>New plan: <strong class="text-primary">pro</strong></p>
            <p style="margin-left: 20px">Unlimited Alerts, Price Point, Percent Change, Regular Updates, All Channels, 30+ Markets, 11,000+ Cryptocurrencies</p>
            <hr>
            <h3>Terms of Service and Privacy Policy</h3>
            <ul>
                <li><a href="/terms" target="_blank">Terms of Service</a></li>
                <li><a href="/privacy" target="_blank">Privacy Policy</a></li>
            </ul>
            <p>By proceeding you confirm that you have read and agree to the Terms of Serivce and Privacy Policy detailed in the links above. <em>NOTE - we do not offer refunds.</em></p>
            <hr>
            <h3>Payment options</h3>
            <!-- Nav tabs -->
            <ul class="nav nav-pills" id="payments" role="tablist">
                <li class="nav-item">
                    <a class="btn btn-primary" id="cc-tab" data-toggle="tab" href="#cc" role="tab" aria-controls="cc" aria-selected="true">Credit Card or PayPal</a>
                </li>
                <li class="nav-item">
                    <a href="{{ $link_transaction }}" class="btn btn-primary ml-2" target="_blank">Pay with Cryptocurrency</a>
                </li>
            </ul>
            <div class="tab-content" id="paymentsContent">
                <div class="tab-pane fade show active" id="cc" role="tabpanel" aria-labelledby="cc-tab">
                    <div id="dropin-container"></div>
                    <button class="btn btn-success" id="dropin-button">Pay 100$ annually</button>
                </div>
            </div>
            <p>&nbsp;</p>

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
                    $.get('{{ route('payments.braintree') }}', payload, function (response) {
                        if (response.success) {
                            $('#dropin-button').remove();
                            window.location.href = '{{ route('subscription.index') }}';
                        } else {
                            alert('Payment failed. Please contact us');
                        }
                    }, 'json');
                });
            });
        });
    </script>
@endpush