@extends('layouts.default')

@push('css-custom')
    <style>
        #nav-container {
            width: 100%;
        }

        .input-group-text {
            background: #7367F0;
            color: #FFFFFF;
        }

        #header {
            height: 80%;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
            background: #7367F0;
            color: #FFFFFF;
        }

        .card-img-top {
            height: 250px;
        }
    </style>
@endpush

@section('content')
<nav class="navbar bg-light">
    <div class="d-flex justify-content-end align-items-center ms-3 me-3" id="nav-container">
        <div>
            <form class="d-flex" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari" aria-label="Cari" aria-describedby="basic-addon1">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                </div>
            </form>
        </div>
    </div>
</nav>

<div class="container text-center p-4" id="header">
    <h1>CeritaKu</h1>
    <h3>Sebuah tempat untuk mengembangkan karyamu menjadi sebuah cerita</h3>
    <br>
    <br>
    <h4>Baca dan tulis karyamu menjadi sebuah cerita disini</h4>
    <a href="#" class="btn btn-light mt-2" id="btn-start" role="button">Mulai Menulis</a>
</div>

<div class="container p-4" id="content">
    <div class="row justify-content-evenly">
        <div class="col">
            <div class="card">
                <a href="#">
                    <img class="card-img-top img-fluid" src="{{ asset('app-assets/images/banner/sejarah-majapahit.jpg') }}" alt="Sejarah Majapahit" />
                </a>
                <div class="card-body">
                    <h5 class="card-title">Sejarah Kerajaan Majapahit</h5>
                    <div class="d-flex align-items-center text-secondary" id="post-desc">
                        <div class="me-50">
                            <div class="avatar">
                                <img src="{{ asset('app-assets/images/banner/profile-1.jpg') }}" alt="Avatar" width="24" height="24" />
                            </div>
                        </div>
                        <p class="author">Alfa</p>
                        <p>|</p>
                        <p class="created-date">Desember 11, 2022</p>
                    </div>
                    <p class="card-text">Sejarah berdirinya Kerajaan Majapahit bermula dari permohonan Raden Jayawijaya kepada Jayakatwang untuk membuka hutan di daerah Tarik. Jayakatwang merupakan raja Kerajaan Gelanggelang. Ia adalah sosok yang berpengaruh terhadap keruntuhan Kerajaan Singasari.</p>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center" id="comment">
                            <i class="bi bi-chat-left-text-fill"></i>
                            <p class="text-secondary">9 Komentar</p>
                        </div>
                        <a href="#" class="btn btn-primary">Mulai Membaca</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <a href="#">
                    <img class="card-img-top img-fluid" src="{{ asset('app-assets/images/banner/malin-kundang.png') }}" alt="Malin Kundang" />
                </a>
                <div class="card-body">
                    <h5 class="card-title">Malin Kundang</h5>
                    <div class="d-flex align-items-center text-secondary" id="post-desc">
                        <div class="me-50">
                            <div class="avatar">
                                <img src="{{ asset('app-assets/images/banner/profile-2.jpg') }}" alt="Avatar" width="24" height="24" />
                            </div>
                        </div>
                        <p class="author">Beta</p>
                        <p>|</p>
                        <p class="created-date">Desember 13, 2022</p>
                    </div>
                    <p class="card-text">Sejarah berdirinya Kerajaan Majapahit bermula dari permohonan Raden Jayawijaya kepada Jayakatwang untuk membuka hutan di daerah Tarik. Jayakatwang merupakan raja Kerajaan Gelanggelang. Ia adalah sosok yang berpengaruh terhadap keruntuhan Kerajaan Singasari.</p>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center" id="comment">
                            <i class="bi bi-chat-left-text-fill"></i>
                            <p class="text-secondary">10 Komentar</p>
                        </div>
                        <a href="#" class="btn btn-primary">Mulai Membaca</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <a href="#">
                    <img class="card-img-top img-fluid" src="{{ asset('app-assets/images/banner/kancil-dan-buaya.jpg') }}" alt="Kancil dan Buaya" />
                </a>
                <div class="card-body">
                    <h5 class="card-title">Kancil & Buaya</h5>
                    <div class="d-flex align-items-center text-secondary" id="post-desc">
                        <div class="me-50">
                            <div class="avatar">
                                <img src="{{ asset('app-assets/images/banner/profile-3.jpg') }}" alt="Avatar" width="24" height="24" />
                            </div>
                        </div>
                        <p class="author">Charlie</p>
                        <p>|</p>
                        <p class="created-date">Desember 10, 2022</p>
                    </div>
                    <p class="card-text">Disebuah hutan belantara yang luas, tinggal beraneka ragam satwa. Salah satunya seekor kancil. Kancil yang satu ini dikenal memiliki kecerdikan yang luar biasa. Tak hanya cerdik, kancil pun dikenal sebagai satwa yang ramah akan sesama.</p>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center" id="comment">
                            <i class="bi bi-chat-left-text-fill"></i>
                            <p class="text-secondary">5 Komentar</p>
                        </div>
                        <a href="#" class="btn btn-primary">Mulai Membaca</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
