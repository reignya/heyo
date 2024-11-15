document.getElementById('verificationForm').onsubmit = function (e) {
    e.preventDefault();
    const verificationCode = document.getElementById('verification_code').value;

    fetch('verify_code.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ verification_code: verificationCode })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Email verified successfully!');
            // Optionally redirect to login or dashboard
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during verification. Please try again.');
    });
};
