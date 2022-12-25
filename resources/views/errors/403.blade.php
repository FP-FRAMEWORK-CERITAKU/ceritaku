@extends('layouts.default')

@section('content')
    <!-- Not authorized-->
    <div class="misc-wrapper">
        <div class="misc-inner p-2 p-sm-3">
            <div class="w-100 text-center">
                <h2 class="mb-1">Tidak punya hak akses untuk sumber daya ini! 🔐</h2>
                <p class="mb-2">
                    Jika ini adalah sebuah kesalahan yang tidak seharusnya, maka anda dapat melaporkannya ke pengurus situs web.
                </p>
                <img class="img-fluid" src="{{ asset('app-assets/images/pages/not-authorized.svg') }}" alt="Not authorized page"/>
            </div>
        </div>
    </div>
    <!-- / Not authorized-->
@endsection
