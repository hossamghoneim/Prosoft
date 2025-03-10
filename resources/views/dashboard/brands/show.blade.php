@extends('partials.dashboard.master')
@section('content')

    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                 data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                 class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a href="{{ route('dashboard.brands.index') }}"
                    class="text-muted text-hover-primary">{{ __("Brands") }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __("brand data") }}
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
                <h3 class="fw-bolder text-dark">{{ __("brand data") . ' : ' . $brand->name }}</h3>
            </div>
            <!-- end   :: Card header -->

            <!-- begin :: Inputs wrapper -->
            <div class="inputs-wrapper">

                <!-- begin :: Row -->
                <div class="row mb-10">

                    <!-- begin :: Column -->
                    <div class="col-md-12 fv-row d-flex justify-content-evenly">

                        <div class="d-flex flex-column">
                            <!-- begin :: Upload image component -->
                            <label class="text-center fw-bold mb-4">{{ __("Image") }}</label>
                            <x-dashboard.upload-image-inp name="image" :image="$brand->image" directory="Brands" placeholder="default.jpg" type="show"  ></x-dashboard.upload-image-inp>
                            <!-- end   :: Upload image component -->
                        </div>

                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

                <!-- begin :: Row -->
                <div class="row mb-10">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __("Name in arabic") }}</label>
                        <input type="text" class="form-control" value="{{ $brand->name_ar }}" readonly />

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-6 fw-bold mb-2">{{ __("Name in english") }}</label>
                        <input type="text" class="form-control" value="{{ $brand->name_en }}" readonly />


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
                <a href="{{ route('dashboard.brands.index') }}" class="btn btn-primary" >

                    <span class="indicator-label">{{ __("Back") }}</span>

                </a>
                <!-- end   :: Submit btn -->

            </div>
            <!-- end   :: Form footer -->
            <!-- end   :: Form -->
        </div>
        <!-- end   :: Card body -->
    </div>

@endsection
