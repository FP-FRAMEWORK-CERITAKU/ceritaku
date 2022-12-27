@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-12">
        <ul class="nav nav-pills mb-2">
            <!-- account -->
            <li class="nav-item">
                <a
                    class="nav-link active"
                    href="{{ route('profile.index') }}"
                >
                    <i data-feather="user" class="font-medium-3 me-50"></i>
                    <span class="fw-bold">Account</span>
                </a>
            </li>
        </ul>


        <!-- profile -->
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">Detail Profil</h4>
            </div>
            <div class="card-body py-2 my-25">
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

                <!-- header section -->
                <div class="d-flex mb-1">
                    @php
                        $avatar = $data->getPhotoUrl() ?: asset('app-assets/images/portrait/small/avatar-s-11.jpg');
                    @endphp
                    <div class="d-flex flex-column">
                        <a href="#" class="mb-1">
                            <img
                                src="{{ $avatar }}"
                                class="uploadedAvatar rounded"
                                alt="profile image"
                                height="100"
                                width="100"
                            />
                        </a>
                        <span class="badge bg-warning">{{ $data->roles->implode('name', ', ') }}</span>
                    </div>

                    <!-- upload and reset button -->
                    <div class="d-flex align-items-end mt-75 ms-1">
                        <div>
                            <form action="{{ route('profile.update-photo') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <label class="btn btn-sm btn-primary mb-75 me-75" for="photo">Unggah</label>
                                <input id="photo" type="file" name="photo" hidden accept="image/*" onchange="this.closest('form').submit();return false;"/>
                                <button type="submit" name="delete" value="1" class="btn btn-sm btn-outline-secondary mb-75">Hapus Foto</button>
                            </form>

                            {{--<div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>--}}
                            <p class="mb-0">Tipe gambar yang diperbolehkan: jpg, jpeg, png </p>
                            <p class="mb-0">Maksimal ukuran gambar: 2MB</p>
                        </div>
                    </div>
                    <!--/ upload and reset button -->
                </div>
                <!--/ header section -->

                <!-- form -->
                <form class="form form-horizontal" action="{{ route('profile.update') }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label">NAMA</label>
                                </div>
                                <div class="col-sm-9">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="name"
                                        value="{{ $data->name }}"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label">EMAIL</label>
                                </div>
                                <div class="col-sm-9">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="email"
                                        value="{{ $data->email }}"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Password</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group form-password-toggle input-group-merge">
                                        <input
                                            type="password"
                                            class="form-control"
                                            placeholder="Kosongkan jika tidak ingin mengubah"
                                            name="password"
                                        />
                                        <div class="input-group-text cursor-pointer">
                                            <i data-feather="eye"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Konfirmasi Password</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group form-password-toggle input-group-merge">
                                        <input
                                            type="password"
                                            class="form-control"
                                            placeholder="Kosongkan jika tidak ingin mengubah"
                                            name="password_confirmation"
                                        />
                                        <div class="input-group-text cursor-pointer">
                                            <i data-feather="eye"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary me-1">Simpan</button>
                        </div>
                    </div>
                </form>
                <!--/ form -->
            </div>
        </div>

    </div>
</div>
@endsection
