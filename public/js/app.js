var xhr;
var _orgAjax = jQuery.ajaxSettings.xhr;
jQuery.ajaxSettings.xhr = function () {
    xhr = _orgAjax();
    return xhr;
};

$("body").on("click", ".modal-show", function (event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr("href"),
        title = me.attr("title");

    $("#modal-title").text(title);
    $("#modal-btn-save")
        .removeClass("hide")
        .text(me.hasClass("edit") ? "Update" : "Create");

    $.ajax({
        url: url,
        dataType: "html",
        success: function (response) {
            if (xhr.responseURL === loginUrl) {
                location.reload();
            }
            $("#modal-body").html(response);
            $("#modal").modal("show");
        },
    });
});

$("#modal-btn-save").click(function (event) {
    event.preventDefault();

    var form = $("#modal-body form"),
        url = form.attr("action"),
        method = $("input[name=_method]").val() == undefined ? "POST" : "PUT";

    var formdata = false;

    if (form[0].enctype == "multipart/form-data") {
        formdata = new FormData(form[0]);
    } else {
        formdata = form.serialize();
    }

    console.log(formdata);
    form.find(".help-block").remove();
    form.find(".form-group").removeClass("has-error");

    if (form[0].enctype == "multipart/form-data") {
        $.ajax({
            url: url,
            method: method,
            data: formdata,
            contentType: false,
            processData: false,
            cache: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "Data has been saved!",
                        timer: 2000,
                        confirmButtonColor: "#3085d6",
                    });
                    form.trigger("reset");
                    $("#modal").modal("hide");
                    $("#question").val("");
                    $("#datatable").DataTable().ajax.reload();
                    $("#group-answer-" + data).html("");
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Something went wrong!",
                        text: "Check your values",
                        confirmButtonColor: "#3085d6",
                    });
                }

                if (response.redirect) {
                    window.location.replace(response.redirect);
                }
            },
            error: function (xhr) {
                var res = xhr.responseJSON;
                if (res.message != "") {
                }
                console.log(res.errors);
                if ($.isEmptyObject(res.errors) == false) {
                    $.each(res.errors, function (key, value) {
                        $("#" + key)
                            .closest(".form-control")
                            .addClass("is-invalid");
                        $(
                            '<span class="invalid-feedback" role="alert"><strong>' +
                                value +
                                "</strong></span>"
                        ).insertAfter($("#" + key));
                    });
                }

                Swal.fire({
                    icon: "error",
                    title: "Something went wrong!",
                    text: "Check your values",
                    confirmButtonColor: "#3085d6",
                });
            },
        });
    } else {
        $.ajax({
            url: url,
            method: method,
            data: formdata,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "Data has been saved!",
                        timer: 2000,
                        confirmButtonColor: "#3085d6",
                    });
                    form.trigger("reset");
                    $("#modal").modal("hide");
                    $("#datatable").DataTable().ajax.reload();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Something went wrong!",
                        text: "Check your values",
                        confirmButtonColor: "#3085d6",
                    });
                }

                if (response.redirect) {
                    window.location.replace(response.redirect);
                }
            },
            error: function (xhr) {
                var res = xhr.responseJSON;
                if (res.message != "") {
                }
                console.log(res.errors);
                if ($.isEmptyObject(res.errors) == false) {
                    $.each(res.errors, function (key, value) {
                        $("#" + key)
                            .closest(".form-control")
                            .addClass("is-invalid");
                        $(
                            '<span class="invalid-feedback" role="alert"><strong>' +
                                value +
                                "</strong></span>"
                        ).insertAfter($("#" + key));
                    });
                }

                Swal.fire({
                    icon: "error",
                    title: "Something went wrong!",
                    text: "Check your values",
                    confirmButtonColor: "#3085d6",
                });
            },
        });
    }
});

$("body").on("click", ".btn-delete", function (event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr("href"),
        title = me.attr("title"),
        csrf_token = $('meta[name="csrf-token"]').attr("content");

    Swal.fire({
        title: "Are you sure want to delete \n" + title + " ?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _method: "DELETE",
                    _token: csrf_token,
                },
                success: function (response) {
                    $("#datatable").DataTable().ajax.reload();
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "Data has been deleted!",
                        timer: 2000,
                        confirmButtonColor: "#3085d6",
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                        confirmButtonColor: "#3085d6",
                    });
                },
            });
        }
    });
});

$("body").on("click", ".btn-show", function (event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr("href"),
        title = me.attr("title");

    $("#modal-title").text(title);
    $("#modal-btn-save").addClass("hide");

    $.ajax({
        url: url,
        dataType: "html",
        success: function (response) {
            $("#modal-body").html(response);
        },
    });

    $("#modal").modal("show");
});

$("body").on("click", ".modal-create", function (event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr("href"),
        title = me.attr("title");

    $("#modal-title-create").text(title);
    $("#modal-btn-save")
        .removeClass("hide")
        .text(me.hasClass("edit") ? "Update" : "Create");

    $.ajax({
        url: url,
        dataType: "html",
        success: function (response) {
            if (xhr.responseURL === loginUrl) {
                location.reload();
            }
            $("#modal-body-create").html(response);
            $("#modal-create").modal("show");
        },
    });
});

$("#modal-btn-create").click(function (event) {
    event.preventDefault();

    var form = $("#modal-body-create form"),
        url = form.attr("action"),
        method = $("input[name=_method]").val() == undefined ? "POST" : "PUT";

    form.find(".help-block").remove();
    form.find(".form-group").removeClass("has-error");

    $.ajax({
        url: url,
        method: method,
        data: form.serialize(),
        success: function (response) {
            form.trigger("reset");
            $("#modal-create").modal("hide");
            // $('#datatable').DataTable().ajax.reload();
            console.log(response.res);
            if (response.res === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Data has been saved!",
                    timer: 2000,
                    confirmButtonColor: "#3085d6",
                });
                window.location.reload();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Something went wrong!",
                    text: "Check your values",
                    confirmButtonColor: "#3085d6",
                });
            }
        },
        error: function (xhr) {
            var res = xhr.responseJSON;
            if (res.message != "") {
            }
            console.log(res.errors);
            if ($.isEmptyObject(res.errors) == false) {
                $.each(res.errors, function (key, value) {
                    $("#" + key)
                        .closest(".form-control")
                        .addClass("is-invalid");
                    $(
                        '<span class="invalid-feedback" role="alert"><strong>' +
                            value +
                            "</strong></span>"
                    ).insertAfter($("#" + key));
                });
            }

            Swal.fire({
                icon: "error",
                title: "Something went wrong!",
                text: "Check your values",
                confirmButtonColor: "#3085d6",
            });
        },
    });
});

$("body").on("click", ".modal-create-upload", function (event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr("href"),
        title = me.attr("title");

    $("#modal-title-create").text(title);
    $("#modal-btn-create-upload")
        .removeClass("hide")
        .text(me.hasClass("edit") ? "Update" : "Create");

    $.ajax({
        url: url,
        dataType: "html",
        success: function (response) {
            if (xhr.responseURL === loginUrl) {
                location.reload();
            }
            $("#modal-body-create-upload").html(response);
            $("#modal-create-upload").modal("show");
        },
    });
});

$("#modal-btn-create-upload").click(function (event) {
    event.preventDefault();

    var form = $("#modal-body-create form"),
        url = form.attr("action"),
        method = $("input[name=_method]").val() == undefined ? "POST" : "PUT";

    var formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }

    form.find(".help-block").remove();
    form.find(".form-group").removeClass("has-error");

    $.ajax({
        url: url,
        method: method,
        contentType: false,
        cache: false,
        processData: false,
        enctype: "multipart/form-data",
        data: formdata ? formdata : form.serialize(),
        success: function (response) {
            form.trigger("reset");
            $("#modal-create").modal("hide");
            // $('#datatable').DataTable().ajax.reload();
            if (response.res === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Data has been saved!",
                    timer: 2000,
                    confirmButtonColor: "#3085d6",
                });
                window.location.reload();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Something went wrong!",
                    text: "Check your values",
                    confirmButtonColor: "#3085d6",
                });
            }
        },
        error: function (xhr) {
            var res = xhr.responseJSON;
            if (res.message != "") {
            }
            console.log(res.errors);
            if ($.isEmptyObject(res.errors) == false) {
                $.each(res.errors, function (key, value) {
                    $("#" + key)
                        .closest(".form-control")
                        .addClass("is-invalid");
                    $(
                        '<span class="invalid-feedback" role="alert"><strong>' +
                            value +
                            "</strong></span>"
                    ).insertAfter($("#" + key));
                });
            }

            Swal.fire({
                icon: "error",
                title: "Something went wrong!",
                text: "Check your values",
                confirmButtonColor: "#3085d6",
            });
        },
    });
});
