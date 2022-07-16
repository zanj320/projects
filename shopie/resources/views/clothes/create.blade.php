@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card w-75 m-auto bg-dark text-primary shadow-sm">
        <div class="card-header border-2 border-primary">
            <span class="h5">
                Add new
            </span>
        </div>
        <div class="card-body p-10">
            <form action="/clothes" method="POST" enctype="multipart/form-data">
                @csrf   
                <span class="h5">Name</span>
                <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="enter a name">
                <br>

                <span class="h5">Price(in €)</span>
                <input type="text" name="price" class="form-control" value="{{old('price')}}" placeholder="enter a price">
                <br>

                <span class="h5">Quantity</span>
                <input type="number" name="quantity" class="form-control" value="{{old('quantity')}}" placeholder="enter quantity">
                <br>

                <span class="h5">Location (avaliability)</span>
                <select name="location" id="location" class="form-control">                    
                    <option value="none" disabled selected hidden>select location</option>
                    @foreach($locations as $location)
                        <option value="{{$location->id}}" <?php if(old('location')==$location->id) echo 'selected' ?>>{{ucfirst($location->name)}}</option>
                    @endforeach
                </select>
                <br>

                <span class="h5">Description</span>
                <input type="text" name="description" class="form-control" value="{{old('description')}}" placeholder="enter description">
                <br>

                <span class="h5">Category</span>
                <select name="category" id="category" class="form-control">                    
                    <option value="none" disabled selected hidden>select category</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" <?php if(old('category')==$category->id) echo 'selected' ?>>{{ucfirst($category->name)}}</option>
                    @endforeach
                </select>
                <br>

                <span class="h5">Brand</span>
                <select name="brand" id="brand" class="form-control">
                    <option value="none" disabled selected hidden>select a brand</option>
                    @foreach($brands as $brand)
                        <option value="{{$brand->id}}" <?php if(old('brand')==$brand->id) echo 'selected' ?>>{{ucfirst($brand->name)}}</option>
                    @endforeach
                </select>
                <br>

                <span class="h5 text-warning">Image</span>
                <input type="file" name="image" class="form-control">
                <br>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mr-auto w-25">Confirm</button>
                </div>
            </form>
            @if($errors->any())
                <ul class="text-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection