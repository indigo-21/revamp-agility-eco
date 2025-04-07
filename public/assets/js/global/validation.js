// FORMAT TEXT PATTERN
// // Accept Only letters and spaces
// onlyTextRegex = /^[a-zA-Z\s]*$/;

// // Accept Only numbers
// onlyNumberRegex = /^[0-9]*$/;

// // Accept Allow letters, numbers, and specific special characters
// safeSpecialRegex = /^[a-zA-Z0-9!@#&()\-]*$/;

function validateForm(formID){
    let form            = $(`#${formID}`);
    let inputContainer  = [];
    let selectContainer = [];
    let firstElement    = "";
    let errorCount      = 0;

    form.find("input, select").each(function () {
        let element = this;
        let elementContainer = element.tagName !== "INPUT" ? selectContainer : inputContainer;
        elementContainer.push(element);
    });

    inputContainer.forEach((element, index) =>{
        const thisElement    = $(element);
        const value          = thisElement.val();
        const isRequired     = thisElement.attr("required");
        const patternAttr    = thisElement.attr("textpattern") ? `^${thisElement.attr("textpattern")}+$` : false;
        const messageElement = thisElement.closest(".form-group").find(".invalid-feedback");
        let pattern          = patternAttr ? new RegExp(patternAttr) : false;

        // Clear any previous errors
        thisElement.removeClass("is-invalid");

        if(thisElement.attr("type") === "text"){
            errorCount++;
            if (isRequired && value.trim() === "") {
                thisElement.addClass("is-invalid");
                messageElement.html("This field is required.");
                if (firstElement == "") firstElement = element;
            } else if (pattern && !pattern.test(value)) {
                thisElement.addClass("is-invalid");
                messageElement.html("Invalid format.");
                if (firstElement == "") firstElement = element;
            } else{
                thisElement.attr("disabled") || thisElement.addClass("is-valid");
                messageElement.html("");
                errorCount--;
            }
        }else if(thisElement.attr("type") === "email"){
            errorCount++;
            pattern = new RegExp(`^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$`);

            if (isRequired && value.trim() === "") {
                thisElement.addClass("is-invalid");
                messageElement.html("This field is required.");
                if (firstElement == "") firstElement = element;
            } else if (pattern && !pattern.test(value)) {
                thisElement.addClass("is-invalid");
                messageElement.html("Invalid format.");
                if (firstElement == "") firstElement = element;
            } else{
                thisElement.addClass("is-valid");
                messageElement.html("");
                errorCount--;
            }
        }else if(thisElement.attr("type") === "checkbox"){

        }
    });

    selectContainer.forEach((element,index)=>{
        const thisElement       = $(element);
        const value             = thisElement.val();
        const isRequired        = thisElement.attr("required");
        const select2Element    = thisElement.closest(".form-group").find(".select2-selection");
        const messageElement    = thisElement.closest(".form-group").find(".invalid-feedback");
        
        // Clear any previous errors
        thisElement.removeClass("is-invalid");
        select2Element.removeClass("has-error");
        errorCount++;
        if(isRequired && value === null){
            thisElement.addClass("is-invalid");
            select2Element.addClass("has-error");
            messageElement.html("This field is required.");
            if (firstElement == "") firstElement = element;
        }else{
            select2Element.addClass("no-error");
            errorCount--;
        }
    })

    firstElement != "" && firstElement.focus();

    return errorCount;
}