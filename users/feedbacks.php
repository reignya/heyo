<?php
// Include the database connection
include('../DBconnection/dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Feedback Section</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: whitesmoke;
            overflow: hidden;
        }
        #feedback-form {
            margin-bottom: 20px;
        }
        textarea, input {
            width: 100%;
            margin-bottom: 10px;
            border: none;
            background: none;
            font-size: 16px;
            resize: none;
        }
        textarea {
            height: 80px;
        }
        #post-button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: solid white;
            cursor: pointer;
            border-radius: 9px;
            margin-left: 10px;
            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
        }
        #post-button:hover {
            background-color: darkblue;
            border: solid blue;
            box-shadow: rgb(204, 219, 232) 3px 3px 6px 0px inset, rgba(255, 255, 255, 0.5) -3px -3px 6px 1px inset;
        }
        textarea:focus, input:focus {
            outline: none;
            border-bottom: 2px solid #007bff;
        }
        .line-separator {
            border-bottom: 1px solid #ccc;
            margin: -10px 0;
        }
       
    </style>
</head>
<body>

    <div id="feedback-form">
    <p>Welcome to the feedback area! This section is designed to capture detailed suggestions or concerns about the system that need attention or improvement.</p><br>
        <input id="user-name" type="text" placeholder="Your Name (optional)" /><br/>
        <div class="line-separator"></div> <!-- Div for line separation --><br>
        <textarea id="feedback-text" placeholder="Write your feedback..."></textarea><br/>
        <button id="post-button"><i class="bi bi-postcard-heart-fill"></i> Submit Feedback</button>
    </div>

    <script>
        // Post a new feedback
        document.getElementById('post-button').addEventListener('click', function () {
            const userName = document.getElementById('user-name').value.trim() || 'Anonymous'; // Default to 'Anonymous'
            const feedbackText = document.getElementById('feedback-text').value.trim();

            if (feedbackText === '') {
                alert('Please enter feedback before submitting.');
                return;
            }

            const formData = new FormData();
            formData.append('username', userName);
            formData.append('feedback', feedbackText);

            fetch('post_feedback.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();  // Use text() to inspect raw response
            })
            .then(text => {
                try {
                    const data = JSON.parse(text);  // Attempt to parse JSON
                    if (data.success) {
                        document.getElementById('user-name').value = '';
                        document.getElementById('feedback-text').value = '';
                        alert('Feedback submitted successfully!'); // Notify success
                    } else {
                        alert('Failed to submit feedback: ' + data.message);
                    }
                } catch (error) {
                    console.error('Invalid JSON:', text);
                    alert('Received invalid JSON response.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while submitting the feedback.');
            });
        });
    </script>

</body>
</html>
