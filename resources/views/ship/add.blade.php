@extends('layouts.dashboard')
@section('title')
    Ship || Dashboard
@endsection
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Ship</h5>
                        <div class="card-header-action">
                            <a href="{{ route('ship.list') }}" class="btn btn-primary btn-sm">Ship List
                            </a>
                        </div>
                </div>
                <div class="card-body">
                    <form class="row mt-2  needs-validation" method="POST" action="{{ route('ship.insert') }}"
                        enctype="multipart/form-data">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="form-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="image" class="form-label">Image Upload</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="file" id="image" name="image"
                                    accept=".png, .jpg, .jpeg" required>
                            </div>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
