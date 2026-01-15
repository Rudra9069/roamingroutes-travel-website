<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Roaming Routes</title>
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #f4f4f4; }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #1a2341;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .header {
            padding: 40px 20px;
            text-align: center;
            border-bottom: 2px solid #d1ad72;
        }
        .content {
            padding: 40px 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #ffffff;
            line-height: 1.6;
        }
        .content h1 {
            color: #d1ad72;
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .content h2 {
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .content p {
            font-size: 16px;
            color: #e0e0e0;
            margin-bottom: 25px;
        }
        .button-container {
            text-align: center;
            margin: 35px 0;
        }
        .verify-button {
            display: inline-block;
            background-color: #d1ad72;
            color: #1a2341 !important;
            text-decoration: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .footer {
            padding: 20px;
            background-color: #151b33;
            text-align: center;
            color: #a5a8b1;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table class="email-container" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td class="header">
                            <h2 style="color: #d1ad72; margin: 0; font-family: 'Cinzel', serif; letter-spacing: 3px;">ROAMING ROUTES</h2>
                        </td>
                    </tr>
                    <tr>
                        <td class="content">
                            <h2>Hello, {{name}}</h2>
                            <h1>Welcome to the Adventure!</h1>
                            <p>
                                Thank you for joining Roaming Routes. Your gateway to exploring the world's most hidden gems and luxury escapes is now open. 🌍✨
                            </p>
                            <p>
                                Before you start planning your next journey, please verify your email address to secure your account.
                            </p>
                            <div class="button-container">
                                <a href="{{verify_link}}" class="verify-button">Verify Account</a>
                            </div>
                            <p style="margin-top: 40px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                                Best Regards,<br>
                                <b style="color: #d1ad72;">The Roaming Routes Team</b>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="footer">
                            <p>&copy; 2026 Roaming Routes Pvt Ltd. All rights reserved.</p>
                            <p>Luxury Travel & Curated Experiences</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
