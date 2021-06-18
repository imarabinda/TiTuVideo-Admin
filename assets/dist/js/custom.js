function successmessage(heading, messge) {
    $.toast({ heading: heading, text: messge, icon: "success", position: "top-right" });
}
function errormessage(heading, messge) {
    $.toast({ heading: heading, text: messge, icon: "error", position: "top-right" });
}
$(document).ready(function () {

    
    $(document).on("change", "#profile_image", function () {
        CheckFileExtention(this);
    });
    $(document).on("change", "#hash_tag_profile", function () {
        CheckFileExtention(this);
    });
    $(document).on("change", "#sound_category_profile", function () {
        CheckFileExtention(this);
    });
    $(document).on("change", "#profile_category_image", function () {
        CheckFileExtention(this);
    });
    $(document).on("change", "#sound", function () {
        CheckSoundExtention(this);
    });
    $(document).on("change", "#sound_image", function () {
        CheckFileExtention(this);
    });
    var CheckFileExtention = function (input) {
        if (input.files) {
            $(".image_error").text("");
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
            if (!allowedExtensions.exec(input.value)) {
                $(".image_error").show();
                $(".image_error").text("Please upload file having extensions .jpeg/.jpg/.png only.");
                input.value = "";
                return false;
            } else {
                $(".image_error").text("");
            }
        }
    };
    var CheckSoundExtention = function (input) {
        if (input.files) {
            $(".sound_error").text("");
            var allowedExtensions = /(\.mp3|\.aac)$/i;
            if (!allowedExtensions.exec(input.value)) {
                $(".sound_error").show();
                $(".sound_error").text("Please upload file having extensions .mp3/.aac only.");
                input.value = "";
                return false;
            } else {
                $(".sound_error").text("");
            }
        }
    };
    $("#modal-video").on("hidden.bs.modal", function (e) {
        $(".videodiv video")[0].pause();
    });
    $(document).on("click", "#playvideomdl", function () {
        var src = $(this).attr("data-src");
        $(".videodiv video source").attr("src", src);
        $(".videodiv video")[0].load();
    });
});
if ($("form[name='edit_user']").length > 0) {
    $("form[name='edit_user']").validate({
        rules: { full_name: "required", user_name: "required", user_email: "required" },
        messages: { full_name: "Please enter your first name", user_name: "Please enter your last name", user_email: "Please enter your email" },
        submitHandler: function (form) {
            $(".loader").show();
            $.ajax({
                url: base_url + "admin/User/update_user",
                data: new FormData($("#edit_user")[0]),
                type: "POST",
                contentType: false,
                processData: false,
                success: function (data) {
                    $(".loader").hide();
                    if (data == 1) {
                        successmessage("Success", "User update successfully");
                    } else {
                        errormessage("Error", "User update failed");
                    }
                },
            });
        },
    });
}
if ($("form[name='explore_image']").length > 0) {
    var hdn_hash_tag_id = $("#hash_tag_id").val();
    $("form[name='explore_image']").validate({
        rules: {
            hash_tag_id: { required: true },
            hash_tag_profile: {
                required: {
                    depends: function (element) {
                        return $("#hash_tag_id").val() == 0;
                    },
                },
            },
        },
        messages: { hash_tag_id: { required: "Please enter sound category name" }, hash_tag_profile: { required: "Please upload image" } },
        submitHandler: function (form) {
            $(".loader").show();
            $.ajax({
                url: base_url + "admin/Hash_Tag/update_explore_image",
                data: new FormData($("#explore_image")[0]),
                type: "POST",
                contentType: false,
                processData: false,
                success: function (data) {
                    $(".loader").hide();
                    if (data == 1) {
                        successmessage("Success", "Explore image update successfully");
                        $("#hashtag-table").DataTable().ajax.reload(null, false);
                        $("#hashtag-table-explore").DataTable().ajax.reload(null, false);
                        $(".close").click();
                        $("#modal-hashtag").modal("hide");
                    } else {
                        errormessage("Error", "Explore image update failed");
                    }
                },
            });
        },
    });
}
$(document).on("click", ".hashtag_cancel", function () {
    $("#modal-hashtag").modal("hide");
});
$("#hashtag-table-explore").on("click", ".edit_hashtag", function () {
    $(".preview_hashtagimg").html("");
    $("#hash_tag_profile").val("");
    var id = $(this).attr("data-id");
    var src = $(this).attr("data-src");
    $("#hdn_hash_tag_id").val(id);
    if (src) {
        var html = '<div class="text-center"><img height="150px;" width="150px;" class="displayimg" src="' + src + '"> </div>';
        $(".preview_hashtagimg").html(html);
    }
});
$("#hashtag-table").on("click", ".edit_hashtag", function () {
    $(".preview_hashtagimg").html("");
    $("#hash_tag_profile").val("");
    var id = $(this).attr("data-id");
    var src = $(this).attr("data-src");
    $("#hdn_hash_tag_id").val(id);
    if (src) {
        var html = '<div class="text-center"><img height="150px;" width="150px;" class="displayimg" src="' + src + '"> </div>';
        $(".preview_hashtagimg").html(html);
    }
});
if ($("form[name='rewarding_action_form']").length > 0) {
    $("form[name='rewarding_action_form']").validate({
        rules: { action_name: "required", coin: "required" },
        messages: { action_name: "Please enter action name", coin: "Please enter coin" },
        submitHandler: function (form) {
            $(".loader").show();
            $.ajax({
                url: base_url + "admin/Rewarding/update_rewarding_action",
                data: new FormData($("#rewarding_action_form")[0]),
                type: "POST",
                contentType: false,
                processData: false,
                success: function (data) {
                    $(".loader").hide();
                    if (data == 1) {
                        successmessage("Success", "Action update successfully");
                        $("#rewarding-table").DataTable().ajax.reload(null, false);
                        $("#modal-rewarding_action").modal("hide");
                    } else {
                        errormessage("Error", "Action update failed");
                    }
                },
            });
        },
    });
}
$(document).on("click", ".rewarding_cancel", function () {
    $("#modal-rewarding_action").modal("hide");
});
$("#rewarding-table").on("click", ".edit_rewarding_action", function () {
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");
    var coin = $(this).attr("data-coin");
    $("#rewarding_action_id").val(id);
    $("#action_name").val(name);
    $("#coin").val(coin);
});
if ($("form[name='coin_rate_form']").length > 0) {
    $("form[name='coin_rate_form']").validate({
        rules: { usd_rate: "required" },
        messages: { usd_rate: "Please enter coin rate" },
        submitHandler: function (form) {
            $(".loader").show();
            $.ajax({
                url: base_url + "admin/Coin/update_coin_rate",
                data: new FormData($("#coin_rate_form")[0]),
                type: "POST",
                contentType: false,
                processData: false,
                success: function (data) {
                    $(".loader").hide();
                    if (data == 1) {
                        successmessage("Success", "Coin rate update successfully");
                    } else {
                        errormessage("Error", "Coin rate update failed");
                    }
                },
            });
        },
    });
}
if ($("form[name='sound_category_form']").length > 0) {
    var hdn_sound_category_id = $("#hdn_sound_category_id").val();
    $("form[name='sound_category_form']").validate({
        rules: {
            sound_category_name: { required: true },
            sound_category_profile: {
                required: {
                    depends: function (element) {
                        return $("#hdn_sound_category_id").val() == 0;
                    },
                },
            },
        },
        messages: { sound_category_name: { required: "Please enter sound category name" }, sound_category_profile: { required: "Please upload image" } },
        submitHandler: function (form) {
            $(".image_error").text("");
            $(".loader").show();
            $.ajax({
                url: base_url + "admin/Sound/manage_sound_category",
                data: new FormData($("#sound_category_form")[0]),
                type: "POST",
                contentType: false,
                processData: false,
                success: function (data) {
                    $(".loader").hide();
                    var obj = jQuery.parseJSON(data);
                    if (obj.status == 1) {
                        successmessage("Success", "Sound category update successfully");
                        setTimeout(function () {
                            $("#sound-category-table").DataTable().ajax.reload(null, false);
                            $("#modal-soundcategory").modal("hide");
                        }, 3000);
                    } else if (obj.status == 2) {
                        successmessage("Success", "Sound category add successfully");
                        $("#sound_category_form")[0].reset();
                        $("#sound-category-table").DataTable().ajax.reload(null, false);
                        $("#modal-soundcategory").modal("hide");
                    } else {
                        errormessage("Error", "Somrthing went wrong");
                    }
                },
            });
        },
    });
}
$(document).on("click", ".sound_category_cancel", function () {
    $("#modal-soundcategory").modal("hide");
});
$("#modal-soundcategory").on("hidden.bs.modal", function (e) {
    $("#sound_category_form")[0].reset();
    $(".soundcattitle").text("Add Sound Category");
    $("#hdn_sound_category_id").val("");
    $(".preview_soundcatimg").html("");
    var validator = $("#sound_category_form").validate();
    validator.resetForm();
});
$("#sound-category-table").on("click", ".edit_soundcategory", function () {
    $(".soundcattitle").text("Edit Sound Category");
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");
    var src = $(this).attr("data-src");
    $("#hdn_sound_category_id").val(id);
    $("#sound_category_name").val(name);
    var html = '<div class="text-center"><img height="150px;" width="150px;" class="displayimg" src="' + src + '"> </div>';
    $(".preview_soundcatimg").html(html);
});
if ($("form[name='profile_category_form']").length > 0) {
    var hdn_profile_category_id = $("#profile_category_id").val();
    $("form[name='profile_category_form']").validate({
        rules: {
            profile_category_name: { required: true },
            profile_category_image: {
                required: {
                    depends: function (element) {
                        return $("#profile_category_id").val() == 0;
                    },
                },
            },
        },
        messages: { profile_category_name: { required: "Please enter profile category name" }, profile_category_image: { required: "Please upload image" } },
        submitHandler: function (form) {
            $(".loader").show();
            $(".image_error").text("");
            $.ajax({
                url: base_url + "admin/Profile_Categories/manage_profile_category",
                data: new FormData($("#profile_category_form")[0]),
                type: "POST",
                contentType: false,
                processData: false,
                success: function (data) {
                    $(".loader").hide();
                    var obj = jQuery.parseJSON(data);
                    if (obj.status == 1) {
                        successmessage("Success", "Profile category update successfully");
                        setTimeout(function () {
                            $("#modal-profilecategory").modal("hide");
                            $("#profile-category-table").DataTable().ajax.reload(null, false);
                        }, 3000);
                    } else if (obj.status == 2) {
                        successmessage("Success", "Profile category add successfully");
                        $("#profile_category_form")[0].reset();
                        $("#modal-profilecategory").modal("hide");
                        $("#profile-category-table").DataTable().ajax.reload(null, false);
                    } else {
                        errormessage("Error", "Somrthing went wrong");
                    }
                },
            });
        },
    });
}
$(document).on("click", ".profile_category_cancel", function () {
    $("#modal-profilecategory").modal("hide");
});
$("#modal-profilecategory").on("hidden.bs.modal", function (e) {
    $("#profile_category_form")[0].reset();
    $(".profilecattitle").text("Add Profile Category");
    $("#profile_category_id").val("");
    $(".preview_profilecatimg").html("");
    var validator = $("#profile_category_form").validate();
    validator.resetForm();
});
$("#profile-category-table").on("click", ".edit_profilecategory", function () {
    $(".profilecattitle").text("Edit Profile Category");
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");
    var src = $(this).attr("data-src");
    $("#profile_category_id").val(id);
    $("#profile_category_name").val(name);
    var html = '<div class="text-center"><img height="150px;" width="150px;" class="displayimg" src="' + src + '"> </div>';
    $(".preview_profilecatimg").html(html);
});
if ($("form[name='coin_plan_form']").length > 0) {
    $("form[name='coin_plan_form']").validate({
        rules: { coin_plan_name: "required", coin_plan_description: "required", coin_plan_price: "required", coin_amount: "required", playstore_product_id: "required" },
        messages: {
            coin_plan_name: "Please enter coin plan name",
            coin_plan_description: "Please enter coin plan description",
            coin_plan_price: "Please enter coin plan price",
            coin_amount: "Please enter coin amount",
            playstore_product_id: "Please enter playstore id",
        },
        submitHandler: function (form) {
            $(".loader").show();
            $.ajax({
                url: base_url + "admin/Coin/manage_coin_plan",
                data: new FormData($("#coin_plan_form")[0]),
                type: "POST",
                contentType: false,
                processData: false,
                success: function (data) {
                    $(".loader").hide();
                    var obj = jQuery.parseJSON(data);
                    if (obj.status == 1) {
                        successmessage("Success", "Coin Plan update successfully");
                        setTimeout(function () {
                            $("#modal-coin-plan").modal("hide");
                            $("#coin-plan-table").DataTable().ajax.reload(null, false);
                        }, 3000);
                    } else if (obj.status == 2) {
                        successmessage("Success", "Coin Plan add successfully");
                        $("#coin_plan_form")[0].reset();
                        $("#modal-coin-plan").modal("hide");
                        $("#coin-plan-table").DataTable().ajax.reload(null, false);
                    } else {
                        errormessage("Error", "Somrthing went wrong");
                    }
                },
            });
        },
    });
}
$(document).on("click", ".coin_plan_cancel", function () {
    $("#modal-coin-plan").modal("hide");
});
$("#modal-coin-plan").on("hidden.bs.modal", function (e) {
    $("#coin_plan_form")[0].reset();
    $(".coinplantitle").text("Add Coin Plan");
    $("#coin_plan_id").val("");
    var validator = $("#coin_plan_form").validate();
    validator.resetForm();
});
$("#coin-plan-table").on("click", ".edit_coin-plan", function () {
    $(".coinplantitle").text("Edit Coin Plan");
    var coin_plan_id = $(this).attr("data-id");
    $.ajax({
        url: base_url + "admin/Coin/get_coinplan_data_by_id",
        data: { coin_plan_id: coin_plan_id },
        type: "POST",
        cache: false,
        dataType: "json",
        success: function (data) {
            if (data.status == 1) {
                var coin_plan = data.data.coin_plan;
                $("#coin_plan_id").val(coin_plan.coin_plan_id);
                $("#coin_plan_name").val(coin_plan.coin_plan_name);
                $("#coin_plan_description").val(coin_plan.coin_plan_description);
                $("#coin_plan_price").val(coin_plan.coin_plan_price);
                $("#coin_amount").val(coin_plan.coin_amount);
                $("#playstore_product_id").val(coin_plan.playstore_product_id);
                $("#appstore_product_id").val(coin_plan.appstore_product_id);
            } else {
                errormessage("Error", "No Data Found");
            }
        },
    });
});

if ($("form[name='sound_form']").length > 0) {
    $("form[name='sound_form']").validate({
        rules: {
            sound_category_id: { required: true },
            sound_title: { required: true },
            sound: {
                required: {
                    depends: function (element) {
                        return $("#sound_id").val() == 0;
                    },
                },
            },
            sound_image: {
                required: {
                    depends: function (element) {
                        return $("#sound_id").val() == 0;
                    },
                },
            },
        },
        messages: { sound_category_id: { required: "Please enter sound category" }, sound_title: { required: "Please enter sound title" }, sound: { required: "Please upload sound" }, sound_image: { required: "Please upload image" } },
        submitHandler: function (form) {
            $(".image_error").text("");
            $(".sound_error").text("");
            $(".loader").show();
            $.ajax({
                url: base_url + "admin/Sound/manage_sound",
                data: new FormData($("#sound_form")[0]),
                type: "POST",
                contentType: false,
                processData: false,
                success: function (data) {
                    $(".loader").hide();
                    var obj = jQuery.parseJSON(data);
                    if (obj.status == 1) {
                        successmessage("Success", "Sound update successfully");
                        setTimeout(function () {
                            $("#modal-sound").modal("hide");
                            $("#sound-table").DataTable().ajax.reload(null, false);
                            $("#sound-by-category-table").DataTable().ajax.reload(null, false);
                            $("#sounds-by-user-table").DataTable().ajax.reload(null, false);
                        }, 3000);
                    } else if (obj.status == 2) {
                        successmessage("Success", "Sound add successfully");
                        $("#sound_form")[0].reset();
                        $("#modal-sound").modal("hide");
                        $("#sound-table").DataTable().ajax.reload(null, false);
                        $("#sound-by-category-table").DataTable().ajax.reload(null, false);
                        $("#sounds-by-user-table").DataTable().ajax.reload(null, false);
                    } else {
                        errormessage("Error", "Somrthing went wrong");
                    }
                },
            });
        },
    });
}



if ($("form[name='notification_form']").length > 0) {
    $("form[name='notification_form']").validate({
        rules: {
            notification_title: { required: true },
            notification_body: { required: true },
            
        },
        messages: { notification_title: { required: "Please enter notification title" }, notification_body: { required: "Please enter notification body" } },
        submitHandler: function (form) {
            $(".image_error").text("");
            $(".notification_error").text("");
            $(".loader").show();
            $.ajax({
                url: base_url + "admin/Notifications/send_notification",
                data: new FormData($("#notification_form")[0]),
                type: "POST",
                contentType: false,
                processData: false,
                success: function (data) {
                    $(".loader").hide();
                    var obj = jQuery.parseJSON(data);
                    if (obj.status == 1) {
                        successmessage("Success", "Notification sent successfully");
                        setTimeout(function () {
                            $("#modal-notification").modal("hide");
                            $("#notification-table").DataTable().ajax.reload(null, false);
                            }, 3000);
                    } else {
                        errormessage("Error", "Something went wrong");
                    }
                },
            });
        },
    });
}


if ($("form[name='banner_form']").length > 0) {
    $("form[name='banner_form']").validate({
        rules: {
            banner_action: { required: true },
            // banner_action_value: { required: true },
            banner_image: {
                required: {
                    depends: function (element) {
                        return $("#banner_id").val() == 0;
                    },
                },
            },
        },
        messages: { 
            banner_action: { required: "Please select banner action" }, 
            banner_image: { required: "Please upload image" } },
        submitHandler: function (form) {
            $(".image_error").text("");
            $(".banner_error").text("");
            $(".loader").show();
            $.ajax({
                url: base_url + "admin/SearchHeaders/manage_banner",
                data: new FormData($("#banner_form")[0]),
                type: "POST",
                contentType: false,
                processData: false,
                success: function (data) {
                    $(".loader").hide();
                    var obj = jQuery.parseJSON(data);
                    if (obj.status == 1) {
                        successmessage("Success", "Banner update successfully");
                        setTimeout(function () {
                            $("#modal-banner").modal("hide");
                            $("#banners-table").DataTable().ajax.reload(null, false);
                            }, 3000);
                    } else if (obj.status == 2) {
                        successmessage("Success", "Banner add successfully");
                        $("#banner_form")[0].reset();
                        $("#modal-banner").modal("hide");
                        $("#banners-table").DataTable().ajax.reload(null, false);
                        } else {
                        errormessage("Error", "Somrthing went wrong");
                    }
                },
            });
        },
    });
}



$(".add_sound").on("click", function (e) {
    $("#sound_form")[0].reset();
    $(".soundtitle").text("Add Sound");
    $("#sound_id").val("");
    $.ajax({
        url: base_url + "admin/Sound/get_category",
        data: {},
        type: "POST",
        cache: false,
        dataType: "json",
        success: function (data) {
            var html = '<option value="">Select Category</option>';
            if (data.status == 1) {
                $(data.data.sound_category_data).each(function (i, value) {
                    html += '<option value="' + value.sound_category_id + '" >' + value.sound_category_name + "</option>";
                });
            }
            $("#sound_category_id").html(html);
        },
    });
    $(".preview_soundimg").html("");
    $(".preview_soundcatimg").html("");
    var validator = $("#sound_form").validate();
    validator.resetForm();
});


$(".add_banner").on("click", function (e) {
    $("#banner_form")[0].reset();
    $(".bannertitle").text("Add Banner");
    $("#banner_id").val("");
    
    $(".preview_bannerimg").html("");
    var validator = $("#banner_form").validate();
    validator.resetForm();
});


$("#modal-sound").on("hidden.bs.modal", function (e) {
    $("#sound_form")[0].reset();
    $(".soundtitle").text("Add Sound");
    $("#sound_id").val("");
    // $.ajax({
    //     url: base_url + "admin/Sound/get_category",
    //     data: {},
    //     type: "POST",
    //     cache: false,
    //     dataType: "json",
    //     success: function (data) {
    //         var html = '<option value="">Select Category</option>';
    //         if (data.status == 1) {
    //             $(data.data.sound_category_data).each(function (i, value) {
    //                 html += '<option value="' + value.sound_category_id + '" >' + value.sound_category_name + "</option>";
    //             });
    //         }
    //         $("#sound_category_id").html(html);
    //     },
    // });
    $(".preview_soundimg").html("");
    $(".preview_soundcatimg").html("");
    var validator = $("#sound_form").validate();
    validator.resetForm();
});

$(document).on("click", ".sound_cancel", function () {
    $("#modal-sound").modal("hide");
});
$("#modal-banner").on("hidden.bs.modal", function (e) {
    $("#banner_form")[0].reset();
    $(".bannertitle").text("Add Banner");
    $("#banner_id").val("");
    // $.ajax({
    //     url: base_url + "admin/Sound/get_category",
    //     data: {},
    //     type: "POST",
    //     cache: false,
    //     dataType: "json",
    //     success: function (data) {
    //         var html = '<option value="">Select Category</option>';
    //         if (data.status == 1) {
    //             $(data.data.sound_category_data).each(function (i, value) {
    //                 html += '<option value="' + value.sound_category_id + '" >' + value.sound_category_name + "</option>";
    //             });
    //         }
    //         $("#sound_category_id").html(html);
    //     },
    // });
    $(".preview_bannerimg").html("");
    var validator = $("#banner_form").validate();
    validator.resetForm();
});

$(document).on("click", ".banner_cancel", function () {
    $("#modal-banner").modal("hide");
});
$("#sound-table").on("click", ".edit_sound", function () {
    $(".soundtitle").text("Edit Sound");
    var sound_id = $(this).attr("data-id");
    $.ajax({
        url: base_url + "admin/Sound/get_sound_data_by_id",
        data: { sound_id: sound_id },
        type: "POST",
        cache: false,
        dataType: "json",
        success: function (data) {
            if (data.status == 1) {
                var sound_data = data.data.sound_data;
                var html = '<option value="">Select Category</option>';
                $(data.data.sound_category_data).each(function (i, value) {
                    if (value.sound_category_id == sound_data.sound_category_id) {
                        var selected = "selected";
                    } else {
                        var selected = "";
                    }
                    html += '<option value="' + value.sound_category_id + '" ' + selected + ">" + value.sound_category_name + "</option>";
                });
                $("#sound_category_id").html(html);
                $("#sound_id").val(sound_data.sound_id);
                $("#sound_title").val(sound_data.sound_title);
                $("#duration").val(sound_data.duration);
                $("#singer").val(sound_data.singer);
                $(".preview_soundimg").html('<div class="text-center mt-5"> <audio controls=""> <source class="displayimg1" src="' + sound_data.sound + '" type="audio/mpeg"></audio> </div>');
                $(".preview_soundcatimg").html('<div class="text-center"><img height="150px;" width="150px;" class="displayimg" src="' + sound_data.sound_image + '"> </div>');
            } else {
                errormessage("Error", "No Data Found");
            }
        },
    });
});


$("#banners-table").on("click", ".edit_banner", function () {
    $(".bannertitle").text("Edit Banner");
    var banner_id = $(this).attr("data-id");
    $.ajax({
        url: base_url + "admin/SearchHeaders/get_banner_data_by_id",
        data: { banner_id: banner_id },
        type: "POST",
        cache: false,
        dataType: "json",
        success: function (data) {
            if (data.status == 1) {
                var banner_data = data.data.banner_data;
                var html = '<option value="">Select Action</option>';
                $(data.data.banner_options).each(function (i, value) {
                    if (value.banner_action == banner_data.banner_action) {
                        var selected = "selected";
                    } else {
                        var selected = "";
                    }
                    html += '<option value="' + value.banner_action + '" ' + selected + ">" + value.banner_action_name + "</option>";
                });
                $("#banner_action").html(html);
                $("#banner_id").val(banner_data.banner_id);
                $("#banner_action_value").val(banner_data.banner_action_value);
                $(".preview_bannerimg").html('<div class="text-center mt-5"> <img height="200" width="200" src="' + banner_data.banner_image + '"/></div>');
               } else {
                errormessage("Error", "No Data Found");
            }
        },
    });
});


$("#sounds-by-user-table").on("click", ".edit_sound", function () {
    $(".soundtitle").text("Edit Sound");
    var sound_id = $(this).attr("data-id");
    $.ajax({
        url: base_url + "admin/Sound/get_sound_data_by_id",
        data: { sound_id: sound_id },
        type: "POST",
        cache: false,
        dataType: "json",
        success: function (data) {
            if (data.status == 1) {
                var sound_data = data.data.sound_data;
                var html = '<option value="">Select Category</option>';
                $(data.data.sound_category_data).each(function (i, value) {
                    if (value.sound_category_id == sound_data.sound_category_id) {
                        var selected = "selected";
                    } else {
                        var selected = "";
                    }
                    html += '<option value="' + value.sound_category_id + '" ' + selected + ">" + value.sound_category_name + "</option>";
                });
                $("#sound_category_id").html(html);
                $("#sound_id").val(sound_data.sound_id);
                $("#sound_title").val(sound_data.sound_title);
                $("#duration").val(sound_data.duration);
                $("#singer").val(sound_data.singer);
                $(".preview_soundimg").html('<div class="text-center mt-5"> <audio controls=""> <source class="displayimg1" src="' + sound_data.sound + '" type="audio/mpeg"></audio> </div>');
                $(".preview_soundcatimg").html('<div class="text-center"><img height="150px;" width="150px;" class="displayimg" src="' + sound_data.sound_image + '"> </div>');
            } else {
                errormessage("Error", "No Data Found");
            }
        },
    });
});

$("#sound-by-category-table").on("click", ".edit_sound", function () {
    $(".soundtitle").text("Edit Sound");
    var sound_id = $(this).attr("data-id");
    $.ajax({
        url: base_url + "admin/Sound/get_sound_data_by_id",
        data: { sound_id: sound_id },
        type: "POST",
        cache: false,
        dataType: "json",
        success: function (data) {
            if (data.status == 1) {
                var sound_data = data.data.sound_data;
                var html = '<option value="">Select Category</option>';
                $(data.data.sound_category_data).each(function (i, value) {
                    if (value.sound_category_id == sound_data.sound_category_id) {
                        var selected = "selected";
                    } else {
                        var selected = "";
                    }
                    html += '<option value="' + value.sound_category_id + '" ' + selected + ">" + value.sound_category_name + "</option>";
                });
                $("#sound_category_id").html(html);
                $("#sound_id").val(sound_data.sound_id);
                $("#sound_title").val(sound_data.sound_title);
                $("#duration").val(sound_data.duration);
                $("#singer").val(sound_data.singer);
                $(".preview_soundimg").html('<div class="text-center mt-5"> <audio controls=""> <source class="displayimg1" src="' + sound_data.sound + '" type="audio/mpeg"></audio> </div>');
                $(".preview_soundcatimg").html('<div class="text-center"><img height="150px;" width="150px;" class="displayimg" src="' + sound_data.sound_image + '"> </div>');
            } else {
                errormessage("Error", "No Data Found");
            }
        },
    });
});
if ($("form[name='adminprofile']").length > 0) {
    $("form[name='adminprofile']").validate({
        rules: { admin_name: "required", admin_email: "required", admin_password: "required" },
        messages: { admin_name: "Please enter your name", admin_email: "Please enter your email", admin_password: "Please enter your password" },
        submitHandler: function (form) {
            $(".loader").show();
            $.ajax({
                url: base_url + "admin/Login/updateadminprofile",
                data: new FormData($("#adminprofile")[0]),
                type: "POST",
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    $(".loader").hide();
                    if (data.status == 1) {
                        $(".admin_name").text(data.admin_name);
                        $(".admin_email").text(data.admin_email);
                        if (data.admin_profile) {
                            $(".admin_profile").attr("src", data.admin_profile);
                        }
                        $("#profile_image").val("");
                        $("#modal-adminprofile").modal("hide");
                        successmessage("Success", "Admin profile update successfully");
                    } else {
                        errormessage("Error", "Admin profile update failed");
                    }
                },
            });
        },
    });
}
$(document).on("click", ".admin_profile_cancel", function () {
    $("#modal-adminprofile").modal("hide");
});
if ($("form[name='manage_2fa']").length > 0) {
    $("form[name='manage_2fa']").validate({
        rules: { password: "required", two_fa_code: { required: true, number: true, minlength: 6, maxlength: 6 } },
        messages: { password: "Please enter password", two_fa_code: "Please enter valid two-fa-code" },
        submitHandler: function (form) {
            $(".loader").show();
            $.ajax({
                url: base_url + "admin/Login/update2fa",
                data: new FormData($("#manage_2fa")[0]),
                type: "POST",
                contentType: false,
                processData: false,
                success: function (data) {
                    $(".loader").hide();
                    var obj = jQuery.parseJSON(data);
                    if (obj.status == true) {
                        successmessage("Success", obj.dismessage);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else if (obj.status == false) {
                        errormessage("Error", obj.dismessage);
                    }
                },
            });
        },
    });
}
function selectfileadmin() {
    $("#file").click();
}
function uploadadminprofile() {
    var name = document.getElementById("file").files[0].name;
    var form_data = new FormData();
    var ext = name.split(".").pop().toLowerCase();
    if (jQuery.inArray(ext, ["gif", "png", "jpg", "jpeg"]) == -1) {
        errormessage("Error", "Invalid Image File");
    }
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("file").files[0]);
    var f = document.getElementById("file").files[0];
    var fsize = f.size || f.fileSize;
    if (fsize > 2000000) {
        errormessage("Error", "Image File Size is very big");
    } else {
        form_data.append("file", document.getElementById("file").files[0]);
        $.ajax({
            url: base_url + "admin/Login/updateadminprofileimg",
            method: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == 1) {
                    successmessage("Success", "Admin profile image update successfully");
                    setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                } else {
                    errormessage("Error", data);
                }
            },
        });
    }
}
function callagain() {
    $(".tree li").hide();
    $(".tree>ul>li").show();
    $(".tree li").on("click", function (e) {
        var children = $(this).find("> ul > li");
        if (children.is(":visible")) children.hide("fast");
        else children.show("fast");
        e.stopPropagation();
    });
}
function deletedata(id, action_type) {
    if (action_type == "sound_category") {
        var text = "You will not be able to recover this data!";
        var confirmButtonText = "Yes, Delete it!";
        var btn = "btn-danger";
    }
    if (action_type == "profile_category") {
        var text = "You will not be able to recover this data!";
        var confirmButtonText = "Yes, Delete it!";
        var btn = "btn-danger";
    }
    if (action_type == "sound") {
        var text = "You will not be able to recover this data!";
        var confirmButtonText = "Yes, Delete it!";
        var btn = "btn-danger";
    }
    if (action_type == "report_confirm") {
        var text = "Report will be confirmed!";
        var confirmButtonText = "Yes, Confirm it!";
        var btn = "btn-success";
    }
    if (action_type == "report_deny") {
        var text = "Report will be denied!";
        var confirmButtonText = "Yes, Confirm it!";
        var btn = "btn-success";
    }
    if (action_type == "verification_request") {
        var text = "This verification request confirm!";
        var confirmButtonText = "Yes, Confirm it!";
        var btn = "btn-success";
    }
    if (action_type == "verification_request_deny") {
        var text = "This verification request deny!";
        var confirmButtonText = "Yes, Deny it!";
        var btn = "btn-success";
    }
    if (action_type == "redeem_request") {
        var text = "Your redeem request confirm!";
        var confirmButtonText = "Yes, Confirm it!";
        var btn = "btn-success";
    }
    if (action_type == "post") {
        var text = "You will not be able to recover this data!";
        var confirmButtonText = "Yes, Delete it!";
        var btn = "btn-danger";
    }
    if (action_type == "user") {
        var text = "You will not be able to recover this data!";
        var confirmButtonText = "Yes, Delete it!";
        var btn = "btn-danger";
    }
    if (action_type == "report_delete") {
        var text = "You will not be able to recover this data!";
        var confirmButtonText = "Yes, Delete it!";
        var btn = "btn-danger";
    }
    if (action_type == "coin_plan") {
        var text = "You will not be able to recover this data!";
        var confirmButtonText = "Yes, Delete it!";
        var btn = "btn-danger";
    }
    if (action_type == "hash_tags") {
        var text = "Your report able to submit data!";
        var confirmButtonText = "Yes, Confirm it!";
        var btn = "btn-success";
    }
    if (action_type == "remove_hash_tags") {
        var text = "You will not be able to recover this data!";
        var confirmButtonText = "Yes, Delete it!";
        var btn = "btn-danger";
    }
    if (action_type == "move_to_trending") {
        var text = "Your post move to trending?";
        var confirmButtonText = "Yes, Confirm it!";
        var btn = "btn-success";
    }
    if (action_type == "remove_from_trending") {
        var text = "Your post remove to trending!";
        var confirmButtonText = "Yes, Remove it!";
        var btn = "btn-danger";
    }
    if (action_type == "post_ban") {
        var text = "This post will be banned!";
        var confirmButtonText = "Yes, Ban it!";
        var btn = "btn-danger";
    }
    swal(
        { title: "Are you sure?", text: text, type: "warning", showCancelButton: true, confirmButtonClass: btn, confirmButtonText: confirmButtonText, cancelButtonText: "No, cancel please!", closeOnConfirm: false, closeOnCancel: false },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: base_url + "admin/Dashboard/deletedata",
                    data: { id: id, action_type: action_type },
                    type: "POST",
                    success: function (data) {
                        if (data == 1) {
                            if (action_type == "sound_category") {
                                swal("Disable!", "Your sound category has been disable!", "success");
                                $("#sound-category-table").DataTable().ajax.reload(null, false);
                            }
                            if (action_type == "profile_category") {
                                swal("Disable!", "Your profile category has been disable!", "success");
                                $("#profile-category-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "sound") {
                                swal("Disable!", "Your sound has been disable!", "success");
                                $("#sound-table").DataTable().ajax.reload(null, false);
                                $("#sound-by-category-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "post") {
                                swal("Disable!", "Your post has been disable!", "success");
                                $("#post-table").DataTable().ajax.reload(null, false);
                                $("#user-post-table").DataTable().ajax.reload(null, false);
                                $("#hash-post-table").DataTable().ajax.reload(null, false);
                                $("#sound-post-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "user") {
                                swal("Disable!", "Your post has been disable!", "success");
                                $("#user-table").DataTable().ajax.reload(null, false);$("#user-category-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "report_delete") {
                                swal("Disable!", "Your report has been disable!", "success");
                                $("#report-table").DataTable().ajax.reload(null, false);
                                $("#report-table-user").DataTable().ajax.reload(null, false);
                                $("#user-reports-table").DataTable().ajax.reload(null, false);
                                $("#video-reports-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "report_confirm") {
                                swal("Disable!", "Report has been confirm!", "success");
                                $("#report-table").DataTable().ajax.reload(null, false);
                                $("#report-table-user").DataTable().ajax.reload(null, false);
                                $("#user-reports-table").DataTable().ajax.reload(null, false);
                                $("#video-reports-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "report_deny") {
                                swal("Disable!", "Report has been denied!", "success");
                                $("#report-table").DataTable().ajax.reload(null, false);
                                $("#report-table-user").DataTable().ajax.reload(null, false);
                                $("#user-reports-table").DataTable().ajax.reload(null, false);
                                $("#video-reports-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "coin_plan") {
                                swal("Disable!", "Coin plan has been disable!", "success");
                                $("#coin-plan-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "redeem_request") {
                                swal("Confirm!", "Your redeem request has been confirm!", "success");
                                $("#redeem-request-table").DataTable().ajax.reload(null, false);
                                $("#redeem-request-confirm-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "verification_request") {
                                swal("Confirm!", "Your verification request has been confirm!", "success");
                                $("#verification-request-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "verification_request_deny") {
                                swal("Confirm!", "Your verification request has been denied!", "success");
                                $("#verification-request-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "hash_tags") {
                                swal("Confirm!", "Your hash tag has been explore!", "success");
                                $("#hashtag-table").DataTable().ajax.reload(null, false);
                                $("#hashtag-table-explore").DataTable().ajax.reload(null, false);
                            } else if (action_type == "remove_hash_tags") {
                                swal("Disable!", "Your hash tag has remove to explore!", "success");
                                $("#hashtag-table").DataTable().ajax.reload(null, false);
                                $("#hashtag-table-explore").DataTable().ajax.reload(null, false);
                            } else if (action_type == "move_to_trending") {
                                swal("Confirm!", "Your post has move to trending!", "success");
                                $("#post-table").DataTable().ajax.reload(null, false);
                                $("#user-post-table").DataTable().ajax.reload(null, false);
                                $("#hash-post-table").DataTable().ajax.reload(null, false);
                                $("#sound-post-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "remove_from_trending") {
                                swal("Disable!", "Your post has removed from trending!", "success");
                                $("#post-table").DataTable().ajax.reload(null, false);
                                $("#user-post-table").DataTable().ajax.reload(null, false);
                                $("#hash-post-table").DataTable().ajax.reload(null, false);
                                $("#sound-post-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "post_allow") {
                                swal("Confirm!", "Your post allowed!", "success");
                                $("#post-table").DataTable().ajax.reload(null, false);
                                $("#user-post-table").DataTable().ajax.reload(null, false);
                                $("#hash-post-table").DataTable().ajax.reload(null, false);
                                $("#sound-post-table").DataTable().ajax.reload(null, false);
                            } else if (action_type == "post_ban") {
                                swal("Confirm!", "Your post banned!", "success");
                                $("#post-table").DataTable().ajax.reload(null, false);
                                $("#user-post-table").DataTable().ajax.reload(null, false);
                                $("#hash-post-table").DataTable().ajax.reload(null, false);
                                $("#sound-post-table").DataTable().ajax.reload(null, false);
                            } else {
                                swal("Delete!", "Your data has been deleted!", "success");
                            }
                        }
                    },
                });
            } else {
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        }
    );
}



function removeverify(verification_request_id) {
    swal(
        {
            title: "Are you sure?",
            text: "You want set your reject message:",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, reject it!",
            animation: "slide-from-top",
            inputPlaceholder: "Enter message",
        },
        function (message_text) {
            if (message_text === false) return false;
            if (message_text === "") {
                swal.showInputError("Enter message here");
                return false;
            } else {
                $.ajax({
                    url: base_url + "admin/Dashboard/removeverify",
                    data: { verification_request_id: verification_request_id, message_text: message_text },
                    type: "POST",
                    success: function (data) {
                        if (data == 1) {
                            successmessage("Success", "verification request remove successfully");
                            setTimeout(function () {
                                window.location.reload();
                            }, 3000);
                        } else {
                            errormessage("Error", "verification request remove failed");
                        }
                    },
                });
            }
        }
    );
}
function send_perticular_noti() {
    var message = $("#message").val();
    var user_id = $("#user_id").val();
    if (message == "") {
        return false;
    }
    $.ajax({
        url: base_url + "admin/User/send_perticular_noti",
        data: { message: message, user_id: user_id },
        type: "POST",
        success: function (data) {
            if (data == 1) {
                successmessage("Success", "Notification send successfully");
                setTimeout(function () {
                    window.location.reload();
                }, 3000);
            } else {
                errormessage("Error", "Notification send failed");
            }
        },
    });
}
