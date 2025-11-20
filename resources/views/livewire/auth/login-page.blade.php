<div class="login-container">

    <style>
        /* 1. SETUP FULL SCREEN (BREAKOUT) */
        .login-container {
            position: fixed;       /* Kunci: Memaksa keluar dari container parent */
            top: 0; 
            left: 0;
            width: 100vw;          /* Lebar penuh viewport */
            height: 100vh;         /* Tinggi penuh viewport */
            z-index: 9999;         /* Pastikan di atas elemen lain */
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            overflow: hidden;      /* Hilangkan scrollbar */
            
            /* Background Image Berkualitas Tinggi */
            background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1932&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }

        /* Overlay Gelap & Blur */
        .login-container::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.5); /* Warna Navy Gelap Transparan */
            backdrop-filter: blur(8px);        /* Efek Blur Kaca Buram */
            z-index: -1;
        }

        /* 2. KARTU GLASSMORPHISM */
        .glass-card {
            position: relative;
            width: 90%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.85); /* Putih Susu Transparan */
            backdrop-filter: blur(20px);           /* Blur Konsentrat di belakang kartu */
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.5), /* Bayangan Bawah Besar */
                0 0 0 1px rgba(255, 255, 255, 0.2) inset; /* Border Cahaya Dalam */
            
            /* ANIMASI MASUK: Muncul dari bawah */
            animation: slideUpFade 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            transform: translateY(30px);
            opacity: 0;
        }

        @keyframes slideUpFade {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* 3. TYPOGRAPHY */
        .brand-section {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            font-size: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            margin: 0 auto 1rem auto;
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.5);
            
            /* Animasi Ikon Berdenyut Halus */
            animation: pulseGlow 3s infinite;
        }

        @keyframes pulseGlow {
            0%, 100% { transform: scale(1); box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.5); }
            50% { transform: scale(1.05); box-shadow: 0 15px 35px -5px rgba(37, 99, 235, 0.7); }
        }

        .app-name {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .app-desc {
            color: #64748b;
            font-size: 0.95rem;
            margin-top: 0.25rem;
        }

        /* 4. INPUT FORM */
        .input-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .input-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
            margin-left: 4px;
        }

        .modern-input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 2.8rem; /* Padding kiri untuk ikon */
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            color: #334155;
            transition: all 0.3s ease;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 42px; /* Sesuaikan dengan posisi label */
            color: #94a3b8;
            transition: color 0.3s;
        }

        .modern-input:focus {
            background: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        
        .modern-input:focus + .input-icon { /* Ikon berubah warna saat fokus */
            color: #3b82f6;
        }

        /* 5. TOMBOL & INTERAKSI */
        .btn-primary {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(to right, #2563eb, #1d4ed8);
            color: white;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.4);
        }

        .btn-primary:active { transform: scale(0.98); }

        /* Tombol Sekunder (Publik) */
        .btn-secondary {
            width: 100%;
            padding: 0.9rem;
            background: rgba(255, 255, 255, 0.5);
            border: 2px solid #e2e8f0;
            color: #475569;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
            margin-top: 1rem;
        }

        .btn-secondary:hover {
            background: #ffffff;
            border-color: #cbd5e1;
            color: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        /* 6. UTILITAS */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #94a3b8;
            font-size: 0.85rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        .divider::before { margin-right: 1em; }
        .divider::after { margin-left: 1em; }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            border: 1px solid #fecaca;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        .footer-copy {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.8rem;
            color: #94a3b8;
        }
    </style>

    <div class="glass-card">
        
        {{-- HEADER --}}
        <div class="brand-section">
            <div class="logo-icon">
                <i class="fas fa-landmark"></i>
            </div>
            <h1 class="app-name">SITANAS</h1>
            <p class="app-desc">Sistem Informasi Tanah kas Desa</p>
        </div>

        {{-- ALERT ERROR --}}
        @if (session('error'))
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- FORM LOGIN --}}
        <form wire:submit="login">
            
            {{-- Email Input --}}
            <div class="input-group">
                <label class="input-label">Email</label>
                <i class="fas fa-envelope input-icon"></i> <input type="email" wire:model="email" class="modern-input" placeholder="admin@desa.id" required autofocus>
                @error('email') <span style="color: #ef4444; font-size: 0.8rem; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            </div>

            {{-- Password Input --}}
            <div class="input-group">
                <label class="input-label">Kata Sandi</label>
                <i class="fas fa-lock input-icon"></i> <input type="password" wire:model="password" class="modern-input" placeholder="••••••••" required>
                @error('password') <span style="color: #ef4444; font-size: 0.8rem; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            </div>

            {{-- Tombol Login --}}
            <button type="submit" class="btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove>Masuk Aplikasi</span>
                <span wire:loading>
                    <i class="fas fa-circle-notch fa-spin"></i> Memproses...
                </span>
            </button>

        </form>

        <div class="divider">Atau akses sebagai tamu</div>

        {{-- Tombol Publik --}}
        <a href="{{ route('publik') }}" wire:navigate class="btn-secondary">
            <i class="fas fa-globe-asia"></i> Lihat Data Publik
        </a>

        <div class="footer-copy">
            &copy; {{ date('Y') }} Pemerintah Desa Maju Jaya.<br>All Rights Reserved.
        </div>

    </div>
</div>