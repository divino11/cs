@extends('layouts.guest')

@section('content')
    <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 offset-xs-0">
    <div class="jumbotron text-xs-center" style="text-align: center!important; border-radius: 0">
        <h1 class="display-3">Thank You</h1>
        <p class="lead">{{ $message }}</p>
        <hr>
        <p>
            Having trouble? <a href="mailto:mail@coinspy.it">Contact us</a>
        </p>
        <p class="lead">
            <a class="btn btn-primary btn-sm" href="//my.coinspy.it/" role="button">Continue to member area</a>
        </p>
    </div>
    </div>
@endsection