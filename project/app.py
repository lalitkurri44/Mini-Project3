from flask import Flask, render_template
import speech_recognition as sr
import webbrowser
import datetime

app = Flask(__name__)

def sptext():
    recognizer = sr.Recognizer()
    with sr.Microphone() as source:
        print("Listening...")
        recognizer.adjust_for_ambient_noise(source)
        audio = recognizer.listen(source)
        try:
            print("Recognizing...")
            data = recognizer.recognize_google(audio)
            print(data)
            return data
        except sr.UnknownValueError:
            return "Not Understand"

@app.route("/")
def home():
    return render_template("index.html")

@app.route("/start-assistant", methods=["POST"])
def start_assistant():
    # Mic se speech capture
    data1 = sptext().lower()

    if "your name" in data1:
        return "My name is Peter."

    elif "old are you" in data1:
        return "I am two years old."

    elif "time" in data1:
        return datetime.datetime.now().strftime("Current time is %I:%M %p")

    elif "google" in data1:
        webbrowser.open("https://www.google.co.in/")
        return "Opening Google."

    elif "Where is soham mobile" in data1:
        return "In my pocket."  # Tumhara custom response
    
    elif "soham mobile" in data1:
        return "In my pocket."  # Tumhara custom response
    elif " mobile" in data1:
        return "In my pocket."  # Tumhara custom response

    elif "exit" in data1:
        return "Assistant stopped. Thank you!"

    else:
        return "I didn't understand. Please try again."

if __name__ == "__main__":
    app.run(debug=True)
