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
                        href="{{ route('dashboard.home-secondary-sections.index') }}"
                        class="text-muted text-hover-primary">{{ __('Home Secondary') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Edit secondary') }}
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
            <form action="{{ route('dashboard.home-secondary-sections.update', $homeSecondarySection->id) }}" class="form submitted-form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.home-secondary-sections.index') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Edit secondary') . ' : ' . $homeSecondarySection->main_title }}</h3>
                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">

                    <!-- begin :: Main Section -->
                    <div class="row my-10">
                        <div class="col-12">
                            <h4 class="fw-bold text-dark mb-5">{{ __('Main Section') }}</h4>
                        </div>
                    </div>

                    <div class="row my-10">
                        <!-- begin :: Main Title -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Main Title') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="main_title_inp" name="main_title"
                                    placeholder="example" value="{{ $homeSecondarySection->main_title }}" />
                                <label for="main_title_inp">{{ __('Enter the main title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="main_title"></p>
                        </div>
                        <!-- end   :: Main Title -->

                        <!-- begin :: Background Image -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Background Image') }}</label>
                            <div class="form-floating">
                                <input type="file" class="form-control" id="background_image_inp" accept="image/*" name="background_image" placeholder="example" />
                                <label for="background_image_inp">{{ __('Upload background image') }}</label>
                            </div>
                            <p class="invalid-feedback" id="background_image"></p>
                        </div>
                        <!-- end   :: Background Image -->
                    </div>

                    <div class="row my-10">
                        <!-- begin :: Main Description -->
                        <div class="col-12 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Main Description') }}</label>
                            <textarea class="form-control form-control form-control" name="main_description" id="main_description_inp"
                                data-kt-autosize="true">{{ $homeSecondarySection->main_description }}</textarea>
                            <p class="invalid-feedback" id="main_description"></p>
                        </div>
                        <!-- end   :: Main Description -->
                    </div>

                    <!-- begin :: First Card Section -->
                    <div class="row my-10">
                        <div class="col-12">
                            <h4 class="fw-bold text-dark mb-5">{{ __('First Card') }}</h4>
                        </div>
                    </div>

                    <div class="row my-10">
                        <!-- begin :: First Card Logo -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('First Card Logo') }}</label>
                            <div class="form-floating">
                                <input type="file" class="form-control" id="first_card_logo_inp" accept="image/*" name="first_card_logo" placeholder="example" />
                                <label for="first_card_logo_inp">{{ __('Upload first card logo') }}</label>
                            </div>
                            <p class="invalid-feedback" id="first_card_logo"></p>
                        </div>
                        <!-- end   :: First Card Logo -->

                        <!-- begin :: First Card Title -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('First Card Title') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="first_card_title_inp" name="first_card_title"
                                    placeholder="example" value="{{ $homeSecondarySection->first_card_title }}" />
                                <label for="first_card_title_inp">{{ __('Enter the first card title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="first_card_title"></p>
                        </div>
                        <!-- end   :: First Card Title -->
                    </div>

                    <div class="row my-10">
                        <!-- begin :: First Card Description -->
                        <div class="col-12 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('First Card Description') }}</label>
                            <textarea class="form-control form-control form-control" name="first_card_description" id="first_card_description_inp"
                                data-kt-autosize="true">{{ $homeSecondarySection->first_card_description }}</textarea>
                            <p class="invalid-feedback" id="first_card_description"></p>
                        </div>
                        <!-- end   :: First Card Description -->
                    </div>

                    <!-- begin :: Second Card Section -->
                    <div class="row my-10">
                        <div class="col-12">
                            <h4 class="fw-bold text-dark mb-5">{{ __('Second Card') }}</h4>
                        </div>
                    </div>

                    <div class="row my-10">
                        <!-- begin :: Second Card Logo -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Second Card Logo') }}</label>
                            <div class="form-floating">
                                <input type="file" class="form-control" id="second_card_logo_inp" accept="image/*" name="second_card_logo" placeholder="example" />
                                <label for="second_card_logo_inp">{{ __('Upload second card logo') }}</label>
                            </div>
                            <p class="invalid-feedback" id="second_card_logo"></p>
                        </div>
                        <!-- end   :: Second Card Logo -->

                        <!-- begin :: Second Card Title -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Second Card Title') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="second_card_title_inp" name="second_card_title"
                                    placeholder="example" value="{{ $homeSecondarySection->second_card_title }}" />
                                <label for="second_card_title_inp">{{ __('Enter the second card title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="second_card_title"></p>
                        </div>
                        <!-- end   :: Second Card Title -->
                    </div>

                    <div class="row my-10">
                        <!-- begin :: Second Card Description -->
                        <div class="col-12 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Second Card Description') }}</label>
                            <textarea class="form-control form-control form-control" name="second_card_description" id="second_card_description_inp"
                                data-kt-autosize="true">{{ $homeSecondarySection->second_card_description }}</textarea>
                            <p class="invalid-feedback" id="second_card_description"></p>
                        </div>
                        <!-- end   :: Second Card Description -->
                    </div>

                    <!-- begin :: Third Card Section -->
                    <div class="row my-10">
                        <div class="col-12">
                            <h4 class="fw-bold text-dark mb-5">{{ __('Third Card') }}</h4>
                        </div>
                    </div>

                    <div class="row my-10">
                        <!-- begin :: Third Card Logo -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Third Card Logo') }}</label>
                            <div class="form-floating">
                                <input type="file" class="form-control" id="third_card_logo_inp" accept="image/*" name="third_card_logo" placeholder="example" />
                                <label for="third_card_logo_inp">{{ __('Upload third card logo') }}</label>
                            </div>
                            <p class="invalid-feedback" id="third_card_logo"></p>
                        </div>
                        <!-- end   :: Third Card Logo -->

                        <!-- begin :: Third Card Title -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Third Card Title') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="third_card_title_inp" name="third_card_title"
                                    placeholder="example" value="{{ $homeSecondarySection->third_card_title }}" />
                                <label for="third_card_title_inp">{{ __('Enter the third card title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="third_card_title"></p>
                        </div>
                        <!-- end   :: Third Card Title -->
                    </div>

                    <div class="row my-10">
                        <!-- begin :: Third Card Description -->
                        <div class="col-12 fv-row">
                            <label class="fs-6 fw-bold mb-2">{{ __('Third Card Description') }}</label>
                            <textarea class="form-control form-control form-control" name="third_card_description" id="third_card_description_inp"
                                data-kt-autosize="true">{{ $homeSecondarySection->third_card_description }}</textarea>
                            <p class="invalid-feedback" id="third_card_description"></p>
                        </div>
                        <!-- end   :: Third Card Description -->
                    </div>

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
