<?php
// Include the database connection
include('../DBconnection/dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Comment Section</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: whitesmoke;
            overflow: hidden;
        }
        #comment-form {
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

        <div id="comment-form">
            <p>Welcome to the comment area! You are encouraged to express your thoughts, ask questions, and bring up any pertinent topics. </p><br>
            <input id="user-name" type="text" placeholder="Your Name" /><br>
            <div class="line-separator"></div> <!-- Div for line separation --><br>
            <textarea id="comment-text" placeholder="Write your comment..."></textarea><br/>
            
            <button id="post-button"><i class="bi bi-postcard-fill"></i> Post Comment</button>
        </div>

    <script>
    // Load existing comments on page load
    document.addEventListener('DOMContentLoaded', function () {
        fetch('../admin/get_comments.php')
            .then(response => {
                console.log('Response Status:', response.status); // Debug: Log response status
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Response Data:', data); // Debug: Log the received data

                if (data.success && Array.isArray(data.comments)) {
                    data.comments.forEach(comment => {
                        addCommentToUI(comment.username || 'Anonymous', comment.comment);
                    });
                } else {
                    alert('Failed to load comments: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error loading comments:', error);
                alert('An error occurred while loading comments.');
            });
    });

    // Post a new comment
    document.getElementById('post-button').addEventListener('click', function () {
        const userName = document.getElementById('user-name').value.trim() || 'Anonymous'; // Default to 'Anonymous'
        const commentText = document.getElementById('comment-text').value.trim();

        if (commentText === '') {
            alert('Please enter a comment before posting.');
            return;
        }

        const formData = new FormData();
        formData.append('username', userName);
        formData.append('comment', commentText);

        fetch('post_comment.php', {
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
                    alert('Your comment has been sent!'); // Show success message
                    document.getElementById('user-name').value = '';
                    document.getElementById('comment-text').value = '';
                } else {
                    alert('Failed to submit comment: ' + data.message);
                }
            } catch (error) {
                console.error('Invalid JSON:', text);
                alert('Received invalid JSON response.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting the comment.');
        });
    });

    // Helper function to add a new comment to the UI (if needed)
    function addCommentToUI(userName, commentText) {
        // This function can be used in admin_comments.php
    }
    </script>
</body>
</html>
