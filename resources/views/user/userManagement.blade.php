@php
    $id = session('id');
    $role = session('role');
@endphp

@if (!empty($id))

    @if (\Illuminate\Support\Facades\Auth::id() == $id && $role == 'Admin')

        <!doctype html>
        <html lang="en">

        <head>

            @include('Layout.appStyles')
            <title>Admin | CBBS | User Management</title>


        </head>

        <body data-sidebar="dark">

            <!-- Begin page -->
            <div id="layout-wrapper">


                {{--    Header --}}
                @include('Layout.header')

                {{--    End Header --}}

                <!-- Left Sidebar Start  -->
                @include('Layout.sidebar')
                <!-- Left Sidebar End -->



                <!-- ============================================================== -->
                <!-- Start right Content here -->
                <!-- ============================================================== -->
                <div class="main-content">

                    <div class="page-content">
                        <div class="container-fluid">

                            <!-- start page title -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0 font-size-18">Users</h4>

                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a>
                                                </li>
                                                <li class="breadcrumb-item active">User Management</li>
                                            </ol>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- end page title -->

                            <div class="row">
                                <div class="col-md-3">
                                    <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                        data-bs-target="#userAddModal">Add User</button>
                                </div>
                            </div>
                            <br>
                            @if (session()->has('message'))
                                <div class="col-md-4">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session()->get('message') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                            @foreach ($errors->all() as $error)
                                <div class="col-md-4">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $error }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endforeach

                            <br>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="scrollme">
                                                <table id="datatable-buttons"
                                                    class="table table-responsive nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Contact</th>
                                                            <th>Role</th>
                                                            {{-- <th>Branch</th> --}}
                                                            <th></th>
                                                            <th></th>

                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        @if (!empty($data))
                                                            @foreach ($data as $item)
                                                                @if ($item->id != $id)
                                                                    @if ($item->isActive == 1)
                                                                        <tr>
                                                                            <td>{{ $item->name }}</td>
                                                                            <td>{{ $item->email }}</td>
                                                                            <td>{{ $item->contact }}</td>
                                                                            <td>{{ $item->role }}</td>
                                                                            {{-- <td>{{$item->branchName}}</td> --}}

                                                                            <td><a href="{{ url('disableUser') . $item->id }}"
                                                                                    class="btn btn-outline-warning btn-sm waves-effect waves-light">Disable
                                                                                    User</a> </td>
                                                                            <td><button data-bs-toggle="modal"
                                                                                    data-bs-target="#resetPassword"
                                                                                    data-id="{{ $item->id }}"
                                                                                    class="btn btn-outline-danger btn-sm waves-effect waves-light">Reset
                                                                                    Password</button> </td>
                                                                        </tr>
                                                                    @else
                                                                        <tr style="color: red">
                                                                            <td>{{ $item->name }}</td>
                                                                            <td>{{ $item->email }}</td>
                                                                            <td>{{ $item->contact }}</td>
                                                                            <td>{{ $item->role }}</td>
                                                                            <td>{{ $item->branchName }}</td>
                                                                            <td class="text-danger">Disabled</td>
                                                                            <td></td>
                                                                        </tr>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>



                        </div>
                        <!-- container-fluid -->
                    </div>
                    <!-- End Page-content -->


                    {{--        Modals --}}

                    {{--        Add User modal --}}

                    <div id="userAddModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0" id="myModalLabel">Add User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addUserForm" action="{{ url('addUser') }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="mb-3">
                                            <label for="" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>
                                                <span class="error text-danger small" id="email_error"></span>

                                        </div>
                                        <div class="mb-3">
                                            <label for="contact" class="form-label">Contact Number</label>
                                            <input type="number" class="form-control" id="contact" name="contact"
                                                required>
                                                <span class="error text-danger small" id="contact_error"></span>

                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Role</label>
                                            <select name="role" id="role" class="form-select">
                                                <option value="Admin">Admin</option>
                                                <option value="Manager">Manager</option>
                                                <option value="Sales">Sales</option>
                                            </select>
                                        </div>


                                        <div class="mb-3">
                                            <button type="submit"
                                                class="btn btn-primary waves-effect waves-light">Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-danger waves-effect waves-light"
                                        data-bs-dismiss="modal">Close</button>

                                </div>

                            </div>
                        </div>
                    </div>

                    {{--        password reset modal --}}
                    <div id="resetPassword" class="modal fade" tabindex="-1" aria-labelledby="resetPassword"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0" id="myModalLabel">Reset Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('resetPassword') }}" method="post"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="text" class="form-control" id="id" name="id"
                                            hidden required>

                                        <div class="mb-3">
                                            <label for="" class="form-label">Enter Password</label>
                                            <input type="password" class="form-control" id="pwd"
                                                name="pwd" required>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit"
                                                class="btn btn-primary waves-effect waves-light">Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button"class="btn btn-outline-danger waves-effect waves-light"
                                        data-bs-dismiss="modal">Close</button>

                                </div>

                            </div>
                        </div>
                    </div>
                    {{--        End password reset modal --}}

                    {{--        End add user modal --}}


                    {{--        End Modals --}}




                    {{--        Footer --}}
                    @include('Layout.footer')
                    {{--        End Footer --}}
                </div>
                <!-- end main content-->

            </div>
            <!-- END layout-wrapper -->

            <!-- Right Sidebar -->
            @include('Layout.rightSideBar')
            <!-- /Right-bar -->

            <!-- Right bar overlay-->
            <div class="rightbar-overlay"></div>

            @include('Layout.appJs')
        </body>
        <script>
            $('#resetPassword').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget)
                let id = button.data('id')

                let modal = $(this)
                modal.find('.modal-body #id').val(id);
            });
        </script>
        <script>
             document.addEventListener('DOMContentLoaded', function () {
                    // List of forms to handle
                    const forms = ['addUserForm'];
              // Error messages
              const errors = {

                        contact: 'Contact Number is required in the correct Sri Lankan format.',

                    };
            forms.forEach((formId) => {
                const form = document.getElementById(formId);
                if (form) {
                    const submitButton = form.querySelector('button[type="submit"]');
                    const inputs = form.querySelectorAll('input, select');

                    // Add input listeners for each field
                    inputs.forEach(input => {
                        input.addEventListener('input', () => {
                            validateField(formId, input);
                            validateForm(form, submitButton);
                        });
                    });

                    // Validate individual field
                    function validateField(formId, field) {
                        const errorElementId = `${field.id}_error`;
                        const errorElement = document.getElementById(errorElementId);

                        if (!field.value.trim()) {
                            errorElement.textContent = errors[field.id];
                            field.classList.add('is-invalid');
                        } else if (field.id.endsWith('email') && !validateEmail(field.value)) {
                            errorElement.textContent = errors[field.id];
                            field.classList.add('is-invalid');
                        } else if ((field.id.endsWith('contact')) && !validateSriLankanPhone(field.value)) {
                            errorElement.textContent = errors[field.id];
                            field.classList.add('is-invalid');
                        } else {
                            errorElement.textContent = '';
                            field.classList.remove('is-invalid');
                        }
                    }

                    // Validate the entire form
                    function validateForm(form, submitButton) {
                        const invalidFields = form.querySelectorAll('.is-invalid');
                        submitButton.disabled = invalidFields.length !== 0;
                    }

                    // Email validation
                    function validateEmail(email) {
                        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        return re.test(email);
                    }

                    // Phone validation
                    function validateSriLankanPhone(phone) {
                        const sriLankanMobilePattern = /^07[0-9]{8}$/; // Mobile numbers
                        const sriLankanLandlinePattern = /^0\d{2}\d{7}$/; // Landline numbers
                        return sriLankanMobilePattern.test(phone) || sriLankanLandlinePattern.test(phone);
                    }


                }
            });
        });
        </script>

        </html>
    @else
        @include('Layout.notValidateUser')
    @endif
@else
    @include('Layout.notValidateUser')
@endif
