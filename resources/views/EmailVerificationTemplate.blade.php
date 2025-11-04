<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Email Already Registered</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f5e8e1;
      font-family: Arial, sans-serif;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: #fdf8f6;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .header-image {
      width: 100%;
      height: auto;
      display: block;
    }
    .header {
      background-color: #965737;
      color: #fdf8f6;
      text-align: center;
      padding: 20px;
      font-size: 20px;
      font-weight: bold;
    }
    .content { 
      padding: 20px;
      color: #333333;
      font-size: 16px;
      line-height: 1.5;
    }
    .button {
      display: inline-block;
      background-color: #965737;
      color: #fdf8f6 !important;
      padding: 12px 20px;
      margin-top: 20px;
      border-radius: 5px;
      text-decoration: none;
      font-size: 16px;
      font-weight: bold;
    }
    .footer {
      background-color: #e7cfc0;
      color: #62341f;
      text-align: center;
      font-size: 12px;
      padding: 15px;
    }
    @media only screen and (max-width: 600px) {
      .content {
        font-size: 14px;
      }
      .header {
        font-size: 18px;
      }
    }
  </style>
</head>
<body>
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center" style="padding: 20px 0;">
        <div class="container">
          
          <!-- Banner Image -->
          <img src="https://gimgs2.nohat.cc/thumb/f/640/forgot-password-concept-illustration-free-vector--5b5b8f3ff3684af39ffa.jpg" 
               alt="irosin central school Banner" 
               class="header-image">

          <div class="header">
            irosincentralschool.com
          </div>
          
          <div class="content">
            <p>Hi there,</p>
            <p>We noticed that this Gmail address is already registered on <strong>irosincentral.com</strong>.</p>
            <p>If this is your account, please verify your email and create a new password to continue using our services.</p>
            <p style="text-align: center;">
              <a href="https://irosincentralschool.com/create-new-password/token/e2yr126dI1OAHVDP5GpXEw2FfUjfu0tcr642vtRIMd40v2LeZLnYve1S65Xm/email/{{ $token }}" class="button">Verify &amp; Create Password</a>
            </p>
            <p>If you didn’t make this request, you can safely ignore this email.</p>
          </div>
          
          <div class="footer">
            &copy; 2025 irosincentral.com. All rights reserved.
          </div>
        </div>
      </td>
    </tr>
  </table>
</body>
</html>
