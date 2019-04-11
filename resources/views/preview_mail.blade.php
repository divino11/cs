@extends('layouts.preview')

@section('title')
    Mail Preview
@endsection

@section('main')
    <iframe src="{{ route(Request::get('route') ?? 'preview.triggered') }}" width="100%" height="100%" frameborder="0"></iframe>
@endsection