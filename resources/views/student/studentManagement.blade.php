@php
    $id = session('id');
    $role = session('role');
    // dd($data)
@endphp

@if (!empty($id))

    @if (\Illuminate\Support\Facades\Auth::id() == $id)
        <!doctype html>
        <html lang="en">

        <head>

            @include('Layout.appStyles')
            <title>Admin | CBBS | Student Management</title>


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
                                        <h4 class="mb-sm-0 font-size-18">Student</h4>

                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Student</a>
                                                </li>
                                                <li class="breadcrumb-item active">Student Management</li>
                                            </ol>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- end page title -->

                            {{-- <div class="row">
                                <div class="col-md-3">
                                    <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                        data-bs-target="#customerAddModal">Add Student</button>


                                </div>

                            </div> --}}

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
                            @if (session()->has('error'))
                                <div class="col-md-4">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session()->get('error') }}
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
                                                    class="table table-bordered dt-responsive  nowrap w-100">

                                                    <thead>
                                                        <tr>
                                                            <th>Student ID</th>
                                                            <th>Name</th>
                                                            <th>NIC</th>
                                                            <th>Email</th>
                                                            <th>Gender</th>
                                                            <th>Mobile</th>
                                                            <th>Whatsapp</th>
                                                            <th>Contact Address</th>
                                                            <th>Batch ID</th>
                                                            <th>Is Fast Track</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data as $item)
                                                            <tr>
                                                                <td>{{ $item->student_id }}</td>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ $item->nic_number }}</td>
                                                                <td>{{ $item->email }}</td>
                                                                <td>{{ $item->gender }}</td>
                                                                <td>{{ $item->mobile }}</td>
                                                                <td>{{ $item->whatsapp }}</td>
                                                                <td>{{ $item->contact_address }}</td>
                                                                <td>{{ $item->batch_no }}</td>
                                                                <td>{{ $item->isFastTrack }}</td>
                                                                <td>
                                                                    <button
                                                                        class="btn btn-outline-info btn-sm waves-effect waves-light"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#studentEditModal"
                                                                        data-studentid="{{ $item->student_id }}"
                                                                        data-name="{{ $item->name }}"
                                                                        data-nic="{{ $item->nic_number }}"
                                                                        data-email="{{ $item->email }}"
                                                                        data-gender="{{ $item->gender }}"
                                                                        data-contactnumber="{{ $item->mobile }}"
                                                                        data-whatsappnumber="{{ $item->whatsapp }}"
                                                                        data-address="{{ $item->contact_address }}"
                                                                        data-batchid="{{ $item->batch_id }}"
                                                                        >Edit</button>
                                                                    <a href="{{ url('/deleteStudent/' . $item->id) }}"
                                                                        class="btn btn-outline-danger btn-sm waves-effect waves-light"
                                                                        onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
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

                    <!-- Start student add model -->
                    <div id="customerAddModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0" id="myModalLabel">Add Student</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addStudentForm" action="{{ url('addStudent') }}" method="post"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <!-- Student ID -->
                                        <div class="mb-3">
                                            <label for="student_id" class="form-label">Student ID</label>
                                            <input type="text" class="form-control" id="student_id" name="student_id"
                                                required>
                                            <span class="error text-danger small" id="student_id_error"></span>
                                        </div>

                                        <!-- Student Name -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Student Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                required>
                                            <span class="error text-danger small" id="name_error"></span>
                                        </div>

                                        <!-- NIC -->
                                        <div class="mb-3">
                                            <label for="nic" class="form-label">NIC/Passport Number</label>
                                            <input type="text" class="form-control" id="nic" name="nic"
                                                required>
                                            <span class="error text-danger small" id="nic_error"></span>
                                        </div>

                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>
                                            <span class="error text-danger small" id="email_error"></span>
                                        </div>

                                        <!-- Gender -->
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select id="gender" name="gender" class="form-control input sm"
                                                required>
                                                <option value="" disabled selected>-- Select Gender --</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            <span class="error text-danger small" id="gender_error"></span>
                                        </div>

                                        <!-- Contact Number -->
                                        <div class="mb-3">
                                            <label for="contact_number" class="form-label">Contact Number</label>
                                            <input type="tel" class="form-control" id="contact_number"
                                                name="contact_number" required>
                                            <span class="error text-danger small" id="contact_number_error"></span>
                                        </div>

                                        <!-- WhatsApp Number -->
                                        <div class="mb-3">
                                            <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                                            <input type="tel" class="form-control" id="whatsapp_number"
                                                name="whatsapp_number" required>
                                            <span class="error text-danger small" id="whatsapp_number_error"></span>
                                        </div>


                                        <!-- Address -->
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                required>
                                            <span class="error text-danger small" id="address_error"></span>
                                        </div>

                                        <!-- Branch Name -->
                                        <div class="mb-3">
                                            <label for="branch_id" class="form-label">Branch Name</label>
                                            <select id="branch_id" name="branch_id" class="form-control input sm"
                                                required>
                                                <option value="" disabled selected>-- Select Branch --</option>
                                                @if (!empty($branch))
                                                    @foreach ($branch as $item)
                                                        <option value="{{ $item->branch_id }}">
                                                            {{ $item->branch_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="error text-danger small" id="branch_id_error"></span>
                                        </div>

                                        <!-- Course Name -->
                                        <div class="mb-3">
                                            <label for="course_id" class="form-label">Course Name</label>
                                            <select id="course_id" name="course_id" class="form-control input sm"
                                                required>
                                                <option value="" disabled selected>-- Select Course --</option>
                                                @if (!empty($course))
                                                    @foreach ($course as $item)
                                                        <option value="{{ $item->course_id }}">
                                                            {{ $item->course_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="error text-danger small" id="course_id_error"></span>
                                        </div>

                                        <!-- Batch Name -->
                                        <div class="mb-3">
                                            <label for="batch_id" class="form-label">Batch Name</label>
                                            <select id="batch_id" name="batch_id" class="form-control input sm"
                                                required>
                                                <option value="" disabled selected>-- Select Batch --</option>
                                                @if (!empty($batch))
                                                    @foreach ($batch as $item)
                                                        <option value="{{ $item->batch_id }}">{{ $item->batch_no }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="error text-danger small" id="batch_id_error"></span>
                                        </div>

                                        <!-- Modal Footer -->
                                        <div class="modal-footer">
                                            <button type="submit" id="submitButton"
                                                class="btn btn-primary waves-effect waves-light" disabled>Save</button>
                                            <button type="button"
                                                class="btn btn-outline-danger waves-effect waves-light"
                                                data-bs-dismiss="modal">Close</button>
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
                    {{--        End student add model --}}

                    {{--        Start student edit model --}}
                    <div id="studentEditModal" class="modal fade" tabindex="-1" role="dialog"
                        aria-labelledby="studentEditModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0" id="myModalLabel">Edit Student</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editStudentForm" action="{{ url('editStudent') }}" method="post"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="text" class="form-control" id="student_id" name="student_id"
                                            hidden>

                                        <!-- Form Fields -->
                                        <div class="mb-3">
                                            <label for="student_id" class="form-label">Student Id</label>
                                            <input type="text" class="form-control" id="edit_student_id"
                                                name="student_id" readonly>
                                            <span class="error text-danger small" id="edit_student_id_error"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Student Name</label>
                                            <input type="text" class="form-control" id="edit_name" name="name"
                                                required>
                                            <span class="error text-danger small" id="edit_name_error"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="nic" class="form-label">NIC</label>
                                            <input type="text" class="form-control" id="edit_nic" name="nic"
                                                required>
                                            <span class="error text-danger small" id="edit_nic_error"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="edit_email"
                                                name="email" required>
                                            <span class="error text-danger small" id="edit_email_error"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select id="edit_gender" name="gender" class="form-control input-sm">
                                                <option value="" disabled selected> -- Select Gender -- </option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            <span class="error text-danger small" id="edit_gender_error"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="contact_number" class="form-label">Contact Number</label>
                                            <input type="text" class="form-control" id="edit_contact_number"
                                                name="contact_number" required>
                                            <span class="error text-danger small"
                                                id="edit_contact_number_error"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="whatsapp_number" class="form-label">Whatsapp Number</label>
                                            <input type="text" class="form-control" id="edit_whatsapp_number"
                                                name="whatsapp_number" required>
                                            <span class="error text-danger small"
                                                id="edit_whatsapp_number_error"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="edit_address"
                                                name="address" required>
                                            <span class="error text-danger small" id="edit_address_error"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="branch_id" class="form-label">Branch Name</label>
                                            <select id="edit_branch_id" name="branch_id"
                                                class="form-control input-sm">
                                                <option value="" disabled selected> -- Select Branch -- </option>
                                                @if (!empty($branch))
                                                    @foreach ($branch as $item)
                                                        <option value="{{ $item->branch_id }}">
                                                            {{ $item->branch_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="error text-danger small" id="edit_branch_id_error"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="course_id" class="form-label">Course Name</label>
                                            <select id="edit_course_id" name="course_id"
                                                class="form-control input-sm">
                                                <option value="" disabled selected> -- Select Course -- </option>
                                                @if (!empty($course))
                                                    @foreach ($course as $item)
                                                        <option value="{{ $item->course_id }}">
                                                            {{ $item->course_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="error text-danger small" id="edit_course_id_error"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="batch_id" class="form-label">Batch Name</label>
                                            <select id="edit_batch_id" name="batch_id" class="form-control input-sm">
                                                <option value="" disabled selected> -- Select Batch -- </option>
                                                @if (!empty($batch))
                                                    @foreach ($batch as $item)
                                                        <option value="{{ $item->batch_id }}">{{ $item->batch_no }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="error text-danger small" id="edit_batch_id_error"></span>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit"
                                                class="btn btn-primary waves-effect waves-light">Save</button>
                                            <button type="button"
                                                class="btn btn-outline-danger waves-effect waves-light"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End student edit model --}}

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

            <script>
                $('#studentEditModal').on('show.bs.modal', function(event) {
                    let button = $(event.relatedTarget);

                    // Retrieve data from button attributes
                    let student_id = button.data('studentid');
                    let name = button.data('name');
                    let nic = button.data('nic');
                    let email = button.data('email');
                    let gender = button.data('gender');
                    let contact_number = button.data('contactnumber');
                    let whatsapp_number = button.data('whatsappnumber');
                    let address = button.data('address');
                    let branch_id = button.data('branchid');
                    let course_id = button.data('courseid');
                    let batch_id = button.data('batchid');

                    // Find modal elements and set values
                    let modal = $(this);
                    modal.find('.modal-body #edit_student_id').val(student_id);
                    modal.find('.modal-body #edit_name').val(name);
                    modal.find('.modal-body #edit_nic').val(nic);
                    modal.find('.modal-body #edit_email').val(email);
                    modal.find('.modal-body #edit_gender').val(gender);
                    modal.find('.modal-body #edit_contact_number').val(contact_number);
                    modal.find('.modal-body #edit_whatsapp_number').val(whatsapp_number);
                    modal.find('.modal-body #edit_address').val(address);
                    modal.find('.modal-body #edit_branch_id').val(branch_id);
                    modal.find('.modal-body #edit_course_id').val(course_id);
                    modal.find('.modal-body #edit_batch_id').val(batch_id);
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // List of forms to handle
                    const forms = ['addStudentForm', 'editStudentForm'];

                    // Error messages
                    const errors = {
                        student_id: 'Student ID is required and must follow the format: Letters/Letters/Numbers/Numbers.',
                        name: 'Name is required.',
                        nic: 'NIC or Passport number is required in the correct format.',
                        email: 'Valid email is required.',
                        gender: 'Please select a gender.',
                        contact_number: 'Contact Number is required in the correct Sri Lankan format.',
                        whatsapp_number: 'WhatsApp Number is required in the correct Sri Lankan format.',
                        address: 'Address is required.',
                        branch_id: 'Please select a branch.',
                        course_id: 'Please select a course.',
                        batch_id: 'Please select a batch.',
                        edit_student_id: 'Invalid Student ID format',
                        edit_name: 'Student name is required',
                        edit_nic: 'Invalid NIC or passport number',
                        edit_email: 'Invalid email address',
                        edit_gender: 'Gender selection is required',
                        edit_contact_number: 'Invalid Sri Lankan phone number format',
                        edit_whatsapp_number: 'Invalid Sri Lankan phone number format',
                        edit_address: 'Address is required',
                        edit_branch_id: 'Branch selection is required',
                        edit_course_id: 'Course selection is required',
                        edit_batch_id: 'Batch selection is required'
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
                                } else if (field.id.endsWith('nic') && !validateNIC(field.value)) {
                                    errorElement.textContent = errors[field.id];
                                    field.classList.add('is-invalid');
                                } else if ((field.id.endsWith('contact_number') || field.id.endsWith(
                                        'whatsapp_number')) && !validateSriLankanPhone(field.value)) {
                                    errorElement.textContent = errors[field.id];
                                    field.classList.add('is-invalid');
                                } else if (field.id.endsWith('student_id') && !validateStudentID(field.value)) {
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

                            // NIC validation
                            function validateNIC(nic) {
                                const oldNicPattern = /^[0-9]{9}[vVxX]$/; // Old NIC format
                                const newNicPattern = /^[0-9]{12}$/; // New NIC format
                                const passportPattern = /^[A-Z0-9]{8,10}$/; // Passport format
                                return oldNicPattern.test(nic) || newNicPattern.test(nic) || passportPattern.test(
                                    nic);
                            }

                            // Phone validation
                            function validateSriLankanPhone(phone) {
                                const sriLankanMobilePattern = /^07[0-9]{8}$/; // Mobile numbers
                                const sriLankanLandlinePattern = /^0\d{2}\d{7}$/; // Landline numbers
                                return sriLankanMobilePattern.test(phone) || sriLankanLandlinePattern.test(phone);
                            }

                            // Student ID validation
                            function validateStudentID(student_id) {
                                const studentIDPattern =
                                    /^[A-Z]+\/[A-Z]+\/\d{2,}\/\d{2,}$/; // Allows formats like MBC/CW/44/01 or BMMC/CW/44/123
                                return studentIDPattern.test(student_id);
                            }
                        }
                    });
                });
            </script>


        </body>

        </html>
    @else
        @include('Layout.notValidateUser')
    @endif
@else
    @include('Layout.noUser')
@endif
