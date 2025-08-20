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
                        href="{{ route('dashboard.locations.index') }}"
                        class="text-muted text-hover-primary">{{ __('Locations') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Add new location') }}
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
            <form action="{{ route('dashboard.locations.store') }}" class="form submitted-form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.locations.index') }}">
                @csrf
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Add new location') }}</h3>
                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Title') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_inp" name="title"
                                    placeholder="example" />
                                <label for="title_inp">{{ __('Enter the title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Order') }}</label>
                            <div class="form-floating">
                                <input type="number" class="form-control" id="order_inp" name="order"
                                    placeholder="1" min="1" />
                                <label for="order_inp">{{ __('Enter the order') }}</label>
                            </div>
                            <p class="invalid-feedback" id="order"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <div class="mb-4"></div>
                            <label class="fs-6 fw-bold mb-2">{{ __('Latitude') }}</label>
                            <div class="form-floating">
                                <input type="number" step="any" class="form-control" id="latitude_inp" name="latitude"
                                    placeholder="30.0787215" />
                                <label for="latitude_inp">{{ __('Enter the latitude') }}</label>
                            </div>
                            <p class="invalid-feedback" id="latitude"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <div class="mb-4"></div>
                            <label class="fs-6 fw-bold mb-2">{{ __('Longitude') }}</label>
                            <div class="form-floating">
                                <input type="number" step="any" class="form-control" id="longitude_inp" name="longitude"
                                    placeholder="30.9996055" />
                                <label for="longitude_inp">{{ __('Enter the longitude') }}</label>
                            </div>
                            <p class="invalid-feedback" id="longitude"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row">
                            <div class="mb-4"></div>
                            <label class="fs-6 fw-bold mb-2">{{ __('Address') }}</label>
                            <textarea class="form-control form-control form-control" name="address" id="address_inp"
                                data-kt-autosize="true" rows="3"></textarea>
                            <p class="invalid-feedback" id="address"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row">
                            <div class="mb-4"></div>
                            <label class="fs-6 fw-bold mb-2">{{ __('Iframe URL') }}</label>
                            <textarea class="form-control form-control form-control" name="iframe_url" id="iframe_url_inp"
                                data-kt-autosize="true" rows="3"></textarea>
                            <p class="invalid-feedback" id="iframe_url"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                </div>
                <!-- end   :: Inputs wrapper -->

                <!-- begin :: Form footer -->
                <div class="form-footer">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary" id="submit-btn">

                        <span class="indicator-label">{{ __('Save') }}</span>

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
@endsection
