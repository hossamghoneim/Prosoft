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
                        href="{{ route('dashboard.about-us-final-sections.index') }}"
                        class="text-muted text-hover-primary">{{ __('About Us Final Section') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('About us final section details') }}
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
                <h3 class="fw-bolder text-dark">{{ __('About us final section details') }}</h3>
            </div>
            <!-- end   :: Card header -->

            <!-- begin :: Content wrapper -->
            <div class="content-wrapper p-10">

                <!-- begin :: Row -->
                <div class="row my-10">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Title') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $aboutUsFinalSection->title }}
                        </div>

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">
                        <div class="mb-4"></div>
                        <label class="fs-6 fw-bold mb-2">{{ __('Description') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $aboutUsFinalSection->description }}
                        </div>
                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

                <!-- begin :: Row -->
                <div class="row my-10">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Status') }}</label>
                        <div class="form-control form-control-solid">
                            @if($aboutUsFinalSection->is_active)
                                <span class="badge badge-light-success">
                                    <i class="fa fa-check-circle me-1"></i> {{ __('Active') }}
                                </span>
                            @else
                                <span class="badge badge-light-danger">
                                    <i class="fa fa-times-circle me-1"></i> {{ __('Inactive') }}
                                </span>
                            @endif
                        </div>

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">
                        <div class="mb-4"></div>
                        <label class="fs-6 fw-bold mb-2">{{ __('Created Date') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $aboutUsFinalSection->created_at }}
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
