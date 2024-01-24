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
                    <h4 class="card-title">Crew List</h5>
                        <div class="card-header-action">
                            <a href="{{ route('crew.add') }}" class="btn btn-primary btn-sm">Add Crew
                            </a>
                        </div>
                </div>
                <div class="card-body">
                    <div class="mt-3 table-responsive">
                        <table class="table datatable table-striped table-hover" id="table-1" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Rank</th>
                                    <th>Joining Date</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($crew as $row)
                                    <tr>
                                        <td>
                                            {{ $i++ }}
                                        </td>
                                        <td>
                                            {{ $row->name }}
                                        </td>
                                        <td>
                                            {{ $row->rank }}
                                        </td>
                                        <td>
                                            {{ $row->join_date }}
                                        </td>
                                        <td>
                                            <img src="{{ $row->image != '' ? asset('uploads/crew') . '/' . $row->image : asset('assets/img/profile-img.jpg') }}"
                                                class="rounded-circle" width="30px">
                                        </td>
                                        <td>
                                            <a href="{{ route('crew.salary.load', $row->id) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="bi bi-currency-dollar"></i>
                                            </a>
                                            <a href="{{ route('crew.edit', $row->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger" id="deleteCrew"
                                                data-id="{{ $row->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $("#table-1").on("click", "button#deleteCrew", function() {
                var id = $(this).data("id");
                swal({
                        title: 'Are you sure?',
                        text: "Once deleted, you will not be able to recover",
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var token = $("meta[name='csrf-token']").attr("content");
                            var url = '{{ url('/crew/delete') }}' + '/' + id;
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "id": id,
                                    "_token": token,
                                },
                                beforeSend: function() {
                                    $(".loader").show();
                                },
                                complete: function() {
                                    $(".loader").hide();
                                },
                                success: function(response) {
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
                                            })
                                            .then((ok) => {
                                                if (ok) {
                                                    location.reload();
                                                }
                                            });
                                    }
                                }
                            });
                        }
                    });
            });
        });
    </script>
@endsection
