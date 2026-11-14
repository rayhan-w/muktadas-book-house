<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পাসওয়ার্ড রিসেট করুন</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; margin: 0; padding: 30px 15px; color: #1e293b;">
    <div style="max-width: 560px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #042f2e 0%, #0f172b 100%); padding: 32px 24px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 800; letter-spacing: 0.5px;">
                মুক্তাদার বইঘর
            </h1>
            <p style="color: #5eead4; margin: 6px 0 0; font-size: 13.5px; font-weight: 600;">
                পাসওয়ার্ড রিসেট ভেরিফিকেশন
            </p>
        </div>

        <!-- Body -->
        <div style="padding: 32px 28px;">
            <p style="font-size: 16px; margin-top: 0; color: #0f172a; font-weight: 700;">
                আসসালামু আলাইকুম, {{ $user->name }}!
            </p>
            <p style="font-size: 14.5px; line-height: 1.7; color: #475569;">
                আপনার মুক্তাদার বইঘর অ্যাকাউন্টের পাসওয়ার্ড রিসেট করার জন্য একটি অনুরোধ এসেছে। আপনি যদি এই অনুরোধ করে থাকেন, তবে নিচের বাটনে ক্লিক করে নতুন পাসওয়ার্ড সেট করুন:
            </p>

            <div style="text-align: center; margin: 32px 0;">
                <a href="{{ $resetUrl }}" style="display: inline-block; background: #0f766e; color: #ffffff; padding: 14px 32px; border-radius: 999px; font-size: 15px; font-weight: 800; text-decoration: none; box-shadow: 0 4px 14px rgba(15, 118, 110, 0.35);">
                    🔐 পাসওয়ার্ড রিসেট করুন
                </a>
            </div>

            <p style="font-size: 13.5px; color: #64748b; line-height: 1.6; background: #f8fafc; border-radius: 10px; padding: 14px; border: 1px solid #e2e8f0;">
                ⚠️ <strong>সতর্কতা:</strong> এই রিসেট লিংকটি আগামী <strong>৬০ মিনিট</strong> পর্যন্ত সক্রিয় থাকবে। আপনি যদি এই অনুরোধ না করে থাকেন, তবে কোনো অ্যাকশনের প্রয়োজন নেই—আপনার অ্যাকাউন্ট সম্পূর্ণ নিরাপদ রয়েছে।
            </p>

            <p style="font-size: 12.5px; color: #94a3b8; word-break: break-all; margin-top: 24px; line-height: 1.5;">
                বাটন কাজ না করলে নিচের লিংকটি কপি করে আপনার ব্রাউজারে পেস্ট করুন:<br>
                <a href="{{ $resetUrl }}" style="color: #0f766e;">{{ $resetUrl }}</a>
            </p>
        </div>

        <!-- Footer -->
        <div style="background: #f8fafc; padding: 18px 24px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12.5px; color: #94a3b8;">
            © {{ date('Y') }} মুক্তাদার বইঘর (Muktada's Book House)। সর্বস্বত্ব সংরক্ষিত।
        </div>
    </div>
</body>
</html>
