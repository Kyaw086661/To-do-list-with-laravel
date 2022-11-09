@extends('master')
@section('content')
    <div class="container">
                <div class="row mt-5">
                    <div class="col-5">
                        <div class="p-3">
                            @if (session('insertSuccess'))
                            <div class="alert-message">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ session('insertSuccess') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>
                            </div>
                            @endif
                            @if (session('updateSuccess'))
                            <div class="alert-message">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ session('updateSuccess') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>
                            </div>
                            @endif
                            @if (session('deleteSuccess'))
                            <div class="alert-message">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ session('deleteSuccess') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>
                            </div>
                            @endif
                            {{-- @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}
                            <form action="{{ route('post#create') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="text-group mb-3">
                                    <label for="">Post Title</label>
                                    <input type="text" name="postTitle" value="{{ old('postTitle') }}"  placeholder="Enter Post Title" class="form-control @error('postTitle') is-invalid @enderror">
                                    @error('postTitle')
                                        <div class="invalid-feedback">
                                            {{-- Post Title is required --}}
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="text-group mb-3">
                                    <label for="">Post Description</label>
                                    <textarea name="postDescription"  placeholder="Enter post description..." cols="30" rows="5" class="form-control @error('postDescription') is-invalid @enderror">{{ old('postDescription') }}</textarea>
                                 @error('postDescription')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                </div>
                                <div class="text-group mb-3">
                                    <label for="">Post Image</label>
                                    <input type="file" class="form-control @error('postImage') is-invalid @enderror" name="postImage" id="">
                                    @error('postImage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-group mb-3">
                                    <label for="">Post Fee</label>
                                    <input type="number" name="postFee" placeholder="Enter post fee" value="{{ old('postFee') }}" class="form-control @error('postFee') is-invalid @enderror">
                                    @error('postFee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-group mb-3">
                                    <label for="">Post Address</label>
                                    <input type="text" name="postAddress" value="{{ old('postAddress') }}"  placeholder="Enter Post Address" class="form-control @error('postAddress') is-invalid @enderror">
                                    @error('postAddress')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-group mb-3">
                                    <label for="">Post Rating</label>
                                    <input type="number" min="0" max="5" name="postRating" placeholder="Enter post rating" value="{{ old('postRating') }}"  class="form-control @error('postRating') is-invalid @enderror">
                                    @error('postRating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-group mb-3">
                                    <input type="submit" value="Create" class="btn btn-danger">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-7 shadow-sm">
                        <div class="row">
                            <div class="d-flex justify-content-between">
                                <div class=""><h3>Total - {{ $posts->total() }}</h3></div>
                                <form action="{{ route('post#createPage') }}" method="get">
                                    <div class=" d-flex justify-content-around">
                                        <input type="text" name="searchKey" placeholder="Enter key to search" class="form-control" value="{{ request("searchKey") }}">
                                        <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div></form>
                            </div>

                        </div>
                        <div class="content mb-3">
                            @if (count($posts) != 0)
                            @foreach ($posts as $p)
                            <div class="date-content p-3 shadow-sm mt-3">
                               <div class="d-flex justify-content-between">
                                <h5>{{ $p['id'] }}-{{ $p['title'] }}</h5>
                                <h5>{{ $p['created_at']->format('d/m/Y h:i A') }}</h5>
                               </div>
                                {{-- <p class="text-muted">{{ $p['description'] }}</p> --}}
                                {{-- <p class="text-muted">{{ Str::substr($p['description'], 0, 100) }}</p> // with pure php --}}
                                <p class="text-muted">{{ Str::words($p['description'], 50, '.....') }}</p>
                                <small><i class="fa-solid fa-money-bill-1-wave text-success"></i> {{ $p->price }}Kyats</small>
                                <small><i class="fa-solid fa-map-location-dot text-warning"></i> {{ $p->address }}</small>
                                <small><i class="fa-solid fa-star-half-stroke text-danger"></i> {{ $p->rating }}</small>

                                <div class="text-end ">
                                    {{-- url('post/delete/'.$p['id']) --}}
                                    <a href="{{ route('post#delete',$p['id']) }}">
                                        <button class="btn btn-sm btn-danger" title="delete" ><i class="fa-solid fa-trash"> ဖျက်ရန်</i></button>
                                    </a>
                                    {{-- <div class=""> with delete method in web.php
                                        <form action="{{ route('post#delete',$p['id']) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-sm btn-danger" title="delete" ><i class="fa-solid fa-trash"> ဖျက်ရန်</i></button>

                                        </form>
                                    </div> --}}

                                       <a href="{{ route('post#updatePage',$p['id']) }}">
                                        <button class="btn btn-sm btn-primary" title="see more"><i  class="fa-solid fa-circle-info"> အပြည့်အစုံ ဖတ်ရန်</i></button>
                                       </a>

                                </div>
                            </div>
                            @endforeach
                            @else
                                <h3 class="text-danger">There is no data ...</h3>
                            @endif
                        </div>
                        {{ $posts->appends(request()->query())->links() }}
                    </div>
                </div>
    </div>
@endsection
