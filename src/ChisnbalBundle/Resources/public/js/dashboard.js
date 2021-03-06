var ctx = document.getElementById("myChart");
var day6order = $("div#day6order").text();
var day5order = $("div#day5order").text();
var day4order = $("div#day4order").text();
var day3order = $("div#day3order").text();
var day2order = $("div#day2order").text();
var day1order = $("div#day1order").text();

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Día-6", "Día-5", "Día-4", "Anteayer", "Ayer", "Hoy"],
        datasets: [{
            label: 'CANTIDAD DE PEDIDOS(ÚLTIMA SEMANA)',
            data: [day6order, day5order, day4order, day3order, day2order, day1order],
            backgroundColor: [
                '#ff4a70',
                '#1f97e9',
                '#ffc73d',
                '#3fb3b3',
                '#884dff',
                '#ff9227'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    stepSize: 1,
                    beginAtZero:true
                }
            }]
        }
    }
});

var ctx1 = document.getElementById("myChart1");
var myChart1 = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ["Día-6", "Día-5", "Día-4", "Anteayer", "Ayer", "Hoy"],
        datasets: [{
            label: 'CANTIDAD DE USUARIO ACTIVOS(ÚLTIMA SEMANA)',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                '#ff4a70',
                '#1f97e9',
                '#ffc73d',
                '#3fb3b3',
                '#884dff',
                '#ff9227'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
