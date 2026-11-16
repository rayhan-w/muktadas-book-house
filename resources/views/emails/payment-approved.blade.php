<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পেমেন্ট ও অর্ডার অনুমোদন</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; margin: 0; padding: 30px 15px; color: #1e293b; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #059669 0%, #0f766e 100%); padding: 32px 24px; text-align: center;">
            <div style="width: 52px; height: 52px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 26px; color: #fff; margin-bottom: 12px;">
                ✓
            </div>
            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 800; letter-spacing: 0.5px;">
                পেমেন্ট অনুমোদিত হয়েছে!
            </h1>
            <p style="color: #d1fae5; margin: 6px 0 0; font-size: 14px; font-weight: 600;">
                অর্ডার নম্বর: #{{ $order->order_number }}
            </p>
        </div>

        <!-- Body -->
        <div style="padding: 32px 28px;">
            <p style="font-size: 16px; margin-top: 0; color: #0f172a; font-weight: 700;">
                প্রিয় {{ $order->customer_name }},
            </p>
            <p style="font-size: 14.5px; color: #475569;">
                সুসংবাদ! আপনার প্রদানকৃত পেমেন্ট তথ্য সফলভাবে ভেরিফাই ও অনুমোদন করা হয়েছে। আপনার অর্ডারটি এখন সম্পূর্ণ কনফার্মড।
            </p>

            @if($hasEbook)
                <!-- E-book Immediate Access Alert -->
                <div style="background: #f0fdfa; border: 2px solid #0d9488; border-radius: 12px; padding: 20px; margin: 22px 0; text-align: center;">
                    <div style="font-size: 28px; margin-bottom: 6px;">📚</div>
                    <strong style="color: #0f766e; font-size: 16px; display: block; margin-bottom: 6px;">
                        আপনার কেনা ই-বুক পাঠাগারে যুক্ত হয়েছে!
                    </strong>
                    <p style="color: #334155; font-size: 13.5px; margin: 0 0 16px;">
                        আপনি এখনই আপনার ফোনে বা কম্পিউটারে বসে সরাসরি আমাদের ডিজিটাল রিডারে বইটি পড়া শুরু করতে পারেন।
                    </p>
                    <a href="{{ route('reader.library') }}" style="display: inline-block; background: #0f766e; color: #ffffff; padding: 12px 28px; border-radius: 8px; font-size: 14.5px; font-weight: 700; text-decoration: none; box-shadow: 0 4px 12px rgba(15, 118, 110, 0.3);">
                        📖 পাঠাগারে প্রবেশ করে বই পড়ুন
                    </a>
                </div>
            @endif

            <!-- Order Info Box -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px 20px; margin: 20px 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13.5px;">পরিশোধিত মোট পরিমাণ:</span>
                    <strong style="color: #059669; font-size: 16px;">৳ {{ number_format($order->total) }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13.5px;">পেমেন্ট মেথড:</span>
                    <span style="color: #1e293b; font-size: 13.5px; font-weight: 700; text-transform: uppercase;">{{ $order->payment_method }}</span>
                </div>
                @if($order->courier_tracking_id)
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: #64748b; font-size: 13.5px;">কুরিয়ার ট্র্যাকিং আইডি:</span>
                        <strong style="color: #0f766e; font-size: 14px;">{{ $order->courier_tracking_id }}</strong>
                    </div>
                @endif
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #64748b; font-size: 13.5px;">বর্তমান স্ট্যাটাস:</span>
                    <span style="background: #dcfce7; color: #166534; padding: 2px 10px; border-radius: 999px; font-size: 12px; font-weight: 700;">
                        পেমেন্ট কনফার্মড
                    </span>
                </div>
            </div>

            <div style="text-align: center; margin: 25px 0 10px;">
                <a href="{{ route('orders.invoice', $order->order_number) }}" style="display: inline-block; background: #1e293b; color: #ffffff; padding: 10px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none;">
                    📄 মানি রিসিট ও অর্ডার ভাউচার দেখুন
                </a>
            </div>

            <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-top: 25px; border-top: 1px solid #f1f5f9; padding-top: 15px;">
                যে-কোনো সহযোগিতার জন্য আমাদের WhatsApp নম্বরে নক করতে পারেন: <a href="https://wa.me/8801700112233" style="color: #0f766e; font-weight: 700;">+880 1700-112233</a>
            </p>
        </div>

        <!-- Footer -->
        <div style="background: #f8fafc; padding: 16px 24px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8;">
            © {{ date('Y') }} মুক্তাদার বইঘর (Muktada's Boighor)। সর্বস্বত্ব সংরক্ষিত।
        </div>
    </div>
</body>
</html>
