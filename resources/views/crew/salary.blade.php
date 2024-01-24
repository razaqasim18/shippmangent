@extends('layouts.dashboard')
@section('title')
    Crew Salary || Dashboard
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
                    <form class="row mt-2 needs-validation" method="POST" action="{{ route('crew.salary.insert.submit') }}"
                        enctype="multipart/form-data">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @csrf
                        <input type="hidden" id="ship_id" name="ship_id" class="form-control"
                            value="{{ $crew->ship_id }}">
                        <input type="hidden" id="crew_id" name="crew_id" class="form-control"
                            value="{{ $crew->id }}">

                        <div class="row mb-3">
                            <label for="ship_id" class="form-label">Month</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="month" id="month" required>
                                    <option value="">Select an option</option>
                                    @for ($month = 1; $month <= 12; $month++)
                                        @php
                                            $monthName = \Carbon\Carbon::create(null, $month, 1)->monthName;
                                        @endphp
                                        <option value="{{ $month }}">{{ $monthName }}</option>
                                    @endfor
                                </select>
                            </div>
                            @error('ship_id')
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
