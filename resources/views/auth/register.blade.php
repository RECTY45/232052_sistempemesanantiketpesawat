<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon/monte-logo.svg') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('vendor/css/pages/page-auth.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('vendor/js/helpers.js') }}"></script>

</head>

<body>
    <!-- Content -->

    <div class="container-xxl d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div
            class="authentication-wrapper authentication-basic container d-flex justify-content-center align-items-center">
            <div class="authentication-inner" style="max-width: 440px; width: 100%;">
                <!-- Register -->
                <div class="card shadow-lg border-0 rounded-4" style="overflow: hidden;">
                    <div class="card-body p-4">

                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show p-3" role="alert"
                                id="success-alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show p-3" role="alert" id="error-alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session()->has('warning'))
                            <div class="alert alert-warning alert-dismissible fade show p-3" role="alert"
                                id="warning-alert">
                                {{ session('warning') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session()->has('info'))
                            <div class="alert alert-info alert-dismissible fade show p-3" role="alert" id="info-alert">
                                {{ session('info') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-3">
                            <a href="#" class="app-brand-link gap-2 text-decoration-none">
                                <span class="app-brand-logo demo">
                                    <img src="{{ asset('img/favicon/travelo-logo.svg') }}" alt="Travelo Logo"
                                        class="block mx-auto pb-2" style="width: 170px; height: auto;">
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <h4 class="mb-2 text-center">Daftar ke {{ $name }} ‹</h4>
                        <p class="mb-4 text-center">Silakan daftar untuk membuat akun dan mulai petualangan Anda</p>

                        <form id="formAuthentication" class="mb-3" action="{{ route('register.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" placeholder="Masukkan Nama Anda" autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" placeholder="Masukkan Email Anda">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="••••••••••••" aria-describedby="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" placeholder="••••••••••••"
                                        aria-describedby="password_confirmation">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me">
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Daftar</button>
                            </div>
                        </form>

                        <p class="text-center mb-0">
                            <span>Sudah punya akun?</span>
                            <a href="{{ route('AuthLogin') }}">
                                <span>Masuk di sini</span>
                            </a>
                        </p>

                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->

</body>

</html>