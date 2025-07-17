<!DOCTYPE html>
<html>
<head>
    <title>Application Renewal Reminder</title>
</head>
<body>
    <h1>Your Application is About to Expire</h1>
    <p>Dear {{ $renewal->firm_name }},</p>
    <p>Your application for {{ $renewal->firm_name }} is set to expire on {{ $renewal->expired_date }}.</p>
    <p>Please renew your application to avoid any interruption.</p>
</body>
</html>
