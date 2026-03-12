import Chart from 'chart.js/auto';

document.addEventListener("DOMContentLoaded", () => {

    const canvas = document.getElementById('graphicChart');

    if (!canvas) return;

    fetch('/admin/report/chart')
        .then(res => res.json())
        .then(data => {

            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: [
                        'Jan','Feb','Mar','Apr','Mei','Jun',
                        'Jul','Agu','Sep','Okt','Nov','Des'
                    ],
                    datasets: [{
                        label: 'Payments',
                        data: data,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    },
                    plugins:{
                        legend: {
                            position: 'top',
                            align: 'start',
                        }
                    }
                }
            });

        });

});