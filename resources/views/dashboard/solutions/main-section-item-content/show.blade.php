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
                        href="{{ route('dashboard.solution-main-section-item-contents.index') }}"
                        class="text-muted text-hover-primary">{{ __('Solution Main Section Item Contents') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Content details') }}
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
                <h3 class="fw-bolder text-dark">{{ __('Content details') }}</h3>
            </div>
            <!-- end   :: Card header -->

            <!-- begin :: Content wrapper -->
            <div class="content-wrapper p-10">

                <!-- begin :: Row -->
                <div class="row my-10">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Solution Main Section Item') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $solutionMainSectionItemContent->solution_main_section_item->title ?? 'N/A' }}
                        </div>

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Main Title') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $solutionMainSectionItemContent->main_title }}
                        </div>

                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

                <!-- begin :: Row -->
                <div class="row my-10">

                    <!-- begin :: Column -->
                    <div class="col-md-12 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Description') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $solutionMainSectionItemContent->description }}
                        </div>

                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

                <!-- begin :: Row -->
                <div class="row my-10">

                    <!-- begin :: Column -->
                    <div class="col-md-12 fv-row d-flex justify-content-center">

                        <div class="d-flex flex-column align-items-center">
                            <!-- begin :: Background Image -->
                            @if($solutionMainSectionItemContent->background_image)
                                <label class="text-center fw-bold mb-4">{{ __('Background Image') }}</label>
                                <img src="{{ $solutionMainSectionItemContent->background_image }}" alt="Background Image"
                                     class="img-fluid rounded" style="max-width: 300px; max-height: 300px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                     style="width: 300px; height: 200px;">
                                    <span class="text-muted">{{ __('No background image available') }}</span>
                                </div>
                            @endif
                            <!-- end   :: Background Image -->
                        </div>

                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

                <!-- begin :: Row -->
                <div class="row my-10">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('First Card Title') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $solutionMainSectionItemContent->first_card_title }}
                        </div>

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Second Card Title') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $solutionMainSectionItemContent->second_card_title ?? 'N/A' }}
                        </div>

                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

                <!-- begin :: Row -->
                <div class="row my-10">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('First Card Description') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $solutionMainSectionItemContent->first_card_description }}
                        </div>

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Second Card Description') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $solutionMainSectionItemContent->second_card_description ?? 'N/A' }}
                        </div>

                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

                <!-- begin :: Row -->
                <div class="row my-10">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Third Card Title') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $solutionMainSectionItemContent->third_card_title ?? 'N/A' }}
                        </div>

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Button Text') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $solutionMainSectionItemContent->button_text ?? 'N/A' }}
                        </div>

                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

                <!-- begin :: Row -->
                <div class="row my-10">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Third Card Description') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $solutionMainSectionItemContent->third_card_description ?? 'N/A' }}
                        </div>

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row d-flex justify-content-center">

                        <div class="d-flex flex-column align-items-center">
                            <!-- begin :: Logo -->
                            @if($solutionMainSectionItemContent->logo)
                                <label class="text-center fw-bold mb-4">{{ __('Logo') }}</label>
                                <img src="{{ $solutionMainSectionItemContent->logo }}" alt="Logo"
                                     class="img-fluid rounded" style="max-width: 200px; max-height: 200px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                     style="width: 200px; height: 200px;">
                                    <span class="text-muted">{{ __('No logo available') }}</span>
                                </div>
                            @endif
                            <!-- end   :: Logo -->
                        </div>

                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

                <!-- begin :: Row -->
                <div class="row my-10">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Created Date') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $solutionMainSectionItemContent->created_at }}
                        </div>

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">
                        <div class="mb-4"></div>
                        <label class="fs-6 fw-bold mb-2">{{ __('Updated Date') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $solutionMainSectionItemContent->updated_at }}
                        </div>
                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

            </div>
            <!-- end   :: Content wrapper -->

        </div>
        <!-- end   :: Card body -->
    </div>
@endsection
