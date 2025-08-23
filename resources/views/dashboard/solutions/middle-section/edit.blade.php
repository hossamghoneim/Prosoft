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
                        {{ __('Edit solution middle section') }}
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
            <form action="{{ route('dashboard.solution-middle-sections.update', $solutionMiddleSection->id) }}" class="form submitted-form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.solution-middle-sections.index') }}">
                @csrf
                @method('PUT')

                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Edit solution middle section') . ' : ' . $solutionMiddleSection->main_title }}</h3>
                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper p-8">

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
                                    <select class="form-select form-select-lg" name="solution_id" id="solution_id_inp" data-control="select2">
                                        <option value="">{{ __('Select solution') }}</option>
                                        @foreach($solutions as $solution)
                                            <option value="{{ $solution->id }}" {{ $solutionMiddleSection->solution_id == $solution->id ? 'selected' : '' }}>
                                                {{ $solution->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="invalid-feedback" id="solution_id"></p>

                                </div>
                                <!-- end   :: Column -->

                                <!-- begin :: Column -->
                                <div class="col-md-6 fv-row">

                                    <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Main Title') }}</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-lg" id="main_title_inp" name="main_title"
                                            placeholder="example" value="{{ $solutionMiddleSection->main_title }}" />
                                        <label for="main_title_inp">{{ __('Enter the main title') }}</label>
                                    </div>
                                    <p class="invalid-feedback" id="main_title"></p>

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
                                        <x-dashboard.upload-image-inp name="first_card_icon" :image="$solutionMiddleSection->first_card_icon" directory="solution-middle-section-icons" placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                    </div>
                                    <p class="invalid-feedback" id="first_card_icon"></p>

                                </div>
                                <!-- end   :: Column -->

                                <!-- begin :: Column -->
                                <div class="col-md-4 fv-row">

                                    <label class="fs-6 fw-bold mb-3 text-dark">{{ __('First Card Title') }}</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-lg" id="first_card_title_inp" name="first_card_title"
                                            placeholder="example" value="{{ $solutionMiddleSection->first_card_title }}" />
                                        <label for="first_card_title_inp">{{ __('Enter the first card title') }}</label>
                                    </div>
                                    <p class="invalid-feedback" id="first_card_title"></p>

                                </div>
                                <!-- end   :: Column -->

                                <!-- begin :: Column -->
                                <div class="col-md-4 fv-row">

                                    <label class="fs-6 fw-bold mb-3 text-dark">{{ __('First Card Description') }}</label>
                                    <textarea class="form-control form-control-lg" name="first_card_description" id="first_card_description_inp"
                                        placeholder="Enter the first card description" rows="3">{{ $solutionMiddleSection->first_card_description }}</textarea>
                                    <p class="invalid-feedback" id="first_card_description"></p>

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
                                        <x-dashboard.upload-image-inp name="second_card_icon" :image="$solutionMiddleSection->second_card_icon" directory="solution-middle-section-icons" placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                    </div>
                                    <p class="invalid-feedback" id="second_card_icon"></p>

                                </div>
                                <!-- end   :: Column -->

                                <!-- begin :: Column -->
                                <div class="col-md-4 fv-row">

                                    <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Second Card Title') }}</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-lg" id="second_card_title_inp" name="second_card_title"
                                            placeholder="example" value="{{ $solutionMiddleSection->second_card_title }}" />
                                        <label for="second_card_title_inp">{{ __('Enter the second card title') }}</label>
                                    </div>
                                    <p class="invalid-feedback" id="second_card_title"></p>

                                </div>
                                <!-- end   :: Column -->

                                <!-- begin :: Column -->
                                <div class="col-md-4 fv-row">

                                    <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Second Card Description') }}</label>
                                    <textarea class="form-control form-control-lg" name="second_card_description" id="second_card_description_inp"
                                        placeholder="Enter the second card description" rows="3">{{ $solutionMiddleSection->second_card_description }}</textarea>
                                    <p class="invalid-feedback" id="second_card_description"></p>

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
                                        <x-dashboard.upload-image-inp name="third_card_icon" :image="$solutionMiddleSection->third_card_icon" directory="solution-middle-section-icons" placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                    </div>
                                    <p class="invalid-feedback" id="third_card_icon"></p>

                                </div>
                                <!-- end   :: Column -->

                                <!-- begin :: Column -->
                                <div class="col-md-4 fv-row">

                                    <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Third Card Title') }}</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-lg" id="third_card_title_inp" name="third_card_title"
                                            placeholder="example" value="{{ $solutionMiddleSection->third_card_title }}" />
                                        <label for="third_card_title_inp">{{ __('Enter the third card title') }}</label>
                                    </div>
                                    <p class="invalid-feedback" id="third_card_title"></p>

                                </div>
                                <!-- end   :: Column -->

                                <!-- begin :: Column -->
                                <div class="col-md-4 fv-row">

                                    <label class="fs-6 fw-bold mb-3 text-dark">{{ __('Third Card Description') }}</label>
                                    <textarea class="form-control form-control-lg" name="third_card_description" id="third_card_description_inp"
                                        placeholder="Enter the third card description" rows="3">{{ $solutionMiddleSection->third_card_description }}</textarea>
                                    <p class="invalid-feedback" id="third_card_description"></p>

                                </div>
                                <!-- end   :: Column -->

                            </div>
                            <!-- end   :: Row -->
                        </div>
                    </div>
                    <!-- end   :: Third Card Section -->

                </div>
                <!-- end   :: Inputs wrapper -->

                <!-- begin :: Form footer -->
                <div class="form-footer bg-light p-6 border-top">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary btn-lg px-8" id="submit-btn">

                        <span class="indicator-label">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ __('Save') }}
                        </span>

                        <!-- begin :: Indicator -->
                        <span class="indicator-progress">{{ __('Please wait ...') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!-- end   :: Indicator -->

                    </button>
                    <!-- end   :: Submit btn -->

                </div>
                <!-- end   :: Form footer -->
            </form>
            <!-- end   :: Form -->
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

    .form-select-lg {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-select-lg:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .btn-lg {
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-lg:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
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
    </style>
@endsection
