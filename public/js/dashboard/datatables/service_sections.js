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
            order: [[5, 'desc']], // display records number and ordering type
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
                    datatable.DataTable().ajax.url(`/service-sections?page=${info.page + 1}&per_page=${info.length}`);
                }
            },
            columns: [
                { data: 'id' },
                { data: 'title' },
                { data: 'slug' },
                { data: 'order' },
                { data: 'is_active' },
                { data: 'created_at' },
                { data: null },
            ],
            columnDefs: [
                {
                    targets: 4, // column index for is_active
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
                                    <a href="/service-sections/${row.id}/edit" class="menu-link px-3 d-flex justify-content-between edit-row" >
                                        <span> ${translate('Edit')} </span>
                                        <span>  <i class="fa fa-edit text-primary"></i> </span>
                                    </a>

                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="/service-sections/${row.id}" class="menu-link px-3 d-flex justify-content-between" >
                                        <span> ${translate('Show')} </span>
                                        <span>  <i class="fa fa-eye text-black-50"></i> </span>
                                    </a>

                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3 d-flex justify-content-between delete-row" data-row-id="${row.id}" data-type="${translate('service section')}">
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
            // Update button state after datatable redraw
            updateAddButtonState();
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
                        url: '/service-sections/' + rowId,
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

    // Update add button state
    let updateAddButtonState = () => {
        // Check if service sections exist via AJAX
        $.ajax({
            method: 'GET',
            url: '/service-sections/check-exists',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                if (response.exists) {
                    // 2 sections exist, disable the add button
                    disableAddButton();
                } else {
                    // Less than 2 sections exist, enable the add button
                    enableAddButton();
                }
            },
            error: function(xhr) {
                console.error('Error checking service sections existence:', xhr);
            }
        });
    }

    // Enable add button
    let enableAddButton = () => {
        const toolbar = document.querySelector('[data-kt-docs-table-toolbar="base"]');
        if (toolbar) {
            // Remove disabled button if exists
            const disabledButton = toolbar.querySelector('button[disabled]');
            if (disabledButton) {
                disabledButton.remove();
            }

            // Add enabled link if not exists
            const enabledLink = toolbar.querySelector('a[href*="service-sections/create"]');
            if (!enabledLink) {
                const addLink = document.createElement('a');
                addLink.href = '/service-sections/create';
                addLink.className = 'btn btn-primary';
                addLink.setAttribute('data-bs-toggle', 'tooltip');
                addLink.setAttribute('title', '');
                addLink.innerHTML = `
                    <span class="svg-icon svg-icon-2">
                        <i class="fa fa-plus fa-lg"></i>
                    </span>
                    Add new section
                `;
                toolbar.appendChild(addLink);

                // Re-attach click event
                handleAddButtonClick();
            }
        }
    }

    // Disable add button
    let disableAddButton = () => {
        const toolbar = document.querySelector('[data-kt-docs-table-toolbar="base"]');
        if (toolbar) {
            // Remove enabled link if exists
            const enabledLink = toolbar.querySelector('a[href*="service-sections/create"]');
            if (enabledLink) {
                enabledLink.remove();
            }

            // Add disabled button if not exists
            const disabledButton = toolbar.querySelector('button[disabled]');
            if (!disabledButton) {
                const addButton = document.createElement('button');
                addButton.type = 'button';
                addButton.className = 'btn btn-secondary';
                addButton.disabled = true;
                addButton.setAttribute('data-bs-toggle', 'tooltip');
                addButton.setAttribute('title', 'You can only add 2 service sections');
                addButton.innerHTML = `
                    <span class="svg-icon svg-icon-2">
                        <i class="fa fa-plus fa-lg"></i>
                    </span>
                    Add new section
                `;
                toolbar.appendChild(addButton);
            }
        }
    }

    // Handle add button click
    let handleAddButtonClick = () => {
        // Check if add button exists and is not disabled
        const addButton = document.querySelector('a[href*="service-sections/create"]');
        if (addButton) {
            addButton.addEventListener('click', function(e) {
                e.preventDefault();

                // Check if service sections already exist via AJAX
                $.ajax({
                    method: 'GET',
                    url: '/service-sections/check-exists',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(response) {
                        if (response.exists) {
                            // 2 sections exist, show error message
                            errorAlert(response.message);
                        } else {
                            // Less than 2 sections exist, redirect to create page
                            window.location.href = addButton.href;
                        }
                    },
                    error: function(xhr) {
                        // If error, show the error message
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorAlert(xhr.responseJSON.message);
                        } else {
                            errorAlert('You cannot add new content because you can only add 2 service sections');
                        }
                    }
                });
            });
        }
    }

    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable(datatable);
            handleAddButtonClick();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatable.init();
});
