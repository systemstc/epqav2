<!-- resources/views/emails/certificate.blade.php -->

<!-- <!DOCTYPE html>
<html>
<head>
    <title>Your Certificate</title>
</head>
<body>
    <p>Dear name ,</p>
    <p>Congratulations! Please find attached your certificate of completion for the course course.</p>
    <p>Best regards,</p>
    <p>Your Company</p>
</body>
</html> -->

@component('mail::message')
Dear Name 
Congratulations! Please find attached your certificate of completion for the course.

Best regards,

Your Company

@endcomponent