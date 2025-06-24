<!-- Chat Button -->
<button id="chatButton" class="chat-button">
    <i class="material-icons">chat</i>
</button>

<!-- Chat Modal -->
<div id="chatModal" class="chat-modal">
    <div class="chat-modal-content">
        <div class="chat-header">
            <h3>GYM Assistant</h3>
            <span class="close-chat">&times;</span>
        </div>
        <div class="chat-messages" id="chatMessages">
            <div class="bot-message">
                <p>Hello! I'm your GYM Assistant. How can I help you today?</p>
            </div>
        </div>
        <div class="chat-input">
            <input type="text" id="userInput" placeholder="Type your message..." />
            <button id="sendButton">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>
</div>

<style>
/* Chat Button */
.chat-button {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background-color: #f36100;
    color: white;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.chat-button:hover {
    background-color: #e04e00;
    transform: scale(1.1);
}

/* Chat Modal */
.chat-modal {
    display: none;
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 350px;
    height: 500px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    z-index: 1001;
    flex-direction: column;
    overflow: hidden;
}

.chat-modal-content {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.chat-header {
    background-color: #f36100;
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header h3 {
    margin: 0;
    font-size: 16px;
}

.close-chat {
    font-size: 24px;
    cursor: pointer;
}

.chat-messages {
    flex-grow: 1;
    padding: 15px;
    overflow-y: auto;
    background-color: #f9f9f9;
}

.bot-message, .user-message {
    margin: 10px 0;
    max-width: 80%;
    padding: 10px 15px;
    border-radius: 15px;
    line-height: 1.4;
    position: relative;
}

.bot-message {
    background-color: #e9e9eb;
    color: #000;
    align-self: flex-start;
    border-bottom-left-radius: 5px;
}

.user-message {
    background-color: #0084ff;
    color: white;
    margin-left: auto;
    border-bottom-right-radius: 5px;
}

.chat-input {
    display: flex;
    padding: 15px;
    background-color: white;
    border-top: 1px solid #ddd;
}

.chat-input input {
    flex-grow: 1;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 20px;
    outline: none;
}

.chat-input button {
    background: none;
    border: none;
    color: #f36100;
    cursor: pointer;
    padding: 0 10px;
    font-size: 20px;
}

.chat-input button:hover {
    color: #e04e00;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatButton = document.getElementById('chatButton');
    const chatModal = document.getElementById('chatModal');
    const closeChat = document.querySelector('.close-chat');
    const sendButton = document.getElementById('sendButton');
    const userInput = document.getElementById('userInput');
    const chatMessages = document.getElementById('chatMessages');

    // Toggle chat modal
    chatButton.addEventListener('click', function() {
        chatModal.style.display = chatModal.style.display === 'flex' ? 'none' : 'flex';
    });

    closeChat.addEventListener('click', function() {
        chatModal.style.display = 'none';
    });

    // Send message function
    function sendMessage() {
        const message = userInput.value.trim();
        if (message === '') return;

        // Add user message to chat
        addMessage(message, 'user');
        userInput.value = '';

        // Send to chatbot
        fetch('http://localhost:5000/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            // Add bot response to chat
            addMessage(data.response, 'bot');
        })
        .catch(error => {
            console.error('Error:', error);
            addMessage('Sorry, I am having trouble connecting to the server.', 'bot');
        });
    }

    // Add message to chat
    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = sender + '-message';
        messageDiv.innerHTML = `<p>${text}</p>`;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Event listeners
    sendButton.addEventListener('click', sendMessage);
    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
});
</script>
