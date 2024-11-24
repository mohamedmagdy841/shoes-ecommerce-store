@extends('frontend.master')

@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Update Blog</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('content')
    <!--================Contact Area =================-->
    <section class="contact_area section_gap_bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mt-5">
                    <h3 class="text-center mb-5">Update Blog</h3>
                    <form class="row contact_form" method="post" action="{{ route('blogs.update', ['blog' => $blog]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="title" value="{{ $blog->title }}" placeholder="Enter blog title" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter blog title'">
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="file" name="image">
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                            <div class="mb-3">
                                <select class="form-select" aria-label="Default select example" name="category_id">
                                    <option selected>Select Category</option>
                                    @if(count($categories) > 0)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <textarea rows="5" class="form-control" name="description" placeholder="Write description" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Write description'">{{ $blog->description }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="submit" class="primary-btn">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
    <!--================Contact Area =================-->
@endsection
