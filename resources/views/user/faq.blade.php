@extends('layouts.user.account')

@section('title', 'FAQ')

@section('tabcontent')
    <div class="tab-pane active" id="channels">
        <div class="row">
            <div class="col-md-7 col-sm-12">
                <div class="settings-generalmodule">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="account-heading">Frequently Asked Questions</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <h4><strong>How do I add my phone number and other channels?</strong></h4>
                            <blockquote>See here: <a href="https://my.coinspy.it/channels">https://my.coinspy.it/channels</a>
                            </blockquote>

                            <h4><strong>Can you please add [insert your desired market here] market?</strong></h4>
                            <blockquote>Maybe. It depends on if they have an API and how easy it will be to integrate
                                it. Feel free to email us at
                                <a href="mailto:support@coinspy.it">support@coinspy.it</a> to request a market.
                            </blockquote>

                            <h4><strong>What currency do I set the alert in?</strong></h4>
                            <blockquote>It's whatever is first. Example - if you select BTC/USD - then it's a BTC price
                                alert in terms of USD. The second currency is the base currency.
                            </blockquote>

                            <h4><strong>Can you please add [insert your desired feature here]?</strong></h4>
                            <blockquote>Maybe. Feel free to email us at <a href="mailto:support@coinspy.it">support@coinspy.it</a>.
                            </blockquote>

                            <h4><strong>Can I delete my account?</strong></h4>
                            <blockquote>Yes.<form class="d-inline-block" action="{{ route('user.delete_user', ['user_id' => \Illuminate\Support\Facades\Auth::user()->id]) }}" method="POST" onsubmit="return confirm('Are you sure remove account?')">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="submit-btn">Click Here.</button>
                                </form>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection