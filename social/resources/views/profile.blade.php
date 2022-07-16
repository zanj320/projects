@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>
                <div class="card-body">
                    <span>Joined {{ $user->created_at }}</span>
                    <span style="float: right;">
                        @if($user->id== Auth::user()->id)
                            <a href="/edit-data" style="float: right;">Edit data</a>
                        @else
                            @if($follows)
                                <form id="follow_form" action="/unfollow_user" style="float: right;" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <button type="submit" class="text-primary follow_button">Unfollow</button>
                                </form>
                            @else
                                <form id="follow_form" action="/follow_user" style="float: right;" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <button type="submit" class="text-primary follow_button">Follow</button>
                                </form>
                            @endif
                        @endif
                    </span>
                    <br>
                    {{ $user->email }}
                </div>
                <div class="card-body">
                    <hr>
                    @forelse($user->messages as $message)
                        <h4>{{ $message->user->name }} (<small>{{ $message->created_at->diffForHumans() }}</small>)</h4>
                        {{ $message->body }}
                        <br>
                        <hr>
                    @empty
                        <h3>User doesn't have any posts!</h3>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
