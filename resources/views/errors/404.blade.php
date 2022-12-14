@extends('layouts.default')

@section('content')
    <!-- Error page-->
    <div class="misc-wrapper">
        <div class="misc-inner p-2 p-sm-3">
            <div class="w-100 text-center">
                <h2 class="mb-1">Sumber daya tidak ditemukan 🕵🏻‍♀️</h2>
                <p class="mb-2">Jika ini adalah sebuah kesalahan yang tidak seharusnya, maka anda dapat melaporkannya ke pengurus situs web.</p>
                <img class="img-fluid" src="{{ asset('app-assets/images/pages/error.svg') }}" alt="Error page"/>
            </div>
        </div>
    </div>
    <!-- / Error page-->
@endsection
