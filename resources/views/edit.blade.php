!@extends('master')
@section('content')
    <div class="content">
        <div class="row mt-5 ">
            <div class="col-6 offset-3 ">
                <div class="">
                    <a href="{{ route('post#updatePage',$data['id']) }}" class="text-decoration-none text-black-50">
                        <i class="fa-solid fa-left-long my-3"></i> Back
                    </a>
                </div>

                <form action="{{ route('post#update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <label for="">Post Title</label>
                        <input type="text" name="postTitle" value="{{ old('postTitle',$data['title']) }}" placeholder="Enter post title"  class="form-control my-3 @error('postTitle') is-invalid @enderror " id="">
                        @error('postTitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input type="hidden" name="postId" value="{{ $data['id'] }}" id=""><br>
                        <label for="">Post Description</label>
                        <textarea name="postDescription" placeholder="Enter post description"  class="form-control @error('postDescription') is-invalid @enderror" cols="30" rows="6">{{ old('postDescription',$data['description']) }}</textarea>
                        @error('postDescription')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <label for="">Image</label>
                        <div class="">
                            @if ($data['image'] == null)
                                <img src="{{ asset("404.jpg") }}" alt="" class="img-thumbnail shadow-sm mt-4">
                                @else
                                <img src="{{ asset('storage/'.$data['image']) }}" class="img-thumbnail mt-3 shadow-sm">
                            @endif
                        </div>
                        <input type="file" class="form-control @error('postImage') is-invalid @enderror" name="postImage" id="">
                                    @error('postImage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                        <label for="">Post Fee</label>
                        <input type="number" name="postFee" value="{{ old('postFee',$data['price']) }}" placeholder="Enter post price"  class="form-control my-3 @error('postFee') is-invalid @enderror " id="">
                        @error('postFee')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <label for="">Post Address</label>
                        <input type="text" name="postAddress" value="{{ old('postAddress',$data['address']) }}" placeholder="Enter post address"  class="form-control my-3 @error('postAddress') is-invalid @enderror " id="">
                        @error('postAddress')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <label for="">Post Rating</label>
                        <input type="number" name="postRating" value="{{ old('postRating',$data['rating']) }}" placeholder="Enter post rating"  class="form-control my-3 @error('postRating') is-invalid @enderror " id="">
                        @error('postRating')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <input type="submit" value="Update" class="btn btn-dark text-white my-3 float-end" name="" id="">
                   </form>

            </div>
        </div>
    </div>
@endsection
