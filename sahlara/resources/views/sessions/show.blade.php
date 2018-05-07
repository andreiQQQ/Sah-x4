@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ $session->name }}
                        <subscribers
                                subscribers-uri="{{ route('session.subscribers', ['session' => $session]) }}"
                                :game-session="{{ $session->id }}"
                        >
                        </subscribers>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @can('subscribe', $session)
                                <div class="form-inline ml-3">
                                    <form method="get" action="{{ route('session.subscribe', [
                                            'session' => $session,
                                        ]) }}" class="form-inline">
                                        <button class="btn btn-success">Play with</button>
                                    </form>
                                </div>
                            @endcan
                            <div class="col-4 form-inline">
                                <label class="custom-control-inline">Initiator:</label>
                                <input class="form-control" disabled value="{{ $sessionUser->name }}">
                            </div>
                            <div class="col-7 form-inline">

                            </div>
                        </div>
                        {{--<div class="row">--}}
                        {{--<header>--}}
                        {{--<h1>Chess x 4</h1>--}}
                        {{--</header>--}}
                        {{--<div id="control">--}}
                        {{--<button type="button" id="NewGameButton">New Game</button><br/>--}}
                        {{--</div>--}}
                        {{--<div id="Board">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
@endsection