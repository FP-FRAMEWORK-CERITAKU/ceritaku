@extends('layouts.default')

@push('css-vendor')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/wysiwyg/suneditor.min.css') }}">
@endpush
@push('js-page-vendor')
    <script src="{{ asset('app-assets/vendors/js/wysiwyg/suneditor.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/wysiwyg/langs/en.js') }}"></script>
@endpush
@push('js-page')
    <script>
        $(function () {
            const commentId = window.location.hash.replace('#', '');
            if (commentId) {
                scrollToElementId(commentId);
            }

            // onclick .reply-to
            $('.reply-to').on('click', function (e) {
                e.preventDefault();

                const commentId = $(this).data('reply-to-id');
                $('#reply_to_id').val(commentId);

                scrollToElementId('comment-form');
            });

            // onclick #reset_reply
            $('#reset_reply').on('click', function (e) {
                e.preventDefault();

                $('#reply_to_id').val('');
            });
        });
    </script>
@endpush

@section('content')
<div class="content-detached content-left">
    <div class="content-body">
        <!-- Blog Detail -->
        <div class="blog-detail-wrapper">
            <div class="row">
                <!-- Blog -->
                <div class="col-12">
                    <div class="card">
                        @php
                            $imageBackground = $data->getPhotoUrl() ?: asset('app-assets/images/slider/03.jpg');
                        @endphp
                        <img src="{{ $imageBackground }}" class="img-fluid card-img-top" alt="{{ $data->title }}" />
                        <div class="card-body">
                            <h4 class="card-title">{{ $data->title }}</h4>
                            <div class="d-flex">
                                @php
                                    $avatar = $data->creator->getPhotoUrl() ?: asset('app-assets/images/portrait/small/avatar-s-11.jpg');
                                @endphp
                                <div class="me-50">
                                    <div class="avatar">
                                        <img src="{{ $avatar }}" alt="{{ $data->creator->name }}" width="24" height="24" />
                                    </div>
                                </div>

                                <div class="author-info">
                                    <small class="text-muted me-25">by</small>
                                    <small><a href="#" class="text-body">{{ $data->creator->name }}</a></small>
                                    <span class="text-muted ms-50 me-25">|</span>
                                    @php
                                        $editedInfo = $data->isEdited()
                                            ? ' (Telah disunting)'
                                            : '';
                                    @endphp
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($data->updated_at)->format('d M, Y') . $editedInfo }}</small>
                                </div>
                            </div>
                            <div class="card-text mb-2 sun-editor-editable">{!! $data->content !!}</div>

                            <hr class="my-2" />
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center me-1">
                                        <a href="#" class="me-50">
                                            <i data-feather="message-square" class="font-medium-5 text-body align-middle"></i>
                                        </a>
                                        <a href="#">
                                            <div class="text-body align-middle">{{ \App\Helpers\Helper::numberKMBT($data->comments_count ?? 0) }} Komentar</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Blog -->

                <!-- Leave a Blog Comment -->
                @if(auth()->check())
                    <div class="col-12 mt-1">
                        <h6 class="section-label mt-25">Berikan Komentar</h6>
                        <div class="card" id="comment-form">
                            <div class="card-body">
                                <form action="{{ route('cerita.comment.store', $data->slug) }}" class="form" method="post">
                                    @csrf

                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="mb-2 d-flex align-items-center">
                                                <input
                                                    id="reply_to_id"
                                                    name="reply_to_id"
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Reply To #12345"
                                                    readonly
                                                />
                                                <a class="text-danger ms-50" href="#" id="reset_reply">
                                                    <div class="d-inline-flex align-items-center">
                                                        <i data-feather="trash" class="font-medium-3 me-50"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                        <textarea
                                            id="comment"
                                            name="comment"
                                            class="form-control mb-2"
                                            rows="4"
                                            placeholder="Masukan komentar anda"
                                            required
                                        ></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                <!--/ Leave a Blog Comment -->

                <!-- Blog Comment -->
                <div class="col-12 mt-1" id="blogComment">
                    <h6 class="section-label mt-25">Komentar</h6>
                    @forelse($data->comments as $comment)
                        <div class="card" id="comment{{ $comment->id }}">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="avatar me-75">
                                        @php
                                            $avatar = $comment->creator->getPhotoUrl() ?: asset('app-assets/images/portrait/small/avatar-s-11.jpg');
                                        @endphp
                                        <img src="{{ $avatar }}" width="38" height="38" alt="{{ $comment->creator->name }}" />
                                    </div>
                                    <div class="author-info w-100">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-bolder mb-25">{{ $comment->creator->name }}</h6>
                                            <a href="#comment{{ $comment->id }}">
                                                <i data-feather="hash"></i>
                                                <span>{{ $comment->id }}</span>
                                            </a>
                                        </div>

                                        <p class="card-text">{{ \Carbon\Carbon::parse($comment->updated_at)->format('d M, Y. H:i') }}</p>

                                        @if($comment->replied_by->count() > 0)
                                            <p class="card-text my-0">Dibalas oleh: #{{ $comment->replied_by->implode('id', ', ') }}</p>
                                        @endif
                                        @if($comment->reply_to)
                                            <p class="card-text my-0">Balasan untuk: #{{ $comment->reply_to->id }}</p>
                                        @endif

                                        <p class="card-text mt-2">{!! nl2br($comment->content) !!}</p>

                                        @if(auth()->check())
                                            <div class="d-flex">
                                                <a class="me-2 reply-to" href="#" data-reply-to-id="{{ $comment->id }}">
                                                    <div class="d-inline-flex align-items-center">
                                                        <i data-feather="corner-up-left" class="font-medium-3 me-50"></i>
                                                        <span>Balas</span>
                                                    </div>
                                                </a>

                                                @if($comment->creator_id == auth()->id() || auth()->user()->hasRoleSuperadmin())
                                                    <form action="{{ route('cerita.comment.destroy', [$data->slug, $comment->id]) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')

                                                        <a class="text-danger" href="#" onclick="this.closest('form').submit();return false;">
                                                            <div class="d-inline-flex align-items-center">
                                                                <i data-feather="trash" class="font-medium-3 me-50"></i>
                                                                <span>Hapus</span>
                                                            </div>
                                                        </a>
                                                    </form>
                                                @endif
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="author-info">
                                        <h6 class="fw-bolder mb-25">Belum ada komentar</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <!--/ Blog Comment -->

            </div>
        </div>
        <!--/ Blog Detail -->

    </div>
</div>

<div class="sidebar-detached sidebar-right">
    <div class="sidebar">
        <div class="blog-sidebar my-2 my-lg-0">
            <!-- Search bar -->
            <div class="blog-search">
                <form action="{{ route('cerita.index') }}">
                    <div class="input-group input-group-merge">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Cari judul"
                            name="search"
                        />
                        <span class="input-group-text cursor-pointer">
                        <i data-feather="search"></i>
                    </span>
                    </div>
                </form>
            </div>
            <!--/ Search bar -->

            <!-- Action -->
            <div class="mt-3">
                <h6 class="section-label">Aksi</h6>
                <div class="mt-75">
                    @if(auth()->check())
                        @if($data->creator_id == auth()->id() || auth()->user()->hasRoleSuperadmin())
                            <a role="button" href="{{ route('cerita.edit', $data->slug) }}" class="w-100 btn btn-flat-warning ms-auto mb-75">
                                <i data-feather="edit" class="me-25"></i>
                                <span>Edit Postingan</span>
                            </a>
                        @endif

                        @if($data->creator_id == auth()->id() || auth()->user()->hasRoleSuperadmin())
                            <form action="{{ route('cerita.destroy', $data->slug) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="w-100 btn btn-flat-danger ms-auto mb-75">
                                    <i data-feather="trash" class="me-25"></i>
                                    <span>Hapus Postingan</span>
                                </button>
                            </form>
                        @endif
                    @endif

                    <a role="button" href="{{ route('cerita.create') }}" class="w-100 btn btn-flat-success ms-auto mb-75">
                        <i data-feather="edit-2" class="me-25"></i>
                        <span>Buat Postingan</span>
                    </a>
                    <a role="button" href="{{ route('cerita.index', ['myposts' => true]) }}" class="w-100 btn btn-flat-info ms-auto">
                        <i data-feather="bookmark" class="me-25"></i>
                        <span>Postingan Saya</span>
                    </a>
                </div>
            </div>
            <!--/ Action -->

            <!-- Recent Posts -->
            <div class="blog-recent-posts mt-3">
                <h6 class="section-label">Postingan Terbaru</h6>
                <div class="mt-75">
                    @forelse($recentPosts as $item)
                        <div class="d-flex mb-2">
                            @php
                                $backgroundRecent = $item->getPhotoUrl() ?: asset('app-assets/images/banner/banner-39.jpg');
                            @endphp
                            <a href="{{ route('cerita.show', $item->slug) }}" class="me-2">
                                <img
                                    class="rounded"
                                    src="{{ $backgroundRecent }}"
                                    width="100"
                                    height="70"
                                    alt="{{ $item->title }}"
                                />
                            </a>
                            <div class="blog-info">
                                <h6 class="blog-recent-post-title">
                                    <a href="{{ route('cerita.show', $item->slug) }}" class="text-body-heading">{{ \App\Helpers\Helper::trimText($item->title) }}</a>
                                </h6>
                                <div class="text-muted mb-0">{{ \Carbon\Carbon::parse($item->created_at)->format('d M, Y') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="w-100 text-center">
                            <a href="#" class="section-label">Tidak ada postingan</a>
                        </div>
                    @endforelse
                </div>
            </div>
            <!--/ Recent Posts -->
        </div>
    </div>
</div>
@endsection
