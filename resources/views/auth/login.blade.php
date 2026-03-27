<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-zinc-100 p-6">
        
        <div class="mb-10 text-center">
            <h1 class="text-5xl font-black tracking-tighter uppercase italic text-zinc-900">DreamStudy</h1>
            <p class="text-zinc-500 tracking-[0.3em] uppercase text-[10px] mt-2 font-bold">Panel de Administración</p>
        </div>

        <div class="w-full max-w-md bg-white shadow-[20px_20px_60px_#bebebe,-20px_-20px_60px_#ffffff] rounded-3xl p-10 border border-zinc-200">
            
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-black uppercase tracking-widest text-zinc-400 mb-2">Usuario / Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                        class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-4 focus:ring-2 focus:ring-black transition outline-none">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold text-red-500" />
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-xs font-black uppercase tracking-widest text-zinc-400">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a class="text-[10px] font-bold text-zinc-400 hover:text-black uppercase tracking-tighter transition" href="{{ route('password.request') }}">
                                ¿Olvidaste?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full bg-zinc-50 border-none ring-1 ring-zinc-200 rounded-xl p-4 focus:ring-2 focus:ring-black transition outline-none">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold text-red-500" />
                </div>

                <div class="flex items-center">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded-md border-zinc-300 text-black shadow-sm focus:ring-black" name="remember">
                        <span class="ms-2 text-xs font-bold text-zinc-500 uppercase tracking-widest">Mantener sesión</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-black text-white py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-xs hover:bg-zinc-800 transition-all active:scale-95 shadow-xl">
                        Ingresar al Sistema
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-10 text-zinc-400 text-[9px] uppercase tracking-[0.4em] font-bold">© 2026 DreamStudy Professional access</p>
    </div>
</x-guest-layout>