@extends('layouts.user')

@section('title', 'Alerts')

@section('content')
    <div class="list-group">
        @foreach($alerts as $alert)
            <div class="list-group-item list-group-item-action flex-column align-items-start p-4">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ $alert->name }}</h5>
                </div>
                <div class="actions">
                    <form action="{{ route('alerts.edit', ['alert_id' => $alert->id]) }}">
                        @csrf
                        <button type="submit" class="material-icons btn btn-link">edit</button>
                    </form>
                    <form action="{{ route('alerts.duplicate', ['alert_id' => $alert->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="material-icons btn btn-link">file_copy</button>
                    </form>
                    <form action="{{ route('alerts.destroy', ['alert_id' => $alert->id]) }}" method="POST" onsubmit="return confirm('Delete Alert?')">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="material-icons btn btn-link">delete</button>
                    </form>
                    <form action="{{ route('api.alert.toggle', ['alert' => $alert->id]) }}" class="form">
                        <div class="btn-group btn-group-sm btn-group-toggle toggle-switch" data-toggle="buttons">
                            <label class="btn btn-outline-primary @if($alert->enabled) active @endif">
                                <input type="radio" class="custom-control-input" autocomplete="off" @if($alert->enabled) checked @endif> On
                            </label>
                            <label class="btn btn-outline-primary @if(!$alert->enabled) active @endif">
                                <input type="radio" class="custom-control-input" autocomplete="off" @if(!$alert->enabled) checked @endif> Off
                            </label>
                        </div>
                    </form>
                </div>
                <p class="mb-1 text-muted">
                    @include('alert.description.' . $alert->type)
                </p>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.toggle-switch input:radio').on('change', function(e){
                $.get($(e.target).parents('form').attr('action'));
            });
        });
    </script>
@endpush