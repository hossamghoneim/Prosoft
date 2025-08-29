@extends('partials.dashboard.master')
@section('content')
    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ __('Solution Middle Section Item Details') }}</h1>
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
                    <li class="breadcrumb-item text-muted">{{ __('Item details') }}</li>
                    <!-- end   :: Item -->
                </ul>
                <!-- end   :: Breadcrumb -->

            </div>

        </div>

    </div>
    <!-- end   :: Subheader -->

    <!-- begin :: Details card -->
    <div class="card mb-2">
        <!-- begin :: Card Body -->
        <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">

            <!-- begin :: Row -->
            <div class="row mb-8">

                <!-- begin :: Column -->
                <div class="col-md-6">

                    <!-- begin :: Label -->
                    <label class="fs-6 fw-bold mb-2">{{ __('Solution Middle Section') }}</label>
                    <!-- end   :: Label -->

                    <!-- begin :: Value -->
                    <p class="text-gray-600">{{ $solutionMiddleSectionItem->solution_middle_section->main_title ?? 'N/A' }}</p>
                    <!-- end   :: Value -->

                </div>
                <!-- end   :: Column -->

                <!-- begin :: Column -->
                <div class="col-md-6">

                    <!-- begin :: Label -->
                    <label class="fs-6 fw-bold mb-2">{{ __('Title') }}</label>
                    <!-- end   :: Label -->

                    <!-- begin :: Value -->
                    <p class="text-gray-600">{{ $solutionMiddleSectionItem->title }}</p>
                    <!-- end   :: Value -->

                </div>
                <!-- end   :: Column -->

            </div>
            <!-- end   :: Row -->

            <!-- begin :: Row -->
            <div class="row mb-8">

                <!-- begin :: Column -->
                <div class="col-md-12">

                    <!-- begin :: Label -->
                    <label class="fs-6 fw-bold mb-2">{{ __('Description') }}</label>
                    <!-- end   :: Label -->

                    <!-- begin :: Value -->
                    <p class="text-gray-600">{{ $solutionMiddleSectionItem->description }}</p>
                    <!-- end   :: Value -->

                </div>
                <!-- end   :: Column -->

            </div>
            <!-- end   :: Row -->

            <!-- begin :: Row -->
            <div class="row mb-8">

                <!-- begin :: Column -->
                <div class="col-md-6">

                    <!-- begin :: Label -->
                    <label class="fs-6 fw-bold mb-2">{{ __('Icon') }}</label>
                    <!-- end   :: Label -->

                    <!-- begin :: Value -->
                    @if($solutionMiddleSectionItem->icon)
                        <img src="{{ $solutionMiddleSectionItem->icon }}" alt="Icon" class="img-fluid" style="max-width: 100px;">
                    @else
                        <p class="text-gray-600">No icon uploaded</p>
                    @endif
                    <!-- end   :: Value -->

                </div>
                <!-- end   :: Column -->

                <!-- begin :: Column -->
                <div class="col-md-6">

                    <!-- begin :: Label -->
                    <label class="fs-6 fw-bold mb-2">{{ __('Order') }}</label>
                    <!-- end   :: Label -->

                    <!-- begin :: Value -->
                    <p class="text-gray-600">{{ $solutionMiddleSectionItem->order }}</p>
                    <!-- end   :: Value -->

                </div>
                <!-- end   :: Column -->

            </div>
            <!-- end   :: Row -->

            <!-- begin :: Row -->
            <div class="row mb-8">

                <!-- begin :: Column -->
                <div class="col-md-6">

                    <!-- begin :: Label -->
                    <label class="fs-6 fw-bold mb-2">{{ __('Status') }}</label>
                    <!-- end   :: Label -->

                    <!-- begin :: Value -->
                    <span class="badge badge-{{ $solutionMiddleSectionItem->is_active ? 'success' : 'danger' }}">
                        {{ $solutionMiddleSectionItem->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <!-- end   :: Value -->

                </div>
                <!-- end   :: Column -->

                <!-- begin :: Column -->
                <div class="col-md-6">

                    <!-- begin :: Label -->
                    <label class="fs-6 fw-bold mb-2">{{ __('Created At') }}</label>
                    <!-- end   :: Label -->

                    <!-- begin :: Value -->
                    <p class="text-gray-600">{{ $solutionMiddleSectionItem->created_at }}</p>
                    <!-- end   :: Value -->

                </div>
                <!-- end   :: Column -->

            </div>
            <!-- end   :: Row -->

            <!-- begin :: Actions -->
            <div class="text-center">

                <a href="{{ route('dashboard.solution-middle-section-items.edit', $solutionMiddleSectionItem->id) }}" class="btn btn-primary me-2">
                    {{ __('Edit') }}
                </a>

                <a href="{{ route('dashboard.solution-middle-section-items.index') }}" class="btn btn-secondary">
                    {{ __('Back to List') }}
                </a>

            </div>
            <!-- end   :: Actions -->

        </div>
        <!-- end   :: Card Body -->
    </div>
    <!-- end   :: Details card -->

@endsection
