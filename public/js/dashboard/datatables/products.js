"use strict";

// Class definition
let KTDatatable = function () {

    // Shared variables
    let table;
    let datatable;

    // Private functions
    let initDatatable = function () {
        datatable = $("#kt_datatable").DataTable({
            orderable: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[4, 'desc']], // display records number and ordering type
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
                    datatable.DataTable().ajax.url(`/products?page=${info.page + 1}&per_page=${info.length}`);
                }
            },
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'sku'},
                {data: 'price'},
                {data: 'rate'},
                {data: 'status'},
                {data: 'created_at'},
                {data: null},
            ],
            columnDefs: [
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
                                    <a href="/products/${ row.id }/edit" class="menu-link px-3 d-flex justify-content-between edit-row" >
                                       <span> ${translate('Edit')} </span>
                                       <span>  <i class="fa fa-edit text-primary"></i> </span>
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                   <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3 d-flex justify-content-between delete-row" data-row-id="${row.id}" data-type="${translate('product')}">
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
                {
                    targets: 1,
                    orderable: false,
                    render: function (data, type, row) {
                        return `<div class="d-flex align-items-start">
                                    <!--begin::Thumbnail-->

                                    <a class="d-block overlay symbol-50px"  style="height:60px;" data-fslightbox="lightbox-basic" href="${getFilePath( row.main_image )}">
                                    <!--begin::Image-->
                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded"
                                         style="height:60px;width:60px;border-radius:4px;margin:auto;background-image:url('${getFilePath(row.main_image)}');background-size:contain;">
                                    </div>
                                    <!--end::Image-->
                                </a>
                                    <!--end::Thumbnail-->
                                    <div class="ms-5">
                                        <!--begin::Title-->
                                        <a href="/products/${ row.id }/edit" target="_blank" class="text-gray-800 text-hover-primary fs-5 fw-bold">${ data }</a>
                                        <p class="text-primary fs-7 text-start">${ row['stock_quantity'] + ' ' + translate('pieces') }</p>
                                        <!--end::Title-->
                                    </div>
                            </div>`
                    }
                },
                {
                    targets: 5,
                    orderable: false,
                    render: function (data, type, row) {
                            if ( row.status )
                                return `<div class="badge badge-light-success"> ${ translate('published') } </div>`
                            else
                                return `<div class="badge badge-light-danger"> ${ translate('unpublished') } </div>`
                    }
                },{
                    targets: 3,
                    orderable: false,
                    render: function (data, type, row) {
                        return data + ' ' + translate('QAR')
                    }
                },{
                    targets: 4,
                    orderable: false,
                    render: function (data, type, row) {

                        let stars = ``;

                        for (let i = 1; i <= 5; i++)
                            stars += `<i class="fa fa-star me-1 ${ row.rate >= i   ? 'text-warning' : '' }"></i>`

                        return `${ stars } <br> <small class="text-muted mt-2"> ${ data }  of 5 </small>` ;
                    }
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
            let type  = $(this).data('type');

            deleteAlert(type).then(function (result) {

                if (result.value) {

                    loadingAlert(translate('deleting now ...'));

                    $.ajax({
                        method: 'delete',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: '/products/' + rowId,
                        success: () => {

                            setTimeout( () => {

                                successAlert(`${translate('You have deleted the') + ' ' + type + ' ' + translate('successfully !')} `)
                                    .then(function () {
                                        datatable.draw();
                                    });

                            } , 1000)



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

                    errorAlert( translate('was not deleted !') )

                }
            });
        })
    }


    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable(datatable);
            handleFilterDatatable(datatable);
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatable.init();
});
