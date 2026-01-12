window.onload = function() {
    //ChartAllData
    if (typeof chartUserData === 'undefined' || typeof chartCriticData === 'undefined' || typeof chartLabels === 'undefined') {
    }
    else {
        const data = {
            labels: chartLabels,
            datasets:
                [{
                    label: 'Średnia Wartość Ocen Użytkowników',
                    backgroundColor: "#d48446",
                    borderColor: "#d48446",
                    data: chartUserData,
                    spanGaps: true,
                    pointBackgroundColor: "#c06014",
                    pointBorderColor: "#c06014"
                },
                    {
                        label: 'Średnia Wartość Ocen Recenzentów',
                        backgroundColor: "#96b4c8",
                        borderColor: "#96b4c8",
                        data: chartCriticData,
                        spanGaps: true,
                        pointBackgroundColor: "#799cb3",
                        pointBorderColor: "#799cb3"
                    }]
        };
        const config = {
            type: 'line',
            data: data,
            options: {
                scales: {
                    y : {
                        min : 0,
                        max : 10,
                        autoSkip : 0
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        };
        const chart = new Chart(document.getElementById('chart'), config);
    }

    //ChartAllDataCount
    if (typeof chart2Data === 'undefined' || typeof chartLabels === 'undefined') {
    }
    else {
        let data2 = {
            labels: chartLabels,
            datasets: [{
                label: 'Ilość Ocen',
                backgroundColor: "#d5d9c7",
                data: chart2Data
            }]
        };
        let config2 = {
            type: 'bar',
            data: data2,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        };
        const chart2 = new Chart(document.getElementById('chart2'), config2);
    }

    if (typeof chart3Data === 'undefined' || typeof chart3Labels === 'undefined') {
    }
    else {
        const data3 = {
            labels: chart3Labels,
            datasets: [{
                label: 'Średnia Wartość Ocen',
                backgroundColor: "#d48446",
                borderColor: "#d48446",
                data: chart3Data,
                spanGaps: true,
                pointBackgroundColor: "#c06014",
                pointBorderColor: "#c06014"
            }]
        };
        const config3 = {
            type: 'line',
            data: data3,
            options: {
                scales: {
                    y : {
                        min : 0,
                        max : 10,
                        autoSkip : 0
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        };
        const chart3 = new Chart(document.getElementById('chart3'), config3);
    }

};
