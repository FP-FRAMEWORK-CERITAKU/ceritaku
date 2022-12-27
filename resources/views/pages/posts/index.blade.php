@extends('layouts.default')

@section('content')
<div class="content-detached content-left">
    <div class="content-body"><!-- Blog List -->
        <div class="blog-list-wrapper">
            <!-- Blog List Items -->
            <div class="row">
                @forelse($posts as $item)
                    <div class="col-md-6 col-12">
                        <div class="card">
                            @php
                                $background = empty($item->getPhotoUrl())
                                    ? asset('app-assets/images/slider/02.jpg')
                                    : $item->getPhotoUrl();
                            @endphp
                            <a href="{{ route('cerita.show', $item->slug) }}">
                                <img class="card-img-top img-fluid" src="{{ $background }}" alt="{{ $item->title }}" />
                            </a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="{{ route('cerita.show', $item->slug) }}" class="blog-title-truncate text-body-heading">{{ $item->title }}</a>
                                </h4>
                                <div class="d-flex">
                                    @php
                                        $avatar = empty($item->creator->photo ?? null)
                                            ? asset('app-assets/images/portrait/small/avatar-s-11.jpg')
                                            : Storage::url($item->creator->photo ?? null);
                                    @endphp
                                    <div class="me-50">
                                        <div class="avatar">
                                            <img src="{{ $avatar }}" alt="Avatar" width="24" height="24" />
                                        </div>
                                    </div>
                                    @php
                                        $editedInfo = $item->isEdited()
                                            ? ' (Telah disunting)'
                                            : '';
                                    @endphp
                                    <div class="author-info">
                                        <small class="text-muted me-25">oleh</small>
                                        <small><a href="#" class="text-body">{{ $item->creator->name ?? null }}</a></small>
                                        <span class="text-muted ms-50 me-25">|</span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($item->updated_at)->format('d M, Y') . $editedInfo }}</small>
                                    </div>
                                </div>

                                {{--<p class="card-text blog-content-truncate">{{ $item->content }}</p>--}}
                                <hr />
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#">
                                        <div class="d-flex align-items-center">
                                            <i data-feather="message-square" class="font-medium-1 text-body me-50"></i>
                                            <span class="text-body fw-bold">{{ \App\Helpers\Helper::numberKMBT($item->comments_count ?? 0) }} Komentar</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('cerita.show', $item->slug) }}" class="fw-bold">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="w-100 text-center">
                            <a href="#" class="section-label">Tidak ada postingan</a>
                        </div>
                    </div>
                @endforelse
            </div>
            <!--/ Blog List Items -->

            <!-- Pagination -->
            <div class="row">
                <div class="col-12">
                    {{ $posts->onEachSide(5)->links() }}
                </div>
            </div>
            <!--/ Pagination -->
        </div>
        <!--/ Blog List -->

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
                            value="{{ request('search') }}"
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
                                $backgroundRecent = empty($item->getPhotoUrl())
                                    ? asset('app-assets/images/banner/banner-39.jpg')
                                    : $item->getPhotoUrl();
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
                                <div class="text-muted mb-0">{{ \Carbon\Carbon::parse($item->updated_at)->format('d M, Y') }}</div>
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
