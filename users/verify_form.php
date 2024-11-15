<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <h1>Email Verification</h1>
    
    <!-- Form to collect the user's email -->
    <form id="emailForm">
        <label for="email">Enter your email:</label>
        <input type="email" id="email" name="email" required>
        <button type="button" onclick="sendVerificationEmail()">Send Verification Code</button>
    </form>

    <div id="verificationCodeSection" style="display:none;">
        <h2>Enter the verification code sent to your email</h2>
        <form action="verify_code.php" method="post">
            <label for="verification_code">Verification Code:</label>
            <input type="text" id="verification_code" name="verification_code" required>
            <button type="submit">Verify</button>
        </form>
    </div>

    <!-- Link to the external JavaScript file -->
    <script src="JavaScript/verify_form.js"></script>
</body>
</html>
