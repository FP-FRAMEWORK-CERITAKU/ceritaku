@extends('layouts.default')

@section('content')
    <section  style="background-color:#82868B;">
        <div class="container py-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <!-- <div class="col-md-6 col-lg-5 d-none d-md-block">
                              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp"
                                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div> -->
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form>

                                        <!-- <div class="d-flex align-items-center mb-3 pb-1">
                                          <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                          <span class="h1 fw-bold mb-0">Selamat datang di CeritaKu!</span>
                                        </div> -->

                                        <h5 class="fw-bold mb-3 pb-3" style="letter-spacing: 1px;">Selamat datang di CeritaKu!</h5>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example17">Email</label>
                                            <input type="email"
                                                   placeholder="Masukkan email"
                                                   id="form2Example17" class="form-control form-control-lg" />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example27">Password</label>
                                            <input type="password" id="form2Example27" class="form-control form-control-lg" />
                                        </div>

                                        <div class="d-grid gap-2 mb-4">
                                            <button class="btn  btn-block" type="button"
                                                    style="background-color:#7367F0; color: #FFFFFF;">Masuk</button>
                                        </div>

                                        <p class="small text-muted" href="#!">Belum punya akun?
                                            <a href="#!"
                                               style="color: blue;">Buat akun</a>
                                        </p>
                                        <!-- <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="#!"
                                            style="color: #393f81;">Register here</a></p> -->
                                        <!-- <a href="#!" class="small text-muted">Terms of use.</a>
                                        <a href="#!" class="small text-muted">Privacy policy</a> -->
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

