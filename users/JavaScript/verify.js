// Function to handle the resend button via AJAX
function resendCode(event) {
    event.preventDefault(); // Prevent page reload

    fetch('verify.php?resend=true')
        .then(response => response.json())
        .then(data => {
            alert(data.message); // Show a message to the user
        })
        .catch(error => console.error('Error:', error));
}

// Attach the click event to the Resend button
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('resendButton').addEventListener('click', resendCode);
});
