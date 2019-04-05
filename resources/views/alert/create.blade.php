@extends('layouts.user')

@section('title', 'Create ' . App\Enums\AlertType::getDescription($alert->type) . ' alert')

@section('content')
    <h2>Create {{App\Enums\AlertType::getDescription($alert->type)}} alert</h2>

    <div class="row">
        <div class="col-md-7 col-sm-12">
            <form method="post" action="{{ route("alerts.store") }}" id="alertForm">
                @include('components.alert.form')
                <button class="btn btn-default bt-section-out" type="submit" role="button">Create alert</button>
            </form>
        </div>
    </div>
@endsection