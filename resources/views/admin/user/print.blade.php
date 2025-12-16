<!--<!DOCTYPE html>-->
<!--<html>-->

<!--<head>-->
<!--    <title>User QR Code</title>-->
<!--    <style>-->
<!--        body {-->
<!--            text-align: center;-->
<!--            font-family: sans-serif;-->
<!--        }-->

<!--        .qr-img {-->
<!--            margin-top: 250px;-->
<!--            width: 200px;-->
<!--        }-->

<!--        .user-name {-->
<!--            font-size: 22px;-->
<!--            margin-top: 30px;-->
<!--             font-weight: 700; -->
<!--        }-->
<!--          .comp-name {-->
<!--            font-size: 20px;-->
<!--            margin-top: 5px;-->
<!--             font-weight: 700; -->
<!--        }-->
<!--    </style>-->
<!--</head>-->

<!--<body>-->

<!--    <img src="{{ $qr_image }}" class="qr-img">-->
<!--    <div class="user-name">{{ $name }}</div>-->
<!--    <div class="comp-name">{{ $comp_name }}</div>-->

<!--</body>-->

<!--</html>-->



<!DOCTYPE html>
<html>
<head>
    <title>User QR Code</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 35%;
            min-height:1px;
            
            /*padding-left: 50px;*/ /* Adjust left padding for better print layout */
            padding-top: 24%; /* Adjust top padding if needed */
            border:3px solid none;
           text-align:center;
        }
        .qr-img {
             /* If you want 3.7 inch → Let me know, I’ll convert to accurate px */
            width: 100px;
        }

        .user-name {
            font-size: 20px;
            font-weight: 700;
            margin-top: 12px;
            text-align:center;
        }

        .comp-name {
            font-size: 16px;
            font-weight: 700;
            margin-top: 5px;
              text-align:center;
        }
    </style>
</head>

<body>
  <div class="container">
    <img src="{{ $qr_image }}" class="qr-img">
    <div class="user-name">{{ $name }}</div>
    <div class="comp-name">{{ $comp_name }}</div>
        <div class="reg-date" style="font-size: 14px; margin-top: 5px; font-weight:600;">
        Registered: {{ $registration_date }}
    </div>
    </div>

</body>
</html>






