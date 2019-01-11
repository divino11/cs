@extends('layouts.user.account')

@section('title', 'Support')

@section('tabcontent')
    <div class="container">
        <div class="tab-pane active">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="account-heading">Support</h3>
                    <hr>
                </div>
                <div class="col-lg-12">
                    <p>Please note - You might not know but Coindera is built and maintained by me (<a
                                href="https://adamevers.com">Adam</a>). Unfortunately, I'm not a Bitcoin millionaire,
                        just a guy that loves Bitcoin and was disappointed with other alert systems. I don't have a
                        support staff, it's just me.&nbsp;I’ll get back to you just as soon as I can.&nbsp; Thank you
                        for your patience.</p>
                    <p>I do not provide support for free users. If you have a billing issue please contact us at <a
                                href="mailto:info@coindera.com" target="_blank">info@coindera.com</a></p>
                    <p>Public Channel on Telegram <a href="https://t.me/coindera"
                                                     target="_blank">https://t.me/coindera</a></p>
                </div>
                <div class="col-lg-12">
                    <h3 class="account-heading">Release notes - 3.0</h3>
                    <hr>
                </div>
                <div class="col-lg-12">
                    <p>Released: 7/13/2018</p>
                    <p><strong>Helios Updates</strong></p>
                    <ul>
                        <li>Brand new shiny backend.</li>
                        <li>Upgraded server hardware. Fully redundant and co-located.</li>
                        <li>Massive speed increase - we're fetching data now every minute.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection