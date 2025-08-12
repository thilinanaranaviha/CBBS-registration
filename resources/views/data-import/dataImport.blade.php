@php
    $id = session('id');
    $role = session('role');
@endphp

@if (!empty($id))

    @if (\Illuminate\Support\Facades\Auth::id() == $id)
        <!doctype html>
        <html lang="en">

        <head>

            @include('Layout.appStyles')
            <title>Admin | CBBS | Student Registration </title>

            <style>
                .custom-select {
                    width: 100%;
                    padding: 10px;
                    font-size: 14px;
                    border: 1px solid #ced4da;
                    border-radius: 4px;
                    background-color: #fff;
                    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
                    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                }

                .custom-select:focus {
                    border-color: #80bdff;
                    outline: 0;
                    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                }

                .form-control-file {
                    width: 100%;
                    padding: 5px;
                    font-size: 14px;
                    border: 1px solid #ced4da;
                    border-radius: 4px;
                    background-color: #f8f9fa;
                    margin-top: 10px;
                }

                .btn-primary {
                    background-color: #007bff;
                    border-color: #007bff;
                    transition: background-color 0.3s ease;
                }

                .btn-primary:hover {
                    background-color: #0056b3;
                    border-color: #004085;
                }
            </style>


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
                        {{-- <div class="container-fluid"> --}}
                        <div class="container mt-2 mb-5">
                            <div class="card shadow-sm">
                                <div class="card-header"
                                    style="background-color: #1d3557; color: #f1faee; font-family: 'Poppins', sans-serif;">
                                    <h4 class="mb-0" style="font-weight: 600; color: #f1faee;">Student Registration
                                        Form</h4>
                                </div>

                                <div class="card-body">
                                    @if (session('message'))
                                        <div class="alert alert-success">{{ session('message') }}</div>
                                    @endif

                                    <form method="POST" action="{{ route('students.store') }}">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="student_id" class="form-label">Student ID <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="student_id" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Student Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="citizenship" class="form-label">Citizenship <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="citizenship" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="nic_number" class="form-label">NIC Number <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="nic_number" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="certificate_name" class="form-label">Name on Certificate
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" name="certificate_name" class="form-control"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="gender" class="form-label">Gender <span
                                                        class="text-danger">*</span></label>
                                                <select name="gender" class="form-select" required>
                                                    <option value="" disabled selected>-- Select --</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                    <option>Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="mobile" class="form-label">Mobile Number</label>
                                                <input type="text" name="mobile" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="whatsapp" class="form-label">WhatsApp Number</label>
                                                <input type="text" name="whatsapp" class="form-control">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" name="email" class="form-control">
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="contact_address" class="form-label">Contact Address</label>
                                                <textarea name="contact_address" rows="2" class="form-control"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="permanent_address" class="form-label">Permanent
                                                    Address</label>
                                                <textarea name="permanent_address" rows="2" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="course_id" class="form-label">Course <span
                                                        class="text-danger">*</span></label>
                                                <select name="course_id" class="form-select">
                                                    <option value="" disabled selected>-- Select Course --
                                                    </option>
                                                    @if (!empty($course))
                                                    @foreach ($course as $item)
                                                        <option value="{{ $item->course_id }}">
                                                            {{ $item->course_name }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="branch_id" class="form-label">Branch <span
                                                        class="text-danger">*</span></label>
                                                <select name="branch_id" class="form-select">
                                                    <option value="" disabled selected>-- Select Branch --
                                                    </option>
                                                    @if (!empty($branch))
                                                    @foreach ($branch as $item)
                                                        <option value="{{ $item->branch_id }}">
                                                            {{ $item->branch_name }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="batch_id" class="form-label">Batch <span
                                                        class="text-danger">*</span></label>
                                                <select name="batch_id" class="form-select">
                                                    <option value="" disabled selected>-- Select Batch --
                                                    </option>
                                                    @if (!empty($batch))
                                                    @foreach ($batch as $item)
                                                        <option value="{{ $item->batch_id }}">{{ $item->batch_no }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-success btn-lg">Submit
                                                Registration</button>
                                        </div>

                                    </form>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}
                </div>



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

        </html>
    @else
        @include('Layout.notValidateUser')
    @endif
@else
    @include('Layout.noUser')
@endif
