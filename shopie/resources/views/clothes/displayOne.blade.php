@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card m-auto bg-dark text-primary shadow-sm">
            <div class="card-header border-2 border-primary">
                <span class="h4">{{$clothe->name}}</span>
            </div>
            <div class="card-body row">
                <div class="col-4">
                    @if(file_exists(public_path('images/' . $clothe->images[0]->image_path)))
                        <img src="{{ asset('images/' . $clothe->images[0]->image_path) }}" alt="" class="box-image-single bg-white rounded">
                    @else
                        <svg class="bd-placeholder-img rounded float-left" width="400" height="400" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 400x400"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96" /><text x="37%" y="50%" fill="#dee2e6" class="h4">400x400</text></svg>
                    @endif
                </div>
                <div class="col-6 h5">
                    <span>{{ucfirst($clothe->brand->name)}} {{$clothe->category->name}}</span>
                    @auth
                    <div class="position-absolute top-0 end-0 mt-5 me-5">
                        @if(Auth::user()->role === 'a')
                            <form action="/clothes/{{$clothe->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger"><i>delete &rarr;</i></button>
                            </form>
                        @endif
                    </div>
                    @endauth
                    <br>
                    <br>
                    <span>
                        {{$clothe->description}}
                    </span>
                    <br>
                    <br>
                    <br>
                    @auth
                    <div class="position-absolute top-40 end-0 me-5">
                        <form action="/clothes/{{ $clothe->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <span class="<?php if($liked>0) echo 'text-danger'; ?>" >
                                {{$clothe->likes()}}
                                <button type="submit" class="btn btn-link btn-lg text-decoration-none <?php if($liked>0) echo 'text-danger'; ?>">
                                    &#10084;
                                </button>
                            </span>
                        </form>
                    </div>
                    @endauth

                    <div class="position-absolute bottom-0 mb-5">
                        Available at: <u>{{$clothe->avaliabilities[0]->location->name}}</u> 
                            (@include('layouts.avaliability'))
                    </div>
                    <br>
                    <br>
                </div>
                
                <div class="col-2 h3 text-end">
                    <div class="position-absolute bottom-0 end-0 mb-5 me-5">
                        {{$clothe->price}} €
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection