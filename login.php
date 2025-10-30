<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Masuk - KF OLX</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    html { font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">
  <!-- <header class="border-b bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <a href="/KF-OLX/" class="flex items-center gap-2">
          <div class="w-8 h-8 rounded bg-emerald-600 text-white grid place-items-center font-extrabold">KF</div>
          <span class="text-xl font-bold">OLX</span>
        </a>
        <nav class="hidden md:flex items-center gap-6 text-sm">
          <a href="/KF-OLX/" class="hover:text-emerald-600">Beranda</a>
          <a href="/KF-OLX/#categories" class="hover:text-emerald-600">Kategori</a>
          <a href="/KF-OLX/#latest" class="hover:text-emerald-600">Iklan Terbaru</a>
        </nav>
        <button id="mobileMenuButton" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-emerald-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500" aria-controls="mobileMenu" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <div class="hidden md:flex items-center gap-3">
          <a href="/KF-OLX/login.php" class="px-3 py-2 text-sm font-medium hover:text-emerald-700">Masuk</a>
          <a href="/KF-OLX/register.php" class="px-3 py-2 text-sm font-medium hover:text-emerald-700">Daftar</a>
          <a href="#post-ad" class="px-4 py-2 bg-emerald-600 text-white rounded-md text-sm font-semibold hover:bg-emerald-700">Pasang Iklan</a>
        </div>
      </div>
      <div id="mobileMenu" class="md:hidden hidden border-t">
        <div class="px-4 py-3 space-y-2 bg-white">
          <a href="/KF-OLX/" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Beranda</a>
          <a href="/KF-OLX/#categories" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Kategori</a>
          <a href="/KF-OLX/#latest" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Iklan Terbaru</a>
          <hr class="my-2">
          <a href="/KF-OLX/login.php" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Masuk</a>
          <a href="/KF-OLX/register.php" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Daftar</a>
          <a href="#post-ad" class="block px-3 py-2 rounded-md text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 text-center">Pasang Iklan</a>
        </div>
      </div>
    </div>
  </header> -->

  <main>
    <section class="bg-white border-b text-center">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl sm:text-3xl font-bold mb-2">Masuk ke KF OLX</h1>
        <p class="text-gray-600">Selamat datang kembali! Silakan masuk untuk melanjutkan.</p>
      </div>
    </section>

    <section class="py-10">
      <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border rounded-lg p-6 shadow-sm">
          <form action="#" method="post" class="space-y-4">
            <div>
              <label for="email" class="block text-sm font-medium mb-1">Email</label>
              <input type="email" id="email" name="email" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="nama@email.com" required>
            </div>
            <div>
              <label for="password" class="block text-sm font-medium mb-1">Password</label>
              <input type="password" id="password" name="password" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="••••••••" required>
            </div>
            <div class="flex items-center justify-between">
              <label class="inline-flex items-center gap-2 text-sm">
                <input type="checkbox" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <span>Ingat saya</span>
              </label>
              <a href="#" class="text-sm text-emerald-700 hover:underline">Lupa password?</a>
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700">Masuk</button>
          </form>

          <div class="mt-6 text-sm text-center text-gray-600">
            Belum punya akun?
            <a href="register.php" class="text-emerald-700 font-semibold hover:underline">Daftar</a>
          </div>

          <div class="mt-6">
            <div class="relative">
              <div class="absolute inset-0 flex items-center"><div class="w-full border-t"></div></div>
              <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-white px-2 text-gray-500">atau masuk dengan</span>
              </div>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-3">
              <button class="inline-flex items-center justify-center gap-2 px-3 py-2 border rounded-md text-sm font-semibold hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-5 h-5"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12 c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C33.64,6.053,29.051,4,24,4C12.955,4,4,12.955,4,24 s8.955,20,20,20s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.371,15.108,18.839,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657 C33.64,6.053,29.051,4,24,4C16.318,4,9.656,8.63,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.768-1.977,13.285-5.196l-6.132-5.177C29.155,35.091,26.715,36,24,36 c-5.202,0-9.619-3.317-11.277-7.946l-6.49,5.002C9.551,39.798,16.227,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.103,5.623c0.001-0.001,0.002-0.001,0.003-0.002 l6.132,5.177C36.86,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
                Google
              </button>
              <button class="inline-flex items-center justify-center gap-2 px-3 py-2 border rounded-md text-sm font-semibold hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor"><path d="M22.675 0H1.325C.593 0 0 .593 0 1.326v21.348C0 23.407.593 24 1.325 24h11.495v-9.294H9.691v-3.622h3.129V8.413c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.796.715-1.796 1.763v2.312h3.59l-.467 3.622h-3.123V24h6.127C23.407 24 24 23.407 24 22.674V1.326C24 .593 23.407 0 22.675 0z"/></svg>
                Facebook
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="border-t bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-sm">
        <div>
          <div class="font-semibold mb-3">KF olx</div>
          <ul class="space-y-2">
            <li><a href="#" class="hover:text-emerald-700">Tentang kami</a></li>
            <li><a href="#" class="hover:text-emerald-700">Karir</a></li>
            <li><a href="#" class="hover:text-emerald-700">Blog</a></li>
          </ul>
        </div>
        <div>
          <div class="font-semibold mb-3">Bantuan</div>
          <ul class="space-y-2">
            <li><a href="#" class="hover:text-emerald-700">Pusat bantuan</a></li>
            <li><a href="#" class="hover:text-emerald-700">Syarat & Ketentuan</a></li>
            <li><a href="#" class="hover:text-emerald-700">Kebijakan Privasi</a></li>
          </ul>
        </div>
        <div>
          <div class="font-semibold mb-3">Kategori</div>
          <ul class="space-y-2">
            <li><a href="#" class="hover:text-emerald-700">Mobil</a></li>
            <li><a href="#" class="hover:text-emerald-700">Motor</a></li>
            <li><a href="#" class="hover:text-emerald-700">Properti</a></li>
          </ul>
        </div>
        <div>
          <div class="font-semibold mb-3">Ikuti kami</div>
          <ul class="space-y-2">
            <li><a href="#" class="hover:text-emerald-700">Instagram</a></li>
            <li><a href="#" class="hover:text-emerald-700">Facebook</a></li>
            <li><a href="#" class="hover:text-emerald-700">Twitter</a></li>
          </ul>
        </div>
      </div>
      <div class="mt-8 text-xs text-gray-500">© <?php echo date('Y'); ?> KF olx. All rights reserved.</div>
    </div>
  </footer>

  <script>
    (function(){
      const btn = document.getElementById('mobileMenuButton');
      const menu = document.getElementById('mobileMenu');
      if (!btn || !menu) return;
      btn.addEventListener('click', function(){
        const isHidden = menu.classList.contains('hidden');
        menu.classList.toggle('hidden');
        btn.setAttribute('aria-expanded', String(isHidden));
      });
    })();
  </script>
</body>
</html>
