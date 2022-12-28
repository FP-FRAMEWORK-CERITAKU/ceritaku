@extends('layouts.default')

@section('content')
    <div class="auth-wrapper auth-basic mx-2 col d-flex justify-content-center">
        <div class="auth-inner my-2 col-5">
            <div class="card mb-0">
                <div class="card-body">
                    <a href="#" class="brand-logo">
                        <h2 class="brand-text text-primary">Ceritaku</h2>
                    </a>

                    <p class="card-text mb-2">Silahkan login dengan akun yang anda punya</p>

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

                    <form action="{{ route('auth.login') }}" class="auth-login-form mt-2" method="post">
                        @csrf
                        <div class="mb-1">
                            <label for="login-email" class="form-label">Email</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="email@email.com"
                                tabindex="1"
                                autofocus
                                name="email"
                            />
                        </div>

                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="login-password">Password</label>
                                {{--<a href="{{ route('auth.forgot') }}">
                                    <small>Lupa Password?</small>
                                </a>--}}
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input
                                    type="password"
                                    class="form-control form-control-merge"
                                    tabindex="2"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    name="password"
                                />
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" tabindex="4">Masuk</button>
                    </form>

                    <p class="text-center mt-2">
                        <span>Belum punya akun?</span>
                        <a href="{{ route('auth.register') }}">
                            <span>Segera daftar</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
