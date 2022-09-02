var bar_chart_draw123123 =function(type,content, idx) {
  const ctx = document.getElementById("pie-chartdivcnv"+idx).getContext('2d');
  var option = {};
  if(type === 'horizontal'){
    option = {
      indexAxis: 'y',
      // Elements options apply to all of the options unless overridden in a dataset
      // In this case, we are setting the border of each horizontal bar to be 2px wide
      elements: {
        bar: {
          borderWidth: 2,
        }
      },
      responsive: true,
      plugins: {
        legend: {
          position: 'right',
        },
        title: {
          display: true,
          text: 'Chart.js Horizontal Bar Chart'
        }
      }
    }
  }
  else if(type === 'stacked'){
    option = {
      plugins: {
        title: {
          display: true,
          text: 'Chart.js Bar Chart - Stacked'
        },
      },
      responsive: true,
      scales: {
        x: {
          stacked: true,
        },
        y: {
          stacked: true
        }
      }
    }
  }
  else if(type === 'vertical'){
    option = {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Chart.js Bar Chart'
        }
      }
    }
  }
  const myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          datasets: [{
              label: 'col1',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.6)',
                  'rgba(54, 162, 235, 0.6)',
                  'rgba(255, 206, 86, 0.6)',
                  'rgba(75, 192, 192, 0.6)',
                  'rgba(153, 102, 255, 0.6)',
                  'rgba(255, 159, 64, 0.6)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          },
          {
            label: 'col2',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
          }
        ]
      },
      options: option
  });
};
var bar_chart_draw =function(content, idx) {
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end
        
        // Create chart instance
        var chart = am4core.create("bar-chartdiv"+idx, am4charts.XYChart);
        
        // Add data
        // chart.data = [{
        //   "country": "USA",
        //   "visits": 2025
        // }, {
        //   "country": "China",
        //   "visits": 1882
        // }, {
        //   "country": "Japan",
        //   "visits": 1809
        // }, {
        //   "country": "Germany",
        //   "visits": 1322
        // }, {
        //   "country": "UK",
        //   "visits": 1122
        // }, {
        //   "country": "France",
        //   "visits": 1114
        // }, {
        //   "country": "India",
        //   "visits": 984
        // }, {
        //   "country": "Spain",
        //   "visits": 711
        // }, {
        //   "country": "Netherlands",
        //   "visits": 665
        // }, {
        //   "country": "Russia",
        //   "visits": 580
        // }, {
        //   "country": "South Korea",
        //   "visits": 443
        // }, {
        //   "country": "Canada",
        //   "visits": 441
        // }, {
        //   "country": "Brazil",
        //   "visits": 395
        // }];
        
        // Create axes
        chart.data = [];
        for(let i = 1; i < content.length; i++) {
        for (let j = 1; j < content[0].length; j++) {
            let name = content[i][0] + "(" + content[0][j] + ")";
            if(content[0][j] == undefined || content[0][j] == null || content[0][j] == "")
            name = content[i][0];

            let val = content[i][j];
            if(val == undefined || isNaN(val))
            val = 0;
            if (Array.isArray(content[i][j]) === true)
            val = 10;
            var dt = {
            "country": name,
            "visits": val
            };
            chart.data.push(dt);
        }
        }
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "country";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 30;
        
        categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
          if (target.dataItem && target.dataItem.index & 2 == 2) {
            return dy + 25;
          }
          return dy;
        });
        
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        
        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "visits";
        series.dataFields.categoryX = "country";
        series.name = "Visits";
        series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
        series.columns.template.fillOpacity = .8;
        
        var columnTemplate = series.columns.template;
        columnTemplate.strokeWidth = 2;
        columnTemplate.strokeOpacity = 1;
        var eles = document.querySelectorAll("[aria-labelledby$=-title]");
        for(var i=0;i<eles.length;i++){
            eles[i].style.visibility="hidden"
        }
    }); // end am4core.ready()
};

