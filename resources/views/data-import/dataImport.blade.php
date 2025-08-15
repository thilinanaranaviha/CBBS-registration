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
            <title>Admin | CBBS | Student Registration</title>

            <style>
                body{background:#f6f8fb;}
                .card-modern{border:0;border-radius:1rem;box-shadow:0 10px 30px rgba(16,24,40,.06);}
                .card-modern .card-header{border-radius:1rem 1rem 0 0;background:linear-gradient(135deg,#1d3557,#457b9d);color:#fff;}
                .card-modern .card-header h4{font-weight:600;margin:0;}
                .section{padding:1.25rem;background:#fff;border:1px solid #eef1f5;border-radius:.75rem;margin-bottom:1.25rem;}
                .section-title{font-weight:600;font-size:1.05rem;margin:0 0 .75rem;display:flex;align-items:center;gap:.5rem}
                /* removed dot */
                .required::after{content:" *";color:#dc3545}
                @media (max-width: 576px){
                    .btn-lg{padding:.75rem 1.1rem;font-size:1rem}
                }
            </style>
        </head>

        <body data-sidebar="dark">
        <div id="layout-wrapper">
            @include('Layout.header')
            @include('Layout.sidebar')

            <div class="main-content">
                <div class="page-content">
                    <div class="container mt-2 mb-5">
                        <div class="card card-modern">
                            <div class="card-header" style="color: #fff;">
                                <h4 style="color: #fff; margin: 0;">Student Registration Form</h4>
                                <div class="small opacity-75" style="color: #fff;">Please complete all required fields</div>
                            </div>

                            <div class="card-body">
                                @if (session('message'))
                                    <div class="alert alert-success">{{ session('message') }}</div>
                                @endif

                                <form method="POST" action="{{ route('students.store') }}" class="needs-validation" novalidate>
                                    @csrf
                                    <input type="hidden" name="name" id="nameHidden" value="">

                                    {{-- Personal Details --}}
                                    <div class="section">
                                        <h6 class="section-title">Personal Details</h6>
                                        <div class="row g-3">
                                            <div class="col-12 col-md-4">
                                                <label for="student_id" class="form-label required">Student ID</label>
                                                <input type="text" name="student_id" id="student_id" class="form-control" required value="{{ old('student_id') }}">
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="first_name" class="form-label required">First Name</label>
                                                <input type="text" id="first_name" class="form-control" required value="{{ old('first_name') }}">
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="last_name" class="form-label required">Last Name</label>
                                                <input type="text" id="last_name" class="form-control" required value="{{ old('last_name') }}">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="citizenship" class="form-label required">Citizenship</label>
                                                <input type="text" name="citizenship" id="citizenship" class="form-control" required value="{{ old('citizenship') }}">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="nic_number" class="form-label required">NIC Number</label>
                                                <input type="text" name="nic_number" id="nic_number" class="form-control" required
                                                       placeholder="199012345678 or 901234567V"
                                                       pattern="^(\d{9}[VvXx]|\d{12})$" value="{{ old('nic_number') }}">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="certificate_name" class="form-label required">Name on Certificate</label>
                                                <input type="text" name="certificate_name" id="certificate_name" class="form-control" required value="{{ old('certificate_name') }}">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="gender" class="form-label required">Gender</label>
                                                <select name="gender" id="gender" class="form-select" required>
                                                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>-- Select --</option>
                                                    <option {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                                    <option {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Contact --}}
                                    <div class="section">
                                        <h6 class="section-title">Contact</h6>
                                        <div class="row g-3">
                                            <div class="col-12 col-md-4">
                                                <label for="mobile" class="form-label">Mobile Number</label>
                                                <input type="text" name="mobile" id="mobile" class="form-control"
                                                       placeholder="+9471XXXXXXX or 071XXXXXXX"
                                                       pattern="^(?:\+94|0)?7\d{8}$" value="{{ old('mobile') }}">
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="whatsapp" class="form-label">WhatsApp Number</label>
                                                <input type="text" name="whatsapp" id="whatsapp" class="form-control"
                                                       pattern="^(?:\+94|0)?7\d{8}$" value="{{ old('whatsapp') }}">
                                                <div class="form-text"><a href="#" id="copyMobile">Same as mobile</a></div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" name="email" id="email" class="form-control"
                                                       value="{{ old('email') }}" placeholder="name@example.com">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Addresses --}}
                                    <div class="section">
                                        <h6 class="section-title">Addresses</h6>
                                        <div class="row g-3">
                                            <div class="col-12 col-lg-6">
                                                <label for="contact_address" class="form-label">Contact Address</label>
                                                <textarea name="contact_address" id="contact_address" rows="2" class="form-control">{{ old('contact_address') }}</textarea>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="permanent_address" class="form-label">Permanent Address</label>
                                                <textarea name="permanent_address" id="permanent_address" rows="2" class="form-control">{{ old('permanent_address') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Enrollment --}}
                                    <div class="section">
                                        <h6 class="section-title">Enrollment</h6>
                                        <div class="row g-3">
                                            <div class="col-12 col-md-4">
                                                <label for="course_id" class="form-label required">Course</label>
                                                <select name="course_id" id="course_id" class="form-select" required>
                                                    <option value="" disabled {{ old('course_id') ? '' : 'selected' }}>-- Select Course --</option>
                                                    @if (!empty($course))
                                                        @foreach ($course as $item)
                                                            <option value="{{ $item->course_id }}" {{ old('course_id') == $item->course_id ? 'selected' : '' }}>
                                                                {{ $item->course_name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="branch_id" class="form-label required">Branch</label>
                                                <select name="branch_id" id="branch_id" class="form-select" required>
                                                    <option value="" disabled {{ old('branch_id') ? '' : 'selected' }}>-- Select Branch --</option>
                                                    @if (!empty($branch))
                                                        @foreach ($branch as $item)
                                                            <option value="{{ $item->branch_id }}" {{ old('branch_id') == $item->branch_id ? 'selected' : '' }}>
                                                                {{ $item->branch_name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="batch_id" class="form-label required">Batch</label>
                                                <select name="batch_id" id="batch_id" class="form-select" required>
                                                    <option value="" disabled {{ old('batch_id') ? '' : 'selected' }}>-- Select Batch --</option>
                                                    @if (!empty($batch))
                                                        @foreach ($batch as $item)
                                                            <option value="{{ $item->batch_id }}" {{ old('batch_id') == $item->batch_id ? 'selected' : '' }}>
                                                                {{ $item->batch_no }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                            Submit Registration
                                        </button>
                                    </div>
                                </form>

                                @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
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
            </div>

            @include('Layout.footer')
        </div>

        @include('Layout.rightSideBar')
        <div class="rightbar-overlay"></div>
        @include('Layout.appJs')

        <script>
            document.getElementById('copyMobile')?.addEventListener('click', function(e){
                e.preventDefault();
                const m = document.getElementById('mobile');
                const w = document.getElementById('whatsapp');
                if (m && w) w.value = m.value;
            });
            document.getElementById('submitBtn')?.addEventListener('click', function(){
                const first = (document.getElementById('first_name')?.value || '').trim();
                const last  = (document.getElementById('last_name')?.value || '').trim();
                const hidden = document.getElementById('nameHidden');
                if (hidden) hidden.value = (first + ' ' + last).trim();
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
