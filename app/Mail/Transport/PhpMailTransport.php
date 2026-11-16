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
            $subject = $email->getSubject() ?? '(No Subject)';

            // Prepare headers without To and Subject (since PHP mail() adds them)
            $headers = clone $email->getPreparedHeaders();
            $headers->remove('To');
            $headers->remove('Subject');

            $headerLines = [];
            foreach ($headers->all() as $header) {
                $headerLines[] = rtrim($header->toString(), "\r\n");
            }
            $headerString = implode("\r\n", array_filter($headerLines));

            // Get body
            $body = $email->getBody()->toString();

            $sender = $message->getEnvelope()->getSender()->getAddress();
            $extraParams = !empty($sender) ? '-f' . escapeshellcmd($sender) : '';

            $sent = false;
            if (!empty($extraParams)) {
                $sent = @mail($to, $subject, $body, $headerString, $extraParams);
            }
            if (!$sent) {
                $sent = @mail($to, $subject, $body, $headerString);
            }

            if (!$sent) {
                throw new \RuntimeException("PHP mail() ফাংশন ব্যর্থ হয়েছে। অনুগ্রহ করে অ্যাডমিন প্যানেল থেকে SMTP কনফিগারেশন চেক করুন।");
            }
        } else {
            // Raw message fallback
            $raw = $message->toString();
            $parts = preg_split("/\r\n\r\n|\n\n/", $raw, 2);
            $headerString = $parts[0] ?? '';
            $body = $parts[1] ?? '';

            $subject = '';
            if (preg_match('/^Subject:\s*(.*)$/mi', $headerString, $matches)) {
                $subject = trim($matches[1]);
            }

            $sent = @mail($to, $subject, $body, $headerString);
            if (!$sent) {
                throw new \RuntimeException("PHP mail() ফাংশন ব্যর্থ হয়েছে।");
            }
        }
    }

    public function __toString(): string
    {
        return 'phpmail';
    }
}
