<!-- resources/views/pdf/certificate.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .certificate {
            text-align: center;
            margin: 50px;
        }
        .certificate h1 {
            font-size: 50px;
            margin-bottom: 0;
        }
        .certificate p {
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>Certificate of Completion</h1>
        <p>This is to certify that</p>
        <h2>{{$name}}</h2>
        <p>has successfully completed the course</p>
        <h3>{{$course}}</h3>
        <p>with Registration no : <h3>{{$registartion_no}}</h3></p>
        <p>on {{$date}}</p>
    	<p>certificate will expire on {{ $expiry_date }}</p>
    </div>
</body>
</html>
