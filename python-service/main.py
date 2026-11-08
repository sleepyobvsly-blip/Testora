
from fastapi import FastAPI
from pydantic import BaseModel
from transformers import pipeline

app = FastAPI(
    title="Testora AI API",
    description="AI-powered sentiment analysis and feedback summarization",
    version="1.0.0"
)

# Load sentiment analysis model
print("Loading Testora sentiment model...")

sentiment_analyzer = pipeline(
    "text-classification",
    model="cardiffnlp/twitter-roberta-base-sentiment-latest"
)

print("Testora Sentiment model is ready!")

# Load summarization model
print("Loading Testora summarization model...")

summarizer = pipeline(
    "summarization",
    model="sshleifer/distilbart-cnn-12-6"
)

print("Testora Summarization model is ready!")


class FeedbackRequest(BaseModel):
    text: str


class SummaryRequest(BaseModel):
    feedback: list[str]


@app.get("/")
def home():
    return {
        "message": "Testora AI API is running!"
    }


# Individual sentiment analysis
@app.post("/analyze")
def analyze_feedback(request: FeedbackRequest):
    result = sentiment_analyzer(request.text)[0]

    return {
        "feedback": request.text,
        "sentiment": result["label"],
        "confidence": round(result["score"] * 100, 2)
    }


# Multiple feedback summarization
@app.post("/summarize")
def summarize_feedback(request: SummaryRequest):

    feedback_list = [
        text.strip()
        for text in request.feedback
        if text.strip()
    ]

    if not feedback_list:
        return {
            "summary": "No feedback was provided."
        }

    if len(feedback_list) == 1:
        return {
            "summary": "More feedback is needed to generate a useful overall summary."
        }

    combined_feedback = "\n".join(
        f"- {text}" for text in feedback_list
    )

    result = summarizer(
        combined_feedback,
        max_length=120,
        min_length=10,
        do_sample=False,
        truncation=True
    )[0]

    return {
        "total_feedback": len(feedback_list),
        "summary": result["summary_text"]
    }
