@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>
                
                <div class="messages">
                    @forelse($messages as $message)
                        @if($message->sent_id==Auth::user()->id)
                            <div class="card-body me"><span><div class="me-template"><small>Me: </small></div></span>{{ $message->body }}</div>
                        @else
                            <div class="card-body friend"><span><div class="me-template"><small>Friend: </small></div></span>{{ $message->body }}</div>
                        @endif
                    @empty
                        <div class="card-body">
                            <h4>You haven't sent or recieved any messages!</h4>
                        </div>
                    @endforelse
                </div>

                <form action="/send_message" class="format-button-input send-message" method="post">
                    {{ csrf_field() }}
                    <input type="text" class="form-control" name="body">
                    <div></div>
                    <button type="submit" class="btn btn-primary">send</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection