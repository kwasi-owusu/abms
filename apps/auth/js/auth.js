$("#user_loginForm").on("submit", function (e) {
  $("#loader").show();
  $("#saveBtn").prop("disabled", true);
  e.preventDefault();

  var email = $("#username").val();

  // grecaptcha.ready(function() {
  //     grecaptcha.execute('6Lfqc-YhAAAAAIVtOJ7GyiGX4gjWJE8FAGOsi418', {action: 'CTRLLoginUser'}).then(function(token) {
  //         $('#user_loginForm').prepend('<input type="hidden" name="r_token" value="' + token + '">');
  //         $('#user_loginForm').prepend('<input type="hidden" name="r_action" value="CTRLLoginUser">');
  //         //$('#loginForm').unbind('submit').submit();
  //     });;
  // });

  $.ajax({
    url: "apps/auth/controller/CTRLLoginUser.php",
    method: "POST",
    data: new FormData(this),
    contentType: false,
    dataType: "JSON",
    cache: false,
    processData: false,

    success: function (data) {
      $.toast({
        heading: "Agency Banking",
        text: data.message,
        icon: "info",
        loader: true, // Change it to false to disable loader
        position: "top-right",
        loaderBg: "#000", // To change the background
      });

      $("#loader").hide();

      if(data.message =="Login Successful" && data.error_code == 111){
        setInterval("location.reload()", 3000);
        window.location = "admin";
    }

    else{
     $("#loader").hide(); 
     $('#saveBtn').prop('disabled', false);  
    }

      setInterval("location.reload()", 3000);
    },
  });
});

$("#user_add_frm").on("submit", function (e) {
  $("#saveBtn").prop("disabled", true);
  $("#loader").show();
  e.preventDefault();
  $.ajax({
    url: "auth/controller/AddUserController.php",
    method: "POST",
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    success: function (data) {
      $("#responseHere").fadeOut("slow", function () {
        Snackbar.show({
          text: data,
          actionTextColor: "#fff",
          backgroundColor: "#2196f3",
        });

        $("#loader").hide();

        setInterval("location.reload()", 3000);
      });

      $("#saveBtn").prop("disabled", false);
    },
  });
});

$("#user_role_frm").on("submit", function (e) {
  $("#loader").show();
  $("#saveBtn").prop("disabled", true);
  e.preventDefault();
  $.ajax({
    url: "bamboo/controller/users/AddUserRoles.php",
    method: "POST",
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    success: function (data) {
      $("#submit_output").fadeOut("slow", function () {
        $("#loader").hide();
        $.toast({
          heading: "Rails ERP",
          text: data,
          icon: "info",
          loader: true, // Change it to false to disable loader
          position: "top-right",
          loaderBg: "#9EC600", // To change the background
        });
        setInterval("location.reload()", 3000);
      });
    },
  });
});

$("#update_my_password_frm").on("submit", function (e) {
  $("#loader").show();
  $("#saveBtnModal").prop("disabled", true);
  e.preventDefault();
  $.ajax({
    url: "auth/controller/UpdateMyPasswordController.php",
    method: "POST",
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    success: function (data) {
      Snackbar.show({
        text: data,
        actionTextColor: "#fff",
        backgroundColor: "#2196f3",
      });

      $("#loader").hide();
      setInterval("location.reload()", 3000);
    },
  });
});

//change user role modal
function changeRole(itm) {
  let id = $(itm).attr("data-id");
  $("<div>").load(
    "auth/view/modals/modal.change_user_role.php?id=" + id,
    function (data) {
      $("#userModalContentSM").html(data);
    }
  );
}

//edit user details modal
function editThisUser(itm) {
  let id = $(itm).attr("data-id");
  $("<div>").load(
    "auth/view/modals/modal.edit_user.php?id=" + id,
    function (data) {
      $("#userModalContentLG").html(data);
    }
  );
}

//change user status modal
function deactivateUser(itm) {
  let id = $(itm).attr("data-id");
  $("<div>").load(
    "auth/view/modals/modal.deactivate_user.php?id=" + id,
    function (data) {
      $("#userModalContentSM").html(data);
    }
  );
}

//change user password modal
function changePassword(itm) {
  let id = $(itm).attr("data-id");
  $("<div>").load(
    "auth/view/modals/modal.change_user_password.php?id=" + id,
    function (data) {
      $("#userModalContentSM").html(data);
    }
  );
}

$("#c_password").on("keyup", function () {
  let firsPassword = $("#password").val();
  let secondPassword = $("#c_password").val();

  if (firsPassword !== secondPassword) {
    $("#responseHere").text("Passwords do not Match");
    $("#saveBtn").prop("disabled", true);
  } else {
    $("#responseHere").text(" ");
    $("#saveBtn").prop("disabled", false);
  }
});

let specialKeys = new Array();
specialKeys.push(8, 46); //Backspace
function IsNumeric(e) {
  let keyCode = e.which ? e.which : e.keyCode;
  console.log(keyCode);
  let ret =
    (keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1;
  return ret;
}

$(document).on("change keyup blur", "#user_email", function () {
  let email = $(this).val();
  let check_where = "users";

  $.ajax({
    url: "settings/controller/CheckEmails.php",
    type: "POST",
    //dataType:"json",
    data: { email: email, check_where: check_where },
    success: function (data) {
      if (data == "Email Exists") {
        $("#saveBtn").prop("disabled", true);

        $("#responseHere").html(data);
      } else {
        $("#saveBtn").prop("disabled", false);

        $("#responseHere").text("");
      }
    },
  });
});
