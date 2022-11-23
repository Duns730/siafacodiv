function getListGraph(lists, graph_id){
    data = []
    labels = []
    total_amount = 0

    for(index in lists){
        if (lists[index].products[0].amout == null) {
            data.push(0)
            total_amount += 0
        }
        else{
            data.push(parseFloat(lists[index].products[0].amout))
            total_amount += parseFloat(lists[index].products[0].amout)
        }
    }

    for(index in lists){
        labels.push('Lista '+lists[index].list + ': ' + ((parseFloat(lists[index].products[0].amout) * 100) / total_amount).toFixed(2) + '%')
        
    }

    
    renderGraph({'labels': labels,'data': data}, graph_id)
}

function renderGraph(data, canvas_id) {
    Chart.defaults.global.defaultFontSize = 18
    var myChart = new Chart(document.getElementById(canvas_id), {
        type: 'pie',
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
                    'rgba(124, 252, 0, 0.2)',
                    'rgba(255, 0, 255, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(165, 42, 42, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                ],
                borderColor: [
                    'rgba(30, 144, 255, 1)',
                    'rgba(169, 169, 169, 1)',
                    'rgba(255, 215, 0, 1)',
                    'rgba(0, 128, 0, 1)',
                    'rgba(128, 0, 0, 1)',
                    'rgba(25, 25, 112, 1)',
                    'rgba(124, 252, 0, 1)',
                    'rgba(255, 0, 255, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(165, 42, 42, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            
        }
    });
}