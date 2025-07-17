<!DOCTYPE html>
<html>
<head>
    <title>Application Expiration Notice</title>
</head>
<body>
    <h1>Your Application has Expired</h1>
    <p>Dear {{ $renewal->firm_name }},</p>
    <p>Your application for {{ $renewal->firm_name }} has expired on {{ $renewal->expired_date }}.</p>
    <p>Please renew your application as soon as possible.</p>
</body>
</html>
