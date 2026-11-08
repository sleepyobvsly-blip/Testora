
from transformers import pipeline

# Load the pretrained sentiment analysis model
MODEL_NAME = "cardiffnlp/twitter-roberta-base-sentiment-latest"

print("Loading Sentra's sentiment analysis model...")

sentiment_analyzer = pipeline(
    "text-classification",
    model=MODEL_NAME
)

print("Model loaded successfully!\n")

# Sample feedback for testing
feedback_samples = [
    "This product is amazing! I really love its features.",
    "The product is okay. Nothing special.",
    "I am disappointed. The product does not work properly."
]

# Analyze each feedback
for feedback in feedback_samples:
    result = sentiment_analyzer(feedback)[0]

    sentiment = result["label"]
    confidence = result["score"] * 100

    print("Feedback:", feedback)
    print("Sentiment:", sentiment)
    print(f"Confidence: {confidence:.2f}%")
    print("-" * 60)
