@extends('partials.dashboard.master')

@section('title', __('Edit Solution Main Section'))

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
                        {{ __('Edit solution main section') }}
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
            <form action="{{ route('dashboard.solution-main-sections.update', $solutionMainSection->id) }}" class="form submitted-form" method="post"
                id="submitted-form" data-redirection-url="{{ route('dashboard.solution-main-sections.index') }}">
                @csrf
                @method('PUT')

                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Edit solution main section') . ' : ' . $solutionMainSection->title }}</h3>
                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">

                    <!-- begin :: Row -->
                    <div class="row my-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Solution') }}</label>
                            <select class="form-select" name="solution_id" id="solution_id_inp" data-control="select2">
                                <option value="">{{ __('Select Solution') }}</option>
                                @foreach($solutions as $solution)
                                    <option value="{{ $solution->id }}" {{ old('solution_id', $solutionMainSection->solution_id) == $solution->id ? 'selected' : '' }}>
                                        {{ $solution->title }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="invalid-feedback" id="solution_id"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-6 fw-bold mb-2">{{ __('Title') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_inp" name="title"
                                    placeholder="example" value="{{ old('title', $solutionMainSection->title) }}" />
                                <label for="title_inp">{{ __('Enter the title') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title"></p>

                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row">
                            <div class="mb-4"></div>
                            <label class="fs-6 fw-bold mb-2">{{ __('Description') }}</label>
                            <textarea class="form-control form-control form-control" name="description" id="description_inp"
                                data-kt-autosize="true">{{ old('description', $solutionMainSection->description) }}</textarea>
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
