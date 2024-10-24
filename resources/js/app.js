import './bootstrap';
import toastr from 'toastr';
import 'toastr/build/toastr.css';

window.toastr = toastr;
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
document.addEventListener('DOMContentLoaded', function() {
    const testsGraph = {
        labels: ["6eme", "5eme", "4eme ", "3eme", "2nd"], 
        datasets: [
            {
                label: 'Enseignants',
                data: [3, 5, 6, 8, 10], 
                borderColor: '#18aefa', 
                backgroundColor: '#18aefa',
                fill: false,
            },
            {
                label: 'Étudiants',
                data: [5, 6, 7, 8, 9],
                borderColor: '#3D5EE1', 
                backgroundColor: '#3D5EE1',
                fill: false,
            },
            {
                label: 'Cours',
                data: [2, 3, 4, 5, 10],
                borderColor: '#2A3042', 
                backgroundColor: '#2A3042',
                fill: false,
            }
        ]
    };

  
    const options = {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: "Comparaison du nombre d'enseignants, de cours et d'étudiants"
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    const ctx = document.getElementById('graph-viewer')?.getContext('2d');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: testsGraph,
            options: options
        });
    }
});
