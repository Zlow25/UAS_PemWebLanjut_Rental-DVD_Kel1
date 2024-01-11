@extends('BackEnd.layouts.main')
@section('title', 'Edit DVDs')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@section('content')
    <h2>Edit DVD</h2>
    <div class="mt-4 w-75">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="mt-4 w-75">
        <form action="/dvd-edit/{{ $dvd->slug }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="code" class="form-label">Code DVD</label>
                <input type="text" name="dvd_code" class="form-control" id="code" placeholder="DVD Name"
                    value="{{ $dvd->dvd_code }}">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Enter the dvd title"
                    value="{{ $dvd->title }}">
            </div>
            <div class="mb-3">
                <label for="cover" class="form-label">Cover</label>
                <input type="file" name="cover" class="form-control">
            </div>
            <div class="mb-3">
                <label for="currentCover" class="form-label">Current Cover</label>
                <div>
                    @if ($dvd->cover != '')
                        <img src="{{ asset('storage/cover/' . $dvd->cover) }}" class="img-responsive border"
                            style="max-width:150px;" alt="">
                    @else
                        <img src="{{ asset('images/no_cover.jpg') }}" class="img-responsive border" style="max-width:150px;"
                            alt="">
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="categories[]" id="category" class="form-control select-multiple" multiple
                    aria-label="Default select example">
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="currentCategory" class="form-label">Current Category</label>
                <ul>
                    @foreach ($dvd->categories as $category)
                        <li>{{ $category->name }}</li>
                    @endforeach
                </ul>
            </div>
            <button class="btn btn-success" type="submit">Update</button>
            <a href="/dvds" class="btn btn-primary">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select-multiple').select2();
        });
    </script>
@endsection
