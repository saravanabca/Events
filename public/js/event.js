$(document).ready(function () {
    var mode, id, coreJSON;
    var currentPage = 0; 
    // ***************************[Get] ********************************************************************
    // Getevent();


        $.ajax({
            url: baseUrl + "/event-get",
            type: "GET",
            dataType: "json",
            success: function (response) {
                disevent(response);
                coreJSON = response.eventdetails;
                console.log(coreJSON);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching event details:", error);
            },
        });
    

        function disevent(data) {
            if ($.fn.DataTable.isDataTable("#datatable")) {
                $('#datatable').DataTable().clear().destroy();
            }
        
            var table = $("#datatable").dataTable({
                aaSorting: [],
                aaData: data.eventdetails,
                aoColumns: [
                    {
                        mData: function (data, type, full, meta) {
                            return data.name;
                        },
                    },
                    {
                        mData: function (data, type, full, meta) {
                            return data.event_date;
                        },
                    },
                    {
                        mData: function (data, type, full, meta) {
                            return data.event_descrption;
                        },
                    },
                    {
                        mData: function (data, type, full, meta) {
                            return `<img class="view_image" src="${baseUrl}/${data.image}" alt="event Image" style="width: 50px; height: 50px;">`;
                        },
                    },
                    {
                        mData: function (data, type, full, meta) {
                            return `<button class="edit-btn btn btn-primary" id="${meta.row}">Edit</button>
                                    <button class="delete-btn btn btn-danger" id="${data.id}">Delete</button>`;
                        },
                    },
                ],
                drawCallback: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        
            $('[data-toggle="tooltip"]').tooltip();
        }
        

    function refreshDetails()
    {
        currentPage = $('#datatable').DataTable().page(); // Capture the current page number
        $.when(Getevent()).done(function(){
            var table = $('#datatable').DataTable();
            table.destroy();    
            disevent(coreJSON);               
        });     
    }

    // ***************************[Add] ********************************************************************

    $(".add_event_btn").click(function () {
        mode = "new";
        $("#add_event").modal("show");
    });

    $("#add_event").on("show.bs.modal", function () {
        $(this).find("form").trigger("reset");
        $(".form-control").removeClass("danger-border success-border");
        $(".error-message").html("");
        $("#previewImage").attr("src", "");

    });

    $('#eventImage').on('change', function(event) {
        var file = event.target.files[0];
        
        if (file) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
                $('#previewImage').show(); 
                $('#eventImage_error').text(''); 
            };
            
            reader.readAsDataURL(file);
        } else {
            $('#previewImage').hide();
            $('#eventImage_error').text('No file selected.');
        }
    });

    $("#event_add_form input").on("keyup", function () {
        validateField($(this));
    });

    // Form submission

    $("#event_add_form").on("submit", function (e) {
        e.preventDefault();
        
        var form = $(this);
        var isValid = true;
        var firstInvalidField = null;

        // Validate all fields
        if (!validateField($("#eventName"))) {
            isValid = false;
            firstInvalidField = $("#eventName");
        } else if (!validateField($("#eventDate"))) {
            isValid = false;
            if (firstInvalidField === null) firstInvalidField = $("#eventDate");
        } 
        else if (!validateField($("#eventDescrption"))) {
            isValid = false;
            if (firstInvalidField === null) firstInvalidField = $("#eventDescrption");
        } 
        else if (!validateField($("#eventImage"))) {
            isValid = false;
            if (firstInvalidField === null)
                firstInvalidField = $("#eventImage");
        }

        if (isValid) {
            var formData = new FormData(this);
            console.log(formData);
            if (mode == "new") {
                // showToast("add");
                // return;
                AjaxSubmit(formData, baseUrl + "/event-add", "POST");

            } else if (mode == "update") {
              
                formData.append("event_id", id);
                AjaxSubmit(formData, baseUrl + "/event-update", "POST");
            }
        } else {
            firstInvalidField.focus();
        }
    });

    // Field validation function

    function validateField(field) {
        var fieldId = field.attr("id");
        var fieldValue = field.val().trim();
        var isValid = true;
        var errorMessage = "";

        if (fieldId === "eventName") {
            if (fieldValue === "") {
                isValid = false;
                errorMessage = "event Name is required";
            }
        } 
        else if (fieldId === "eventDescrption") {
            if (fieldValue === "") {
                isValid = false;
                errorMessage = "event Descrption is required";
            }
        } 
       else if (fieldId === "eventDate") {
            if (fieldValue === "") {
                isValid = false;
                errorMessage = "event Date is required";
            }
        } 
       else if (fieldId === "eventImage" && mode != 'update') {
            if (fieldValue === "") {
                isValid = false;
                errorMessage = "event Image is required";
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


    // AJAX submit function
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
                // Handle success
                if (response.status === "event_add_success") {
                    if (response.status_value) {
                        
                        $("#add_event").modal("hide");

                        showToast(response.message);
                        window.location.reload();
                        // Getevent();
                     
                    } else {
                        showToast(response.message);
                    }
                }
                if (response.status === "event_update_success") {
                    if (response.status_value) {
                        $("#add_event").modal("hide");
                        showToast(response.message);
                        // refreshDetails();
                        // Getevent();
                        window.location.reload();

                    } else {
                        showToast(response.message);
                    }
                }
                else {
                    showToast(response.message);
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

    // ***************************[Edit] ********************************************************************

    $(document).on("click", ".edit-btn", function () {
        var r_index = $(this).attr("id");
        mode = "update";
        $("#add_event").modal("show");
        
        $("#eventName").val(coreJSON[r_index].name);
        $("#eventDescrption").val(coreJSON[r_index].event_descrption);
        let eventDate = coreJSON[r_index].event_date;
        eventDate = eventDate.split(' ')[0]; // Extracts '2024-11-11'
        $("#eventDate").val(eventDate);
        // $("#eventDate").val(coreJSON[r_index].event_date);
        $("#previewImage").attr("src", baseUrl + '/' + coreJSON[r_index].image);

        console.log(coreJSON);
        id = coreJSON[r_index].id;
    });

    // ***************************[Delete] ********************************************************************

    $(document).on("click", ".delete-btn", function () {
        var selectedId = $(this).attr("id");
        $.confirm({
            title: "Confirmation!",
            content: "Are you sure want to delete?",
            type: "red",
            typeAnimated: true,
            // autoClose: 'cancelAction|8000',
            buttons: {
                deleteevent: {
                    text: "delete event",
                    action: function () {
                        $.ajax({
                            url: baseUrl + "/event-delete",
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                            },
                            data: { selectedId: selectedId }, // Send data as an object
                            success: function (data) {
                                if (data.status) {
                                   showToast(data.message);
                                   location.reload();
                                } else {
                                    showToast(data.message);
                                }
                            },
                            error: function (xhr, status, error) {
                                // Handle error response
                            },
                        });
                    },
                    btnClass: "btn-red",
                },
                cancel: function () {
                    // $.showToast('action is canceled');
                },
            },
        });
    });

    
    
});
