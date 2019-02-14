@extends('layouts.user')

@section('title', 'Alerts')

@section('content')
    <h2>Alerts</h2>

    <!-- CREDITS -->
    <div class="tab-pane" id="credits">
    @forelse($alerts as $alert)
        <!-- blurb -->
        <div class="alerts-module">
            <div class="row">

                <div class="col-md-8 col-sm-8">
                    <div class="pull-left">
                        <img src="{{asset('images/alerts_ico_regularupdate.svg')}}" alt=""/>
                    </div>
                    <div class="media-body">
                        <h4>{{ $alert->name }}</h4>
                        <p>@include('alert.description.' . $alert->type)</p>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 alerts-module-right text-right">
                    <ul class="list-inline alerts-module-right">
                        <li>
                            <form action="{{ route('alerts.edit', ['alert_id' => $alert->id]) }}">
                                @csrf
                                <button type="submit" class="alert-submit-btn"><img src="{{ asset('images/ico_edit.svg') }}" alt=""/></button>
                            </form>
                        </li>
                        <li>
                            <form action="{{ route('alerts.destroy', ['alert_id' => $alert->id]) }}" method="POST" onsubmit="return confirm('Delete Alert?')">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="alert-submit-btn"><img src="{{ asset('images/ico_trash.svg') }}" alt=""/></button>
                            </form>
                        </li>
                        <li>
                            <form action="{{ route('api.alert.toggle', ['alert' => $alert->id]) }}" class="form">
                                    <label class="switch">
                                        <input type="checkbox" @if($alert->enabled) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        @empty
            <h3 class="text-center pt-5">You don't have any alerts</h3>
        @endforelse

        <div class="content-bottom">
            <a class="btn btn-default bt-section-out" href="{{ route('alerts.create') }}" role="button">Add new alert</a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('input:checkbox').on('change', function(e){
                $.get($(e.target).parents('form').attr('action'));
            });
        });
    </script>
@endpush