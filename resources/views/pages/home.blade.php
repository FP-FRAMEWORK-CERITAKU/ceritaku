@extends('layouts.default')

@push('css-custom')
    <style>
        .faq-search{
            background-size:cover;
            background-color:rgba(115,103,240,.12)!important
        }
        .faq-search .faq-search-input .input-group:focus-within{
            box-shadow:none
        }
        .faq-contact .faq-contact-card{
            background-color:rgba(186,191,199,.12)
        }
        @media (min-width:992px){
            .faq-search .card-body{
                padding:8rem!important
            }
        }
        @media (min-width:768px) and (max-width:991.98px){
            .faq-search .card-body{
                padding:6rem!important
            }
        }
        @media (min-width:768px){
            .faq-search .faq-search-input .input-group{
                width:576px;
                margin:0 auto
            }
            .faq-navigation{
                height:550px
            }
        }
    </style>
@endpush

@section('content')
<section id="dashboard-section">
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

    <div class="card faq-search" style="background-image: url({{ asset('app-assets/images/banner/banner.png') }})">
        <div class="card-body text-center">
            <!-- subtitle -->
            <p class="card-text mb-2">Masukkan keyword</p>

            <!-- search input -->
            <form action="{{ route('cerita.index') }}">
                <div class="faq-search-input">
                    <div class="input-group input-group-merge">
                        <div class="input-group-text">
                            <i data-feather="search"></i>
                        </div>
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Si kancil anak nakal"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
