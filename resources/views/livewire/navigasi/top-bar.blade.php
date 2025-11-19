<div>
    <style>
        .topbar-container {
            background: #111827;
            color: #f3f4f6;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }


        .brand-area {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
            color: #ffffff;
            text-decoration: none;
        }


        .nav-menu {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-link {
            color: #9ca3af;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            color: #60a5fa;
            background-color: rgba(96, 165, 250, 0.1);
        }

        .dropdown-wrapper {
            position: relative; 
            display: inline-block;
        }

        .dropdown-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            outline: none;
        }


        .dropdown-content {
            position: absolute;
            top: 100%;
            left: 0;
            margin-top: 0.5rem;
            min-width: 220px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            visibility: hidden;
            z-index: 100;
        }

        /* Tampilkan Dropdown saat Open */
        .dropdown-wrapper[data-open="true"] .dropdown-content {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }

        .dropdown-item {
            display: block;
            padding: 12px 16px;
            color: #374151;
            text-decoration: none;
            font-size: 0.9rem;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s;
        }

        .dropdown-item:last-child { border-bottom: none; }
        .dropdown-item:hover { background-color: #f9fafb; color: #111827; }

        /* Profile Area */
        .user-area {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-left: 20px;
            border-left: 1px solid rgba(255,255,255,0.2);
        }

        .user-name {
            font-size: 0.9rem;
            text-align: right;
            line-height: 1.2;
        }
        .user-role {
            font-size: 0.75rem;
            color: #9ca3af;
            display: block;
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-logout:hover {
            background: #ef4444;
            color: white;
            border-color: #ef4444;
        }
    </style>

    <header class="topbar-container">
        
        <a href="{{ route('dashboard') }}" wire:navigate class="brand-area">
            <i class="fas fa-landmark" style="color: #60a5fa;"></i>
            <span>SITANAS</span>
        </a>

        <nav class="nav-menu">
            <a href="{{ route('dashboard') }}" wire:navigate class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            

            <a href="{{ route('laporan') }}" wire:navigate class="nav-link {{ request()->routeIs('laporan') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i> <span>Laporan</span>
            </a>


            @if(auth()->user()->role_id == 1)
                <div x-data="{ open: false }" 
                     @click.outside="open = false" 
                     class="dropdown-wrapper" 
                     :data-open="open">
                    
                    <button @click="open = !open" class="nav-link dropdown-btn {{ request()->is('admin*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i> 
                        <span>Admin</span> 
                        <i class="fas fa-chevron-down" style="font-size: 0.75rem; margin-left: 4px; transition: transform 0.2s;" :style="open ? 'transform: rotate(180deg)' : ''"></i>
                    </button>


                    <div class="dropdown-content">
                        <div style="padding: 8px 16px; background: #f3f4f6; font-size: 0.75rem; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                            Menu Administrator
                        </div>
                        
                        <a href="{{ route('admin.users') }}" wire:navigate class="dropdown-item">
                            <i class="fas fa-users fa-fw" style="color: #6b7280; margin-right: 8px;"></i> Manajemen User
                        </a>
                        <a href="{{ route('admin.arsip') }}" wire:navigate class="dropdown-item">
                            <i class="fas fa-archive fa-fw" style="color: #6b7280; margin-right: 8px;"></i> Arsip Aset
                        </a>
                        <a href="{{ route('admin.log') }}" wire:navigate class="dropdown-item">
                            <i class="fas fa-history fa-fw" style="color: #6b7280; margin-right: 8px;"></i> Log Aktivitas
                        </a>
                    </div>
                </div>
            @endif
        </nav>


        <div class="user-area">
            <div>
                <div class="user-name">{{ auth()->user()->nama_lengkap }}</div>
                <span class="user-role">{{ auth()->user()->role->nama_role }}</span>
            </div>
            
            <button wire:click="logout" class="btn-logout" title="Keluar dari Aplikasi">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </div>

    </header>
</div>