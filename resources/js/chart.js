import Chart from 'chart.js/auto';

document.addEventListener("DOMContentLoaded", () => {

    const canvas = document.getElementById('graphicChart');

    if (!canvas) return;

    fetch('/admin/report/chart')
    .then(res => res.json())
    .then(data => {

        const transaksi = data.map(item => item.total_transactions);
        const income = data.map(item => Number(item.total_income));

        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: [
                    'Jan','Feb','Mar','Apr','Mei','Jun',
                    'Jul','Agu','Sep','Okt','Nov','Des'
                ],
                datasets: [
                    {
                        label: 'Transaksi',
                        data: transaksi,
                        borderWidth: 1
                    },
                    {
                        label: 'Pendapatan',
                        data: income,
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

    });

});