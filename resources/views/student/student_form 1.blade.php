<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Student Registration — CBBS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      /* Logo colors */
      --brand-blue:#1e3357;
      --brand-blue-2:#29476f;
      --brand-red:#bf2135;
      --brand-red-2:#d4464f;
      --footer-top:#13283a;
      --footer-bot:#102232;
    }

    body{background:#f6f8fb;}

    /* ====== HERO (slightly smaller) ====== */
    .hero{
      position:relative; overflow:hidden; color:#fff;
      background: linear-gradient(110deg, var(--brand-blue) 0%, var(--brand-blue-2) 45%, var(--brand-red-2) 75%, var(--brand-red) 100%);
      padding: 2.25rem 1rem 3.75rem; /* reduced height */
      text-align:center;
      border-bottom-left-radius: 2rem;
      border-bottom-right-radius: 2rem;
      box-shadow: 0 8px 28px rgba(0,0,0,.18);
    }
    .hero::before,.hero::after{content:"";position:absolute;filter:blur(60px);opacity:.25;pointer-events:none}
    .hero::before{width:420px;height:420px;top:-120px;left:-140px;background:radial-gradient(closest-side,#fff,transparent 65%)}
    .hero::after{width:460px;height:460px;right:-160px;top:-80px;background:radial-gradient(closest-side,#ffd3d6,transparent 65%)}
    .hero .sheen{position:absolute;inset:0;transform:skewY(-2deg);background:linear-gradient(120deg,rgba(255,255,255,.06),rgba(255,255,255,0) 30%,rgba(255,255,255,.06) 60%,rgba(255,255,255,0) 85%);pointer-events:none}
    .hero .wave{position:absolute;left:0;right:0;bottom:-1px;line-height:0}
    .hero .wave svg{display:block;width:100%;height:48px}
    .hero .wave path{fill:#f6f8fb}
    .logo-badge{width:108px;height:108px;margin:0 auto .55rem;display:grid;place-items:center;border-radius:999px;background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.45);box-shadow:0 12px 26px rgba(0,0,0,.22),inset 0 0 0 6px rgba(255,255,255,.08);backdrop-filter:blur(6px)}
    .logo-badge img{width:78px;height:78px;object-fit:contain}
    .brand-title{font-weight:800;letter-spacing:.2px;margin:0}
    .brand-sub{opacity:.9;font-size:.95rem;margin-top:.15rem}

    /* ====== LAYOUT ====== */
    .wrap-container{max-width:1320px}
    .content-col{max-width:100%} /* remove old cap so form can widen */

    /* Banners */
    .ad-banner{background:#fff;border:1px solid #eef1f5;border-radius:.75rem;overflow:hidden;box-shadow:0 6px 16px rgba(16,24,40,.06)}
    .ad-banner a{display:block}
    .ad-banner img{width:100%;height:auto;display:block}
    @media (min-width:992px){.ad-sticky{position:sticky;top:1rem}}

    /* ====== FORM CARD ====== */
    .card-modern{border:0;border-radius:1rem;box-shadow:0 10px 30px rgba(16,24,40,.08)}
    .card-modern .card-header{
      /* SOLID logo red – no gradient */
      background: var(--brand-red);
      color:#fff;
      border-radius:1rem 1rem 0 0;
    }
    .section{padding:1.25rem;background:#fff;border:1px solid #eef1f5;border-radius:.75rem;margin-bottom:1rem}
    .section-title{font-weight:700;font-size:1.05rem;margin:0 0 .75rem;color:#23344a}
    .required::after{content:" *";color:#dc3545}
    .form-control:focus,.form-select:focus{border-color:#3f6da5;box-shadow:0 0 0 .2rem rgba(63,109,165,.25)}
    @media (max-width:576px){.btn-lg{padding:.75rem 1.1rem;font-size:1rem}}

    /* ====== FOOTER ====== */
    .site-footer{background:var(--footer-top);color:#e6eef5}
    .site-footer .footer-top{padding:1.5rem 0}
    .site-footer h6{font-weight:700;font-size:1.05rem;margin-bottom:.6rem;color:#fff}
    .site-footer .small,.site-footer a{color:#d6e2ea;text-decoration:none}
    .site-footer a:hover{color:#fff}
    .footer-bottom{background:var(--footer-bot);padding:.65rem 0}
    .footer-logo{height:40px;width:auto}
  </style>
</head>
<body>

  <!-- HERO -->
  <header class="hero">
    <div class="sheen"></div>
    <div class="container">
      <div class="logo-badge">
        <img src="{{ asset('assets/images/logo.png') }}" alt="CBBS">
      </div>
      <h1 class="brand-title h4">Colombo Bartender &amp; Barista School</h1>
      <div class="brand-sub">Admissions &amp; Registration</div>
    </div>
    <div class="wave">
      <svg viewBox="0 0 1440 56" preserveAspectRatio="none"><path d="M0,32 C240,64 480,0 720,16 C960,32 1200,72 1440,24 L1440,56 L0,56 Z"/></svg>
    </div>
  </header>

  <main class="container wrap-container my-3 my-lg-4">
    <div class="row g-4 align-items-start justify-content-center">

      <!-- LEFT BANNER (desktop) -->
      {{-- <aside class="col-lg-2 d-none d-lg-block">
        <div class="ad-banner ad-sticky">
          <a href="{{ $companyWebsite ?? 'https://example.com' }}" target="_blank" rel="noopener">
            <img src="{{ asset('assets/images/Banner web.jpg') }}" alt="CBBS Promotion Left">
          </a>
        </div>
      </aside> --}}

      <!-- FORM (now wider: col-lg-8) -->
      <section class="col-12 col-lg-8 content-col">
        <div class="card card-modern">
          <div class="card-header">
            <h4 class="mb-1">Student Registration Form</h4>
            <div class="small opacity-75">Please complete all required fields</div>
          </div>

          <div class="card-body">
            @if (session('message'))
              <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <form method="POST" action="{{ route('students.store') }}" class="needs-validation" novalidate>
              @csrf
              <input type="hidden" name="name" id="nameHidden" value="">

              <!-- Personal Details -->
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
                      <option {{ old('gender')==='Male'?'selected':'' }}>Male</option>
                      <option {{ old('gender')==='Female'?'selected':'' }}>Female</option>
                      <option {{ old('gender')==='Other'?'selected':'' }}>Other</option>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Contact -->
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

              <!-- Addresses -->
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

              <!-- Enrollment -->
              <div class="section">
                <h6 class="section-title">Enrollment</h6>
                <div class="row g-3">
                  <div class="col-12 col-md-4">
                    <label for="course_id" class="form-label required">Course</label>
                    <select name="course_id" id="course_id" class="form-select" required>
                      <option value="" disabled {{ old('course_id') ? '' : 'selected' }}>-- Select Course --</option>
                      @foreach(($course ?? []) as $item)
                        <option value="{{ $item->course_id }}" {{ old('course_id')==$item->course_id ? 'selected' : '' }}>
                          {{ $item->course_name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-12 col-md-4">
                    <label for="branch_id" class="form-label required">Branch</label>
                    <select name="branch_id" id="branch_id" class="form-select" required>
                      <option value="" disabled {{ old('branch_id') ? '' : 'selected' }}>-- Select Branch --</option>
                      @foreach(($branch ?? []) as $item)
                        <option value="{{ $item->branch_id }}" {{ old('branch_id')==$item->branch_id ? 'selected' : '' }}>
                          {{ $item->branch_name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-12 col-md-4">
                    <label for="batch_id" class="form-label required">Batch</label>
                    <select name="batch_id" id="batch_id" class="form-select" required>
                      <option value="" disabled {{ old('batch_id') ? '' : 'selected' }}>-- Select Batch --</option>
                      @foreach(($batch ?? []) as $item)
                        <option value="{{ $item->batch_id }}" {{ old('batch_id')==$item->batch_id ? 'selected' : '' }}>
                          {{ $item->batch_no }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-success btn-lg" id="submitBtn">Submit Registration</button>
              </div>
            </form>
          </div>
        </div>

        <!-- MOBILE BANNER (after form on small screens) -->
        <div class="ad-banner d-lg-none mt-3">
          <a href="{{ $companyWebsite ?? 'https://example.com' }}" target="_blank" rel="noopener">
            <img src="{{ asset('assets/images/Banner mobile.jpg') }}" alt="CBBS Promotion Mobile">
          </a>
        </div>
      </section>

      <!-- RIGHT BANNER (desktop) -->
      {{-- <aside class="col-lg-2 d-none d-lg-block">
        <div class="ad-banner ad-sticky">
          <a href="{{ $companyWebsite ?? 'https://example.com' }}" target="_blank" rel="noopener">
            <img src="{{ asset('assets/images/Banner web.jpg') }}" alt="CBBS Promotion Right">
          </a>
        </div>
      </aside> --}}
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="site-footer mt-4">
    <div class="footer-top">
      <div class="container">
        <div class="row g-4">
          <div class="col-12 col-lg-4">
            <h6>Navigation</h6>
            <ul class="list-unstyled small mb-0">
              <li class="mb-1"><a href="#">Bartending Course</a></li>
              <li class="mb-1"><a href="#">Barista Course</a></li>
              <li class="mb-1"><a href="#">Bartending Course – (Fast Track)</a></li>
              <li class="mb-1"><a href="#">Barista Course – (Fast Track)</a></li>
              <li class="mb-1"><a href="#">Contact Us</a></li>
              <li class="mb-1"><a href="#">News</a></li>
              <li class="mb-1"><a href="#">Locations</a></li>
            </ul>
          </div>

          <div class="col-12 col-lg-4">
            <h6>Locations</h6>
            <div class="small mb-3">No. 15B 1/2, Alfred Place,<br>Colombo 03.<br>077 202 8750</div>
            <div class="small mb-3">No. 67, Walukarama Road,<br>Colombo 03.<br>077 718 0275</div>
            <div class="small">No: 446/5, Peradeniya Road,<br>Kandy.<br>074 394 2648</div>
          </div>

          <div class="col-12 col-lg-4">
            <h6>Contact Us</h6>
            <div class="small mb-2"><strong>Alfred Place</strong><br>Office : +94 11 799 9480<br>HotLine : +94 077 202 8750</div>
            <div class="small mb-2"><strong>Walukarama Road</strong><br>Office : +94 11 237 2824<br>HotLine : +94 77 718 0275</div>
            <div class="small mb-2"><strong>Kandy</strong><br>HotLine : +94 74 394 2648</div>
            <div class="small mb-3"><strong>Kurunegala</strong><br>HotLine : +94 76 663 0721</div>
            <div class="small">E-mail : <a href="mailto:hi@barbistaschool.com">hi@barbistaschool.com</a></div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="container d-flex flex-column align-items-center gap-2">
        <img src="{{ asset('assets/images/logo.png') }}" alt="CBBS" class="footer-logo">
        <div class="small text-center">Colombo Bartender &amp; Barista School © {{ date('Y') }} / All Rights Reserved</div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Copy mobile -> WhatsApp
    document.getElementById('copyMobile')?.addEventListener('click', function(e){
      e.preventDefault();
      const m = document.getElementById('mobile');
      const w = document.getElementById('whatsapp');
      if (m && w) w.value = m.value;
    });
    // Build hidden 'name' from first/last (backend unchanged)
    document.getElementById('submitBtn')?.addEventListener('click', function(){
      const first = (document.getElementById('first_name')?.value || '').trim();
      const last  = (document.getElementById('last_name')?.value || '').trim();
      const hidden = document.getElementById('nameHidden');
      if (hidden) hidden.value = (first + ' ' + last).trim();
    });
  </script>
</body>
</html>
