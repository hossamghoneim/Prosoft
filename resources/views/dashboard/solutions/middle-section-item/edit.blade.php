@extends('partials.dashboard.master')
@section('content')
    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ __('Edit Solution Middle Section Item') }}</h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard.solution-middle-section-items.index') }}"
                            class="text-muted text-hover-primary">{{ __('Solution Middle Section Items') }}</a>
                    </li>
                    <!-- end   :: Item -->

                    <!-- begin :: Item -->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>
                    <!-- end   :: Item -->

                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">{{ __('Edit item') }}</li>
                    <!-- end   :: Item -->
                </ul>
                <!-- end   :: Breadcrumb -->

            </div>

        </div>

    </div>
    <!-- end   :: Subheader -->

    <!-- begin :: Form card -->
    <div class="card mb-2">
        <!-- begin :: Card Body -->
        <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">

            <!-- begin :: Form -->
            <form action="{{ route('dashboard.solution-middle-section-items.update', $solutionMiddleSectionItem->id) }}" class="form submitted-form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.solution-middle-section-items.index') }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <!-- begin :: Row -->
                <div class="row mb-8">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <!-- begin :: Label -->
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required">{{ __('Solution Middle Section') }}</span>
                        </label>
                        <!-- end   :: Label -->

                        <!-- begin :: Select -->
                        <select class="form-select form-select-solid" name="solution_middle_section_id" data-control="select2"
                            data-placeholder="{{ __('Select a solution middle section') }}" data-allow-clear="true">

                            <option></option>

                            @foreach($availableSections as $section)
                                <option value="{{ $section->id }}" {{ old('solution_middle_section_id', $solutionMiddleSectionItem->solution_middle_section_id) == $section->id ? 'selected' : '' }}>
                                    {{ $section->main_title }}
                                </option>
                            @endforeach

                        </select>
                        <!-- end   :: Select -->

                        <!-- begin :: Error -->
                        @error('solution_middle_section_id')
                            <div class="fv-plugins-message-container invalid-feedback">
                                <div data-field="name" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                        @enderror
                        <!-- end   :: Error -->

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <!-- begin :: Label -->
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required">{{ __('Title') }}</span>
                        </label>
                        <!-- end   :: Label -->

                        <!-- begin :: Input -->
                        <input type="text" class="form-control form-control-solid" name="title" value="{{ old('title', $solutionMiddleSectionItem->title) }}"
                            placeholder="{{ __('Enter title') }}" />
                        <!-- end   :: Input -->

                        <!-- begin :: Error -->
                        @error('title')
                            <div class="fv-plugins-message-container invalid-feedback">
                                <div data-field="name" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                        @enderror
                        <!-- end   :: Error -->

                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

                <!-- begin :: Row -->
                <div class="row mb-8">

                    <!-- begin :: Column -->
                    <div class="col-md-12 fv-row">

                        <!-- begin :: Label -->
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required">{{ __('Description') }}</span>
                        </label>
                        <!-- end   :: Label -->

                        <!-- begin :: Textarea -->
                        <textarea class="form-control form-control-solid" name="description" rows="4"
                            placeholder="{{ __('Enter description') }}">{{ old('description', $solutionMiddleSectionItem->description) }}</textarea>
                        <!-- end   :: Textarea -->

                        <!-- begin :: Error -->
                        @error('description')
                            <div class="fv-plugins-message-container invalid-feedback">
                                <div data-field="name" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                        @enderror
                        <!-- end   :: Error -->

                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

                <!-- begin :: Row -->
                <div class="row mb-8">

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <!-- begin :: Label -->
                        <label class="fs-6 fw-bold mb-2">
                            {{ __('Icon') }}
                        </label>
                        <!-- end   :: Label -->

                        <!-- begin :: Upload Image Input -->
                        <x-dashboard.upload-image-inp name="icon" :image="$solutionMiddleSectionItem->getRawOriginal('icon')" directory="solution-middle-section-items" placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                        <!-- end   :: Upload Image Input -->

                        <!-- begin :: Error -->
                        @error('icon')
                            <div class="fv-plugins-message-container invalid-feedback">
                                <div data-field="name" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                        @enderror
                        <!-- end   :: Error -->

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <!-- begin :: Label -->
                        <label class="fs-6 fw-bold mb-2">
                            <span class="required">{{ __('Order') }}</span>
                        </label>
                        <!-- end   :: Label -->

                        <!-- begin :: Input -->
                        <input type="number" class="form-control form-control-solid" name="order" value="{{ old('order', $solutionMiddleSectionItem->order) }}"
                            placeholder="{{ __('Enter order') }}" min="1" />
                        <!-- end   :: Input -->

                        <!-- begin :: Error -->
                        @error('order')
                            <div class="fv-plugins-message-container invalid-feedback">
                                <div data-field="name" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                        @enderror
                        <!-- end   :: Error -->

                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

                <!-- begin :: Form Actions -->
                <div class="text-center">

                    <button type="submit" class="btn btn-primary" id="kt_submit">

                        <span class="indicator-label">{{ __('Update') }}</span>

                        <!-- begin :: Loading indicator -->
                        <span class="indicator-progress">{{ __('Please wait ...') }}

                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>

                        </span>
                        <!-- end   :: Loading indicator -->

                    </button>

                </div>
                <!-- end   :: Form Actions -->

            </form>
            <!-- end   :: Form -->

        </div>
        <!-- end   :: Card Body -->
    </div>
    <!-- end   :: Form card -->

@endsection
