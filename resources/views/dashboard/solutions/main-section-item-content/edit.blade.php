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
                        {{ __('Edit solution main section item content') }}
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
            <form action="{{ route('dashboard.solution-main-section-item-contents.update', $content->id) }}" class="form submitted-form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.solution-main-section-item-contents.index') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Edit solution main section item content') . ' : ' . $content->main_title }}</h3>
                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row d-flex justify-content-evenly">

                            <div class="d-flex flex-column">
                                <!-- begin :: Upload background image component -->
                                <label class="text-center fw-bold mb-4">{{ __('Background Image') }}</label>
                                <x-dashboard.upload-image-inp name="background_image" :image="$content->background_image" directory="solution-main-section-item-contents" placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                <p class="invalid-feedback" id="background_image"></p>
                                <!-- end   :: Upload background image component -->
                            </div>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Solution Main Section Item') }}</label>
                            <select class="form-select" name="solution_main_section_item_id" id="solution_main_section_item_id_inp" data-control="select2">
                                <option value="">{{ __('Select solution main section item') }}</option>
                                @foreach($availableItems as $item)
                                    <option value="{{ $item->id }}" {{ $content->solution_main_section_item_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->title }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="invalid-feedback" id="solution_main_section_item_id"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Main Title') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="main_title_inp" name="main_title"
                                    placeholder="example" value="{{ $content->main_title }}" />
                                <label for="main_title_inp">{{ __('Enter the main title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="main_title"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Description') }}</label>
                            <textarea class="form-control form-control form-control" name="description" id="description_inp"
                                data-kt-autosize="true">{{ $content->description }}</textarea>
                            <p class="invalid-feedback" id="description"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('First Card Title') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="first_card_title_inp" name="first_card_title"
                                    placeholder="example" value="{{ $content->first_card_title }}" />
                                <label for="first_card_title_inp">{{ __('Enter the first card title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="first_card_title"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Second Card Title') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="second_card_title_inp" name="second_card_title"
                                    placeholder="example" value="{{ $content->second_card_title }}" />
                                <label for="second_card_title_inp">{{ __('Enter the second card title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="second_card_title"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('First Card Description') }}</label>
                            <textarea class="form-control form-control form-control" name="first_card_description" id="first_card_description_inp"
                                data-kt-autosize="true">{{ $content->first_card_description }}</textarea>
                            <p class="invalid-feedback" id="first_card_description"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Second Card Description') }}</label>
                            <textarea class="form-control form-control form-control" name="second_card_description" id="second_card_description_inp"
                                data-kt-autosize="true">{{ $content->second_card_description }}</textarea>
                            <p class="invalid-feedback" id="second_card_description"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Third Card Title') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="third_card_title_inp" name="third_card_title"
                                    placeholder="example" value="{{ $content->third_card_title }}" />
                                <label for="third_card_title_inp">{{ __('Enter the third card title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="third_card_title"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Button Text') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="button_text_inp" name="button_text"
                                    placeholder="example" value="{{ $content->button_text }}" />
                                <label for="button_text_inp">{{ __('Enter the button text') }}</label>
                            </div>
                            <p class="invalid-feedback" id="button_text"></p>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Third Card Description') }}</label>
                            <textarea class="form-control form-control form-control" name="third_card_description" id="third_card_description_inp"
                                data-kt-autosize="true">{{ $content->third_card_description }}</textarea>
                            <p class="invalid-feedback" id="third_card_description"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row d-flex justify-content-evenly">

                            <div class="d-flex flex-column">
                                <!-- begin :: Upload logo component -->
                                <label class="text-center fw-bold mb-4">{{ __('Logo') }}</label>
                                <x-dashboard.upload-image-inp name="logo" :image="$content->logo" directory="solution-main-section-item-contents" placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                <p class="invalid-feedback" id="logo"></p>
                                <!-- end   :: Upload logo component -->
                            </div>

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
