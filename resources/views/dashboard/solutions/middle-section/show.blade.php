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
                        href="{{ route('dashboard.solution-middle-sections.index') }}"
                        class="text-muted text-hover-primary">{{ __('Solution Middle Section') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Solution middle section details') }}
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
                <h3 class="fw-bolder text-dark">{{ __('Solution middle section details') }}</h3>
            </div>
            <!-- end   :: Card header -->

            <!-- begin :: Content wrapper -->
            <div class="content-wrapper p-8">

                <!-- begin :: Main Information Section -->
                <div class="card card-flush border border-gray-300 mb-8">
                    <div class="card-header bg-light-secondary">
                        <h4 class="fw-bold text-dark mb-0">
                            <i class="bi bi-info-circle-fill text-info me-2"></i>
                            {{ __('Main Information') }}
                        </h4>
                    </div>
                    <div class="card-body p-6">
                        <!-- begin :: Row -->
                        <div class="row g-6">

                            <!-- begin :: Column -->
                            <div class="col-md-6 fv-row">

                                <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Solution') }}</label>
                                <div class="form-control form-control-solid form-control-lg">
                                    {{ $solutionMiddleSection->solution->title ?? 'N/A' }}
                                </div>

                            </div>
                            <!-- end   :: Column -->

                            <!-- begin :: Column -->
                            <div class="col-md-6 fv-row">

                                <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Main Title') }}</label>
                                <div class="form-control form-control-solid form-control-lg">
                                    {{ $solutionMiddleSection->main_title }}
                                </div>

                            </div>
                            <!-- end   :: Column -->

                        </div>
                        <!-- end   :: Row -->
                    </div>
                </div>
                <!-- end   :: Main Information Section -->

                <!-- begin :: First Card Section -->
                <div class="card card-flush border border-gray-300 mb-8">
                    <div class="card-header bg-light-success">
                        <h4 class="fw-bold text-dark mb-0">
                            <i class="bi bi-1-circle-fill text-success me-2"></i>
                            {{ __('First Card') }}
                        </h4>
                    </div>
                    <div class="card-body p-6">
                        <!-- begin :: Row -->
                        <div class="row g-6">

                            <!-- begin :: Column -->
                            <div class="col-md-4 fv-row">

                                <label class="fs-6 fw-bold mb-3 text-dark">{{ __('First Card Icon') }}</label>
                                <div class="d-flex justify-content-center">
                                    <x-dashboard.upload-image-inp name="first_card_icon" :image="$solutionMiddleSection->first_card_icon" directory="solution-middle-section-icons" placeholder="default.jpg" type="show"></x-dashboard.upload-image-inp>
                                </div>

                            </div>
                            <!-- end   :: Column -->

                            <!-- begin :: Column -->
                            <div class="col-md-4 fv-row">

                                <label class="fs-6 fw-bold mb-3 text-dark">{{ __('First Card Title') }}</label>
                                <div class="form-control form-control-solid form-control-lg">
                                    {{ $solutionMiddleSection->first_card_title ?? 'N/A' }}
                                </div>

                            </div>
                            <!-- end   :: Column -->

                            <!-- begin :: Column -->
                            <div class="col-md-4 fv-row">

                                <label class="fs-6 fw-bold mb-3 text-dark">{{ __('First Card Description') }}</label>
                                <div class="form-control form-control-solid form-control-lg">
                                    {{ $solutionMiddleSection->first_card_description ?? 'N/A' }}
                                </div>

                            </div>
                            <!-- end   :: Column -->

                        </div>
                        <!-- end   :: Row -->
                    </div>
                </div>
                <!-- end   :: First Card Section -->

                <!-- begin :: Second Card Section -->
                <div class="card card-flush border border-gray-300 mb-8">
                    <div class="card-header bg-light-warning">
                        <h4 class="fw-bold text-dark mb-0">
                            <i class="bi bi-2-circle-fill text-warning me-2"></i>
                            {{ __('Second Card') }}
                        </h4>
                    </div>
                    <div class="card-body p-6">
                        <!-- begin :: Row -->
                        <div class="row g-6">

                            <!-- begin :: Column -->
                            <div class="col-md-4 fv-row">

                                <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Second Card Icon') }}</label>
                                <div class="d-flex justify-content-center">
                                    <x-dashboard.upload-image-inp name="second_card_icon" :image="$solutionMiddleSection->second_card_icon" directory="solution-middle-section-icons" placeholder="default.jpg" type="show"></x-dashboard.upload-image-inp>
                                </div>

                            </div>
                            <!-- end   :: Column -->

                            <!-- begin :: Column -->
                            <div class="col-md-4 fv-row">

                                <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Second Card Title') }}</label>
                                <div class="form-control form-control-solid form-control-lg">
                                    {{ $solutionMiddleSection->second_card_title ?? 'N/A' }}
                                </div>

                            </div>
                            <!-- end   :: Column -->

                            <!-- begin :: Column -->
                            <div class="col-md-4 fv-row">

                                <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Second Card Description') }}</label>
                                <div class="form-control form-control-solid form-control-lg">
                                    {{ $solutionMiddleSection->second_card_description ?? 'N/A' }}
                                </div>

                            </div>
                            <!-- end   :: Column -->

                        </div>
                        <!-- end   :: Row -->
                    </div>
                </div>
                <!-- end   :: Second Card Section -->

                <!-- begin :: Third Card Section -->
                <div class="card card-flush border border-gray-300 mb-8">
                    <div class="card-header bg-light-danger">
                        <h4 class="fw-bold text-dark mb-0">
                            <i class="bi bi-3-circle-fill text-danger me-2"></i>
                            {{ __('Third Card') }}
                        </h4>
                    </div>
                    <div class="card-body p-6">
                        <!-- begin :: Row -->
                        <div class="row g-6">

                            <!-- begin :: Column -->
                            <div class="col-md-4 fv-row">

                                <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Third Card Icon') }}</label>
                                <div class="d-flex justify-content-center">
                                    <x-dashboard.upload-image-inp name="third_card_icon" :image="$solutionMiddleSection->third_card_icon" directory="solution-middle-section-icons" placeholder="default.jpg" type="show"></x-dashboard.upload-image-inp>
                                </div>

                            </div>
                            <!-- end   :: Column -->

                            <!-- begin :: Column -->
                            <div class="col-md-4 fv-row">

                                <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Third Card Title') }}</label>
                                <div class="form-control form-control-solid form-control-lg">
                                    {{ $solutionMiddleSection->third_card_title ?? 'N/A' }}
                                </div>

                            </div>
                            <!-- end   :: Column -->

                            <!-- begin :: Column -->
                            <div class="col-md-4 fv-row">

                                <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Third Card Description') }}</label>
                                <div class="form-control form-control-solid form-control-lg">
                                    {{ $solutionMiddleSection->third_card_description ?? 'N/A' }}
                                </div>

                            </div>
                            <!-- end   :: Column -->

                        </div>
                        <!-- end   :: Row -->
                    </div>
                </div>
                <!-- end   :: Third Card Section -->

                <!-- begin :: Status & Date Section -->
                <div class="card card-flush border border-gray-300 mb-8">
                    <div class="card-header bg-light-primary">
                        <h4 class="fw-bold text-dark mb-0">
                            <i class="bi bi-clock-history text-primary me-2"></i>
                            {{ __('Status & Information') }}
                        </h4>
                    </div>
                    <div class="card-body p-6">
                        <!-- begin :: Row -->
                        <div class="row g-6">

                            <!-- begin :: Column -->
                            <div class="col-md-6 fv-row">

                                <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Status') }}</label>
                                <div class="form-control form-control-solid form-control-lg">
                                    @if($solutionMiddleSection->is_active)
                                        <span class="badge badge-light-success fs-7 px-4 py-2">
                                            <i class="bi bi-check-circle-fill me-2"></i> {{ __('Active') }}
                                        </span>
                                    @else
                                        <span class="badge badge-light-danger fs-7 px-4 py-2">
                                            <i class="bi bi-x-circle-fill me-2"></i> {{ __('Inactive') }}
                                        </span>
                                    @endif
                                </div>

                            </div>
                            <!-- end   :: Column -->

                            <!-- begin :: Column -->
                            <div class="col-md-6 fv-row">

                                <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Created Date') }}</label>
                                <div class="form-control form-control-solid form-control-lg">
                                    <i class="bi bi-calendar3 me-2 text-muted"></i>
                                    {{ $solutionMiddleSection->created_at }}
                                </div>
                            </div>
                            <!-- end   :: Column -->

                        </div>
                        <!-- end   :: Row -->
                    </div>
                </div>
                <!-- end   :: Status & Date Section -->

            </div>
            <!-- end   :: Content wrapper -->

        </div>
        <!-- end   :: Card body -->
    </div>

    <style>
    .card-flush {
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .card-flush:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        border-radius: 12px 12px 0 0 !important;
        border-bottom: 1px solid #e9ecef;
    }

    .form-control-lg {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-control-lg:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .bg-light-primary {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%) !important;
    }

    .bg-light-secondary {
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%) !important;
    }

    .bg-light-success {
        background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%) !important;
    }

    .bg-light-warning {
        background: linear-gradient(135deg, #fff3e0 0%, #ffcc80 100%) !important;
    }

    .bg-light-danger {
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%) !important;
    }

    .badge {
        border-radius: 6px;
        font-weight: 600;
    }
    </style>
@endsection
