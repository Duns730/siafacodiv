function getProformasGraph(argumemt, id){ 
    var data = {}
    url_graph = api_url + 'negotiations/'+ argumemt +'graph/' + id    
    axios
        .get(url_graph)
        .then(response => {
          if (response.data.status == 201) {
            renderGraph(response.data, argumemt + 'Graph')
          }
        }).catch(error => {
            if (error.response.status == 500) {
              this.getProformasGraph
            }
          });
}

function renderGraph(data, canvas_id) {
    var myChart = new Chart(document.getElementById(canvas_id), {
        type: 'doughnut',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Monto',
                data: data.data,
                backgroundColor: [
                    'rgba(30, 144, 255, 0.2)',
                    'rgba(169, 169, 169, 0.2)',
                    'rgba(255, 215, 0, 0.2)',
                    'rgba(0, 128, 0, 0.2)',
                    'rgba(128, 0, 0, 0.2)',
                    'rgba(25, 25, 112, 0.2)',
                    'rgba(165, 42, 42, 0.2)',
                    'rgba(124, 252, 0, 0.2)',
                    'rgba(255, 0, 255, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                ],
                borderColor: [
                    'rgba(30, 144, 255, 1)',
                    'rgba(169, 169, 169, 1)',
                    'rgba(255, 215, 0, 1)',
                    'rgba(0, 128, 0, 1)',
                    'rgba(128, 0, 0, 1)',
                    'rgba(25, 25, 112, 1)',
                    'rgba(165, 42, 42, 1)',
                    'rgba(124, 252, 0, 1)',
                    'rgba(255, 0, 255, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            
        }
    });
}
