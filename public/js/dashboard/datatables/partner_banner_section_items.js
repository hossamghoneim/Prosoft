"use strict";

// Class definition
let KTDatatable = function () {

    // Shared variables
    let table;
    let datatable;

    // Private functions
    let initDatatable = function () {
        datatable = $("#kt_datatable").DataTable({
            ordering: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[6, 'desc']], // display records number and ordering type
            stateSave: false,
            select: {
                style: 'os',
                selector: 'td:first-child',
                className: 'row-selected'
            },
            ajax: {
                data: function () {
                    let datatable = $('#kt_datatable');
                    let info = datatable.DataTable().page.info();
                    datatable.DataTable().ajax.url(`/partner-banner-section-items?page=${info.page + 1}&per_page=${info.length}`);
                }
            },
            columns: [
                { data: 'id' },
                { data: 'icon' },
                { data: 'title' },
                { data: 'description' },
                { data: 'partner_banner_section.title' },
                { data: 'is_active' },
                { data: 'created_at' },
                { data: null },
            ],
            columnDefs: [
                {
                    targets: 1,
                    render: function (data, type, row) {
                        if (!data) return '';

                        return `
                            <a class="d-block overlay" style="height:47px;" data-fslightbox="lightbox-basic" href="${data}">
                                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded"
                                    style="height:55px;width:55px;border-radius:4px;margin:auto;background-image:url('${data}');background-size:contain;">
                                </div>
                            </a>`;
                    }
                },
                {
                    targets: 5, // column index for is_active
                    render: function (data, type, row) {
                        if (data == true || data == 1) {
                            return `
                                <span class="badge badge-light-success">
                                    <i class="fa fa-check-circle me-1"></i> ${translate('Active')}
                                </span>`;
                        } else {
                            return `
                                <span class="badge badge-light-danger">
                                    <i class="fa fa-times-circle me-1"></i> ${translate('Inactive')}
                                </span>`;
                        }
                    }
                },
                {
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {

                        return `
                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                ${translate('Actions')}
                                <span class="svg-icon svg-icon-5 m-0">
                                    <i class="fa fa-angle-down mx-1"></i>
                                </span>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="/partner-banner-section-items/${row.id}/edit" class="menu-link px-3 d-flex justify-content-between edit-row" >
                                        <span> ${translate('Edit')} </span>
                                        <span>  <i class="fa fa-edit text-primary"></i> </span>
                                    </a>

                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="/partner-banner-section-items/${row.id}" class="menu-link px-3 d-flex justify-content-between" >
                                        <span> ${translate('Show')} </span>
                                        <span>  <i class="fa fa-eye text-black-50"></i> </span>
                                    </a>

                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3 d-flex justify-content-between delete-row" data-row-id="${row.id}" data-type="${translate('partner banner section item')}">
                                        <span> ${translate('Delete')} </span>
                                        <span>  <i class="fa fa-trash text-danger"></i> </span>
                                    </a>
                                </div>
                                <!--end::Menu item-->

                            </div>
                            <!--end::Menu-->
                        `;
                    },
                },
            ],
        });

        table = datatable.$;

        datatable.on('draw', function () {
            handleDeleteRows();
            KTMenu.createInstances();
            $('body').append(`<script src='${lightboxPath}' ></script>`)
        });
    }

    // Delete record
    let handleDeleteRows = () => {

        $('.delete-row').click(function () {

            let rowId = $(this).data('row-id');
            let type = $(this).data('type');

            deleteAlert(type).then(function (result) {

                if (result.value) {

                    loadingAlert(translate('deleting now ...'));

                    $.ajax({
                        method: 'delete',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: '/partner-banner-section-items/' + rowId,
                        success: () => {

                            setTimeout(() => {

                                successAlert(`${translate('You have deleted the') + ' ' + type + ' ' + translate('successfully !')} `)
                                    .then(function () {
                                        datatable.draw();
                                    });

                            }, 1000)

                        },
                        error: (err) => {

                            if (err.hasOwnProperty('responseJSON')) {
                                if (err.responseJSON.hasOwnProperty('message')) {
                                    errorAlert(err.responseJSON.message);
                                }
                            }
                        }
                    });

                } else if (result.dismiss === 'cancel') {

                    errorAlert(translate('was not deleted !'))

                }
            });
        })
    }



    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable(datatable);
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatable.init();
});
