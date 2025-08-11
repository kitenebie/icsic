 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>OTP Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background-color: #f7fafc; padding: 40px; font-family: Arial, sans-serif;">

    <div style="max-width: 500px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">

        <!-- Header image -->
        <img src="https://www.shutterstock.com/image-vector/secure-email-otp-authentication-verification-260nw-1532700359.jpg" 
             alt="OTP Verification" 
             style="width: 100%; display: block;">

        <!-- Body -->
        <div style="padding: 24px;">
            <h1 style="font-size: 24px; font-weight: bold; color: #2d3748; margin-bottom: 16px;">
                Your One-Time Password
            </h1>

            <p style="color: #4a5568; font-size: 16px; margin-bottom: 16px; line-height: 1.5;">
                Use the following One-Time Password (OTP) to complete your verification. 
                This code is valid for the next 5 minutes.
            </p>

            <!-- OTP Code -->
            <div style="background-color: #ebf8ff; color: #2b6cb0; font-size: 28px; font-weight: bold; letter-spacing: 0.3em; text-align: center; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                {{ $otp }}
            </div>

            <p style="color: #a0aec0; font-size: 14px; line-height: 1.5;">
                If you did not request this code, please ignore this email or contact our support team.
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f7fafc; padding: 16px; text-align: center; color: #a0aec0; font-size: 12px;">
            &copy; {{ date('Y') }} Your Company. All rights reserved.
        </div>
    </div>

</body>
</html>
