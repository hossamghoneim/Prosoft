@extends('partials.dashboard.master')
@section('content')

    <!-- begin :: Subheader -->
    <div class="toolbar" >
        <!--begin::Container-->
        <div  class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ __("Dashboard") }}

                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->

                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1"></small>
                <!--end::Description-->

            </h1>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Primary button-->
                <a href="/" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-globe fs-6"></i> {{ __("website") }} </a>
                <a href="#" target="_blank" class="btn btn-sm btn-dark"><i class="bi bi-envelope-fill fs-6"></i> {{ __("mail") }} </a>
                <!--end::Primary button-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
    <!-- end   :: Subheader -->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid" style="margin:1.5rem">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-6">
                    <!--begin::Statistics Widget 3-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex flex-stack flex-grow-1 card-p">
                                <div class="d-flex flex-column me-2">
                                    <a href="#" class="text-dark text-hover-primary fw-bold fs-3">{{ __('Orders rate') }}</a>
                                </div>
                                <span class="symbol symbol-50px">
                                    <span class="symbol-label fs-5 fw-bold bg-light-primary text-primary">+ {{ array_sum( $ordersRate['data'] ) }}</span>
                                </span>
                            </div>
                            <div class="card-rounded-bottom" id="orders_rate_chart" data-kt-chart-color="primary" style="height: 150px"></div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget 3-->
                </div>
                <div class="col-xl-6">
                    <!--begin::Statistics Widget 3-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex flex-stack flex-grow-1 card-p">
                                <div class="d-flex flex-column me-2">
                                    <a href="#" class="text-dark text-hover-primary fw-bold fs-3">{{ __('Clients rate') }}</a>
                                </div>
                                <span class="symbol symbol-50px">
                                    <span class="symbol-label fs-5 fw-bold bg-light-primary text-primary">+ {{ array_sum( $clientsRate['data'] ) }}</span>
                                </span>
                            </div>
                            <div class="card-rounded-bottom" id="clients_rate_chart" data-kt-chart-color="primary" style="height: 150px"></div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget 3-->
                </div>

            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-xl-10">
                <!--begin::Col-->
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                    <!--begin::Card widget 4-->
                    <div class="card card-flush h-md-50 mb-5 mb-xl-10">

                        <!--begin::Header-->
                        <div class="card-header pt-5 mb-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ ( int ) $totalOrders->sum('sub_total') }}</span>
                                    <!--end::Amount-->
                                    <!--begin::Currency-->
                                    <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">{{ __('QAR') }}</span>
                                    <!--end::Currency-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Subtitle-->
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">{{ __('Total Sales') }}</span>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-2 pb-4 d-flex justify-content-center align-items-center px-0">
                            <!--begin::Chart-->
                        @if( $totalSalesCategories->count() )
                            <div class="d-flex flex-center pt-2">
                                <canvas id="categories_sales_chart"></canvas>
                            </div>
                        @else
                            <h6 class="text-muted">{{ __('There are no sales yet') }}</h6>
                        @endif
                        <!--end::Chart-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card widget 4-->
                    <!--begin::Card widget 5-->
                    <div class="card card-flush h-md-50 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $thisMonthOrders }}</span>
                                    <!--end::Amount-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Subtitle-->
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">{{ __('Orders This Month') }}</span>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex align-items-end pt-0">
                            <!--begin::Progress-->
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                    @if( $ordersGoalThisMonth > $thisMonthOrders )  <!-- goal is not achieved yet -->
                                    <span class="fw-bolder fs-6 text-dark">{{ $ordersGoalThisMonth - $thisMonthOrders }} {{ __('order to Goal') }}</span>
                                    <span class="fw-bold fs-6 text-gray-400">{{ $thisMonthOrders * 100 / $ordersGoalThisMonth }}%</span>
                                    @else
                                        <span class="fw-bolder fs-6 text-dark">{{ __('Goal is achieved') }}</span>
                                        <span class="fw-bold fs-6 text-gray-400">{{ $thisMonthOrders * 100 / $ordersGoalThisMonth }}%</span>
                                    @endif

                                </div>
                                <div class="h-8px mx-3 w-100 bg-light-primary rounded">
                                    <div class="bg-primary rounded h-8px" role="progressbar" style="width:{{ $ordersGoalThisMonth > $thisMonthOrders ? ( $thisMonthOrders * 100 / $ordersGoalThisMonth ) : 100 }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <!--end::Progress-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card widget 5-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                    <!--begin::Card widget 6-->
                    <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5 mb-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ __('Categories') }}</span>
                                    <!--end::Amount-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Subtitle-->
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">{{ __('Products categories') }}</span>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-2 pb-4 d-flex justify-content-center align-items-center px-0">
                            <!--begin::Chart-->
                            @if( $productsCategories->count() )
                                <div class="d-flex flex-center p-2">
                                    <canvas id="products_categories_chart"></canvas>
                                </div>
                            @else
                                <h6 class="text-muted">{{ __('There are no categories yet') }}</h6>
                        @endif
                        <!--end::Chart-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card widget 6-->
                    <!--begin::Card widget 7-->
                    <div class="card card-flush h-md-50 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Amount-->
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $thisMonthClients->count() }}</span>
                                <!--end::Amount-->
                                <!--begin::Subtitle-->
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">{{ __('New Clients This Month') }}</span>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-column justify-content-end pe-0">
                            <!--begin::Users group-->
                            <div class="symbol-group symbol-hover flex-nowrap">
                                @foreach($thisMonthClients->take(6) as $client)
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{ $client->name }}">
                                        <img alt="Pic" src="{{ getFilePath( $client->image ) }}" />
                                    </div>
                                @endforeach
                                @if( $thisMonthClients->count() > 6 )
                                    <a href="javascript:" class="symbol symbol-35px symbol-circle">
                                        <span class="symbol-label bg-light text-gray-400 fs-8 fw-bold">+{{ $thisMonthClients->count() - 6  }}</span>
                                    </a>
                                @endif
                            </div>
                            <!--end::Users group-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card widget 7-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
                    <!--begin::Chart widget 3-->
                    <div class="card card-flush overflow-hidden h-md-100">
                        <!--begin::Header-->
                        <div class="card-header py-5">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">{{ __('Sales This Month') }}</span>
                                <span class="text-gray-400 mt-1 fw-semibold fs-6"></span>
                            </h3>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                            <!--begin::Statistics-->
                            <div class="px-9 mb-5">
                                <!--begin::Statistics-->
                                <div class="d-flex mb-2">
                                    <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ collect($dailySales)->sum('sales') }}</span>
                                    <span class="fs-4 fw-semibold text-gray-400 me-1">{{ __('QAR') }}</span>
                                </div>
                                <!--end::Statistics-->
                            </div>
                            <!--end::Statistics-->
                            <!--begin::Chart-->
                            <div id="monthly_sales_chart" class="min-h-auto ps-4 pe-6" style="height: 300px"></div>
                            <!--end::Chart-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Chart widget 3-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->

            <!--end::Dashboard-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
@push('scripts')
    <script src="{{asset('js/dashboard/reports.js')}}"></script>

    <script>
        let clientsMonthlyRate     = @json($clientsRate);
        let ordersMonthlyRate      = @json($ordersRate);
        let dailySales             = @json($dailySales);
        let productsCategories     = [
                ... @json( $productsCategories->take(3) ),
            { product_count: {{ $productsCategories->splice(3)->sum('products_count') }} , name: "{{ __('Others') }}"  }
        ]
        let categoriesSales        = [
                ... @json( $totalSalesCategories->take(3)->values() ),
            { total_price: {{ $totalSalesCategories->splice(3)->sum('total_price') }} , category: "{{ __('Others') }}"  }
        ]

        initOrdersRatingChart();
        iniClientsRatingChart();
    </script>

    <script src="{{asset('dashboard-assets/js/widgets.bundle.js')}}"></script>
    <script src="{{asset('dashboard-assets/js/custom/widgets.js')}}"></script>
    <script src="{{asset('js/dashboard/statistics.js')}}"></script>
@endpush
