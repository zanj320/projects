@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Users found') }}</div>

                <div class="card-body">
                    @foreach($users as $user)
                        <div>
                            {{ $user->name }}</a>, joined {{ $user->created_at }}
                            <a href="/u/{{ $user->id }}" style="float: right;">View profile</a>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
