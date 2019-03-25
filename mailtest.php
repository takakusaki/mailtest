<?php
        mb_language("japanese");
        mb_internal_encoding("UTF-8");

        $from = "<<送信元>>";
        $to = "<<宛先>>";
        $subject = "<<件名>>";

        //メールヘッダ
        $boundary = "--" . uniqid(rand(), 1);
        $headers = [
                'MIME-Version: 1.0',
                'Content-Type: multipart/alternative; boundary="' . $boundary . '"',
                "From: " . $from
        ];

	//件名
        $subject = mb_convert_encoding($subject, "iso-2022-jp");

        //本文(ヘッダー)
        $message = '';
        $message .= '--' . $boundary . "\r\n";
        $message .= 'Content-Type: text/html; charset=iso-2022-jp' . "\r\n";
        $message .= 'Content-Disposition: inline' . "\r\n";
        $message .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n";
        $message .= "\r\n";

        //本文(HTML)
        $html_body = file_get_contents("mailtest.html");
        $message .= quoted_printable_encode(mb_convert_encoding($html_body, 'iso-2022-jp', 'UTF-8')) . "\r\n";
        $message .= '--' . $boundary . "--\r\n";
        print($message);

        //メール送信
        print("[メール送信]\n");
        $ret=mb_send_mail($to, $subject, $message, implode("\n", $headers));
        print("mb_send_mail()=$ret\n");
?>

