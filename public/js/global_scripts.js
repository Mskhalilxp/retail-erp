
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

let initTinyMc = function( editingInp = false, height = 400 ) {

    tinymce.init({
        height,
        selector: ".tinymce",
        menubar: false,
        toolbar: ["styleselect save",
            "undo redo | cut copy paste | forecolor backcolor casechange permanentpen formatpainter removeformat | bold italic underline strikethrough | link image | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | blockquote subscript superscript | charmap | print preview | code fullscreen | media pageembed link | ltr rtl"],
        plugins : "lists charmap print preview code save directionality fullscreen image link media ",
        save_onsavecallback: function () { }
    });

    if ( ! editingInp )
        $('.tinymce').val(null);

}

let getImagePath = function(imageName , directory) {

    return imagesBasePath + '/' + directory + '/' + imageName;
}

let removeValidationMessages = function() {
    /** Remove All Validation Messages **/

    let errorElements = $('.invalid-feedback');

    errorElements.html('').css('display','none');

    $('form .form-control').removeClass('is-invalid is-valid') // remove validation borders

}

let displayValidationMessages = function(errors ,form) {

    removeValidationMessages();

    form.find('.form-control').addClass('is-valid') // remove validation borders

    /** Display All Validation Messages **/
    $.each(errors, function(elementId, errorMessage) {

        elementId = elementId.replaceAll('.','_');

        let errorInput   = form.find("#" + elementId + '_inp' );
        let errorElement = form.find("#" + elementId );

        if (errorElement != null)
            errorElement.html(errorMessage).css('display','block')

        if (errorInput   != null)
            errorInput.addClass('is-invalid')

    });

    /** scroll to the first error element **/
    let firstErrorElementId = Object.keys(errors)[0].replaceAll('.','_');

    let firstErrorElement   = document.getElementById(firstErrorElementId);

    firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });


}


/** Begin :: System Alerts  **/

let confirmationAlert = function(message = translate("Are You Sure ?")) {
    return Swal.fire({
        text: message,
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: translate('Yes'),
        cancelButtonText: translate('No'),
        customClass: {
            confirmButton: "btn fw-bold btn-success",
            cancelButton: "btn fw-bold btn-danger"
        }
    })
}

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
        confirmButtonColor:'#1E1E2D',
        cancelButtonColor:'#c61919',
        confirmButtonText: `<span> ${ translate('change')} </span>`,
        cancelButtonText: `<span> ${translate('cancel')} </span>`,
        allowOutsideClick: false,
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

    if ( $('textarea[class="tinymce"]').length )
        tinymce.triggerSave();

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

            successAlert( form.data('success-message') ).then( () => response.redirection_url ? window.location.replace(response.redirection_url) : window.location.replace( form.data('redirection-url') ) );

            form.trigger('reset');

            if ( form.data('success-callback-function') !== undefined )
                window[ form.data('success-callback-function') ](200 , response)
        },
        error:function (response) {

            removeValidationMessages();

            if (response.status === 422)
                displayValidationMessages(response.responseJSON.errors , form);
            else if (response.status === 403)
                unauthorizedAlert();
            else
                errorAlert(response.responseJSON.message , 5000 )

            if ( form.data('error-callback-function') !== undefined )
                window[ form.data('error-callback-function') ](response.status , response)
        },
        complete:function () {
            submitBtn.attr('disabled',false).removeAttr("data-kt-indicator")
        }
    });

}
/** End   :: Submit any form in dashboard function  **/

/** initialize datepicker inputs */
let initDatePicker = function(inputId = null, startDate) {
    /** initialize datepicker inputs */
    let datePickers = inputId ? $("#" + inputId) : $('.datepicker');

    datePickers.daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 2000,
        autoClose: true,
        startDate: startDate ? startDate : moment(),
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: translate('Clear'),
            applyLabel: translate('Apply'),
        },
        todayHighlight: false,
        autoApply: true,
    }).on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('').trigger('change');
    });

    /** initialize datepicker inputs */
}
/** initialize datepicker inputs */

/** End   :: Helper Functions  **/

$(document).ready(function () {

    /** Start :: ajax request form  **/
    $('#submitted-form,.submitted-form').submit(function (event) {

        event.preventDefault();

        if($('.tinymce').length)
            tinyMCE.triggerSave();
        submitForm( this );

    })
    /** End   :: ajax request form  **/

    /** initialize timepicker inputs */
    let timepickers = $('.timepicker');

    if( timepickers.length )
    {
        timepickers.flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            direction: 'ltr'
        });
    }
    /** initialize timepicker inputs */

    /** customizing select2 message */
    let selectBoxes = $('select');

    if( selectBoxes.length )
    {
        selectBoxes.select2({
            "language": {
                "noResults": function () {
                    return translate("No results found");
                }
            },
            allowClear: true,
            templateResult: formatState,
            templateSelection: formatState,
        })
    }
    /** customizing select2 message */

    function formatState(state) {
        const option = $(state.element);
        const color = option.data("color");

        if (!color) {
            return state.text;
        }

        return $(`<span style="color: ${color}">${state.text}</span>`);
    };

})
