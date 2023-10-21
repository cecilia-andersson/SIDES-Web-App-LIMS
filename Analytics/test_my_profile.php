<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
</head>
<body>
    <div class="container">
        <h1>My Profile</h1>
        <button id="showRecommendationsButton">Show Recommendations</button>
        <div id="recommendations" style="display: none;"></div>

        <script>
            var user_id = <?php echo $user_id; ?>; // Pass the user_id from PHP to JavaScript

            document.getElementById('showRecommendationsButton').addEventListener('click', function() {
                var recommendations = document.getElementById('recommendations');
                if (recommendations.style.display === 'none' || recommendations.style.display === '') {
                    fetch('http://localhost/Analytics/user_drug_recommendation.php?user_id=' + user_id) // Pass user_id as a query parameter
                        .then(response => response.text())
                        .then(data => {
                            recommendations.innerHTML = data;
                            recommendations.style.display = 'block';
                        })
                        .catch(error => console.error('Error loading user_drug_recommendation.php:', error));
                } else {
                    recommendations.style display = 'none';
                }
            });
        </script>
    </div>
</body>
</html>
