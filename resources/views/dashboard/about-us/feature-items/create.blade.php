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
                        href="{{ route('dashboard.about-us-feature-items.index') }}"
                        class="text-muted text-hover-primary">{{ __('About Us Feature Items') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Add new feature item') }}
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
            <form action="{{ route('dashboard.about-us-feature-items.store') }}" class="form submitted-form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.about-us-feature-items.index') }}" enctype="multipart/form-data">
                @csrf
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Add new feature item') }}</h3>
                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row d-flex justify-content-evenly">

                            <div class="d-flex flex-column">
                                <!-- begin :: Upload icon component -->
                                <label class="text-center fw-bold mb-4">{{ __('Icon') }}</label>
                                <x-dashboard.upload-image-inp name="icon" image="null" :directory="null"
                                    placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                <p class="invalid-feedback" id="icon"></p>
                                <!-- end   :: Upload icon component -->
                            </div>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

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

                            <label class="fs-6 fw-bold mb-2">{{ __("About Us Feature") }}</label>
                            <select class="form-select" data-control="select2" name="about_us_feature_id" id="about_us_feature_id_inp" data-placeholder="{{ __("Choose the feature") }}" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                <option></option>
                                @foreach($availableFeatures as $feature)
                                    <option value="{{ $feature->id }}">{{ $feature->title }}</option>
                                @endforeach
                            </select>

                            <p class="invalid-feedback" id="about_us_feature_id" ></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <div class="mb-4"></div>
                            <label class="fs-6 fw-bold mb-2">{{ __('Description') }}</label>
                            <textarea class="form-control form-control form-control" name="description" id="description_inp"
                                data-kt-autosize="true"></textarea>
                            <p class="invalid-feedback" id="description"></p>


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
