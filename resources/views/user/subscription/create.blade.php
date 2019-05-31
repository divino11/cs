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
                        <a href="#" class="btn btn-primary bt-section d-inline-flex btn-plan" id="bitcoin-button"
                           data-plan="yearly"
                           data-price={{ config('payments.yearly.price') }}
                           data-toggle="modal"
                           data-target="#myModal"><i class="material-icons">credit_card</i> Credit card: ${{ config('payments.yearly.price') }}
                        </a>
                        <a href="{{ $link_transaction_yearly }}" class="btn btn-primary bt-section d-inline-flex"
                           target="_blank"><i class="material-icons">monetization_on</i> Bitcoin: ${{ config('payments.yearly.price') }}</a>
                    </div>
                </div>
            </div>
            <div class="settings-credits-module advancedplan-module">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h3>Monthly</h3>
                    </div>
                    <div class="col-md-8 col-sm-8 advancedplan-module-right">
                        <a href="#" class="btn btn-primary bt-section d-inline-flex btn-plan" id="bitcoin-button"
                           data-plan="monthly"
                           data-price={{ config('payments.monthly.price') }}
                           data-toggle="modal"
                           data-target="#myModal"><i class="material-icons">credit_card</i> Credit card: ${{ config('payments.monthly.price') }}
                        </a>
                        <a href="{{ $link_transaction_monthly }}" class="btn btn-primary bt-section d-inline-flex"
                           target="_blank"><i class="material-icons">monetization_on</i> Bitcoin: ${{ config('payments.monthly.price') }}</a>
                    </div>
                </div>
            </div>
            <!-- END blurb -->

            <div class="advancedplan-bottom">
                <a class="btn btn-default bt-section-out" href="{{ route('user.subscription.index') }}" role="button">Back
                    to all plans</a>
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
                            <form action="{{ route('api.payments.stripe.subscribe') }}" method="post" id="payment-form">
                                @csrf
                                <input type="hidden" name="plan">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-row">
                                            <label for="card-element">
                                                Credit or debit card
                                            </label>
                                            <div id="card-element"></div>
                                            <div id="card-errors" role="alert"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary bt-section" type="submit">Pay 100$</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ config('services.stripe.key') }}');

        var elements = stripe.elements();

        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        var card = elements.create('card', {hidePostalCode: true, style: style});

        card.mount('#card-element');

        card.addEventListener('change', function (event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }

        $('.btn-plan').click(function () {
            var plan = $(this).data('plan');
            var price = 'Pay ' + $(this).data('price') + '$';
            $('input[name="plan"]').val(plan);
            $('.modal-footer button').text(price);
        });
    </script>
@endpush