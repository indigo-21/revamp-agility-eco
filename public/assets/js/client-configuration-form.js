$(function () {
    const formData = {};
    //Initialize Elements Plugin
        $('.duallistbox').bootstrapDualListbox()

        //Initialize Select2 Elements
        $('.select2').select2();
        let clientMeasureTable    = $("#clientMeasureTable").DataTable();
        let clientJobStatusTable  = $("#clientJobStatusTable").DataTable();
    //End Initialize Elements Plugin

    // STEPPER SCRIPT
        let stepIndex   = 0;
        let steps       = $(".step");
        let stepNav     = $(".stepper-nav")
        let progressBar = $("#progress-bar");
        let totalSteps  = steps.length;
        

        function updateStepper() {
            steps.removeClass("active-step").eq(stepIndex).addClass("active-step");
            progressBar.css("width", ((stepIndex + 1) / totalSteps) * 100 + "%");
            progressBar.css("width", ((stepIndex + 1) / totalSteps) * 100 + "%");
            progressBar.text("Step " + (stepIndex + 1));
            stepNav.removeClass("btn-primary").addClass("btn-outline-primary").eq(stepIndex).removeClass("btn-outline-primary").addClass("btn-primary");
            
        }

        $(".next").click(function () {
            let formID      = $(this).attr("formid");
            let tableID     = $(this).attr("tableid");
            let errorCount  = validateForm(formID);
            
            if (errorCount < 1 && (stepIndex < totalSteps - 1)) {
                // formData.append(formID, JSON.stringify(appendFormData(formID)))
                if(!formID && !tableID){
                    let selectedValues          = $('.duallistbox').val();
                    formData["installerForm"]   = selectedValues.join(",");
                }else{
                    formData[formID || tableID] = appendFormData(formID || tableID, tableID);
                }
                stepIndex++;
                updateStepper();
            }
            
        });

        $(".prev").click(function () {
            if (stepIndex > 0) {
                stepIndex--;
                updateStepper();
            }
        });
    // END STEPPER SCRIPT

    $(document).on("click", "#clientMeasuresBtn", function(){
        let formID      = $(this).attr("formid");
        let errorCount  = validateForm(formID);

        if(errorCount < 1){
            // FORM VALUES
            let measureId   = $('select[name="measure_cat"] option:selected').val();
            let measureCat  = $('select[name="measure_cat"] option:selected').text();
            let measureVal  = $('[name=measure_fee_value]').val();
            let measureFee  = $('[name=measure_fee_currency]').val();

            let newRow = clientMeasureTable.row.add([
                measureCat,
                measureVal,
                measureFee,
                '<button class="btn btn-danger btn-sm deleteRow">Delete</button>'
            ]).draw().node();

            $(newRow).attr("id", measureId);

            clearForm(formID);
        }
        
    });

    $(document).on("click", "#clientJobStatusBtn", function(){
        let formID      = $(this).attr("formid");
        let errorCount  = validateForm(formID);

        if(errorCount < 1){
            // FORM VALUES
            let vera_job_status_name    = $('select[name="vera_job_status_name"] option:selected').text();
            let client_job_status_name  = $('[name=client_job_status_name]').val();

            clientJobStatusTable.row.add([
                vera_job_status_name,
                client_job_status_name,
                '<button class="btn btn-danger btn-sm deleteRow">Delete</button>'
            ]).draw();

            clearForm(formID);
        }
        
    }); 

    // Handle Row Deletion
    $(document).on('click', '.deleteRow', function () {
        let table = $(this).closest('table').DataTable();
        table.row($(this).parents('tr')).remove().draw();
    });

    $(document).on("click", "#submitBtn", function(){
        let containerID      = $(this).attr("formid");
        let errorCount       = validateForm(containerID);
        if(errorCount < 1){
            formData[containerID] = appendFormData(containerID);
            setTimeout(() => {
                storeData();
            }, 1000);
        }
    });

    $(document).on("keyup",".job-types", function(){
        let thisVal     = $(this).val();
        let inputName   = $(this).attr("name");
        let checkboxId  = "";
        switch (inputName) {
            case "qai_visit_duration":
                checkboxId = "qai";
                break;
            case "assessor_visit_duration":
                checkboxId = "assesor";
                break;
            default: 
                // surveyor_visit_duration
                checkboxId = "surveyor";
                break;
        }
        $(`#${checkboxId}`).attr("checked", false);

        if(thisVal.length > 0){
            $(`#${checkboxId}`).attr("checked", true);
        }
        
    });


    // Initialize Function 
    function appendFormData(containerID, isFromTable = false){
        if (containerID) {
            let data = {};

            if(isFromTable){
                data[containerID] = [];
                if($(`#${containerID} tbody tr`).length > 0){
                    let rowId = $(this).attr("id");
                    $(`#${containerID} tbody tr`).each(function(){
                        let rowData = $(this).find('td').map(function () {
                            return $(this).text().trim();
                        }).get();
    
                        if(rowData.length > 0){
                            let tempData;
                            tempData = {
                                id:rowId,
                                measure: rowData[0],
                                chargeValue: rowData[1],
                                currency: rowData[2]
                            }
                            data[containerID].push(tempData);
                        }
                    })
                }
                
            }else{
                $(`#${containerID} [name]`).each((index, element) => {
                    let thisElement = $(element);
                    let name        = thisElement.attr("name");
                    let tag         = element.tagName.toLowerCase();
                    let type        = thisElement.attr("type");
                    let value;
            
                    // Handle checkbox
                    if(type === "checkbox") {
                        data[name] =  thisElement.is(":checked"); 
                    } else if(type === "radio"){
                        data[name] =  !thisElement.is(":checked"); 
                    }else {
                        if (tag === "select") {
                            if(thisElement.hasClass("duallistbox")){
                                value = thisElement.val();
                            }else{

                                value = thisElement.find("option:selected").val();
                            }
                        } else {
                            value = thisElement.val();
                        }
                        data[name] = value;
                    }
                });
            }

           return data;
        }
    }

    function storeData(){
        let url =  $("#clientConfigurationForm").attr("action");
        console.log(formData);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url,
            method: 'POST',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function (response) {
                // Remove the alert if it exists
                $('#formAlert').removeClass('alert-danger').addClass('d-none').empty();

                // Optionally show a success alert
                $('#formAlert')
                    .removeClass('d-none')
                    .addClass('alert alert-success')
                    .text('Form submitted successfully! Please wait...');

                // Hide the success message after a few seconds
                setTimeout(() => {
                    $('#formAlert').addClass('d-none').removeClass('alert alert-success').empty();
                    window.location.href = '/client-configuration';
                }, 1000);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }


   

});



