console.log(typeof Plotly); // Should output "function"

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

    // Create a Plotly histogram
    var trace = {
        x: labels,
        y: frequencies,
        type: 'bar'
    };

    var layout = {
        title: 'Drug Frequencies for ' + sideEffectName,
        xaxis: {
            title: 'Drug Brand'
        },
        yaxis: {
            title: 'Frequency'
        }
    };

    Plotly.newPlot('histogram', [trace], layout);
});
