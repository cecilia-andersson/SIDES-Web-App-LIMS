// Import the apriori library
const Apriori = require('apriori-js');

// JavaScript code to mine association rules using Apriori
function mineRules() {
    // Get user input from the form
    const userInput = document.getElementById('userInput').value;

    // Split the user input into an array of items (e.g., drugs)
    const items = userInput.split(',');

    // Perform Apriori rule mining
    const apriori = new Apriori();
    const transactions = [items]; // Create a transaction from user input
    const { rules } = apriori.analyze(transactions, { support: 0.2, confidence: 0.6 });

    // Display the mined rules (you can customize this part)
    const ruleList = document.getElementById('ruleList');
    ruleList.innerHTML = '';
    rules.forEach((rule) => {
        const listItem = document.createElement('li');
        listItem.textContent = `${rule.antecedent.join(', ')} => ${rule.consequent.join(', ')} (Support: ${rule.support}, Confidence: ${rule.confidence})`;
        ruleList.appendChild(listItem);
    });
}

// Add an event listener to the form submission
const userInputForm = document.getElementById('userInputForm');
userInputForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the form from submitting and reloading the page
    mineRules(); // Call mineRules when the form is submitted
});
