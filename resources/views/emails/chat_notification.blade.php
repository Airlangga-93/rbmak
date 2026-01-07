<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pesan Baru - Tower Management</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #1a2a6c; /* Navy Tower Theme */
            background-image: linear-gradient(to right, #1a2a6c, #2a4858);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            opacity: 0.8;
            font-size: 14px;
        }
        .content {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.6;
        }
        .message-box {
            background-color: #f8f9fa;
            border-left: 4px solid #f1c40f; /* Gold accent */
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .info-label {
            font-weight: bold;
            color: #1a2a6c;
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
            text-transform: uppercase;
        }
        .footer {
            background-color: #f4f7f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            border-top: 1px solid #eeeeee;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #1a2a6c;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
        .tower-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="tower-icon">🏢</div>
            <h1>Tower Management</h1>
            <p>Admin Notification System</p>
        </div>

        <div class="content">
            <h2 style="color: #1a2a6c; margin-top: 0;">Halo Admin,</h2>
            <p>Anda menerima pesan baru melalui portal layanan pelanggan <strong>Tower Booking Management</strong>.</p>

            <div class="message-box">
                <span class="info-label">Pengirim</span>
                <p style="margin: 0 0 15px 0; font-size: 16px;"><strong>{{ $msg->sender->name }}</strong></p>

                <span class="info-label">Isi Pesan</span>
                <p style="margin: 0; color: #555;">
                    @if($msg->message)
                        "{{ $msg->message }}"
                    @else
                        <em>(User mengirimkan lampiran gambar)</em>
                    @endif
                </p>
            </div>

            <p>Segera berikan respon untuk menjaga kualitas layanan tower kita.</p>

            <div style="text-align: center;">
                <a href="{{ url('/admin/bookings/chat/' . $msg->sender_id) }}" class="button">Balas Pesan Sekarang</a>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Tower Booking Management System. All rights reserved.</p>
            <p>Pesan ini dikirim secara otomatis oleh sistem, mohon tidak membalas langsung ke email ini.</p>
        </div>
    </div>
</body>
</html>