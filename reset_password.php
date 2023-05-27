<?php
 function generateToken($length = 32) {
    $token = bin2hex(random_bytes($length / 2)); // Generate random bytes and convert to hexadecimal

    return $token;
}
if (isset($_POST['submit'])) {
    // Retrieve the email address entered by the user
    $email = $_POST['email'];

   
    // Validate the email address (you can add more checks here)
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Generate a unique token or temporary password
        $token = generateToken(); // Implement your own token generation function

        // Store the token in your database for verification

        // Send the password reset email
        $subject = "Password Reset";
        $message = "Click the link below to reset your password:\n\n";
        $message .= "http://example.com/reset_password.php?token=" . urlencode($token);
        $headers = "From: YourName <noreply@example.com>";
        if (mail($email, $subject, $message, $headers)) {
            echo "An email with instructions to reset your password has been sent to your email address.";
        } else {
            echo "Failed to send the password reset email.";
        }
    } else {
        echo "Invalid email address.";
    }
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify the token (check if it exists in your database and hasn't expired)

    if ($tokenIsValid) {
        if (isset($_POST['submit'])) {
            // Retrieve the new password entered by the user
            $newPassword = $_POST['new_password'];

            // Update the user's password in your database (you may need to hash and salt it)

            echo "Password has been reset successfully.";
        } else {
            // Display the password reset form
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Reset Password</title>
            </head>
            <body>
                <h2>Reset Password</h2>
                <form method="post" action="">
                    <label>New Password:</label>
                    <input type="password" name="new_password" required>
                    <input type="submit" name="submit" value="Reset Password">
                </form>
            </body>
            </html>
            <?php
        }
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "Token not found.";
}
?>
