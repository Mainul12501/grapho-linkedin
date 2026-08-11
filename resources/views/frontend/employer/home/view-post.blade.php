@extends('frontend.employer.master')

@section('title', $post->title ?? 'Post Title')

@section('body')
    <main class="dashboardContent p-3 p-md-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9 col-lg-8 col-xl-7 mx-auto">

                    <!-- Back Button -->
                    <div class="vp-back-row">
                        <button type="button" class="vp-back-btn" onclick="window.history.back()">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>Back</span>
                        </button>
                    </div>

                    <!-- Post Card -->
                    <article class="vp-card">

                        <!-- Post Header: Author Info + Date -->
                        <div class="vp-header">
                            <div class="vp-author">
                                <img src="{{ asset($post?->employer?->employerCompany?->logo ?? 'frontend/company-vector.jpg') }}"
                                     alt="{{ $post?->employer?->name ?? 'Company' }}"
                                     class="vp-author-logo" />
                                <div class="vp-author-info">
                                    <h6 class="vp-author-name">{{ $post?->employer?->name ?? 'Employer Name' }}</h6>
                                    <span class="vp-post-time">
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $post->created_at->diffForHumans() }}
                                        <span class="vp-date-full">· {{ $post->created_at->format('d M, Y') }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Post Title -->
                        @if($post->title)
                            <h1 class="vp-title">{{ $post->title }}</h1>
                        @endif

                        <!-- Post Images -->
                        @if(isset($post->images))
                            @php
                                $images = json_decode($post->images);
                                $count = count($images);
                            @endphp

                            @if($count == 1)
                                <div class="vp-images vp-images-single">
                                    <div class="vp-img-wrap zoom-img" mbox-group="jqueryscript">
                                        <a href="{{ asset($images[0]) }}">
                                            <img src="{{ asset($images[0]) }}" alt="Post image" class="vp-img" />
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="vp-images vp-images-grid vp-grid-{{ min($count, 4) }}">
                                    @foreach($images as $index => $image)
                                        <div class="vp-img-wrap zoom-img" mbox-group="jqueryscript">
                                            <a href="{{ asset($image) }}">
                                                <img src="{{ asset($image) }}" alt="Post image" class="vp-img" />
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif

                        <!-- Post Description -->
                        @if($post->description)
                            <div class="vp-body">
                                {!! $post->description !!}
                            </div>
                        @endif

                    </article>

                </div>
            </div>
        </div>
    </main>
@endsection

@push('style')
    <style>
        /* =============================================
           View Post — Consistent with eh- design system
           ============================================= */

        /* --- Back Button --- */
        .vp-back-row {
            margin-bottom: 16px;
            padding-top: 4px;
        }

        .vp-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #0F172A;
            cursor: pointer;
            transition: all .2s;
            font-family: 'Geist', sans-serif;
        }

        .vp-back-btn:hover {
            background: #141C25;
            border-color: #141C25;
            color: #fff!important;
        }

        .vp-back-btn:hover i, .vp-back-btn:hover span {
            color: white!important;
        }

        .vp-back-btn i {
            font-size: 12px;
        }

        /* --- Post Card --- */
        .vp-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #E2E8F0;
            padding: 24px;
            margin-bottom: 24px;
        }

        /* --- Header --- */
        .vp-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .vp-author {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .vp-author-logo {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid #F1F5F9;
            flex-shrink: 0;
        }

        .vp-author-info {
            min-width: 0;
        }

        .vp-author-name {
            font-size: 15px;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 2px;
            line-height: 1.3;
        }

        .vp-post-time {
            font-size: 12px;
            color: #94A3B8;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .vp-post-time i {
            font-size: 11px;
        }

        .vp-date-full {
            color: #94A3B8;
        }

        /* --- Title --- */
        .vp-title {
            font-size: 22px;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 20px;
            line-height: 1.4;
            letter-spacing: -0.2px;
        }

        /* --- Images --- */
        .vp-images {
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
        }

        .vp-images-single .vp-img-wrap {
            display: block;
        }

        .vp-images-single .vp-img {
            width: 100%;
            max-height: 520px;
            object-fit: cover;
            display: block;
            border-radius: 12px;
            transition: transform .3s;
        }

        .vp-images-single .vp-img-wrap:hover .vp-img {
            transform: scale(1.01);
        }

        /* Multi-image grid */
        .vp-images-grid {
            display: grid;
            gap: 4px;
        }

        .vp-grid-2 {
            grid-template-columns: 1fr 1fr;
        }

        .vp-grid-3 {
            grid-template-columns: 1fr 1fr;
        }

        .vp-grid-3 .vp-img-wrap:first-child {
            grid-column: 1 / -1;
        }

        .vp-grid-4 {
            grid-template-columns: 1fr 1fr;
        }

        .vp-images-grid .vp-img-wrap {
            overflow: hidden;
        }

        .vp-images-grid .vp-img-wrap a {
            display: block;
        }

        .vp-images-grid .vp-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
            transition: transform .3s;
        }

        .vp-grid-3 .vp-img-wrap:first-child .vp-img {
            height: 300px;
        }

        .vp-images-grid .vp-img-wrap:hover .vp-img {
            transform: scale(1.03);
        }

        /* --- Body / Description --- */
        .vp-body {
            font-size: 15px;
            color: #334155;
            line-height: 1.8;
            text-align: justify;
            word-break: break-word;
        }

        .vp-body p {
            color: #334155;
            margin-bottom: 12px;
        }

        .vp-body p:last-child {
            margin-bottom: 0;
        }

        .vp-body a {
            color: #141C25;
            font-weight: 600;
            text-decoration: underline;
            text-decoration-color: #FFCB11;
            text-underline-offset: 3px;
            transition: color .2s;
        }

        .vp-body a:hover {
            color: #FFCB11;
        }

        .vp-body img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 8px 0;
        }

        .vp-body ul, .vp-body ol {
            padding-left: 20px;
            margin-bottom: 12px;
        }

        .vp-body li {
            margin-bottom: 4px;
            color: #334155;
        }

        .vp-body h1, .vp-body h2, .vp-body h3,
        .vp-body h4, .vp-body h5, .vp-body h6 {
            color: #0F172A;
            margin-top: 16px;
            margin-bottom: 8px;
        }

        .vp-body blockquote {
            border-left: 3px solid #FFCB11;
            padding: 8px 16px;
            margin: 12px 0;
            background: #FFFBEB;
            border-radius: 0 8px 8px 0;
            color: #475569;
        }

        /* =============================================
           Responsive
           ============================================= */

        @media (max-width: 991px) {
            .vp-card {
                padding: 20px;
            }

            .vp-title {
                font-size: 20px;
            }

            .vp-images-single .vp-img {
                max-height: 400px;
            }
        }

        @media (max-width: 767px) {
            .vp-card {
                padding: 16px;
                border-radius: 12px;
            }

            .vp-author-logo {
                width: 42px;
                height: 42px;
                border-radius: 8px;
            }

            .vp-author-name {
                font-size: 14px;
            }

            .vp-title {
                font-size: 18px;
                margin-bottom: 16px;
            }

            .vp-images-single .vp-img {
                max-height: 300px;
                border-radius: 10px;
            }

            .vp-images-grid .vp-img {
                height: 160px;
            }

            .vp-grid-3 .vp-img-wrap:first-child .vp-img {
                height: 200px;
            }

            .vp-body {
                font-size: 14px;
                line-height: 1.7;
            }

            .vp-date-full {
                display: none;
            }
        }

        @media (max-width: 575px) {
            .vp-card {
                padding: 14px;
            }

            .vp-header {
                margin-bottom: 14px;
            }

            .vp-author-logo {
                width: 38px;
                height: 38px;
            }

            .vp-author-name {
                font-size: 13px;
            }

            .vp-post-time {
                font-size: 11px;
            }

            .vp-title {
                font-size: 16px;
                margin-bottom: 14px;
            }

            .vp-images {
                margin-bottom: 14px;
                border-radius: 10px;
            }

            .vp-images-grid .vp-img {
                height: 120px;
            }

            .vp-grid-3 .vp-img-wrap:first-child .vp-img {
                height: 160px;
            }

            .vp-back-btn {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
    </style>
@endpush

@push('script')
    <link rel="stylesheet" href="{{ asset('frontend/zoom-plugin/mbox.css') }}">
    <script src="{{ asset('frontend/zoom-plugin/mbox.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.zoom-img').mBox();
        });
    </script>
@endpush
