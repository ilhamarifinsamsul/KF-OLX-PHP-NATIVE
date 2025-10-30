<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar - KF OLX</title>
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
        <h1 class="text-2xl sm:text-3xl font-bold mb-2">Daftar akun baru</h1>
        <p class="text-gray-600">Buat akun untuk mulai membeli dan menjual di KF OLX.</p>
      </div>
    </section>

    <section class="py-10">
      <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border rounded-lg p-6 shadow-sm">
          <form action="#" method="post" class="space-y-4">
            <div>
              <label for="name" class="block text-sm font-medium mb-1">Nama Lengkap</label>
              <input type="text" id="name" name="name" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Nama lengkap" required>
            </div>
            <div>
              <label for="email" class="block text-sm font-medium mb-1">Email</label>
              <input type="email" id="email" name="email" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="nama@email.com" required>
            </div>
            <div>
              <label for="password" class="block text-sm font-medium mb-1">Password</label>
              <input type="password" id="password" name="password" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="••••••••" required>
            </div>
            <div>
              <label for="password_confirmation" class="block text-sm font-medium mb-1">Konfirmasi Password</label>
              <input type="password" id="password_confirmation" name="password_confirmation" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="••••••••" required>
            </div>
            <div class="text-sm text-gray-600">
              Dengan mendaftar, Anda menyetujui
              <a href="#" class="text-emerald-700 hover:underline">Syarat & Ketentuan</a> dan
              <a href="#" class="text-emerald-700 hover:underline">Kebijakan Privasi</a> kami.
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700">Daftar</button>
          </form>

          <div class="mt-6 text-sm text-center text-gray-600">
            Sudah punya akun?
            <a href="login.php" class="text-emerald-700 font-semibold hover:underline">Masuk</a>
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
