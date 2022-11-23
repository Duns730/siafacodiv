function ReportGraphMonth(argument, type_graph) {
	var data = []
	if (argument == 'statusProformed') {
    	url = api_url + 'reports/status/proformed/month'
	}
	else{
    	url = api_url + 'reports/'+ argument +'/month/days'
	}
	axios
        .get(url)
        .then(response => {
          data = response.data
          if (data.status == 201) {
            for(item in data){
              console.log(item)
            }
          	if (type_graph == 'line') {
				      renderGraphLine(data, argument + 'ReportGraphMonth')
          	}
          	else{
          		renderGraphBar(data, argument + 'ReportGraphMonth')
          	}
          	
          }
        }).catch(error => {
            if (error.response.status == 500) {
              this.ReportGraphMonth
            }
          });
}

function renderGraphLine(data, canvas_id) {
    var myChart = new Chart(document.getElementById(canvas_id), {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Monto',
                data: data.data,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                ],
                borderWidth: 1,
                pointBorderColor:"rgba(38, 185, 154, 0.7)",
				pointBackgroundColor:"rgba(38, 185, 154, 0.7)",
				pointHoverBackgroundColor:"#fff",
				pointHoverBorderColor:"rgba(220,220,220,1)",
				pointBorderWidth:1,
            }]
        },
        options: {
            title:{
              display:true,
              text:data.title
            },
        }
    });
}

function renderGraphBar(data, canvas_id) {
    var myChart = new Chart(document.getElementById(canvas_id), {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Monto',
                data: data.data,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                ],
                borderWidth: 1,
                pointBorderColor:"rgba(38, 185, 154, 0.7)",
				pointBackgroundColor:"rgba(38, 185, 154, 0.7)",
				pointHoverBackgroundColor:"#fff",
				pointHoverBorderColor:"rgba(220,220,220,1)",
				pointBorderWidth:1,
            }]
        },
        options: {
            title:{
              display:true,
              text:data.title
            },
        }
    });
}