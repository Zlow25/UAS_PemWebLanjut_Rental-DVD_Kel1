@extends('BackEnd.layouts.main')
@section('title', 'Deleted DVD List')

@section('content')
    <h1>Deleted DVD List</h1>

    <div class="mt-2 d-flex justify-content-end">
        <a href="/dvds" class="btn btn-primary">Back To DVD List</a>
    </div>

    <div class="my-4">
        @if (Session::has('success'))
            <div class="alert alert-primary">
                {{ Session('success') }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-hover border border-2">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Code DVD</th>
                        <th scope="col">Title</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($deletedDVD as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->dvd_code }}</td>
                            <td>{{ $item->title }}</td>
                            <td><a href="/dvd-restore/{{ $item->slug }}" class="btn btn-success btn-sm me-2"
                                    onclick="return confirm('yakin ingin mengembalikan data?')"><i
                                        class="bi bi-arrow-clockwise"></i></a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-dark bg-white text-center">Data Masih Kosong
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
