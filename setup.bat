@echo off
echo Creating Python virtual environment...
python -m venv venv

call venv\Scripts\activate.bat

echo Installing required packages...
pip install -r requirements.txt

echo Setup complete! Run 'start_chatbot.bat' to start the chatbot server.
