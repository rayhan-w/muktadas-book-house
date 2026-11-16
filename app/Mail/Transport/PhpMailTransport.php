<?php

namespace App\Mail\Transport;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Email;

class PhpMailTransport extends AbstractTransport
{
    protected function doSend(SentMessage $message): void
    {
        $recipients = $message->getEnvelope()->getRecipients();
        $to = implode(', ', array_map(fn($addr) => $addr->getAddress(), $recipients));

        $email = $message->getMessage();

        if ($email instanceof Email) {
            $rawSubject = $email->getSubject() ?? 'মুক্তাদার বইঘর নোটিফিকেশন';
            // Encode subject to UTF-8 base64 for flawless Bengali display in email clients
            $subject = '=?UTF-8?B?' . base64_encode($rawSubject) . '?=';

            $sender = $message->getEnvelope()->getSender()->getAddress();
            $senderName = $message->getEnvelope()->getSender()->getName() ?: 'মুক্তাদার বইঘর';
            $fromFormatted = '=?UTF-8?B?' . base64_encode($senderName) . '?= <' . $sender . '>';

            $headerLines = [
                'MIME-Version: 1.0',
                'Content-Type: text/html; charset=UTF-8',
                'Content-Transfer-Encoding: 8bit',
                'From: ' . $fromFormatted,
                'Reply-To: ' . $sender,
                'X-Mailer: PHP/' . phpversion(),
            ];

            $headerString = implode("\r\n", $headerLines);

            // Get HTML body or string body
            $body = $email->getHtmlBody();
            if (empty($body)) {
                $body = $email->getTextBody() ?: $email->getBody()->toString();
            }

            $extraParams = !empty($sender) ? '-f' . $sender : '';

            $sent = false;
            if (!empty($extraParams)) {
                $sent = @mail($to, $subject, $body, $headerString, $extraParams);
            }
            if (!$sent) {
                $sent = @mail($to, $subject, $body, $headerString);
            }

            if (!$sent) {
                \Illuminate\Support\Facades\Log::warning("PHP mail() returned false for recipient: {$to}");
            }
        } else {
            $raw = $message->toString();
            $parts = preg_split("/\r\n\r\n|\n\n/", $raw, 2);
            $headerString = $parts[0] ?? '';
            $body = $parts[1] ?? '';

            $subject = 'মুক্তাদার বইঘর';
            if (preg_match('/^Subject:\s*(.*)$/mi', $headerString, $matches)) {
                $subject = trim($matches[1]);
            }

            @mail($to, $subject, $body, $headerString);
        }
    }

    public function __toString(): string
    {
        return 'phpmail';
    }
}
