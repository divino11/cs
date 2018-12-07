@extends('layouts.user')

@section('title', 'Create ' . App\Enums\AlertType::getDescription($alert->type) . ' alert')

@section('content')
    <div class="container-fluid p-4 w-75 float-left" id="alertForm">
        <form method="post" action="{{ route("{$alert->type_key}.store") }}">
            @include('components.alert.form')
            <div class="form-group">
                <input type="submit" class="btn btn-primary text-uppercase" value="create this alert">
            </div>
        </form>
    </div>
@endsection