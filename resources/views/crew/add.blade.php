@extends('layouts.dashboard')
@section('title')
    Crew || Dashboard
@endsection
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Crew</h5>
                        <div class="card-header-action">
                            <a href="{{ route('crew.list') }}" class="btn btn-primary btn-sm">Crew List
                            </a>
                        </div>
                </div>
                <div class="card-body">
                    <form class="row mt-2 needs-validation" method="POST" action="{{ route('crew.insert') }}"
                        enctype="multipart/form-data">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @csrf

                        <div class="row mb-3">
                            <label for="ship_id" class="form-label">Ship</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="ship_id" id="ship_id" required>
                                    <option value="">Select an option</option>
                                    @foreach ($ship as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('ship_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

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
                            <label for="rank" class="form-label">Rank</label>
                            <div class="col-sm-12">
                                <input type="text" id="rank" name="rank" class="form-control" required>
                            </div>
                            @error('rank')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <div class="col-sm-12">
                                <input type="number" id="salary" name="salary" class="form-control" required>
                            </div>
                            @error('salary')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <label for="date" class="form-label">Joinng Data</label>
                            <div class="col-sm-12">
                                <input type="date" id="date" name="date" class="form-control" required>
                            </div>
                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="col-sm-12">
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            @error('password')
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
