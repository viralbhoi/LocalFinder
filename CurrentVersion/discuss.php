<!DOCTYPE html>
<html>

<head>
    <title>Discussion Forum</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .chat-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            word-wrap: break-word;
            max-width: 70%;
        }

        .message.received {
            background-color: #f0f0f0;
            text-align: left;
            align-self: flex-start;
        }

        .message.sent {
            background-color: #e2f0cb;
            text-align: right;
            align-self: flex-end;
        }

        .chat-input {
            display: flex;
            margin-top: 20px;
        }

        .chat-input input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .chat-input button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }

        .chat-input button:hover {
            background-color: #0056b3;
        }

        .chat-area {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>

<body>
    <header>
        <div id="logo_1"></div>
        <div>
            <nav>
                <div><a href="index.php"><i class="fas fa-home"></i> Home</a></div>
                <!-- Add other navigation links -->
            </nav>
        </div>
    </header>
    <section class="discuss">
        <h2>Discussion Forum</h2>
        <div class="chat-container">
            <div class="chat-area">
                <div class="message received">
                    <strong>User A:</strong> Hello!
                </div>
                <div class="message sent">
                    <strong>You:</strong> Hi there!
                </div>
            </div>
            <div class="chat-input">
                <input type="text" placeholder="Type your message...">
                <button onclick="return adding()"><i class="fas fa-paper-plane"></i> Send</button>
            </div>
        </div>
    </section>
    <footer>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <div class="copyright">
            &copy; 2025 LocalFinder. All rights reserved.
        </div>
    </footer>
    <script>
        function adding() {
            var input = document.querySelector('.chat-input input');
            var message = input.value;
            if (message) {
                var chatContainer = document.querySelector('.chat-container .chat-area');
                var messageElement = document.createElement('div');
                messageElement.classList.add('message');
                messageElement.classList.add('sent');
                messageElement.innerHTML = `<strong>You:</strong> ${message}`;
                chatContainer.appendChild(messageElement);
                input.value = '';
                chatContainer.scrollTop = chatContainer.scrollHeight; // Scroll to bottom
            }
            return false;
        }
        // Scroll to the bottom of the chat area on load
        window.onload = function() {
            var chatArea = document.querySelector('.chat-container .chat-area');
            chatArea.scrollTop = chatArea.scrollHeight;
        };
    </script>
</body>

</html>
