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
            order: [[4, 'desc']],
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
                    datatable.DataTable().ajax.url(`/about-us-features?page=${info.page + 1}&per_page=${info.length}`);
                }
            },
            columns: [
                { data: 'id' },
                { data: 'title' },
                {
                    data: 'is_active',
                    render: function (data, type, row) {
                        if (data == true || data == 1) {
                            return `<span class="badge badge-light-success">
                                <i class="fa fa-check-circle me-1"></i> ${translate('Active')}
                            </span>`;
                        } else {
                            return `<span class="badge badge-light-danger">
                                <i class="fa fa-times-circle me-1"></i> ${translate('Inactive')}
                            </span>`;
                        }
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
                                <a href="/about-us-features/${row.id}/edit" class="menu-link px-3 d-flex justify-content-between edit-row">
                                    <span>${translate('Edit')}</span><span><i class="fa fa-edit text-primary"></i></span>
                                </a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="/about-us-features/${row.id}" class="menu-link px-3 d-flex justify-content-between">
                                    <span>${translate('Show')}</span><span><i class="fa fa-eye text-black-50"></i></span>
                                </a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 d-flex justify-content-between delete-row" data-row-id="${row.id}" data-type="${translate('about us feature')}">
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
            $('body').append(`<script src='${lightboxPath}' ></script>`)
            updateAddButtonState();
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
                        url: '/about-us-features/' + rowId,
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

    let handleAddButtonClick = function() {
        $(document).on('click', 'a[href*="about-us-features/create"]', function(e) {
            e.preventDefault();
            $.ajax({
                url: '/about-us-features/check-exists',
                method: 'GET',
                success: function(response) {
                    if (response.exists) {
                        errorAlert(response.message);
                    } else {
                        window.location.href = '/about-us-features/create';
                    }
                },
                error: function() {
                    errorAlert('An error occurred while checking availability.');
                }
            });
        });
    }

    let updateAddButtonState = function() {
        $.ajax({
            url: '/about-us-features/check-exists',
            method: 'GET',
            success: function(response) {
                if (response.exists) {
                    disableAddButton();
                } else {
                    enableAddButton();
                }
            },
            error: function() {
                console.error('Error checking about us feature availability');
            }
        });
    }

    let enableAddButton = function() {
        const toolbar = document.querySelector('[data-kt-docs-table-toolbar="base"]');
        if (!toolbar) return;

        const disabledButton = toolbar.querySelector('button[disabled]');
        if (disabledButton) {
            disabledButton.remove();
        }

        const enabledLink = toolbar.querySelector('a[href*="about-us-features/create"]');
        if (!enabledLink) {
            const addLink = document.createElement('a');
            addLink.href = '/about-us-features/create';
            addLink.className = 'btn btn-primary';
            addLink.setAttribute('data-bs-toggle', 'tooltip');
            addLink.setAttribute('title', '');
            addLink.innerHTML = `<span class="svg-icon svg-icon-2"><i class="fa fa-plus fa-lg"></i></span>Add new content`;
            toolbar.appendChild(addLink);
            handleAddButtonClick();
        }
    }

    let disableAddButton = function() {
        const toolbar = document.querySelector('[data-kt-docs-table-toolbar="base"]');
        if (!toolbar) return;

        const enabledLink = toolbar.querySelector('a[href*="about-us-features/create"]');
        if (enabledLink) {
            enabledLink.remove();
        }

        const disabledButton = toolbar.querySelector('button[disabled]');
        if (!disabledButton) {
            const addButton = document.createElement('button');
            addButton.className = 'btn btn-secondary';
            addButton.disabled = true;
            addButton.setAttribute('data-bs-toggle', 'tooltip');
            addButton.setAttribute('title', 'You cannot add more features because you can only add 2 about us features');
            addButton.innerHTML = `<span class="svg-icon svg-icon-2"><i class="fa fa-plus fa-lg"></i></span>Add new content`;
            toolbar.appendChild(addButton);
        }
    }

    return {
        init: function () {
            initDatatable();
            handleSearchDatatable(datatable);
            handleAddButtonClick();
            updateAddButtonState();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatable.init();
});
