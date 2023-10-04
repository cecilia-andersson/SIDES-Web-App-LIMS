document.addEventListener("DOMContentLoaded", function() {
    // Get the JSON data passed from PHP
    var data = histogramData;  
    // Extract the required data for the histogram plot
    var labels = [];
    var frequencies = [];
    data.forEach(function(item) {
        labels.push(item.drug_brand);
        frequencies.push(item.frequency);
    });
    console.log("sideEffectName:", sideEffectName); // Checking the value of sideEffectName for debugging purposes
    
    var headerText = "Drug frequencies of side effect: " + sideEffectName; // Set the header text dynamically using the sideEffectName variable
    document.getElementById('header').textContent = headerText;

    // Define the canvas context
    var ctx = document.getElementById('histogram').getContext('2d');

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // ~~ Creating a histogram chart using Chart.js ~~
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Frequency',
                data: frequencies,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1, // Set stepSize to 1 for integer values (Good 2 know: If frequency is like 1000, then chart.js will dynamically adapt to that fact and decrease/ the stepsize heavily :) )
                    ticks: {
                        callback: function(value) {
                            // Display the tick only if it's an integer 
                            if (value === parseInt(value, 10)) {
                                return value;
                            }
                        }
                    }
                }
            }
        }
    });
    
        
});
