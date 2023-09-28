import sys
import json
import matplotlib.pyplot as plt

# Receive the JSON data as a command-line argument
data = sys.argv[1]

# Parse the JSON data
results = json.loads(data)

# Extract drug brands and frequencies
drug_brands = [result['drug_brand'] for result in results]
frequencies = [result['frequency'] for result in results]

# Create a histogram
plt.bar(drug_brands, frequencies)
plt.xlabel('Drug Brands')
plt.ylabel('Frequency')
plt.title('Histogram of Side Effect Frequency by Drug Brand')
plt.xticks(rotation=90)
plt.tight_layout()

# Save the plot as an image (e.g., PNG)
plt.savefig('histogram.png')

# Optionally, display the plot (uncomment the following line)
# plt.show()
