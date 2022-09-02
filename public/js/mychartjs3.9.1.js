var chart_draw_by_type =function(type,content, idx) {
  const ctx = document.getElementById("pie-chartdivcnv"+idx).getContext('2d');
  var orientation= $( "#bar_chart_orientation option:selected").text();
  var stacked= document.getElementById("bar_stacked").checked;
  var color = $("#bar_chart_color").val();
  var options = {
    responsive: true,
    plugins: {
      legend: {
        position: 'right',
      },
      title: {
        display: true,
        text: 'Chart.js Horizontal Bar Chart'
      }
    },
    scales: {
      x: {
        stacked: stacked,
      },
      y: {
        stacked: stacked
      }
    }
  };
  if(orientation == "Horizontal"){
    options['indexAxis'] = 'y';
  }
  var chart_data = [];
  var labels = [];
  for(let i = 1; i < content.length; i++) {
    for (let j = 1; j < content[0].length; j++) {
      let name = content[i][0] + "(" + content[0][j] + ")";
      if(content[0][j] == undefined || content[0][j] == null || content[0][j] == "")
        name = content[i][0];

      let val = content[i][j];
      if(val == undefined || isNaN(val) || !isFinite(val))
        val = 0;
      if (Array.isArray(content[i][j]) === true)
        val = 10;
      var dt = {
        "country": name,
        "visits": val
      };
      chart_data.push(val+5);
      labels.push(name);
    }
  }
  const myChart = new Chart(ctx, {
      type: type,
      data: {
          labels: labels,
          datasets: [{
            label: 'Result',
            data: chart_data,
            backgroundColor: color,
            // borderColor: [
            //     'rgba(255, 99, 132, 1)',
            //     'rgba(54, 162, 235, 1)',
            //     'rgba(255, 206, 86, 1)',
            //     'rgba(75, 192, 192, 1)',
            //     'rgba(153, 102, 255, 1)',
            //     'rgba(255, 159, 64, 1)'
            // ],
            borderWidth: 1
          }]
      },
      options: options
  });

  return myChart;
  // myChart.update();
};

