<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo w-100 h-75px" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ route('dashboard.index') }}" class="m-auto">
            <img alt="Logo" src="{{ asset('dashboard-assets/media/car.png')}}" class="h-40px logo" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="white" />
                    <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="white" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">

                @canany(['list_view@brands' , 'list_view@car-models'])
                    <!-- begin :: cars section -->
                    <div class="menu-item mb-3">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __("Car Parts") }}</span>
                        </div>
                    </div>
                @endcanany


                @can('list_view@brands')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('brands') }}" href="{{ route('dashboard.brands.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                        <span class="menu-icon">
                                <i class="fa fa-star"></i>
                        </span>
                            <span class="menu-title"> {{ __("Brands") }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@car-models')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('car-models') }}" href="{{ route('dashboard.car-models.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                        <span class="menu-icon">
                                <i class="fa fa-car-side"></i>
                        </span>
                            <span class="menu-title"> {{ __("Car Models") }}</span>
                        </a>
                    </div>
                @endcan

                @canany(['list_view@products' , 'list_view@categories' , 'list_view@tags'])
                    <div class="menu-item mb-3">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __("Products") }}</span>
                        </div>
                    </div>
                @endcanany


                @can('list_view@tags')
                <div class="menu-item">
                    <a class="menu-link {{ isTabActive('tags') }}" href="{{ route('dashboard.tags.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                        <span class="menu-icon">
                                <i class="fa fa-tag"></i>
                        </span>
                        <span class="menu-title"> {{ __("Tags") }}</span>
                    </a>
                </div>
                @endcan

                @can('list_view@categories')
                <div class="menu-item">
                    <a class="menu-link {{ isTabActive('categories') }}" href="{{ route('dashboard.categories.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                    <span class="menu-icon">
                            <i class="fa fa-box"></i>
                    </span>
                    <span class="menu-title"> {{ __("Categories") }}</span>
                    </a>
                </div>
                @endcan

                @can('list_view@products')
                <div class="menu-item">
                    <a class="menu-link {{ isTabActive('products') }}" href="{{ route('dashboard.products.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                        <span class="menu-icon">
                                    <i class="fa fa-cogs"></i>
                        </span>
                        <span class="menu-title"> {{ __("Products") }}</span>
                    </a>
                </div>
                @endcan

                @canany(['list_view@reports' , 'list_view@orders' ])
                    <div class="menu-item mb-3">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __("Sales") }}</span>
                        </div>
                    </div>
                @endcanany

                @can('list_view@orders')
                <div class="menu-item">
                    <a class="menu-link {{ isTabActive('orders') }}" href="{{ route('dashboard.orders.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                    <span class="menu-icon">
                            <i class="fa fa-shopping-cart"></i>
                    </span>
                        <span class="menu-title"> {{ __("Orders") }}</span>
                    </a>
                </div>
                @endcan

{{--                @can('list_view@reports')--}}
{{--                <div class="menu-item">--}}
{{--                    <a class="menu-link {{ isTabActive('reports') }}" href="{{ route('dashboard.reports') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">--}}
{{--                    <span class="menu-icon">--}}
{{--                            <i class="fa fa-images"></i>--}}
{{--                    </span>--}}
{{--                    <span class="menu-title"> {{ __("Reports") }}</span>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                @endcan--}}

{{--                @canany(['list_view@sliders' , 'list_view@users' , 'list_view@subscribers'])--}}
{{--                    <div class="menu-item mb-3">--}}
{{--                        <div class="menu-content pt-8 pb-0">--}}
{{--                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __("Website") }}</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endcanany--}}

{{--                @can('list_view@coupons')--}}
{{--                <div class="menu-item">--}}
{{--                  <a class="menu-link {{ isTabActive('coupons') }}" href="{{ route('dashboard.coupons.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">--}}
{{--                <span class="menu-icon">--}}
{{--                    <i class="fa fa-gift"></i>--}}
{{--                </span>--}}
{{--                    <span class="menu-title"> {{ __("Coupons") }}</span>--}}
{{--                </a>--}}
{{--                </div>--}}
{{--                @endcan--}}

{{--                @can('list_view@sliders')--}}
{{--                <div class="menu-item">--}}
{{--                <a class="menu-link {{ isTabActive('sliders') }}" href="{{ route('dashboard.sliders.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">--}}
{{--                    <span class="menu-icon">--}}
{{--                        <i class="fa fa-images"></i>--}}
{{--                    </span>--}}
{{--                    <span class="menu-title"> {{ __("Sliders") }}</span>--}}
{{--                </a>--}}
{{--                </div>--}}
{{--                @endcan--}}

                @can('list_view@users')
                <div class="menu-item">
                <a class="menu-link {{ isTabActive('users') }}" href="{{ route('dashboard.users.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                    <span class="menu-icon">
                        <i class="fa fa-users"></i>
                    </span>
                    <span class="menu-title"> {{ __("Users") }}</span>
                </a>
                </div>
                @endcan

{{--                @can('list_view@subscribers')--}}
{{--                <div class="menu-item">--}}
{{--                <a class="menu-link {{ isTabActive('subscribers') }}" href="{{ route('dashboard.subscribers.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">--}}
{{--                    <span class="menu-icon">--}}
{{--                        <i class="fa fa-newspaper"></i>--}}
{{--                    </span>--}}
{{--                    <span class="menu-title"> {{ __("Subscribers") }}</span>--}}
{{--                </a>--}}
{{--                </div>--}}
{{--                @endcan--}}


                @canany(['list_view@roles' , 'list_view@admins' , 'list_view@settings'])
                    <div class="menu-item mb-3">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __("Settings") }}</span>
                        </div>
                    </div>
                @endcanany

                @can('list_view@roles')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('roles') }}" href="{{ route('dashboard.roles.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                        <span class="menu-icon">
                                <i class="fa fa-lock"></i>
                        </span>
                            <span class="menu-title"> {{ __("Roles") }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@admins')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('admins') }}" href="{{ route('dashboard.admins.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                        <span class="menu-icon">
                                <i class="fa fa-user-shield"></i>
                        </span>
                            <span class="menu-title"> {{ __("Admins") }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@settings')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('settings') }}" href="{{ route('dashboard.settings.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                        <span class="menu-icon">
                                <i class="bi bi-gear-fill"></i>
                        </span>
                            <span class="menu-title"> {{ __("Settings") }}</span>
                        </a>
                    </div>
                @endcan

{{--                @can('list_view@recycle_bin')--}}
{{--                    <div class="menu-item">--}}
{{--                        <a class="menu-link {{ isTabActive('trash') }}" href="{{ route('dashboard.trash') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">--}}
{{--                        <span class="menu-icon">--}}
{{--                                <i class="fas fa-trash"></i>--}}
{{--                        </span>--}}
{{--                            <span class="menu-title"> {{ __("Recycle Bin") }}</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                @endcan--}}


            </div>
            <!--end::Menu-->
        </div>
    </div>
    <!--end::Aside menu-->
</div>
