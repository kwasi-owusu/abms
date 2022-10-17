$(document).ready(function () {
  $.ajax({
    url: "apps/dashboard/controller/CTRLDashboardSummaries.php",
    method: "POST",
    dataType: "JSON",
    success: function (data) {
      $("#total_active_users").text(data.total_active_users);
      $("#total_users_online").text(data.check_total_users_logged_in);
      $("#total_agencies").text(data.check_total_active_agencies);
      $("#total_active_branches").text(data.check_total_active_branches);
    },
  });
});


$(document).ready(function () {
  $.ajax({
    url: "apps/dashboard/controller/CTRLDashboardTransactions.php",
    method: "POST",
    dataType: "JSON",
    success: function (data) {
      $("#total_cr_transactions_for_today").text(data.total_cr_transactions_for_today);
      $("#total_dr_transactions_for_today").text(data.total_dr_transactions_for_today);
      $("#total_sum_dr_for_today").text(data.total_sum_dr_for_today);
      $("#total_sum_cr_for_today").text(data.total_sum_cr_for_today);
    },
  });
});