@extends('layouts.dashboard')
@section('title')
    Profile || Dashboard
@endsection
@section('content')
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{ auth()->user()->image != '' ? asset('uploads/profile' . '/' . auth()->user()->image) : asset('assets/img/profile-img.jpg') }}"
                            alt="{{ auth()->user()->name }}" class="rounded-circle">
                        <h2>{{ auth()->user()->name }}</h2>
                        <h3>{{ auth()->user()->role ? 'Editor' : 'Admin' }}</h3>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">


                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                    Profile</button>
                            </li>


                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-change-password">Change Password</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">



                            <div class="tab-pane fade show active profile-edit" id="profile-edit">

                                <!-- Profile Edit Form -->
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <div class="row mb-3">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                        Image</label>
                                    <div class="col-md-8 col-lg-9">
                                        <img id="previewImage"
                                            src="{{ auth()->user()->image != '' ? asset('uploads/profile' . '/' . auth()->user()->image) : asset('assets/img/profile-img.jpg') }}"
                                            alt="Profile">
                                        <!-- Input for selecting a file -->
                                        <input type="file" id="fileInput" style="display: none;">
                                        <div class="pt-2">
                                            <a href="javascript:void(0)" id="uploadButton" class="btn btn-primary btn-sm"
                                                title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                            <a href="javascript:void(0)" id="removeuploadButton"
                                                class="btn btn-danger btn-sm" title="Remove my profile image"><i
                                                    class="bi bi-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('profile.update') }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="email"
                                                value="{{ auth()->user()->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="name" type="text" class="form-control" id="name"
                                                value="{{ auth()->user()->name }}">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->

                            </div>



                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form method="POST" action="{{ route('profile.password.update') }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="currentpassword" class="col-md-4 col-lg-3 col-form-label">Current
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="currentpassword" type="password" class="form-control"
                                                id="currentpassword" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newpassword" class="col-md-4 col-lg-3 col-form-label">New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="newpassword" type="password" class="form-control" id="newpassword"
                                                required>
                                        </div>
                                    </div>



                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection;
@section('script')
    <script>
        $(document).ready(function() {

            $('a#uploadButton').click(function() {
                $('#fileInput').click();
            });

            $('#fileInput').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        // Update the source of the preview image
                        $('#previewImage').attr('src', e.target.result);
                        // Show the preview image
                        $('#previewImage').show();
                    };
                    // Read the selected file as a data URL
                    reader.readAsDataURL(input.files[0]);

                    // Perform Ajax Image Upload when a file is selected
                    var token = $("meta[name='csrf-token']").attr("content");
                    var formData = new FormData();
                    formData.append('image', input.files[0]);
                    formData.append('_token', token);
                    $.ajax({
                        url: "{{ route('profile.picture.update') }}",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            // Handle the success response
                            var typeOfResponse = response.type;
                            var res = response.msg;
                            if (typeOfResponse == 0) {
                                swal('Error', res, 'error');
                            } else if (typeOfResponse == 1) {
                                swal({
                                    title: 'Success',
                                    text: res,
                                    icon: 'success',
                                    type: 'success',
                                    showCancelButton: false, // There won't be any cancel button
                                    showConfirmButton: true // There won't be any confirm button
                                }).then((ok) => {
                                    if (ok) {
                                        location.reload();
                                    }
                                });
                            }
                            // Display the uploaded image
                        },
                        error: function(error) {
                            // Handle the error response
                            console.log(error);
                        }
                    });
                }
            });

            $('a#removeuploadButton').click(function() {
                $.ajax({
                    url: "{{ route('profile.picture.remove') }}",
                    type: 'GET',
                    data: {
                        id: 1
                    },
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        // Handle the success response
                        var typeOfResponse = response.type;
                        var res = response.msg;
                        if (typeOfResponse == 0) {
                            swal('Error', res, 'error');
                        } else if (typeOfResponse == 1) {
                            swal({
                                title: 'Success',
                                text: 'Image is removed',
                                icon: 'success',
                                type: 'success',
                                showCancelButton: false, // There won't be any cancel button
                                showConfirmButton: true // There won't be any confirm button
                            }).then((ok) => {
                                if (ok) {
                                    location.reload();
                                }
                            });
                            $('#previewImage').attr('src', res);
                            $('#previewImage').show();
                        }
                        // Display the uploaded image
                    },
                    error: function(error) {
                        // Handle the error response
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection
