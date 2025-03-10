@extends('partials.dashboard.master')
@section('content')

    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div  class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ __("Roles") }}</h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard.roles.index') }}" class="text-muted text-hover-primary">{{ __("Roles list") }}</a>
                    </li>
                    <!-- end   :: Item -->
                </ul>
                <!-- end   :: Breadcrumb -->

            </div>

        </div>

    </div>
    <!-- end   :: Subheader -->

    <div class="card mb-2">
        <!-- begin :: Card Body -->
        <div class="card-body fs-6 text-gray-700">

            <!-- begin :: Filter -->
            <div class="d-flex flex-stack flex-wrap">

                <!-- begin :: General Search -->
                <div class="d-flex align-items-center position-relative my-1 mb-2 mb-md-0">

                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                               <i class="fa fa-search fa-lg" ></i>
                        </span>

                    <form action="{{ route('dashboard.roles.index') }}" method="GET">
                        <input type="text" class="form-control form-control-solid w-250px ps-15 border-gray-300 border-1" value="{{request()->input('search')}}" name="search" id="general-search-inp" placeholder="{{ __("Search ...") }}">
                    </form>
                </div>
                <!-- end   :: General Search -->

                <!-- begin :: Toolbar -->
                <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">

                    <!-- begin :: Add Button -->
                    <button type="button" class="btn btn-primary" id="add-role-btn" data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">
                                        <span class="svg-icon svg-icon-2">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>

                        {{ __("Add new role") }}
                    </button>
                    <!-- end   :: Add Button -->

                </div>
                <!-- end   :: Toolbar -->



            </div>
            <!-- end   :: Filter -->
        </div>
    </div>

    <!-- begin :: Row -->
    <div class="row">

        <!-- begin :: Roles -->

        @forelse( $roles as $role)
            <div class="col-md-4 my-10">
                <!--begin::Card-->
                <div class="card card-flush h-md-100">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2> {{ $role->name }}</h2>
                        </div>
                        @if( !$role->is_system_role )
                            <div class="card-title">
                                <button class="btn p-0" onclick="deleteElement( '{{ __('Role') }}' , '{{ route('dashboard.roles.destroy',$role->id) }}' , () => window.location.reload() )">
                                    <i class="fa fa-trash fa-3x text-danger"></i>
                                </button>
                            </div>
                        @endif
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                        <div class="card-body pt-1"  style="min-height: 20rem">
                        <!--begin::Users-->
                        <div class="fw-bolder text-gray-600 mb-5">{{ __('Total admins with this role') }} : {{ $role->admins->count() }}</div>
                        <!--end::Users-->
                        <!--begin::Permissions-->
                        <div class="d-flex flex-column text-gray-600">

                            @foreach( collect($role->permissions)->take(5) as $module => $modulePermissions)

                                <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span> {{ __( str_replace("_", " " , $modulePermissions[ mt_rand(0, count($modulePermissions) - 1) ]) ) . ' ' . __( str_replace("_", " " ,$module) ) }}
                                </div>

                            @endforeach
                            @if( collect($role->permissions)->flatten()->count() - 5 > 0)
                                <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>
                                    <em>{{ __("and") . ' ' . ( collect($role->permissions)->flatten()->count() - 5 ) . ' '. __("more") }} ...</em>
                                </div>
                            @endif
                        </div>
                        <!--end::Permissions-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer text-end flex-wrap pt-0">

                        <a href="{{ route('dashboard.roles.show',$role->id) }}" class="btn btn-light btn-active-primary my-1 me-2">{{ __("View") }}</a>

                        @if( $role->id !== 1 )
                            <button type="button" class="btn btn-light btn-active-primary my-1 edit-role-btn" data-role-id="{{$role->id}}" >

                                <span class="indicator-label">{{ __("Edit") }}</span>

                            </button>
                        @endif

                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Card-->
            </div>
            @empty
            <div class="w-100 d-flex flex-column justify-content-center align-items-center min-h-400px">
                <img alt="Logo" src="{{ asset('dashboard-assets/media/no_data.png')}}" class="mt-15" />
                <h3 class="text-gray-500">No Data Found</h3>
            </div>
        @endforelse

        <!-- end   :: Roles -->

    </div>
    <!-- end   :: Row-->

    <!-- begin :: Modals  -->

    <!-- begin :: Add role modal  -->
    <div class="modal fade" id="kt_modal_add_role" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-820px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bolder">{{ __("Add a Role") }}</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" onclick="$('#kt_modal_add_role').modal('hide')" data-kt-roles-modal-action="close">
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                                </svg>
                            </span>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-lg-5 my-7">
                        <!--begin::Form-->
                        <form  id="role_form_add" data-form-type="add" method="POST" class="form fv-plugins-bootstrap5 fv-plugins-framework submitted-form" action="{{ route('dashboard.roles.store') }}" data-redirection-url="/roles">
                            @csrf
                            <!--begin::Scroll-->
                            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header" data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px" style="max-height: 637px;">

                                <!-- begin :: Row -->
                                <div class="row mb-6">

                                    <!-- begin :: Column -->
                                    <div class="col-md-6 fv-row">

                                        <label class="fs-6 fw-bold mb-2">{{ __("Name in arabic") }}</label>
                                        <input type="text" class="form-control" name="name_ar" id="name_ar_inp"/>
                                        <p class="invalid-feedback" id="name_ar" ></p>


                                    </div>
                                    <!-- end   :: Column -->

                                    <!-- begin :: Column -->
                                    <div class="col-md-6 fv-row">

                                        <label class="fs-6 fw-bold mb-2">{{ __("Name in english") }}</label>
                                        <input type="text" class="form-control" name="name_en" id="name_en_inp" />
                                        <p class="invalid-feedback" id="name_en" ></p>


                                    </div>
                                    <!-- end   :: Column -->

                                </div>
                                <!-- end   :: Row -->

                                <!--begin::Permissions-->
                                <div class="fv-row">

                                    <div class="text-center m-auto" style="width:fit-content">
                                        <p class="bg-danger invalid-feedback text-white px-4 py-2" style="border-radius: 4px" id="permissions" ></p>
                                    </div>

                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bolder form-label mb-2">{{ __("Role Permissions") }}</label>
                                    <!--end::Label-->
                                    <!--begin::Table wrapper-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                                            <!--begin::Table body-->
                                            <tbody class="text-gray-600 fw-bold">

                                            <!--begin::Table row-->
                                            <tr>
                                                <td class="text-gray-800">{{ __('Administrator Access') }}
                                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="{{__("Allows a full access to the system")}}" aria-label="{{__("Allows a full access to the system")}}"></i></td>
                                                <td>
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-9">
                                                        <input class="form-check-input" type="checkbox"  id="add-select-all" data-form-type="add" >
                                                        <span class="form-check-label" for="add-select-all" >{{ __("Select all") }}</span>
                                                    </label>
                                                    <!--end::Checkbox-->
                                                </td>
                                            </tr>
                                            <!--end::Table row-->

                                            @foreach( $permissions as $module => $modulePermissions)

                                                <tr>
                                                    <!--begin::Label-->
                                                    <td class="text-gray-800"> {{ __(ucwords( str_replace('_' , ' ' , $module) ))  }} </td>
                                                    <!--end::Label-->
                                                    <!--begin::Input group-->
                                                    <td>
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex">
                                                        @foreach($modulePermissions as $permission)

                                                            <!--begin::Checkbox-->
                                                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                                    <input class="form-check-input add-checkbox" type="checkbox" id="add_{{$permission}}_{{$module}}" data-module="{{$module}}" data-permission="{{$permission}}" >
                                                                    <label  class="custom-control-label mx-4" for="add_{{$permission}}_{{$module}}">{{ str_replace('_' , ' ' , $permission) }}</label>
                                                                </label>
                                                            <!--end::Checkbox-->

                                                        @endforeach
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </td>
                                                    <!--end::Input group-->

                                                </tr>

                                            @endforeach

                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
                                </div>
                                <!--end::Permissions-->
                            </div>
                            <!--end::Scroll-->
                            <!--begin::Actions-->
                            <div class="text-center pt-4">
                                <button type="submit" class="btn btn-primary" id="submit-btn" data-kt-roles-modal-action="submit">
                                    <span class="indicator-label">{{ __("Save") }}</span>
                                    <span class="indicator-progress">{{ __("Please wait ...") }}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->

                            <input type="hidden" id="permissions-input-add" name="permissions">
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    <!-- end   :: Add role modal -->


    <!-- begin :: Update role modal -->
    <div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-820px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">{{ __("Update Role") }}</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" onclick="$('#kt_modal_update_role').modal('hide')" data-kt-roles-modal-action="close">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                            </svg>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 my-7">
                    <!--begin::Form-->
                    <form id="role_form_update" data-form-type="update" class="form fv-plugins-bootstrap5 fv-plugins-framework submitted-form" method="POST" data-redirection-url="/roles" data-trailing="_edit" >
                        @csrf
                        @method('PUT')
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px" style="max-height: 637px;">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10 fv-plugins-icon-container">

                            <!-- begin :: Row -->
                            <div class="row mb-6">

                                <!-- begin :: Column -->
                                <div class="col-md-6 fv-row">

                                    <label class="fs-6 fw-bold mb-2">{{ __("Name in arabic") }}</label>
                                    <input type="text" class="form-control" id="name_ar_inp_edit" name="name_ar" />
                                    <p class="invalid-feedback" id="name_ar_edit" ></p>


                                </div>
                                <!-- end   :: Column -->

                                <!-- begin :: Column -->
                                <div class="col-md-6 fv-row">

                                    <label class="fs-6 fw-bold mb-2">{{ __("Name in english") }}</label>
                                    <input type="text" class="form-control" id="name_en_inp_edit" name="name_en" />
                                    <p class="invalid-feedback" id="name_en_edit" ></p>


                                </div>
                                <!-- end   :: Column -->

                            </div>
                            <!-- end   :: Row -->

                            <!--end::Input group-->
                            <!--begin::Permissions-->
                            <div class="fv-row">

                                <div class="text-center m-auto" style="width:fit-content">
                                    <p class="bg-danger invalid-feedback text-white p-2" style="border-radius: 4px" id="permissions_edit" ></p>
                                </div>

                                <!--begin::Label-->
                                <label class="fs-5 fw-bolder form-label mb-2">{{ __("Role Permissions") }}</label>
                                <!--end::Label-->
                                <!--begin::Table wrapper-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-bold">

                                        <!--begin::Table row-->
                                        <tr>
                                            <td class="text-gray-800">{{ __('Administrator Access') }}
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="{{ __('Allows a full access to the system') }}" aria-label="{{ __('Allows a full access to the system') }}"></i></td>
                                            <td>
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                                    <input class="form-check-input" type="checkbox" id="edit-select-all" data-form-type="update" >
                                                    <span class="form-check-label" for="edit-select-all" >{{ __("Select all") }}</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </td>
                                        </tr>
                                        <!--end::Table row-->

                                        @foreach( $permissions as $module => $modulePermissions)

                                            <tr>
                                                <!--begin::Label-->
                                                <td class="text-gray-800"> {{ __(ucwords( str_replace('_' , ' ' , $module) ))  }} </td>
                                                <!--begin::Input group-->
                                                <td>
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex">
                                                        @foreach($modulePermissions as $permission)

                                                        <!--begin::Checkbox-->
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                                <input class="form-check-input update-checkbox" type="checkbox" id="update_{{$permission}}_{{$module}}" data-module="{{$module}}" data-permission="{{$permission}}" >
                                                                <label  class="custom-control-label mx-4" for="update_{{$permission}}_{{$module}}">{{ str_replace('_' , ' ' , $permission) }}</label>
                                                            </label>
                                                            <!--end::Checkbox-->

                                                        @endforeach
                                                    </div>
                                                    <!--end::Wrapper-->
                                                </td>
                                                <!--end::Input group-->
                                            </tr>

                                        @endforeach

                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table wrapper-->
                            </div>
                            <!--end::Permissions-->
                        </div>
                        <!--end::Scroll-->
                       </div>

                        <!--begin::Actions-->
                        <div class="text-center pt-4 mt-1">
                            <button type="submit" class="btn btn-primary" id="submit-btn" data-kt-roles-modal-action="submit">
                                <span class="indicator-label">{{ __("Save") }}</span>
                                <span class="indicator-progress">{{ __("Please wait ...") }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                        <input type="hidden" id="permissions-input-update" name="permissions">
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end   :: Update role modal-->
    <!-- end   :: Modals -->
    @if( $roles->count() > $roles->perPage())
        <div class="p-3 bg-white d-flex justify-content-end">
            {{ $roles->links('pagination::bootstrap-4') }}
        </div>
    @endif

@endsection
@push('scripts')

    <script>


        // start code for resetting add new role modal
        $("#add-role-btn").click( function () {

            $('.add-checkbox').prop('checked',false);

            removeValidationMessages();

        });
        // start code for resetting add new role modal


    </script>
    <script src="{{ asset('js/dashboard/forms/roles/common.js') }}"></script>
@endpush
