$(document).ready(function() {

    var table = $('#handlers_perf_table').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        autoWidth: false,
        buttons: false,
        searching: false,
        info: false,
        order: [
            [0, 'asc']
        ],
        ajax: {
            url: "/get_handler_perf",
            error: function(xhr) {
                if (xhr.status == 401) {
                    window.location.replace("/login");
                } else {
                    toastr.error('An error occured, please try again later');
                }
            }
        },
        columns: [{
            data: 'name',
            name: 'name',
            searchable: true
        }, {
            data: null,
            name: null,
            searchable: true,
            class: 'text-center',
            render: function(data, type) {

                if (data.percentage < 15) {
                    return '<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
                } else if (data.percentage > 15 && data.percentage <= 50) {
                    return '<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
                } else if (data.percentage > 50) {
                    return '<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
                }


            }
        }, ],
        drawCallback: function(settings, json) {
            $('.tooltips').tooltip();
        },

    });

    

    $.ajax({
        type: 'GET',
        url: '/monthlyAnalytics',
        processData: false,
        contentType: false,
        beforeSend: function(){
            $('#msg').empty();
        },
        success: function(result) {
            console.log(result)
            let data = []
            let label = []
            if(result.length == 0){
                label = ['Jan']
                data = [1]
            }else{
                
                for(let i = 0; i < result.length; i++){
                    console.log(result[i])
                    label.push(result[i].months)
                    data.push(result[i].no_of_book)
                }
            }
            
            setTimeout(() => {
                displayChart(label,data)
            },200)
        }
    });

    

});

function gotoMenu(href){
    window.location.href = href
}

function displayChart(label,data){
    const ctx = document.getElementById('patientChart');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
        labels: label,
        datasets: [{
            label: '',
            data: data,
            borderWidth: 1,
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
              ]
        }]
        },
        // options: {
        // scales: {
        //     y: {
        //     beginAtZero: false
        //     }
        // }
        // }
    });
}