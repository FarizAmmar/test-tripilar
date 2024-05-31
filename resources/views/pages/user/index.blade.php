@extends('layouts.app')

@section('main-content')
    <h1 class="h3 mb-3"><strong>Menu User</strong></h1>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col mt-0">
                    <h5 class="card-title">User</h5>
                </div>
                @if (auth()->user()->role->role_name == 'ADMIN')
                    <div class="col-auto">
                        <button class="btn btn-sm btn-primary" onclick="newUser()">Add New</button>
                    </div>
                @endif
            </div>
            <table class="mb-3 table" id="user-table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Company</th>
                        <th scope="col">Role</th>
                        @if (auth()->user()->role->role_name == 'ADMIN')
                            <th scope="col">Action</th>
                        @endif
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal New -->
    <div class="modal fade" id="newUserModal" tabindex="-1" aria-labelledby="newUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newUserModalLabel">New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newUserForm">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="userName" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="userEmail" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="userRole" class="form-label">Role</label>
                            <select class="form-select" id="userRole" name="role">
                                <option value="" selected hidden>Choose an option</option>
                                @foreach ($role as $item)
                                    <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-end mb-3">
                            <button type="submit" class="btn btn-sm btn-success">Create New</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="userName" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="userEmail" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="userRole" class="form-label">Role</label>
                            <select class="form-select" id="userRole" name="role">
                                <option value="" selected hidden>Choose an option</option>
                                @foreach ($role as $item)
                                    <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-end mb-3">
                            <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Datatable
        $(document).ready(function() {
            let isAdmin = "{{ auth()->user()->role->role_name }}" === "ADMIN";

            let columns = [{
                    data: 'row_number',
                    name: 'row_number'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'role_name',
                    name: 'role_name'
                }
            ];

            if (isAdmin) {
                columns.push({
                    data: 'id',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <a class="btn btn-sm btn-warning edit-user" onclick="editUser(${data})">
                                <i class='bx bxs-edit'></i>
                            </a>
                            <button class="btn btn-sm btn-danger" onclick="deleteUser(${data})">
                                <i class='bx bx-trash-alt'></i>
                            </button>`;
                    }
                });
            }

            $('#user-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.list') }}",
                columns: columns,
                order: [
                    [0, 'asc']
                ]
            });
            $('#dt-length-0').removeClass('custom-select');
        });

        // Function new user
        function newUser() {
            $('#newUserForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('user.store') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    success: function(response) {
                        $('#newUserModal').modal('hide');
                        Swal.fire({
                            title: "Successfully!",
                            text: response[1],
                            icon: "success",
                            showConfirmButton: false,
                        });
                        setTimeout(function() {
                            window.location.href =
                                "{{ route('user.list') }}";
                        }, 2000);
                    },
                    error: function(xhr, status, error, response) {
                        console.error('Error creating new user:', error);
                    }
                });
            });
            $('#newUserModal').modal('show');
        }

        // Function edit user modal
        function editUser(id) {
            $.ajax({
                url: "fetch_user/" + id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#editUserModal #userName').val(data.data.name);
                    $('#editUserModal #userEmail').val(data.data.email);
                    $('#editUserModal #userRole').val(data.data.role_id);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching user data:', error);
                }
            });

            $('#editUserForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "update/" + id,
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        $('#newUserModal').modal('hide');
                        Swal.fire({
                            title: "Successfully!",
                            text: response[1],
                            icon: "success",
                            showConfirmButton: false,
                        });
                        setTimeout(function() {
                            window.location.href =
                                "{{ route('user.list') }}";
                        }, 2000);
                    },
                    error: function(xhr, status, error, response) {
                        console.error('Error creating new user:', error);
                    }
                });
            });

            $('#editUserModal').modal('show');
        }

        // Function delete user modal
        function deleteUser(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-sm btn-success me-3",
                    cancelButton: "btn btn-sm btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "delete/" + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            swalWithBootstrapButtons.fire({
                                title: "Deleted!",
                                text: response[1],
                                icon: "success",
                                showConfirmButton: false,
                            });
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('user.list') }}";
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching user data:', error);
                        }
                    });
                }
            });
        }
    </script>
@endpush
