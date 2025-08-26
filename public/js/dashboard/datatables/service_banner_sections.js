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
                    datatable.DataTable().ajax.url(`/service-banner-sections?page=${info.page + 1}&per_page=${info.length}`);
                }
            },
            columns: [
                { data: 'id' },
                { data: 'image' },
                { data: 'title' },
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
                    targets: 3, // column index for is_active
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
                                    <a href="/service-banner-sections/${row.id}/edit" class="menu-link px-3 d-flex justify-content-between edit-row" >
                                        <span> ${translate('Edit')} </span>
                                        <span>  <i class="fa fa-edit text-primary"></i> </span>
                                    </a>

                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="/service-banner-sections/${row.id}" class="menu-link px-3 d-flex justify-content-between" >
                                        <span> ${translate('Show')} </span>
                                        <span>  <i class="fa fa-eye text-black-50"></i> </span>
                                    </a>

                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3 d-flex justify-content-between delete-row" data-row-id="${row.id}" data-type="${translate('service banner section')}">
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
                        url: '/service-banner-sections/' + rowId,
                        success: () => {

                            setTimeout(() => {

                                successAlert(`${translate('You have deleted the') + ' ' + type + ' ' + translate('successfully !')} `)
                                    .then(function () {
                                        datatable.draw();
                                        // Update the add button state after deletion
                                        updateAddButtonState();
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
        // Check if banner exists via AJAX
        $.ajax({
            method: 'GET',
            url: '/service-banner-sections/check-exists',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                if (response.exists) {
                    // Banner exists, disable the add button
                    disableAddButton();
                } else {
                    // No banner exists, enable the add button
                    enableAddButton();
                }
            },
            error: function(xhr) {
                console.error('Error checking banner existence:', xhr);
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
            const enabledLink = toolbar.querySelector('a[href*="service-banner-sections/create"]');
            if (!enabledLink) {
                const addLink = document.createElement('a');
                addLink.href = '/service-banner-sections/create';
                addLink.className = 'btn btn-primary';
                addLink.setAttribute('data-bs-toggle', 'tooltip');
                addLink.setAttribute('title', '');
                addLink.innerHTML = `
                    <span class="svg-icon svg-icon-2">
                        <i class="fa fa-plus fa-lg"></i>
                    </span>
                    Add new content
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
            const enabledLink = toolbar.querySelector('a[href*="service-banner-sections/create"]');
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
                addButton.setAttribute('title', 'You can only add 1 banner');
                addButton.innerHTML = `
                    <span class="svg-icon svg-icon-2">
                        <i class="fa fa-plus fa-lg"></i>
                    </span>
                    Add new content
                `;
                toolbar.appendChild(addButton);
            }
        }
    }

    // Handle add button click
    let handleAddButtonClick = () => {
        // Check if add button exists and is not disabled
        const addButton = document.querySelector('a[href*="service-banner-sections/create"]');
        if (addButton) {
            addButton.addEventListener('click', function(e) {
                e.preventDefault();

                // Check if banner already exists via AJAX
                $.ajax({
                    method: 'GET',
                    url: '/service-banner-sections/check-exists',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(response) {
                        if (response.exists) {
                            // Banner exists, show error message
                            errorAlert(response.message);
                        } else {
                            // No banner exists, redirect to create page
                            window.location.href = addButton.href;
                        }
                    },
                    error: function(xhr) {
                        // If error, show the error message
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorAlert(xhr.responseJSON.message);
                        } else {
                            errorAlert('You cannot add new content because you can only add 1 banner');
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
