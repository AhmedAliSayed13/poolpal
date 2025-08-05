<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طلب خدمة جديد</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 20px; direction: rtl;">

    <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.05);">

        <div style="background-color: #007bff; padding: 20px; color: white; text-align: center;">
            <h2 style="margin: 0;">طلب خدمة جديد</h2>
        </div>

        <div style="padding: 30px;">
            <p><strong>الاسم:</strong> {{ $data['user_name'] }}</p>
            <p><strong>الإيميل:</strong> {{ $data['user_email'] }}</p>
            <p><strong>رقم الهاتف:</strong> {{ $data['phone'] }}</p>
            <p><strong>العنوان:</strong> {{ $data['address'] }}</p>
            <p><strong>الخدمة المطلوبة:</strong> {{ $data['service'] }}</p>
        </div>

        <div style="background-color: #f1f1f1; padding: 15px; text-align: center; color: #666;">
            <small>© {{ date('Y') }} موقعك. جميع الحقوق محفوظة.</small>
        </div>

    </div>

</body>
</html>
