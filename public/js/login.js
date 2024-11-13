
$("#login_form input").on("keyup", function () {
    validateField($(this));
});

$("#login_form").on("submit", function (e) {
    e.preventDefault();

    var form = $(this);
    var isValid = true;
    var firstInvalidField = null;

    // Validate all fields
    if (!validateField($("#email"))) {
        isValid = false;
        firstInvalidField = $("#email");
    } else if (!validateField($("#password"))) {
        isValid = false;
        if (firstInvalidField === null) firstInvalidField = $("#password");
    }

    if (isValid) {
        var formData = new FormData(this);
        console.log(formData);
        AjaxSubmit(formData, baseUrl + "/login", "POST");
    } else {
        firstInvalidField.focus();
    }
});

function validateField(field) {
    var fieldId = field.attr("id");
    var fieldValue = field.val().trim();
    var isValid = true;
    var errorMessage = "";

    if (fieldId === "email") {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (fieldValue === "") {
            isValid = false;
            errorMessage = "Email is required";
        } else if (!emailRegex.test(fieldValue)) {
            isValid = false;
            errorMessage = "Enter a valid Email";
        }
    } else if (fieldId === "password") {
        if (fieldValue === "") {
            isValid = false;
            errorMessage = "password is required";
        }
    }

    if (isValid) {
        field.removeClass("danger-border").addClass("success-border");
        $("#" + fieldId + "_error").text("");
    } else {
        field.removeClass("success-border").addClass("danger-border");
        $("#" + fieldId + "_error").text(errorMessage);
        // field.focus();
    }

    return isValid;
}

function AjaxSubmit(formData, url, method) {

    $.ajax({
        url: url,
        type: method,
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.status) {
                alert(response.message); 
                window.location.href = baseUrl +'/event'; 
            } else {
                alert(response.message); 
            }

        },
        error: function (xhr, status, error) {
            console.error("Error submitting form:", error);
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function (key, message) {
                    alert(message); 
                });
            } else if (xhr.status === 500) { 
                alert("An internal server error occurred. Please try again later.");
            } else {
                alert("An error occurred: " + xhr.status + " - " + error);
            }
        },
    });
}