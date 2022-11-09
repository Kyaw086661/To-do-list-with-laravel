@extends('master')
@section('content')
    <div class="content">
        <div class="row mt-5 ">
            <div class="col-6 offset-3 ">
                <div class="">
                    <a href="{{ route('post#createPage') }}" class="text-decoration-none text-black-50">
                        <i class="fa-solid fa-left-long my-3"></i> Back
                    </a>
                </div>
                {{-- <h3>{{ $data[0]['title'] }}</h3> get() နဲ့ယူလိူ့  --}}
                <h3>{{ $data['title'] }}</h3>
                {{-- first နဲ့ယူ  --}}
                <p>
                    {{ $data['description'] }}
                </p>
                <h1 class="btn btn-dark text-white">{{ $data['price'] }}</h1>
                <h3 class="btn btn-dark text-white">{{ $data['address'] }}</h3>
                <h3 class="btn btn-dark text-white">{{ $data['rating'] }}</h3>
                <div class="">
                    @if ($data['image'] == null)
                        <img src="{{ asset("404.jpg") }}" class="img-thumbnail shadow-sm my-5" alt="">
                        @else
                        <img src="{{ asset('storage/'.$data['image']) }}" class="img-thumbnail my-3 shadow-sm">
                    @endif

                </div>
            </div>
            <div class="row my-3" >
                <div class="col-3 offset-9">
                    <a href="{{ route('post#editPage',$data['id']) }}">
                        <button class="btn btn-dark text-white">Edit</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
