function sendVerificationEmail() {
    const email = document.getElementById('email').value;

    if (!email) {
        alert('Please enter an email.');
        return;
    }

    // Send a POST request to send_verification_code.php
    fetch('test_mail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            email: email
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Verification code sent to ' + email);
            document.getElementById('emailForm').style.display = 'none';
            document.getElementById('verificationCodeSection').style.display = 'block';
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error occurred during email verification:', error);
        alert('An error occurred. Please try again.');
    });
}
