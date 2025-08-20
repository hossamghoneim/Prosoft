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
                        href="{{ route('dashboard.partners.index') }}"
                        class="text-muted text-hover-primary">{{ __('Partners') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Edit partner') }}
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
            <form action="{{ route('dashboard.partners.update', $partner->id) }}" class="form submitted-form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.partners.index') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Edit partner') . ' : ' . $partner->title }}</h3>
                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row d-flex justify-content-center">

                            <div class="d-flex flex-column">
                                <!-- begin :: Upload inner logo component -->
                                <label class="text-center fw-bold mb-4">{{ __('Inner Logo') }}</label>
                                <x-dashboard.upload-image-inp name="inner_logo" :image="$partner->inner_logo" directory="partner-logos" placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                <p class="invalid-feedback" id="inner_logo"></p>
                                <!-- end   :: Upload inner logo component -->
                            </div>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row d-flex justify-content-center">

                            <div class="d-flex flex-column">
                                <!-- begin :: Upload outer logo component -->
                                <label class="text-center fw-bold mb-4">{{ __('Outer Logo') }}</label>
                                <x-dashboard.upload-image-inp name="outer_logo" :image="$partner->outer_logo" directory="partner-logos" placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                <p class="invalid-feedback" id="outer_logo"></p>
                                <!-- end   :: Upload outer logo component -->
                            </div>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Partnership Section') }}</label>
                            <select class="form-select" name="partnership_section_id" id="partnership_section_id_inp" data-control="select2">
                                <option value="">{{ __('Select partnership section') }}</option>
                                @foreach($availableSections as $section)
                                    <option value="{{ $section->id }}" {{ $partner->partnership_section_id == $section->id ? 'selected' : '' }}>
                                        {{ $section->title }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="invalid-feedback" id="partnership_section_id"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Title') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_inp" name="title"
                                    placeholder="example" value="{{ $partner->title }}" />
                                <label for="title_inp">{{ __('Enter the title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Button Text') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="button_text_inp" name="button_text"
                                    placeholder="example" value="{{ $partner->button_text }}" />
                                <label for="button_text_inp">{{ __('Enter the button text') }}</label>
                            </div>
                            <p class="invalid-feedback" id="button_text"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Button URL') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="button_url_inp" name="button_url"
                                    placeholder="example" value="{{ $partner->button_url }}" />
                                <label for="button_url_inp">{{ __('Enter the button URL') }}</label>
                            </div>
                            <p class="invalid-feedback" id="button_url"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Background Color') }}</label>
                            <div class="form-floating">
                                <input type="color" class="form-control" id="background_color_inp" name="background_color"
                                    value="{{ $partner->background_color }}" />
                                <label for="background_color_inp">{{ __('Select background color') }}</label>
                            </div>
                            <p class="invalid-feedback" id="background_color"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Description') }}</label>
                            <textarea class="form-control form-control form-control" name="description" id="description_inp"
                                data-kt-autosize="true">{{ $partner->description }}</textarea>
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
