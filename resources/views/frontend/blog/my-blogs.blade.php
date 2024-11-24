@extends('frontend.master')

@section('banner')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>My Blogs</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('frontend.index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('blogs.index') }}">Blog</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
@endsection

@section('content')
    <div class="container">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end justify-content-md-end mt-4">
            <a href="{{ route('blogs.create') }}" class="primary-btn">Add new blog</a>
{{--            <a href="{{ route('blogs.create') }}" class="btn primary radius text-end">Add new blog</a>--}}
        </div>
        <table class="table table-bordered m-4">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Actions</th>

                </tr>
            </thead>
            <tbody>
            @if(count($blogs) > 0)
                @foreach($blogs as $blog)
                    <tr>
                        <th scope="row">1</th>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->created_at->format("d M Y, h:i A") }}</td>
                        <td>
                            <a href="{{ route('blogs.show', ['blog' => $blog]) }}" class="btn btn-info waves-effect waves-light"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a href="{{ route('blogs.edit', ['blog' => $blog]) }}" class="btn btn-primary waves-effect waves-light"><i class="fa fa-edit" aria-hidden="true"></i></a>
                            <form method="post" class="delete-form" style="display: inline;" data-route="{{route('blogs.destroy',$blog->id)}}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger waves-effect waves-light"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection

