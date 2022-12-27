@extends('layouts.default')

@push('css-vendor')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/wysiwyg/suneditor.min.css') }}">
@endpush

@push('js-page-vendor')
    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/wysiwyg/suneditor.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/wysiwyg/langs/en.js') }}"></script>
@endpush

@push('js-page')
    <script>
        $(function (){
            var select = $('.select2');
            select.each(function () {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>');
                $this.select2({
                    // the following code is used to disable x-scrollbar when click in select input and
                    // take 100% width in responsive also
                    dropdownAutoWidth: true,
                    width: '100%',
                    dropdownParent: $this.parent()
                });
            });

            var editorOptions = {
                'width': 'auto',
                'height': 'auto',
                'textTags': {
                    'bold': 'b',
                    'underline': 'u',
                    'italic': 'i',
                    'strike': 's'
                },
                'mode': 'classic',
                'rtl': false,
                'katex': 'window.katex',
                'charCounter': true,
                'font': [
                    'Montserrat'
                ],
                'fontSize': [
                    8,
                    10,
                    14,
                    18,
                    24,
                    36
                ],
                'formats': [
                    'p',
                    'blockquote',
                    'h1',
                    'h2',
                    'h3'
                ],
                'colorList': [
                    [
                        '#ff0000',
                        '#ff5e00',
                        '#ffe400',
                        '#abf200'
                    ],
                    [
                        '#00d8ff',
                        '#0055ff',
                        '#6600ff',
                        '#ff00dd'
                    ]
                ],
                'imageFileInput': false,
                'imageAccept': '.jpg, .png, .jpeg',
                'videoFileInput': false,
                'tabDisable': false,
                'linkTargetNewWindow': true,
                'linkRel': [
                    'author',
                    'external',
                    'help',
                    'license',
                    'next',
                    'follow',
                    'nofollow',
                    'noreferrer',
                    'noopener',
                    'prev',
                    'search',
                    'tag'
                ],
                'lineHeights': [
                    {
                        'text': 'Single',
                        'value': 1
                    },
                    {
                        'text': 'Double',
                        'value': 2
                    }
                ],
                'paragraphStyles': [
                    'spaced',
                    {
                        'name': 'Box',
                        'class': '__se__customClass'
                    }
                ],
                'textStyles': [
                    'translucent',
                    {
                        'name': 'Emphasis',
                        'style': '-webkit-text-emphasis: filled;',
                        'tag': 'span'
                    }
                ],
                'placeholder': 'Ketik cerita anda',
                'mediaAutoSelect': false,
                'buttonList': [
                    [
                        'undo',
                        'redo',
                        'fontSize',
                        'formatBlock',
                        'paragraphStyle',
                        'blockquote',
                        'bold',
                        'underline',
                        'italic',
                        'strike',
                        'subscript',
                        'superscript',
                        'fontColor',
                        'hiliteColor',
                        'textStyle',
                        'removeFormat',
                        'outdent',
                        'indent',
                        'align',
                        'horizontalRule',
                        'list',
                        'lineHeight',
                        'table',
                        'link',
                        'image',
                        'video',
                        'audio',
                        'math',
                        'fullScreen',
                        'showBlocks',
                        'codeView',
                        'preview',
                        'print',
                    ]
                ],
                'lang': SUNEDITOR_LANG.en,
                'lang(In nodejs)': 'en'
            };
            var editor = SUNEDITOR.create((document.getElementById('editor') || 'editor'), editorOptions);
            editor.onChange = function (contents, core) {
                $('[name="content"]').html(contents);
            };
            editor.setDefaultStyle('font-family: "Montserrat", Helvetica, Arial, serif; font-size: 10px;');
        });
    </script>
@endpush

@section('content')
<div class="blog-edit-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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

                    <div class="d-flex align-items-start">
                        @php
                            $avatar = !empty($user->getPhotoUrl())
                                ? $user->getPhotoUrl()
                                : asset('app-assets/images/portrait/small/avatar-s-11.jpg');
                        @endphp
                        <div class="avatar me-75">
                            <img src="{{ $avatar }}" width="38" height="38" alt="Avatar" />
                        </div>
                        <div class="author-info">
                            <h6 class="mb-25">{{ $user->name }}</h6>
                            <p class="card-text">{{ \Carbon\Carbon::now()->format('d M, Y') }}</p>
                        </div>
                    </div>
                    <!-- Form -->
                    <form action="{{ route('cerita.store') }}" method="post" class="mt-2" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-2">
                                    <label class="form-label" for="blog-edit-title">Judul</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="title"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-2">
                                    <label class="form-label">Status Terbit</label>
                                    <select class="select2 form-select" name="is_publish" required>
                                        <option value="0">Tidak</option>
                                        <option value="1" selected>Ya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-2">
                                    <label class="form-label">Content</label>
                                    <textarea id="editor" class="editor" name="content"></textarea>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="border rounded p-2">
                                    <h4 class="mb-1">Foto Latar</h4>
                                    <div class="d-flex flex-column flex-md-row">
                                        <img
                                            src="{{ asset('app-assets/images/slider/03.jpg') }}"
                                            class="rounded me-2 mb-1 mb-md-0"
                                            width="170"
                                            height="110"
                                            alt="Blog Featured Image"
                                        />
                                        <div class="featured-info">
                                            <small class="text-muted">Disarankan gambar dengan resolusi 800x400.</small>
                                            <br>
                                            <div class="d-inline-block">
                                                <input name="photo_background" class="form-control" type="file" accept="image/*" required />
                                                {{--<div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-50">
                                <button type="submit" class="btn btn-primary me-1">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <!--/ Form -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
