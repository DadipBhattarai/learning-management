<?php
// This part is for the backend (PHP)

header('Content-Type: application/json');

// Replace with your actual DeepSeek API key
$apiKey = 'your_deepseek_api_key_here';

// The API endpoint
$apiUrl = 'https://api.deepseek.com/v1/chat/completions';

// Read the incoming JSON request
$requestData = json_decode(file_get_contents('php://input'), true);

// Extract the user's message
$userMessage = isset($requestData['message']) ? strip_tags($requestData['message']) : ''; // Sanitizing input

// If no message is provided, return an error
if (empty($userMessage)) {
    echo json_encode(['reply' => 'Error: No message provided.']);
    exit;
}

// Prepare the request payload
$data = [
    'model' => 'deepseek-chat',
    'messages' => [['role' => 'user', 'content' => $userMessage]],
    'max_tokens' => 150,
    'temperature' => 0.7,
];

// Initialize cURL
$ch = curl_init($apiUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey,
]);

// Execute the request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo json_encode(['reply' => 'Error: ' . curl_error($ch)]);
    exit;
} else {
    $responseData = json_decode($response, true);

    // Extract the chatbot's reply
    $chatbotReply = $responseData['choices'][0]['message']['content'] ?? 'No response from chatbot.';
    echo json_encode(['reply' => $chatbotReply]);
}

// Close cURL
curl_close($ch);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #chat {
            width: 300px;
            margin: auto;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        #messages {
            height: 300px;
            overflow-y: auto;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        input,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }

        .user,
        .bot {
            padding: 5px;
            border-radius: 5px;
            margin: 5px 0;
        }

        .user {
            background-color: #f1f1f1;
            text-align: right;
        }

        .bot {
            background-color: #e1f5fe;
            text-align: left;
        }
    </style>
</head>

<body>

    <div id="chat">
        <div id="messages"></div>
        <input type="text" id="userInput" placeholder="Type your message..." onkeypress="handleKeyPress(event)">
        <button onclick="sendMessage()">Send</button>
    </div>

    <script>
        function sendMessage() {
            const userInput = document.getElementById('userInput').value.trim();
            if (!userInput) return;

            const messagesDiv = document.getElementById('messages');

            // Display user message
            messagesDiv.innerHTML += `<div class="user"><strong>You:</strong> ${userInput}</div>`;
            messagesDiv.scrollTop = messagesDiv.scrollHeight; // Auto-scroll to latest message

            // Send message to PHP backend
            fetch('chatbot.php', { // Ensure this is the same filename
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: userInput })
            })
                .then(response => response.json())
                .then(data => {
                    // Display chatbot response
                    messagesDiv.innerHTML += `<div class="bot"><strong>Chatbot:</strong> ${data.reply}</div>`;
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                })
                .catch(error => {
                    console.error('Error:', error);
                    messagesDiv.innerHTML += `<div class="bot"><strong>Chatbot:</strong> Something went wrong. Please try again later.</div>`;
                });

            // Clear input
            document.getElementById('userInput').value = '';
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }
    </script>

</body>

</html>