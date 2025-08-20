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
                        href="{{ route('dashboard.about-us-banner-sections.index') }}"
                        class="text-muted text-hover-primary">{{ __('About Us Banner Sections') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Edit banner section') }}
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
                <h3 class="fw-bolder text-dark">{{ __('Edit banner section') }}</h3>
            </div>
            <!-- end   :: Card header -->

            <!-- begin :: Form -->
            <form class="form submitted-form" action="{{ route('dashboard.about-us-banner-sections.update', $aboutUsBannerSection->id) }}" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.about-us-banner-sections.index') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- begin :: Content wrapper -->
                <div class="content-wrapper p-10">

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Title') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="title"
                                value="{{ old('title', $aboutUsBannerSection->title) }}" placeholder="{{ __('Enter title') }}" />
                            @error('title')
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div data-field="title" data-validator="notEmpty">{{ $message }}</div>
                                </div>
                            @enderror

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Button Text') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="button_text"
                                value="{{ old('button_text', $aboutUsBannerSection->button_text) }}" placeholder="{{ __('Enter button text') }}" />
                            @error('button_text')
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div data-field="button_text" data-validator="notEmpty">{{ $message }}</div>
                                </div>
                            @enderror

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Description') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-solid" name="description" rows="4"
                                placeholder="{{ __('Enter description') }}">{{ old('description', $aboutUsBannerSection->description) }}</textarea>
                            @error('description')
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div data-field="description" data-validator="notEmpty">{{ $message }}</div>
                                </div>
                            @enderror

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Button URL') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="button_url"
                                value="{{ old('button_url', $aboutUsBannerSection->button_url) }}" placeholder="{{ __('Enter button URL') }}" />
                            @error('button_url')
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div data-field="button_url" data-validator="notEmpty">{{ $message }}</div>
                                </div>
                            @enderror

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Video') }}</label>
                            <input type="file" class="form-control form-control-solid" name="video" accept="video/*" />
                            <div class="form-text">{{ __('Upload a video file (MP4, AVI, MOV, etc.)') }}</div>
                            @error('video')
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div data-field="video" data-validator="notEmpty">{{ $message }}</div>
                                </div>
                            @enderror
                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                </div>
                <!-- end   :: Content wrapper -->

                <!-- begin :: Card footer -->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('dashboard.about-us-banner-sections.index') }}"
                        class="btn btn-light btn-active-light-primary me-2">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        <span class="indicator-label">{{ __('Save') }}</span>
                        <span class="indicator-progress">{{ __('Please wait ...') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!-- end   :: Card footer -->

            </form>
            <!-- end   :: Form -->

        </div>
        <!-- end   :: Card body -->
    </div>
@endsection


