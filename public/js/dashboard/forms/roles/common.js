// Create an object to store the selected permissions
let selectedPermissions = {};

// Select All handler
$("#edit-select-all, #add-select-all").change(function () {
    const formType = $(this).data('form-type');
    const updatedForm = `#role_form_${formType}`;

    if ($(this).prop('checked')) {
        // Select all checkboxes
        $(`${updatedForm} input[type="checkbox"][class*="${formType}-checkbox"]`).prop('checked', true).each(function() {
            const module = $(this).data('module');
            const permission = $(this).data('permission');

            // Initialize module array if it doesn't exist
            if (!selectedPermissions[module])
                selectedPermissions[module] = [];

            // Add permission if it's not already in the array
            if (!selectedPermissions[module].includes(permission)) {
                selectedPermissions[module].push(permission);
            }
        });
    } else {
        // Unselect all checkboxes and clear permissions
        $(`${updatedForm} input[type="checkbox"]`).prop('checked', false);
        selectedPermissions = {};
    }

    // Update hidden input with the latest permissions
    $(`#permissions-input-${formType}`).val(JSON.stringify(selectedPermissions));
});


// start code for getting the role data by ajax request
$('.edit-role-btn').click( function () {

    let clickedBtn = $(this);
    let roleId     = $(this).data('role-id');

    clickedBtn.attr('disabled',true).attr("data-kt-indicator", "on")

    removeValidationMessages();

    /** turn of all checkboxes of the previous edited role **/

    $('.update-checkbox').prop('checked',false);

    $.ajax({
        url:"/roles/" + roleId,
        method:"GET",
        success:function (response) {

            $("#kt_modal_update_role").modal('show');

            clickedBtn.attr('disabled',false).removeAttr("data-kt-indicator")

            // set the role name
            $("#name_ar_inp_edit").val( response.data.name_ar );
            $("#name_en_inp_edit").val( response.data.name_en );

            // set the route to the update form
            $("#role_form_update").attr('action',`/roles/${roleId}`);

            // set the abilities of the role to checkboxes
            Object.entries(response.data.permissions).forEach(([module, permissions]) => {

                permissions.forEach((permission) => {

                    let checkBox = $(`#update_${permission}_${module}`);
                    console.log(checkBox.length)
                    checkBox.prop('checked', true);

                    if (!selectedPermissions[module])
                        selectedPermissions[module] = [];

                    selectedPermissions[module].push(permission);
                })

            });

            $(`#permissions-input-update`).val(JSON.stringify(selectedPermissions));

        },
    });
});
// start code for getting the role data by ajax request


// start code for customizing the checkbox value to its ability id
$(':checkbox').change(function () {

    const module = $(this).data('module');
    const permission = $(this).data('permission');
    const formType = $(this).attr('id').split('_')[0];

    if ( module ){

        if ($(this).prop('checked')) {
            // If the checkbox is checked, add the permission to the module
            if (!selectedPermissions[module]) {
                selectedPermissions[module] = [];
            }
            selectedPermissions[module].push(permission);
        } else {
            // If the checkbox is unchecked, remove the permission from the module
            if (selectedPermissions[module]) {
                const index = selectedPermissions[module].indexOf(permission);
                if (index > -1) {
                    selectedPermissions[module].splice(index, 1);
                }

                // If no permissions left for the module, remove the module
                if (selectedPermissions[module].length === 0) {
                    delete selectedPermissions[module];
                }
            }
        }
    }

    // Set the value of a hidden input with the stringifies permissions
    $(`#permissions-input-${formType}`).val(JSON.stringify(selectedPermissions));
});
// end   code for customizing the checkbox value to its ability id
