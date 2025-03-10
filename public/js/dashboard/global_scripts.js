
let showHidePass = function( fieldId , showPwIcon )
{
    let passField = $("#" + fieldId);

    if ( passField.attr("type") === "password")
    {
        passField.attr("type","text");
        showPwIcon.children().eq(0).removeClass("fa-eye").addClass("fa-eye-slash");
    }
    else
    {
        passField.attr("type","password");
        showPwIcon.children().eq(0).removeClass("fa-eye-slash").addClass("fa-eye");
    }

}

let initTinyMc = function( editingInp = false, height = "480" ) {

    tinymce.init({
        height : height,
        selector: ".tinymce",
        menubar: false,
        toolbar: ["styleselect save",
            "undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify",
            "bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code"],
        plugins : "advlist autolink link lists charmap print preview code save",
        save_onsavecallback: function () { }
    });

    if ( ! editingInp )
        $('.tinymce').val(null);

}

let getFilePath = function(imagePath) {
    return FilesBasePath  + imagePath;
}

let removeValidationMessages = function() {
    /** Remove All Validation Messages **/

    let errorElements = $('.invalid-feedback');

    errorElements.html('').css('display','none');

    $('form .form-control').removeClass('is-invalid is-valid') // remove validation borders

}

let displayValidationMessages = function(errors ,form) {

    const formTrailing = form.data('trailing') ?? ""; // for example _edit and this trailing is used if two forms are exist in the same page one for create and another for update
    form.find('.form-control').removeClass('is-invalid') // remove validation borders

    /** Display All Validation Messages **/
    $.each(errors, function(elementId, errorMessage) {

        elementId = elementId.replaceAll('.','_');

        let errorInput   = form.find(`#${elementId}_inp${ formTrailing }`);
        let errorElement = form.find(`#${elementId}${ formTrailing }`);

        if (errorElement != null)
            errorElement.html(errorMessage).css('display','block')

        if (errorInput != null)
            if ( !errorInput.is('select') )
                errorInput.addClass('is-invalid')
            else
                errorInput.next('.select2-container').find('.select2-selection--single').addClass('is-invalid');


    });

    /** scroll to the first error element **/
    let firstErrorElementId = Object.keys(errors)[0].replaceAll('.','_') + formTrailing;

    let firstErrorElement   = document.getElementById(firstErrorElementId);

    firstErrorElement?.scrollIntoView({ behavior: 'smooth', block: 'center' });


}


/** Begin :: System Alerts  **/

let deleteAlert = function(elementName = translate("item") , ) {
    return Swal.fire({
        text: `${translate('Are you sure you want to delete this') + ' ' + elementName + ' ' + translate('?')}`,
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: translate('Yes, Delete !'),
        cancelButtonText: translate('No, Cancel'),
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary"
        }
    })
}

let errorAlert = function(message = translate("something went wrong"), time = 5000) {
    return Swal.fire({
        text: translate(message),
        icon: "error",
        buttonsStyling: false,
        showConfirmButton: false,
        timer: time,
        customClass: {
            confirmButton: "btn fw-bold btn-primary",
        }
    });
}

let successAlert = function(message = translate("Operation done successfully") , timer = 2000) {

    return Swal.fire({
        text: message,
        icon: "success",
        customClass: {
            icon: locale === 'ar' ? "flipped" : "",
        },
        buttonsStyling: false,
        showConfirmButton: false,
        timer: timer
    });

}

let inputAlert = function() {

    return Swal.fire({
        icon:'warning',
        title: translate('write a comment'),
        html: '<input id="swal-input1" class="form-control">',
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonColor:'#009ef7',
        cancelButtonColor:'#c61919',
        confirmButtonText: `<span> ${ translate('change')} </span>`,
        cancelButtonText: `<span> ${translate('cancel')} </span>`,
        preConfirm: () => {
            return [
                document.getElementById('swal-input1').value,
            ]
        },
    });

}


let warningAlert        = function(title , message , time = 5000) {
    return swal.fire({
        title: translate(title),
        text: translate(message),
        icon: "warning",
        showConfirmButton: false,
        timer: time
    });
}

let unauthorizedAlert   = function() {
    return swal.fire({
        title: translate("Error !"),
        text: translate("This action is unauthorized."),
        icon: "error",
        showConfirmButton: false,
        timer: 5000,
    });
}

let loadingAlert  = function(message = translate("Loading...") ) {

    return  Swal.fire({
        text: message,
        icon: "info",
        buttonsStyling: false,
        showConfirmButton: false,
        timer: 2000
    });

}

/** End :: System Alerts  **/


/** Start :: Helper Functions  **/

let deleteElement = (deletedElementName , deletionUrl , callback ) =>
{
    deleteAlert(deletedElementName).then(function (result) {

        if (result.value) {

            loadingAlert( translate('deleting now ...') );

            $.ajax({
                method: 'delete',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: deletionUrl,
                success: () => {

                    setTimeout( () => {

                        successAlert(`${translate('You have deleted the') + ' ' + deletedElementName + ' ' + translate('successfully !')} `)
                            .then(function () {

                                if (typeof callback === "function") {
                                    callback()
                                }

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

}

/** Start :: Submit any form in dashboard function  **/
let submitForm = (form) => {

    let formData  = new FormData( form );
    form          = $(form);
    let submitBtn = form.find("[type=submit]");

    submitBtn.attr('disabled',true).attr("data-kt-indicator", "on");

    $.ajax({
        method:form.attr('method'),
        url:form.attr('action'),
        data:formData,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        processData:false,
        contentType: false,
        cache: false,
        enctype: 'multipart/form-data',
        success:function (response) {

            removeValidationMessages();

            successAlert( form.data('success-message') ).then( () => {
                form.trigger('reset');

                if ( form.data('redirection-url') === "#")
                    window.location.reload()
                else if (form.data('redirection-url'))
                    window.location.replace(form.data('redirection-url'))

            });

            if ( form.data('callback-function') !== undefined )
                window[ form.data('callback-function') ](200 , response)
        },
        error:function (response) {

            removeValidationMessages();

            if (response.status === 422)
                displayValidationMessages(response.responseJSON.errors , form);
            else if (response.status === 403)
                unauthorizedAlert();
            else
                errorAlert(response.responseJSON.message , 5000 )

            if ( form.data('callback-function') !== undefined )
                window[ form.data('callback-function') ](response.status , response)
        },
        complete:function () {
            submitBtn.attr('disabled',false).removeAttr("data-kt-indicator")
        }
    });

}
/** End   :: Submit any form in dashboard function  **/


/** Start :: save tinymce editor function  **/
let saveTinyMceEditors = () =>
{
    return new Promise( async (resolve, reject) => {

        await  $('textarea[class="tinymce"]').each( (index,element) => tinymce.get( $(element).attr('id') ).execCommand('mceSave') )

        resolve()
    });
}
/** End   :: save tinymce editor function  **/


/** End   :: Helper Functions  **/

$(document).ready(function () {

    /** Start :: ajax request form  **/
    $('.submitted-form').submit(function (event) {

        event.preventDefault();

        // save tinymce editors then submit the form in resolve
        saveTinyMceEditors().then( () => submitForm( this ) );

    })
    /** End   :: ajax request form  **/

    /** initialize datepicker inputs */
    let datePickers = $('.datepicker');

    if( datePickers.length )
    {
        datePickers.each( ( index , element ) => {

            $(element).daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2000,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: translate('Clear'),
                    applyLabel: translate('Apply'),
                },
                maxYear: parseInt(moment().format("YYYY"),10)
            }).on('cancel.daterangepicker', function(ev, picker) {
                $(this).trigger('change');
                $(this).val('').trigger('change');
            });

            if ( ! window.location.pathname.endsWith('edit') )
                $(element).val('')
            else if ( !$(element).data('has-value') )
                $(element).val('')

        });
    }
    /** initialize datepicker inputs */

    /** customizing select2 message */
    let selectBoxes = $('select');

    if( selectBoxes.length )
    {
        selectBoxes.select2({
            "language": {
                "noResults": function () {
                    return translate("No results found");
                }
            }
        })
    }
    /** customizing select2 message */

})

/** datatables functions */

// Search Datatable
const handleSearchDatatable = (datatable) => {

        $('#general-search-inp').keyup( function () {
            setTimeout( () => datatable.search( $(this).val() ).draw(), 1000)
        });

    }

// Filter Datatable
const handleFilterDatatable = (datatable) => {

    $('.filter-datatable-inp').on('change', function() {
        datatable.column($(this).data('filter-index')).search(this.value).draw();
    });
}
/** datatables functions */
