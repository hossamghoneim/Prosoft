"use strict";

let KTDatatable = function () {
    let table;
    let datatable;

    let initDatatable = function () {
        datatable = $("#kt_datatable").DataTable({
            ordering: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[7, 'desc']],
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
                    datatable.DataTable().ajax.url(`/contact-inquiries?page=${info.page + 1}&per_page=${info.length}`);
                }
            },
            columns: [
                { data: 'id' },
                {
                    data: null,
                    render: function (data, type, row) {
                        return row.first_name + ' ' + row.last_name;
                    }
                },
                { data: 'company' },
                { data: 'email' },
                { data: 'phone' },
                { data: 'inquiry_type_name' },
                {
                    data: 'message',
                    render: function (data, type, row) {
                        if (type === 'display') {
                            return data.length > 50 ? data.substr(0, 50) + '...' : data;
                        }
                        return data;
                    }
                },
                { data: 'created_at' },
                { data: null },
            ],
            columnDefs: [
                {
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return `<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                            ${translate('Actions')}<span class="svg-icon svg-icon-5 m-0"><i class="fa fa-angle-down mx-1"></i></span>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="/contact-inquiries/${row.id}" class="menu-link px-3 d-flex justify-content-between">
                                    <span>${translate('Show')}</span><span><i class="fa fa-eye text-black-50"></i></span>
                                </a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 d-flex justify-content-between delete-row" data-row-id="${row.id}" data-type="${translate('contact inquiry')}">
                                    <span>${translate('Delete')}</span><span><i class="fa fa-trash text-danger"></i></span>
                                </a>
                            </div>
                        </div>`;
                    },
                },
            ],
        });

        table = datatable.$;

        datatable.on('draw', function () {
            handleDeleteRows();
            KTMenu.createInstances();
        });
    }

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
                        url: '/contact-inquiries/' + rowId,
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

    return {
        init: function () {
            initDatatable();
            handleSearchDatatable(datatable);
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatable.init();
});
