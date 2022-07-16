@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Recent Updates') }}</div>

                <div class="card-body">
                    <form action="/post" method="post">
                        @csrf
                        <textarea name="body" rows="5" class="form-control @error('body') is-invalid @enderror" placeholder="What is on your mind?" required></textarea>
                        @error('body')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <br>
                        <button type="submit" class="btn btn-primary">Post!</button>
                    </form>
                </div>
                <hr>
                <div class="card-body">
                    @forelse($messages as $message)
                        <h4>
                            <a href="/u/{{ $message->user->id }}">{{ $message->user->name }}</a> (<small>{{ $message->created_at->diffForHumans() }}</small>)
                            @if(Auth::user()->id == $message->user->id)
                                <form action="/delete-post" method="post" style="display: inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $message->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm" style="float: right;" onclick="return confirm('Delete message?')">DELETE</button>
                                </form>
                            @endif
                        </h4>
                        {{ $message->body }}
                        <br>
                        <hr>
                    @empty
                        <h3>No posts to display!</h3>
                    @endforelse
                </div>

            </div>
        </div>
        <div class="col-md-4 blog-sidebar">
            <form action="/search" class="format-button-input" method="get">
                <input type="text" name="search" class="form-control" placeholder="Search users">
                <div></div>
                <button type="submit" class="btn btn-primary">find</button>
            </form>
            <br>
            <div class="card">
                <div class="card-header">Following</div>
                @foreach($following as $follow)
                    <div class="card-body"><a href="/u/{{ $follow->id }}">{{ $follow->name }}</a><a href="/msg/{{ $follow->id }}" style="float: right;">Message</a></div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection