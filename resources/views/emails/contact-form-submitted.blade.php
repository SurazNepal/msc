<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inbound Lead Notification</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #334155; max-width: 600px; margin: 0 auto; padding: 24px; background-color: #f8fafc;">

    <div style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px; shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">

        <h2 style="margin-top: 0; margin-bottom: 8px; font-size: 20px; font-weight: 700; color: #0f172a; border-bottom: 2px solid #ea580c; padding-bottom: 12px;">
            📬 New Website Inquiry
        </h2>
        <p style="font-size: 14px; color: #64748b; margin-top: 0; margin-bottom: 24px;">
            A new message has been submitted via your website's contact section. Details are outlined below:
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 24px;">
            <tr>
                <td style="padding: 10px 0; font-size: 14px; font-weight: 600; color: #475569; width: 140px; border-bottom: 1px solid #f1f5f9;">Full Name:</td>
                <td style="padding: 10px 0; font-size: 14px; color: #0f172a; border-bottom: 1px solid #f1f5f9;">{{ $formData['name'] }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; font-size: 14px; font-weight: 600; color: #475569; border-bottom: 1px solid #f1f5f9;">Email Address:</td>
                <td style="padding: 10px 0; font-size: 14px; color: #0f172a; border-bottom: 1px solid #f1f5f9;">
                    <a href="mailto:{{ $formData['email'] }}" style="color: #ea580c; text-decoration: none; font-weight: 500;">{{ $formData['email'] }}</a>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; font-size: 14px; font-weight: 600; color: #475569; border-bottom: 1px solid #f1f5f9;">Phone Number:</td>
                <td style="padding: 10px 0; font-size: 14px; color: #0f172a; border-bottom: 1px solid #f1f5f9;">
                    {{ $formData['phone'] ?: 'Not Provided' }}
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; font-size: 14px; font-weight: 600; color: #475569; border-bottom: 1px solid #f1f5f9;">Subject:</td>
                <td style="padding: 10px 0; font-size: 14px; font-weight: 500; color: #0f172a; border-bottom: 1px solid #f1f5f9;">{{ $formData['subject'] }}</td>
            </tr>
        </table>

        <div style="background-color: #f8fafc; border-left: 4px solid #ea580c; border-radius: 4px 12px 12px 4px; padding: 20px; margin-top: 16px;">
            <h4 style="margin-top: 0; margin-bottom: 8px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                Message Content:
            </h4>
            <p style="margin: 0; font-size: 14px; color: #1e293b; white-space: pre-wrap; line-height: 1.5;">{{ $formData['message'] }}</p>
        </div>

    </div>

    <div style="text-align: center; margin-top: 20px; font-size: 11px; color: #94a3b8;">
        This automated notification was generated directly from your server workstation deployment.
    </div>

</body>
</html>
