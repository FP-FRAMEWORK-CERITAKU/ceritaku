@extends('layouts.default')

@section('content')
    <div class="auth-wrapper auth-basic mx-2 col d-flex justify-content-center">
        <div class="auth-inner my-2 col-5">
            <!-- Register basic -->
            <div class="card mb-0">
                <div class="card-body">
                    <a href="#" class="brand-logo">
                        <h2 class="brand-text text-primary">Ceritaku</h2>
                    </a>

                    @if (Session::has('message'))
                        <div class="alert alert-{{ session('status') }}" role="alert">
                            <div class="alert-body">{{ session('message') }}</div>
                        </div>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                <div class="alert-body">{{ $error }}</div>
                            </div>
                        @endforeach
                    @endif

                    <form class="auth-register-form mt-2" action="{{ route('auth.register') }}" method="post">
                        @csrf

                        <div class="mb-1">
                            <label for="register-name" class="form-label">Nama</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="John Doe"
                                aria-describedby="register-name"
                                tabindex="1"
                                autofocus
                                name="name"
                            />
                        </div>
                        <div class="mb-1">
                            <label for="register-username" class="form-label">Email</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="example@example.com"
                                aria-describedby="register-username"
                                tabindex="1"
                                autofocus
                                name="email"
                            />
                        </div>

                        <div class="mb-1">
                            <label for="register-password" class="form-label">Password</label>

                            <div class="input-group input-group-merge form-password-toggle">
                                <input
                                    type="password"
                                    class="form-control form-control-merge"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="register-password"
                                    tabindex="3"
                                    name="password"
                                />
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>

                        <div class="mb-1">
                            <label for="register-password-confirmation" class="form-label">Konfirmasi Password</label>

                            <div class="input-group input-group-merge form-password-toggle">
                                <input
                                    type="password"
                                    class="form-control form-control-merge"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="register-password-confirmation"
                                    tabindex="3"
                                    name="password_confirmation"
                                />
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" tabindex="5">Daftar</button>
                    </form>

                    <p class="text-center mt-2">
                        <span>Sudah memiliki akun?</span>
                        <a href="{{ route('auth.login') }}">
                            <span>Masuk disini</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- /Register basic -->
        </div>
    </div>
@endsection
