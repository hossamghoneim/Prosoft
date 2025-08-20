@extends('partials.dashboard.master')

@section('title', __('Solution Main Section Details'))

@section('content')
    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a
                        href="{{ route('dashboard.solution-main-sections.index') }}"
                        class="text-muted text-hover-primary">{{ __('Solution Main Section') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Solution main section details') }}
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
                <h3 class="fw-bolder text-dark">{{ __('Solution main section details') . ' : ' . $solutionMainSection->title }}</h3>
            </div>
            <!-- end   :: Card header -->

            <!-- begin :: Content wrapper -->
            <div class="content-wrapper p-10">

                <!-- begin :: Row -->
                <div class="row my-10">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Title') }}</label>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="title_inp" name="title"
                                placeholder="example" value="{{ $solutionMainSection->title }}" readonly />
                            <label for="title_inp">{{ __('Enter the title') }}</label>
                        </div>
                        <p class="invalid-feedback" id="title"></p>

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __('Solution') }}</label>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="solution_inp" name="solution"
                                placeholder="example" value="{{ $solutionMainSection->solution->title ?? 'N/A' }}" readonly />
                            <label for="solution_inp">{{ __('Solution') }}</label>
                        </div>
                        <p class="invalid-feedback" id="solution"></p>

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-12 fv-row">
                        <div class="mb-4"></div>
                        <label class="fs-6 fw-bold mb-2">{{ __('Description') }}</label>
                        <textarea class="form-control form-control form-control" name="description" id="description_inp"
                            data-kt-autosize="true" readonly>{{ $solutionMainSection->description }}</textarea>
                        <p class="invalid-feedback" id="description"></p>

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
                            @if($solutionMainSection->is_active)
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
                        <label class="fs-6 fw-bold mb-2">{{ __('Created Date') }}</label>
                        <div class="form-control form-control-solid">
                            {{ $solutionMainSection->created_at }}
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
