
function getOrderGraph(argumemt, id){ 
    var data = []
    url_graph = api_url + 'clients/'+ argumemt +'graph/' + id    
    axios
        .get(url_graph)
        .then(response => {
          this.data = response.data
          if (this.data.status == 201) {
                renderGraph(this.data, argumemt + 'Graph')
          }
        }).catch(error => {
            if (error.response.status == 500) {
              this.getOrderGraph
            }
          });
}

function renderGraph(data, canvas_id) {
    var ctx = document.getElementById(canvas_id);
    var myChart = new Chart(ctx, {
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
              text:"Comportamiento de pedidos facturados"
            },
            tooltips: {
              mode: 'label',
            },
            hover: {
              mode: 'label'
            },
        }
    });
}