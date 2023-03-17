var options = {
    series: [44, 55, 13, 43, 22, 150, 34, 205, 10, 45],
    chart: {
    width: 500,
    type: 'pie',
  },
  labels: ['Agent A', 'Agent B', 'Agent C', 'Agent D', 'Agent E', 'Agent F', 'Agent G', 'Agent H', 'Agent I', 'Agent J'],
  responsive: [{
    breakpoint: 450,
    options: {
      chart: {
        width: 200
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
  };

  var chart = new ApexCharts(document.querySelector("#transaction_metrics_by_regions"), options);
  chart.render();