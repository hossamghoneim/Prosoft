<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo w-100 h-75px" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ route('dashboard.index') }}" class="m-auto">
            <img alt="Logo" src="{{ asset('dashboard-assets/media/car.png') }}" class="h-40px logo" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="white" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="white" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">

                @canany(['list_view@service-hero-sections', 'list_view@service-banner-sections',
                    'list_view@service-sections', 'list_view@service-section-items', 'list_view@partnership-hero-sections'])
                    <!-- begin :: cars section -->
                    <div class="menu-item mb-3">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('Services') }}</span>
                        </div>
                    </div>
                @endcanany

                @can('list_view@service-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('service-sections') }}"
                            href="{{ route('dashboard.service-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-list"></i>
                            </span>
                            <span class="menu-title"> {{ __('Service sections') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@service-section-items')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('service-section-items') }}"
                            href="{{ route('dashboard.service-section-items.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-cube"></i>
                            </span>
                            <span class="menu-title"> {{ __('Service section items') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@service-hero-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('service-hero-sections') }}"
                            href="{{ route('dashboard.service-hero-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-crown"></i>
                            </span>
                            <span class="menu-title"> {{ __('Hero section') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@service-banner-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('service-banner-sections') }}"
                            href="{{ route('dashboard.service-banner-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-bullhorn"></i>
                            </span>
                            <span class="menu-title"> {{ __('Banner section') }}</span>
                        </a>
                    </div>
                @endcan

                @canany(['list_view@partnership-hero-sections', 'list_view@partnership-sections', 'list_view@partners'])
                    <div class="menu-item mb-3">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('Partnerships') }}</span>
                        </div>
                    </div>
                @endcanany

                @can('list_view@partnership-hero-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('partnership-hero-sections') }}"
                            href="{{ route('dashboard.partnership-hero-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-crown"></i>
                            </span>
                            <span class="menu-title"> {{ __('Hero section') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@partnership-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('partnership-sections') }}"
                            href="{{ route('dashboard.partnership-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-handshake"></i>
                            </span>
                            <span class="menu-title"> {{ __('Partnership section') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@partners')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('partners') }}"
                            href="{{ route('dashboard.partners.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-users"></i>
                            </span>
                            <span class="menu-title"> {{ __('Partners') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@partner-banner-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('partner-banner-sections') }}"
                            href="{{ route('dashboard.partner-banner-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-image"></i>
                            </span>
                            <span class="menu-title"> {{ __('Banner section') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@partner-banner-section-items')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('partner-banner-section-items') }}"
                            href="{{ route('dashboard.partner-banner-section-items.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-list"></i>
                            </span>
                            <span class="menu-title"> {{ __('Banner items') }}</span>
                        </a>
                    </div>
                @endcan

                @canany(['list_view@contact-us-contents', 'list_view@contact-us-sections'])
                    <div class="menu-item mb-3">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('Contact Us') }}</span>
                        </div>
                    </div>
                @endcanany

                @can('list_view@contact-us-contents')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('contact-us-contents') }}"
                            href="{{ route('dashboard.contact-us-contents.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <span class="menu-title"> {{ __('Contents') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@contact-us-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('contact-us-sections') }}"
                            href="{{ route('dashboard.contact-us-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-list"></i>
                            </span>
                            <span class="menu-title"> {{ __('Sections') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@contact-inquiries')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('contact-inquiries') }}"
                            href="{{ route('dashboard.contact-inquiries.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-comments"></i>
                            </span>
                            <span class="menu-title"> {{ __('Inquiries') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@locations')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('locations') }}"
                            href="{{ route('dashboard.locations.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-map-marker"></i>
                            </span>
                            <span class="menu-title"> {{ __('Locations') }}</span>
                        </a>
                    </div>
                @endcan

                @canany(['list_view@about-us-hero-sections', 'list_view@about-us-features',
                    'list_view@about-us-feature-items', 'list_view@about-us-middle-sections',
                    'list_view@about-us-middle-section-items', 'list_view@about-us-final-sections',
                    'list_view@about-us-final-section-items', 'list_view@about-us-banner-sections'])
                    <div class="menu-item mb-3">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('About Us') }}</span>
                        </div>
                    </div>
                @endcanany

                @can('list_view@about-us-hero-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('about-us-hero-sections') }}"
                            href="{{ route('dashboard.about-us-hero-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-info-circle"></i>
                            </span>
                            <span class="menu-title"> {{ __('Hero Section') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@about-us-features')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('about-us-features') }}"
                            href="{{ route('dashboard.about-us-features.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-star"></i>
                            </span>
                            <span class="menu-title"> {{ __('Features') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@about-us-feature-items')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('about-us-feature-items') }}"
                            href="{{ route('dashboard.about-us-feature-items.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-list"></i>
                            </span>
                            <span class="menu-title"> {{ __('Feature Items') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@about-us-middle-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('about-us-middle-sections') }}"
                            href="{{ route('dashboard.about-us-middle-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-layer-group"></i>
                            </span>
                            <span class="menu-title"> {{ __('Middle Section') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@about-us-middle-section-items')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('about-us-middle-section-items') }}"
                            href="{{ route('dashboard.about-us-middle-section-items.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-cubes"></i>
                            </span>
                            <span class="menu-title"> {{ __('Middle Section Items') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@about-us-final-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('about-us-final-sections') }}"
                            href="{{ route('dashboard.about-us-final-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-flag-checkered"></i>
                            </span>
                            <span class="menu-title"> {{ __('Final Section') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@about-us-final-section-items')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('about-us-final-section-items') }}"
                            href="{{ route('dashboard.about-us-final-section-items.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-list-ol"></i>
                            </span>
                            <span class="menu-title"> {{ __('Final Section Items') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@about-us-banner-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('about-us-banner-sections') }}"
                            href="{{ route('dashboard.about-us-banner-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-video"></i>
                            </span>
                            <span class="menu-title"> {{ __('Banner Section') }}</span>
                        </a>
                    </div>
                @endcan

                @canany(['list_view@solutions', 'list_view@solution-hero-sections', 'list_view@solution-main-sections', 'list_view@solution-main-section-items', 'list_view@solution-main-section-item-contents', 'list_view@solution-middle-sections'])
                    <div class="menu-item mb-3">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('Solutions') }}</span>
                        </div>
                    </div>
                @endcanany

                @can('list_view@solutions')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('solutions') }}"
                            href="{{ route('dashboard.solutions.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-lightbulb"></i>
                            </span>
                            <span class="menu-title"> {{ __('Solutions list') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@solution-hero-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('solution-hero-sections') }}"
                            href="{{ route('dashboard.solution-hero-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-star"></i>
                            </span>
                            <span class="menu-title"> {{ __('Solution Hero Section') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@solution-main-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('solution-main-sections') }}"
                            href="{{ route('dashboard.solution-main-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-list"></i>
                            </span>
                            <span class="menu-title"> {{ __('Solution Main Section') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@solution-main-section-items')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('solution-main-section-items') }}"
                            href="{{ route('dashboard.solution-main-section-items.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-cube"></i>
                            </span>
                            <span class="menu-title"> {{ __('Solution Main Section Items') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@solution-main-section-item-contents')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('solution-main-section-item-contents') }}"
                            href="{{ route('dashboard.solution-main-section-item-contents.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-file-text"></i>
                            </span>
                            <span class="menu-title"> {{ __('Solution Main Section Item Contents') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@solution-middle-sections')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('solution-middle-sections') }}"
                            href="{{ route('dashboard.solution-middle-sections.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-layer-group"></i>
                            </span>
                            <span class="menu-title"> {{ __('Solution Middle Section') }}</span>
                        </a>
                    </div>
                @endcan

                @canany(['list_view@roles', 'list_view@admins', 'list_view@settings'])
                    <div class="menu-item mb-3">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('Settings') }}</span>
                        </div>
                    </div>
                @endcanany

                @can('list_view@roles')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('roles') }}" href="{{ route('dashboard.roles.index') }}"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-lock"></i>
                            </span>
                            <span class="menu-title"> {{ __('Roles') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@admins')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('admins') }}" href="{{ route('dashboard.admins.index') }}"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-user-shield"></i>
                            </span>
                            <span class="menu-title"> {{ __('Admins') }}</span>
                        </a>
                    </div>
                @endcan

                @can('list_view@settings')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('settings') }}"
                            href="{{ route('dashboard.settings.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="bi bi-gear-fill"></i>
                            </span>
                            <span class="menu-title"> {{ __('Settings') }}</span>
                        </a>
                    </div>
                @endcan

                {{--                @can('list_view@recycle_bin') --}}
                {{--                    <div class="menu-item"> --}}
                {{--                        <a class="menu-link {{ isTabActive('trash') }}" href="{{ route('dashboard.trash') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right"> --}}
                {{--                        <span class="menu-icon"> --}}
                {{--                                <i class="fas fa-trash"></i> --}}
                {{--                        </span> --}}
                {{--                            <span class="menu-title"> {{ __("Recycle Bin") }}</span> --}}
                {{--                        </a> --}}
                {{--                    </div> --}}
                {{--                @endcan --}}


            </div>
            <!--end::Menu-->
        </div>
    </div>
    <!--end::Aside menu-->
</div>
