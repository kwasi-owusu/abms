var specialKeys = new Array();
specialKeys.push(8, 46); //Backspace
function IsNumeric(e) {
  var keyCode = e.which ? e.which : e.keyCode;
  console.log(keyCode);
  var ret =
    (keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1;
  return ret;
}

tinymce.init({
  selector: ".post_content",
  height: 600,
  menubar: true,

  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code fullscreen",
    "insertdatetime media table paste imagetools wordcount",
  ],
  toolbar:
    "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
  content_style:
    "body { font-family:Helvetica,Arial,sans-serif; font-size:14px }",
});

function notify_this_agent(itm) {
  let agent_id = $(itm).attr("data-id");

  $("<div>").load(
    "apps/agency/view/modals/modal.notify_this_agent.phtml?id=" + agent_id,
    function (data) {
      $("#notify_this_agent_content_here").html(data);
    }
  );
}

function mail_this_agent(itm) {
  let agent_id = $(itm).attr("data-id");

  $("<div>").load(
    "apps/agency/view/modals/modal.email_this_agent.phtml?id=" + agent_id,
    function (data) {
      $("#mail_this_agent_content_here").html(data);
    }
  );
}

function change_agency_status(itm) {
  let agent_id = $(itm).attr("data-id");

  $("<div>").load(
    "apps/agency/view/modals/modal.change_agency_status.phtml?id=" + agent_id,
    function (data) {
      $("#change_agency_status_content_here").html(data);
    }
  );
}
