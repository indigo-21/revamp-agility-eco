'use strict';
$(document).ready(function () {

    var form = $("#example-advanced-form").show();

    form.steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        autoAdjustHeight: true,
        stepsOrientation: "vertical",
        onStepChanging: function (event, currentIndex, newIndex) {

            // Allways allow previous action even if the current form is not valid!
            if (currentIndex > newIndex) {
                return true;
            }
            // Forbid next action on "Warning" step if the user is to young
            if (newIndex === 3 && Number($("#age-2").val()) < 18) {
                return false;
            }
            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex) {
                // To remove error styles
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        // onStepChanged: function (event, currentIndex, priorIndex) {

        //     // Used to skip the "Warning" step if the user is old enough.
        //     if (currentIndex === 2 && Number($("#age-2").val()) >= 18) {
        //         form.steps("next");
        //     }
        //     // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
        //     // if (currentIndex === 2 && priorIndex === 4) {
        //     //     console.log('test');
        //     //     form.steps("previous");
        //     // }
        // },     
        onFinishing: function (event, currentIndex) {

            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            alert("Submitted!");
            $('.content input[type="text"]').val('');
            $('.content input[type="email"]').val('');
            $('.content input[type="password"]').val('');
        }
    }).validate({
        errorPlacement: function errorPlacement(error, element) {

            element.before(error);
        },
        rules: {
            confirm: {
                equalTo: "#password-2"
            }
        }
    });

    $(".js-example-basic-single").select2();

    $('.filer_input').filer({
        limit: 3,
        maxSize: 3,
        extensions: ['jpg', 'jpeg', 'png', 'gif', 'psd'],
        changeInput: true,
        showThumbs: true,
        addMore: false
    });
});