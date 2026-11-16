<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isAdminNotification ? 'নতুন অর্ডার গৃহীত হয়েছে' : 'আপনার অর্ডার নিশ্চিতকরণ' }}</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; margin: 0; padding: 30px 15px; color: #1e293b; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0f766e 0%, #042f2e 100%); padding: 32px 24px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 800; letter-spacing: 0.5px;">
                মুক্তাদার বইঘর
            </h1>
            <p style="color: #99f6e4; margin: 6px 0 0; font-size: 14px; font-weight: 600;">
                {{ $isAdminNotification ? 'অ্যাডমিন নোটিফিকেশন: নতুন অর্ডার এসেছে' : 'আপনার অর্ডারটি সফলভাবে গ্রহণ করা হয়েছে!' }}
            </p>
        </div>

        <!-- Body -->
        <div style="padding: 32px 28px;">
            @if($isAdminNotification)
                <p style="font-size: 16px; margin-top: 0; color: #0f172a; font-weight: 700;">
                    অ্যাডমিন মহোদয়,
                </p>
                <p style="font-size: 14.5px; color: #475569;">
                    ওয়েবসাইটে একজন গ্রাহক নতুন একটি অর্ডার দিয়েছেন। বিস্তারিত তথ্য নিচে দেওয়া হলো:
                </p>
            @else
                <p style="font-size: 16px; margin-top: 0; color: #0f172a; font-weight: 700;">
                    প্রিয় {{ $order->customer_name }},
                </p>
                <p style="font-size: 14.5px; color: #475569;">
                    মুক্তাদার বইঘরে আপনার অর্ডারের জন্য আন্তরিক ধন্যবাদ। আপনার অর্ডারটি সফলভাবে নথিভুক্ত করা হয়েছে।
                </p>
            @endif

            <!-- Order Summary Card -->
            <div style="background: #f0fdfa; border: 1.5px solid #ccfbf1; border-radius: 12px; padding: 18px 20px; margin: 20px 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13.5px;">অর্ডার নম্বর:</span>
                    <strong style="color: #0f766e; font-size: 15px;">#{{ $order->order_number }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13.5px;">অর্ডারের তারিখ:</span>
                    <span style="color: #1e293b; font-size: 13.5px; font-weight: 600;">{{ $order->created_at->format('d M, Y - h:i A') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 13.5px;">পেমেন্ট মেথড:</span>
                    <span style="color: #1e293b; font-size: 13.5px; font-weight: 700; text-transform: uppercase;">{{ $order->payment_method }}</span>
                </div>
                @if($order->payment_trx_id)
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: #64748b; font-size: 13.5px;">Transaction ID (TrxID):</span>
                        <code style="background: #fff; padding: 2px 8px; border-radius: 6px; font-size: 13px; color: #0f766e; border: 1px solid #99f6e4;">{{ $order->payment_trx_id }}</code>
                    </div>
                @endif
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #64748b; font-size: 13.5px;">পেমেন্ট স্ট্যাটাস:</span>
                    <strong style="color: {{ $order->payment_status === 'verified' ? '#16a34a' : '#d97706' }}; font-size: 13.5px;">
                        {{ $order->payment_status === 'verified' ? '✓ পরিশোধিত (Verified)' : 'অপেক্ষমান (Pending Verification)' }}
                    </strong>
                </div>
            </div>

            <!-- Items Table -->
            <h3 style="font-size: 16px; color: #0f172a; margin: 24px 0 12px; font-weight: 700; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
                বইয়ের তালিকা
            </h3>
            <table style="width: 100%; border-collapse: collapse; font-size: 14px; margin-bottom: 20px;">
                <thead>
                    <tr style="border-bottom: 1.5px solid #cbd5e1; text-align: left; color: #64748b; font-size: 12.5px;">
                        <th style="padding: 8px 4px;">বইয়ের নাম</th>
                        <th style="padding: 8px 4px; text-align: center;">ফরম্যাট</th>
                        <th style="padding: 8px 4px; text-align: center;">পরিমাণ</th>
                        <th style="padding: 8px 4px; text-align: right;">মূল্য</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px 4px; font-weight: 600; color: #0f172a;">
                                {{ $item->book ? $item->book->title : 'বই #' . $item->book_id }}
                            </td>
                            <td style="padding: 10px 4px; text-align: center;">
                                <span style="font-size: 11px; padding: 2px 8px; border-radius: 999px; background: {{ $item->format === 'ebook' ? '#e0f2fe' : '#fef3c7' }}; color: {{ $item->format === 'ebook' ? '#0369a1' : '#92400e' }}; font-weight: 700;">
                                    {{ $item->format === 'ebook' ? 'ই-বুক' : 'হার্ডকপি' }}
                                </span>
                            </td>
                            <td style="padding: 10px 4px; text-align: center; color: #475569;">
                                {{ $item->quantity }}টি
                            </td>
                            <td style="padding: 10px 4px; text-align: right; font-weight: 700; color: #0f172a;">
                                ৳ {{ number_format($item->total) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @if($order->subtotal)
                        <tr>
                            <td colspan="3" style="padding: 8px 4px; text-align: right; color: #64748b; font-size: 13px;">সাবটোটাল:</td>
                            <td style="padding: 8px 4px; text-align: right; color: #334155; font-size: 13px;">৳ {{ number_format($order->subtotal) }}</td>
                        </tr>
                    @endif
                    @if($order->delivery_charge > 0)
                        <tr>
                            <td colspan="3" style="padding: 4px; text-align: right; color: #64748b; font-size: 13px;">ডেলিভারি চার্জ:</td>
                            <td style="padding: 4px; text-align: right; color: #334155; font-size: 13px;">৳ {{ number_format($order->delivery_charge) }}</td>
                        </tr>
                    @endif
                    @if($order->discount > 0)
                        <tr>
                            <td colspan="3" style="padding: 4px; text-align: right; color: #16a34a; font-size: 13px;">ডিসকাউন্ট:</td>
                            <td style="padding: 4px; text-align: right; color: #16a34a; font-size: 13px;">- ৳ {{ number_format($order->discount) }}</td>
                        </tr>
                    @endif
                    <tr style="border-top: 1.5px solid #cbd5e1;">
                        <td colspan="3" style="padding: 10px 4px; text-align: right; font-weight: 800; color: #0f172a; font-size: 15px;">সর্বমোট পরিশোধযোগ্য:</td>
                        <td style="padding: 10px 4px; text-align: right; font-weight: 800; color: #0f766e; font-size: 16px;">৳ {{ number_format($order->total) }}</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Delivery Details -->
            @if($order->delivery_address)
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px; margin: 18px 0; font-size: 13.5px;">
                    <strong style="color: #0f172a; display: block; margin-bottom: 4px;">📍 ডেলিভারি ঠিকানা:</strong>
                    <span style="color: #475569;">{{ $order->delivery_address }}</span>
                    <div style="margin-top: 4px; color: #64748b;">মোবাইল: {{ $order->customer_phone }} | ইমেইল: {{ $order->customer_email }}</div>
                </div>
            @endif

            <!-- CTA Button -->
            <div style="text-align: center; margin: 30px 0 10px;">
                <a href="{{ route('orders.invoice', $order->order_number) }}" style="display: inline-block; background: #0f766e; color: #ffffff; padding: 12px 30px; border-radius: 8px; font-size: 15px; font-weight: 700; text-decoration: none; box-shadow: 0 4px 12px rgba(15, 118, 110, 0.3);">
                    📄 অনলাইন ইনভয়েস ও রসিদ দেখুন
                </a>
            </div>

            <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-top: 25px; border-top: 1px solid #f1f5f9; padding-top: 15px;">
                কোনো প্রশ্ন থাকলে আমাদের সাথে WhatsApp-এ যোগাযোগ করতে পারেন: <a href="https://wa.me/8801700112233" style="color: #0f766e; font-weight: 700;">+880 1700-112233</a>
            </p>
        </div>

        <!-- Footer -->
        <div style="background: #f8fafc; padding: 16px 24px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8;">
            © {{ date('Y') }} মুক্তাদার বইঘর (Muktada's Boighor)। সর্বস্বত্ব সংরক্ষিত।
        </div>
    </div>
</body>
</html>
