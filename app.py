from flask import Flask, request, jsonify
from flask_cors import CORS
import json
import random

app = Flask(__name__)
CORS(app)

# Simple responses for the chatbot
RESPONSES = {
    "hello": ["Hello! Welcome to GYM Management System. How can I help you today?"],
    "hi": ["Hi there! How can I assist you with your gym membership?"],
    "hours": ["Our gym is open from 5:00 AM to 11:00 PM every day."],
    "membership": ["We offer various membership plans. Would you like to know about monthly or yearly plans?"],
    "monthly": ["Our monthly membership is $49.99 per month with access to all facilities."],
    "yearly": ["Our yearly membership is $499 per year, which saves you 15% compared to monthly payments."],
    "trainers": ["We have certified trainers available. Would you like to know about personal training sessions?"],
    "classes": ["We offer various classes including yoga, Zumba, and HIIT. Would you like the schedule?"],
    "thanks": ["You're welcome! Is there anything else I can help you with?"],
    "bye": ["Goodbye! Have a great workout!", "See you at the gym! Stay fit!"]
}

def get_response(message):
    message = message.lower()
    
    # Check for keywords in the message
    for key in RESPONSES:
        if key in message:
            return random.choice(RESPONSES[key])
    
    # Default response if no keyword matches
    return "I'm here to help with gym-related questions. You can ask about memberships, timings, trainers, or classes."

@app.route('/chat', methods=['POST'])
def chat():
    data = request.json
    user_message = data.get('message', '').strip()
    
    if not user_message:
        return jsonify({'response': 'Please type a message.'})
    
    response = get_response(user_message)
    return jsonify({'response': response})

if __name__ == '__main__':
    app.run(debug=True, port=5000)
