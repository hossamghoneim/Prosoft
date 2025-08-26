@extends('partials.dashboard.master')
@section('content')
    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a
                        href="{{ route('dashboard.home-secondary-sections.index') }}"
                        class="text-muted text-hover-primary">{{ __('Home Secondary') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Secondary details') }}
                    </li>
                    <!-- end   :: Item -->
                </ul>
                <!-- end   :: Breadcrumb -->

            </div>

        </div>

    </div>
    <!-- end   :: Subheader -->

    <div class="card">
        <!-- begin :: Card body -->
        <div class="card-body p-0">
            <!-- begin :: Card header -->
            <div class="card-header d-flex align-items-center">
                <h3 class="fw-bolder text-dark">{{ __('Secondary details') }}</h3>
            </div>
            <!-- end   :: Card header -->

            <!-- begin :: Content wrapper -->
            <div class="content-wrapper p-10">

                <!-- begin :: Main Section -->
                <div class="row my-10">
                    <div class="col-12">
                        <h4 class="fw-bold text-dark mb-5">{{ __('Main Section') }}</h4>
                    </div>
                </div>

                <div class="row my-10">
                    <!-- begin :: Main Title -->
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold mb-2">{{ __('Main Title') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $homeSecondarySection->main_title }}
                        </div>
                    </div>
                    <!-- end   :: Main Title -->

                    <!-- begin :: Created Date -->
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold mb-2">{{ __('Created Date') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $homeSecondarySection->created_at }}
                        </div>
                    </div>
                    <!-- end   :: Created Date -->
                </div>

                <div class="row my-10">
                    <!-- begin :: Main Description -->
                    <div class="col-12 fv-row">
                        <label class="fs-6 fw-bold mb-2">{{ __('Main Description') }}</label>
                        <div class="form-control form-control-solid">
                            {!! nl2br(e($homeSecondarySection->main_description)) !!}
                        </div>
                    </div>
                    <!-- end   :: Main Description -->
                </div>

                <div class="row my-10">
                    <!-- begin :: Background Image -->
                    <div class="col-12 fv-row">
                        <label class="fs-6 fw-bold mb-2">{{ __('Background Image') }}</label>
                        <div class="border rounded p-0"
                            style="width: 100%; height: 400px; overflow: hidden; position: relative;">
                            <div style="width: 100%; height: 100%;">
                                @if ($homeSecondarySection->background_image)
                                    <a class="d-block overlay" data-fslightbox="lightbox-basic"
                                        href="{{ $homeSecondarySection->background_image }}">
                                        <img src="{{ $homeSecondarySection->background_image }}"
                                            alt="{{ $homeSecondarySection->main_title }}"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </a>
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <span class="text-muted">{{ __('No background image uploaded') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- end   :: Background Image -->
                </div>

                <!-- begin :: First Card Section -->
                <div class="row my-10">
                    <div class="col-12">
                        <h4 class="fw-bold text-dark mb-5">{{ __('First Card') }}</h4>
                    </div>
                </div>

                <div class="row my-10">
                    <!-- begin :: First Card Logo -->
                    <div class="col-md-4 fv-row">
                        <label class="fs-6 fw-bold mb-2">{{ __('First Card Logo') }}</label>
                        <div class="border rounded p-0"
                            style="width: 100%; height: 200px; overflow: hidden; position: relative;">
                            <div style="width: 100%; height: 100%;">
                                @if ($homeSecondarySection->first_card_logo)
                                    <a class="d-block overlay" data-fslightbox="lightbox-basic"
                                        href="{{ $homeSecondarySection->first_card_logo }}">
                                        <img src="{{ $homeSecondarySection->first_card_logo }}"
                                            alt="{{ $homeSecondarySection->first_card_title }}"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </a>
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <span class="text-muted">{{ __('No logo uploaded') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- end   :: First Card Logo -->

                    <!-- begin :: First Card Title -->
                    <div class="col-md-4 fv-row">
                        <label class="fs-6 fw-bold mb-2">{{ __('First Card Title') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $homeSecondarySection->first_card_title }}
                        </div>
                    </div>
                    <!-- end   :: First Card Title -->
                </div>

                <div class="row my-10">
                    <!-- begin :: First Card Description -->
                    <div class="col-12 fv-row">
                        <label class="fs-6 fw-bold mb-2">{{ __('First Card Description') }}</label>
                        <div class="form-control form-control-solid">
                            {!! nl2br(e($homeSecondarySection->first_card_description)) !!}
                        </div>
                    </div>
                    <!-- end   :: First Card Description -->
                </div>

                <!-- begin :: Second Card Section -->
                <div class="row my-10">
                    <div class="col-12">
                        <h4 class="fw-bold text-dark mb-5">{{ __('Second Card') }}</h4>
                    </div>
                </div>

                <div class="row my-10">
                    <!-- begin :: Second Card Logo -->
                    <div class="col-md-4 fv-row">
                        <label class="fs-6 fw-bold mb-2">{{ __('Second Card Logo') }}</label>
                        <div class="border rounded p-0"
                            style="width: 100%; height: 200px; overflow: hidden; position: relative;">
                            <div style="width: 100%; height: 100%;">
                                @if ($homeSecondarySection->second_card_logo)
                                    <a class="d-block overlay" data-fslightbox="lightbox-basic"
                                        href="{{ $homeSecondarySection->second_card_logo }}">
                                        <img src="{{ $homeSecondarySection->second_card_logo }}"
                                            alt="{{ $homeSecondarySection->second_card_title }}"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </a>
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <span class="text-muted">{{ __('No logo uploaded') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- end   :: Second Card Logo -->

                    <!-- begin :: Second Card Title -->
                    <div class="col-md-4 fv-row">
                        <label class="fs-6 fw-bold mb-2">{{ __('Second Card Title') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $homeSecondarySection->second_card_title }}
                        </div>
                    </div>
                    <!-- end   :: Second Card Title -->
                </div>

                <div class="row my-10">
                    <!-- begin :: Second Card Description -->
                    <div class="col-12 fv-row">
                        <label class="fs-6 fw-bold mb-2">{{ __('Second Card Description') }}</label>
                        <div class="form-control form-control-solid">
                            {!! nl2br(e($homeSecondarySection->second_card_description)) !!}
                        </div>
                    </div>
                    <!-- end   :: Second Card Description -->
                </div>

                <!-- begin :: Third Card Section -->
                <div class="row my-10">
                    <div class="col-12">
                        <h4 class="fw-bold text-dark mb-5">{{ __('Third Card') }}</h4>
                    </div>
                </div>

                <div class="row my-10">
                    <!-- begin :: Third Card Logo -->
                    <div class="col-md-4 fv-row">
                        <label class="fs-6 fw-bold mb-2">{{ __('Third Card Logo') }}</label>
                        <div class="border rounded p-0"
                            style="width: 100%; height: 200px; overflow: hidden; position: relative;">
                            <div style="width: 100%; height: 100%;">
                                @if ($homeSecondarySection->third_card_logo)
                                    <a class="d-block overlay" data-fslightbox="lightbox-basic"
                                        href="{{ $homeSecondarySection->third_card_logo }}">
                                        <img src="{{ $homeSecondarySection->third_card_logo }}"
                                            alt="{{ $homeSecondarySection->third_card_title }}"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </a>
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <span class="text-muted">{{ __('No logo uploaded') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- end   :: Third Card Logo -->

                    <!-- begin :: Third Card Title -->
                    <div class="col-md-4 fv-row">
                        <label class="fs-6 fw-bold mb-2">{{ __('Third Card Title') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $homeSecondarySection->third_card_title }}
                        </div>
                    </div>
                    <!-- end   :: Third Card Title -->
                </div>

                <div class="row my-10">
                    <!-- begin :: Third Card Description -->
                    <div class="col-12 fv-row">
                        <label class="fs-6 fw-bold mb-2">{{ __('Third Card Description') }}</label>
                        <div class="form-control form-control-solid">
                            {!! nl2br(e($homeSecondarySection->third_card_description)) !!}
                        </div>
                    </div>
                    <!-- end   :: Third Card Description -->
                </div>

            </div>
            <!-- end   :: Content wrapper -->

        </div>
        <!-- end   :: Card body -->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/dashboard/lightbox/fslightbox.bundle.js') }}"></script>
@endpush
