var options = {
    series: [{
    name: 'Credit',
    data: [44, 55, 57, 56, 61, 58, 63, 60, 66, 47]
  }, {
    name: 'Debit',
    data: [76, 85, 101, 98, 87, 105, 91, 114, 94, 55]
  },

  {
    name: 'Transfers',
    data: [100, 85, 110, 58, 65, 121, 85, 74, 49, 100]
  }],
    chart: {
    type: 'bar',
    height: 350
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '55%',
      endingShape: 'rounded'
    },
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
  },
  xaxis: {
    categories: ['Agent A', 'Agent B', 'Agent C', 'Agent D', 'Agent E', 'Agent F', 'Agent G', 'Agent H', 'Agent I', 'Agent J'],
  },
  yaxis: {
    title: {
      text: '$ (thousands)'
    }
  },
  fill: {
    opacity: 1
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return "$ " + val + " thousands"
      }
    }
  }
  };

  var chart = new ApexCharts(document.querySelector("#credit_debit_volume"), options);
  chart.render();