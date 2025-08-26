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
                        href="{{ route('dashboard.terms-condition-hero-sections.index') }}"
                        class="text-muted text-hover-primary">{{ __('Terms & Conditions Hero') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Terms condition hero data') }}
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
                <h3 class="fw-bolder text-dark">{{ __('terms condition hero data') . ' : ' . $termsConditionHeroSection->description }}</h3>
            </div>
            <!-- end   :: Card header -->

            <!-- begin :: Inputs wrapper -->
            <div class="inputs-wrapper">

                <!-- begin :: Row -->
                <div class="row my-10">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">
                        <div class="mb-4"></div>
                        <label class="fs-6 fw-bold mb-2">{{ __('Description') }}</label>
                        <textarea class="form-control form-control form-control" name="description" id="description_inp"
                            data-kt-autosize="true" readonly>{{ $termsConditionHeroSection->description }}</textarea>
                        <p class="invalid-feedback" id="description"></p>
                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">
                        <div class="mb-4"></div>
                        <label class="fs-6 fw-bold mb-2">{{ __('Effective Date') }}</label>
                        <div class="form-floating">
                            <input type="date" class="form-control" id="effective_date_inp" name="effective_date"
                                placeholder="example" value="{{ $termsConditionHeroSection->effective_date->format('Y-m-d') }}" readonly />
                            <label for="effective_date_inp">{{ __('Enter the effective date') }}</label>
                        </div>
                        <p class="invalid-feedback" id="effective_date"></p>
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
                <a href="{{ route('dashboard.terms-condition-hero-sections.index') }}" class="btn btn-primary">

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

