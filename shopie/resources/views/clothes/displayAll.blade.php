@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card m-auto bg-dark text-primary shadow-sm">
            <div class="card-header border-2 border-primary">
                <form action="/clothes" class="d-inline navbar-brand" method="GET">
                    <div class="row mt-4">
                        <div class="col-sm-2">
                            <select name="category" class="form-control">
                                <option value="0" disabled selected hidden>search by category</option>
                                @if(isset($_GET['category']))
                                    <option value="">CLEAR SELECTION</option>
                                @endif

                                @foreach($categories as $category)
                                    @if(isset($_GET['category']) && $_GET['category']==$category->id)
                                        <option value="{{ucfirst($category->id)}}" selected>{{ucfirst($category->name)}}</option>
                                    @else
                                        <option value="{{ucfirst($category->id)}}">{{ucfirst($category->name)}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <select name="brand" class="form-control">
                                <option value="0" disabled selected hidden>search by brand</option>
                                @if(isset($_GET['brand']))
                                    <option value="">CLEAR SELECTION</option>
                                @endif
                                @foreach($brands as $brand)
                                    @if(isset($_GET['brand']) && $_GET['brand']==$brand->id)
                                        <option value="{{ucfirst($brand->id)}}" selected>{{ucfirst($brand->name)}}</option>
                                    @else
                                        <option value="{{ucfirst($brand->id)}}">{{ucfirst($brand->name)}}</option>
                                    @endif
                                @endforeach
                            </select>    
                        </div>

                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary">GO</button>
                        </div>

                        <div class="col-sm-8"></div>
                    </div>
                </form>
            </div>

            <div class="card-body row pt-0">
                @forelse($clothes as $clothe)
                <div class="col-4 mt-4">
                    <div class="box">
                        <div class="card-body text-dark bg-light rounded">
                            <span class="text-dark h3"><a href="/clothes/{{$clothe->id}}" class="text-reset text-decoration-none">{{$clothe->name}}</a></span>
                            
                            <div class="row">
                                <span class="col-5 text-start text-primary">{{strtoupper($clothe->brand->name)}}</span>
                                <span class="col-2"></span>
                                <span class="col-5 h5 text-end">{{$clothe->price}} €</span>
                            </div>

                            <div class="text-center mt-2 w-100">
                                <a href="/clothes/{{$clothe->id}}">
                                    @if(file_exists(public_path('images/' . $clothe->images[0]->image_path)))
                                        <img src="{{ asset('images/' . $clothe->images[0]->image_path) }}" alt="" class="box-image">
                                    @else
                                        <svg class="bd-placeholder-img rounded float-left" width="320" height="320" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 320x320"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96" /><text x="37%" y="50%" fill="#dee2e6" class="h4">320x320</text></svg>
                                    @endif
                                </a>
                            </div>
                            <br>
                                @include('layouts.avaliability')
                            <br>
                            <span>Available at: {{$clothe->avaliabilities[0]->location->name}}</span>
                        </div>
                    </div>
                </div>
                <br>
                @empty
                <h5 class="mt-5">No clothes available</h5>
                @endforelse

                <div class="mt-4">
                    {{$clothes->withQueryString()->links("pagination::bootstrap-5")}}
                </div>
            </div>
        </div>
    </div>
@endsection