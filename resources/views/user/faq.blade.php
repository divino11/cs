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
                            <p>Please note - You might not know but Coindera is built and maintained by me (<a
                                        href="https://adamevers.com">Adam</a>). Unfortunately, I'm not a Bitcoin
                                millionaire, just a
                                guy that loves Bitcoin and was disappointed with other alert systems. I don't have a
                                support staff,
                                it's just me.&nbsp;I’ll get back to you just as soon as I can.&nbsp; Thank you for your
                                patience.
                            </p>
                            <h4><strong>How do I add my phone number?</strong></h4>
                            <blockquote>Go to <a href="https://app.coindera.com/channels/">https://app.coindera.com/channels/</a>
                            </blockquote>
                            <h4><strong>How often do you update Coindera?</strong></h4>
                            <blockquote>
                                <p>About every 2 or 3 months. </p>
                            </blockquote>
                            <h4><strong>What's the formula for percentage change?</strong></h4>
                            <blockquote>
                                <p>Simple Example. Price was $10 and is now $15. This is a 50% increase.</p>
                                <p>(($15 - 10) / $10) * 100 = 50</p>
                                <p>((CV - PV) / PV) * 100</p>
                            </blockquote>
                            <h4><strong>How does the system compare data for the percent change alerts?</strong></h4>
                            <blockquote>
                                <p>Example - if you set an alert to monitor a 2% increase in the buy price within 1 day
                                    everytime we
                                    check the market you've selected we will then compare it with the data we have from
                                    exactly 24
                                    hours previous.</p>
                            </blockquote>
                            <h4><strong>What is Helios?</strong></h4>
                            <blockquote>
                                <p>Helios is the code name for our backend system.</p>
                            </blockquote>
                            <h4><strong>Why am I not getting alerts? </strong></h4>
                            <blockquote>
                                <p>Are you sure the alert isn't paused because it reached it's max notifications? </p>
                            </blockquote>
                            <h4><strong>Can you please add [insert your desired market here] market?</strong></h4>
                            <blockquote>
                                <p>Maybe. It really depends on if they have an API and how easy it will be to integrate
                                    it. Feel
                                    free to email us at <a href="mailto:support@coindera.com">support@coindera.com</a>
                                    to request a
                                    market. </p>
                            </blockquote>
                            <h4><strong>What currency do I set the alert in? </strong></h4>
                            <blockquote>
                                <p>It's whatever is first. Example - if you select BTC_USD - then it's BTC. </p>
                            </blockquote>
                            <h4><strong>Can you please add [insert your desired feature here]?</strong></h4>
                            <blockquote>
                                <p>Maybe, Coindera is a side project. Feel free to request it and I'll do my best to add
                                    it when I
                                    can.</p>
                            </blockquote>
                            <h4><strong>Can I delete my account?</strong></h4>
                            <blockquote>
                                <p>Sad to see you go but yes of course you can. <a
                                            href="https://app.coindera.com/users/delete">Click
                                        Here.</a></p></blockquote>
                            <p><br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection