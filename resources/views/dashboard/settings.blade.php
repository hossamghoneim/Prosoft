@extends('partials.dashboard.master')
@section('content')

    <!--begin::Card-->
    <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10 mt-0"
         style="background-size: auto  calc(100% + 10rem); background-position: {{ isArabic() ? 'left' : 'right' }} ; background-image: url('{{ asset('dashboard-assets/media/illustrations/sketchy-1/4.png') }}')">
        <!--begin::Card header-->
        <div class="p-6">
            <div class="d-flex align-items-center">
                <!--begin::Icon-->
                <div class="symbol symbol-circle me-5">
                    <div class="symbol-label bg-transparent text-primary border border-secondary border-dashed">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs020.svg-->
                        <span>
                            <i class="bi bi-gear-fill fs-1 text-primary"></i>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <!--end::Icon-->
                <!--begin::Title-->
                <div class="d-flex flex-column">
                    <h2>{{ __("settings") }}</h2>
                </div>
                <!--end::Title-->
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pb-0">
            <!--begin::Navs-->
            <div class="d-flex overflow-auto h-55px">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold flex-nowrap">

                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 setting-label active" id="footer-settings-label"
                           href="javascript:" onclick="changeSettingView('footer')">{{ __("Footer") }}</a>
                    </li>
                    <!--end::Nav item-->

                </ul>
            </div>
            <!--begin::Navs-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    <!--begin::Form-->
    <form action="{{ route('dashboard.settings.update') }}" class="form submitted-form" method="post"
          data-redirection-url="{{ route('dashboard.settings.index') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Begin :: Footer Settings Card -->
        <input type="hidden" name="setting_type" value="footer" id="setting-type-inp">




        <!-- Begin :: Footer Settings Card -->
        <div class="card card-flush setting-card" id="footer-settings-card">
            <!--begin::Card header-->
            <div class="card-header pt-8">

                <div class="card-title">
                    <h2>{{ __("Footer") }}</h2>
                </div>

                <div class="card-title">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary mx-4" id="submit-btn-footer">

                        <span class="indicator-label">{{ __("Save") }}</span>

                        <!-- begin :: Indicator -->
                        <span class="indicator-progress">{{ __("Please wait ...") }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!-- end   :: Indicator -->

                    </button>
                    <!-- end   :: Submit btn -->

                </div>

            </div>
            <!--end::Card header-->

            <!-- Begin :: Card body -->
            <div class="card-body">

                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-12">

                        <label class="form-label">{{ __("Description") }}</label>
                        <textarea class="form-control form-control form-control" name="footer_description"
                                  id="footer_description_inp"
                                  data-kt-autosize="true">{{ $footerSettings['description'] ?? 'Prosoft is a specialized value-added distributor with 30+ years of experience in the enterprise IT space. We partner with global technology vendors to bring their solutions to market through our network of trusted experts.' }}</textarea>
                        <p class="invalid-feedback" id="footer_description"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __("LinkedIn URL") }}</label>
                        <input type="text" class="form-control" name="footer_linkedin_url"
                               value="{{ $footerSettings['linkedin_url'] ?? 'https://www.linkedin.com/company/prosoft-infomation-systems/' }}" id="footer_linkedin_url_inp"
                               placeholder="{{ __("Enter the LinkedIn page url") }}">
                        <p class="invalid-feedback" id="footer_linkedin_url"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __("Banner Image") }}</label>
                        <x-dashboard.upload-image-inp name="footer_banner_image" :image="$footerSettings['banner_image'] ?? null" placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                        <p class="invalid-feedback" id="footer_banner_image"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __("Logo") }}</label>
                        <x-dashboard.upload-image-inp name="footer_logo" :image="$footerSettings['logo'] ?? null" placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                        <p class="invalid-feedback" id="footer_logo"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

            </div>
            <!-- End   :: Card body -->

        </div>
        <!-- End   :: Footer Settings Card -->

    </form>
    <!--end::Form-->

@endsection
@push('scripts')
{{--    <script src="{{ asset('dashboard-assets/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>--}}
    <script>



        $(document).ready(() => {
            console.log('Settings page loaded, initializing...');

            // Initialize TinyMCE only if needed
            if (typeof initTinyMc === 'function') {
                initTinyMc(true);
            }




        });

    </script>
@endpush

