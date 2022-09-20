document.addEventListener("DOMContentLoaded", function () {
  new DataTable("#example");
}),
  document.addEventListener("DOMContentLoaded", function () {
    new DataTable("#scroll-vertical", {
      scrollY: "210px",
      scrollCollapse: !0,
      paging: !1,
    });
  }),
  document.addEventListener("DOMContentLoaded", function () {
    new DataTable("#scroll-horizontal", { scrollX: !0 });
  }),
  document.addEventListener("DOMContentLoaded", function () {
    new DataTable("#alternative-pagination", { pagingType: "full_numbers" });
  }),
  $(document).ready(function () {
    var e = $("#add-rows").DataTable(),
      a = 1;
    $("#addRow").on("click", function () {
      e.row
        .add([
          a + ".1",
          a + ".2",
          a + ".3",
          a + ".4",
          a + ".5",
          a + ".6",
          a + ".7",
          a + ".8",
          a + ".9",
          a + ".10",
          a + ".11",
          a + ".12",
        ])
        .draw(!1),
        a++;
    }),
      $("#addRow").click();
  }),
  $(document).ready(function () {
    $("#example").DataTable();
  }),
  document.addEventListener("DOMContentLoaded", function () {
    new DataTable("#fixed-header", { fixedHeader: !0 });
  }),
  document.addEventListener("DOMContentLoaded", function () {
    new DataTable("#model-datatables", {
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (e) {
              e = e.data();
              return "Details for " + e[0] + " " + e[1];
            },
          }),
          renderer: $.fn.dataTable.Responsive.renderer.tableAll({
            tableClass: "table",
          }),
        },
      },
    });
  }),
  document.addEventListener("DOMContentLoaded", function () {
    new DataTable(".buttons-datatables", {
      dom: "Bfrtip",
      buttons: ["copy", "csv", "excel", "print"],
    });
  }),
  document.addEventListener("DOMContentLoaded", function () {
    new DataTable("#ajax-datatables", { ajax: "assets/json/datatable.json" });
  });
