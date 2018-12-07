@extends('layouts.user')

@section('title', 'Activity')

@section('content')
    <div class="list-group">
        @foreach($notifications as $notification)
            <div class="list-group-item list-group-item-action flex-column align-items-start p-4">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"></h5>
                </div>
                <p class="mb-1 text-muted">
                    @include('alert.' . $alert->type)
                </p>
            </div>
        @endforeach
    </div>
@endsection