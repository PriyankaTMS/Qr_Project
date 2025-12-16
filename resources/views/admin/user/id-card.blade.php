<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .id-card {
            width: 200px;
            height: 350px;
            background-color: white;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header img {
            width: 80px;
            height: auto;
        }

        .qr-section {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .qr-section img {
            width: 100px;
            height: 100px;
        }

        .name-section {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="id-card">

        <div class="header">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('stallmaillogo.png'))) }}"
                alt="Main Logo" class="navbar-brand-img">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('sublogo.png'))) }}"
                alt="Sub Logo" class="navbar-brand-img">
        </div>
        <div class="qr-section">
            @if ($user->qr_image)
                <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('users_qr_images/' . $user->qr_image))) }}"
                    alt="QR Code">
            @endif
        </div>
        <div class="name-section">{{ $user->name }}</div>
    </div>
</body>

</html>
</content>
