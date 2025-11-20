<div class="min-h-screen flex bg-white">
    <div class="hidden lg:block relative w-0 flex-1 overflow-hidden bg-slate-900">
        <div class="absolute inset-0 h-full w-full bg-gradient-to-br from-blue-600/20 to-slate-900/90 z-10"></div>
        <img class="absolute inset-0 h-full w-full object-cover opacity-50" src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=3200&auto=format&fit=crop" alt="Tanah Desa">
        <div class="relative z-20 flex flex-col justify-center h-full px-12 text-white">
            <div class="mb-6 p-3 bg-blue-600 rounded-xl w-fit shadow-lg shadow-blue-500/50">
                <i class="fas fa-landmark text-3xl"></i>
            </div>
            <h2 class="text-4xl font-bold mb-4 tracking-tight">Sistem Informasi<br>Tanah Kas Desa</h2>
            <p class="text-lg text-blue-100 max-w-md leading-relaxed">Kelola, monitor, dan amankan aset desa dengan transparansi penuh dan presisi tinggi.</p>
        </div>
    </div>

    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            
            <div class="text-center lg:text-left">
                <h2 class="mt-6 text-3xl font-bold tracking-tight text-slate-900">Selamat Datang</h2>
                <p class="mt-2 text-sm text-slate-500">Silakan masuk untuk mengakses dashboard.</p>
            </div>

            <div class="mt-10">
                <form wire:submit="login" class="space-y-6">
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Alamat Email</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-slate-400 sm:text-sm"></i>
                            </div>
                            <input wire:model="email" id="email" type="email" required class="block w-full pl-10 rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5" placeholder="nama@desa.id">
                        </div>
                        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
                        <div class="mt-1 relative rounded-md shadow-sm" x-data="{ show: false }">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-slate-400 sm:text-sm"></i>
                            </div>
                            <input wire:model="password" id="password" :type="show ? 'text' : 'password'" required class="block w-full pl-10 pr-10 rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5" placeholder="••••••••">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" @click="show = !show">
                                <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'" class="text-slate-400 hover:text-slate-600"></i>
                            </div>
                        </div>
                        @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-all transform active:scale-95">
                            <span wire:loading.remove>Masuk Aplikasi</span>
                            <span wire:loading><i class="fas fa-circle-notch fa-spin mr-2"></i>Memproses...</span>
                        </button>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('publik') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            &larr; Kembali ke Halaman Publik
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>