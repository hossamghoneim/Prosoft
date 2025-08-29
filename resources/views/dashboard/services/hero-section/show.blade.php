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
                        href="{{ route('dashboard.service-hero-sections.index') }}"
                        class="text-muted text-hover-primary">{{ __('Hero') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Hero data') }}
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
            <!-- begin :: Form -->

            <!-- begin :: Card header -->
            <div class="card-header d-flex align-items-center">
                <h3 class="fw-bolder text-dark">{{ __('hero data') . ' : ' . $serviceHeroSection->title }}</h3>
            </div>
            <!-- end   :: Card header -->

            <!-- begin :: Inputs wrapper -->
            <div class="inputs-wrapper">

                <!-- begin :: Row -->
                {{-- <div class="row mb-10">

                    <!-- begin :: Column -->
                    <div class="col-md-12 fv-row d-flex justify-content-evenly">

                        <div class="d-flex flex-column">
                            <!-- begin :: Upload image component -->
                            <label class="text-center fw-bold mb-4">{{ __('Image') }}</label>
                            <x-dashboard.upload-image-inp name="image" :image="$brand->getRawOriginal('image')" directory="Brands"
                                placeholder="default.jpg" type="show"></x-dashboard.upload-image-inp>
                            <!-- end   :: Upload image component -->
                        </div>

                    </div>
                    <!-- end   :: Column -->

                </div> --}}
                <!-- end   :: Row -->

                <!-- begin :: Row -->
                <div class="row my-10">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Title') }}</label>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="title_inp" name="title"
                                placeholder="example" value="{{ $serviceHeroSection->title }}" readonly />
                            <label for="title_inp">{{ __('Enter the title') }}</label>
                        </div>
                        <p class="invalid-feedback" id="title"></p>


                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Button text') }}</label>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="button_text_inp" name="button_text"
                                placeholder="example" value="{{ $serviceHeroSection->button_text }}" readonly />
                            <label for="button_text_inp">{{ __('Enter the button text') }}</label>
                        </div>
                        <p class="invalid-feedback" id="button_text"></p>


                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">
                        <div class="mb-4"></div>
                        <label class="fs-6 fw-bold mb-2">{{ __('Description') }}</label>
                        <textarea class="form-control form-control form-control" name="description" id="description_inp"
                            data-kt-autosize="true" readonly>{{ $serviceHeroSection->description }}</textarea>
                        <p class="invalid-feedback" id="description"></p>


                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">
                        <div class="mb-4"></div>
                        <label class="fs-6 fw-bold mb-2">{{ __('Button url') }}</label>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="button_url_inp" name="button_url"
                                placeholder="example" value="{{ $serviceHeroSection->button_url }}" readonly />
                            <label for="button_url_inp">{{ __('Enter the button url') }}</label>
                        </div>
                        <p class="invalid-feedback" id="button_url"></p>


                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->
                `
            </div>
            <!-- end   :: Inputs wrapper -->

            <!-- begin :: Form footer -->
            <div class="form-footer">

                <!-- begin :: Submit btn -->
                <a href="{{ route('dashboard.service-hero-sections.index') }}" class="btn btn-primary">

                    <span class="indicator-label">{{ __('Back') }}</span>

                </a>
                <!-- end   :: Submit btn -->

            </div>
            <!-- end   :: Form footer -->
            <!-- end   :: Form -->
        </div>
        <!-- end   :: Card body -->
    </div>
@endsection
