@extends('layouts.user')

@section('title', 'Edit ' . App\Enums\AlertType::getDescription($alert->type) . ' alert')

@section('content')
    <div class="container-fluid p-4 w-75 float-left" id="alertForm">
        <form method="post" action="{{ route("{$alert->type_key}.update", ['alert' => $alert->id]) }}">
            @method('PUT')
            @include('components.alert.form')
            <div class="form-group">
                <input type="submit" class="btn btn-primary text-uppercase" value="edit this alert">
            </div>
        </form>
    </div>
@endsection