<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KF OLX</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    html { font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">
  <header class="border-b bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <a href="/" class="flex items-center gap-2">
          <div class="w-8 h-8 rounded bg-emerald-600 text-white grid place-items-center font-extrabold">KF</div>
          <span class="text-xl font-bold">OLX</span>
        </a>
        <nav class="hidden md:flex items-center gap-6 text-sm">
          <a href="#" class="hover:text-emerald-600">Beranda</a>
          <a href="#categories" class="hover:text-emerald-600">Kategori</a>
          <a href="#latest" class="hover:text-emerald-600">Iklan Terbaru</a>
        </nav>
        <button id="mobileMenuButton" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-emerald-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500" aria-controls="mobileMenu" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <div class="hidden md:flex items-center gap-3">
          <a href="login.php" class="px-3 py-2 text-sm font-medium hover:text-emerald-700">Masuk</a>
          <a href="register.php" class="px-3 py-2 text-sm font-medium hover:text-emerald-700">Daftar</a>
          <a href="post-ad.php" class="px-4 py-2 bg-emerald-600 text-white rounded-md text-sm font-semibold hover:bg-emerald-700">Pasang Iklan</a>
        </div>
      </div>
      <!-- Mobile menu panel -->
      <div id="mobileMenu" class="md:hidden hidden border-t">
        <div class="px-4 py-3 space-y-2 bg-white">
          <a href="#" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Beranda</a>
          <a href="#categories" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Kategori</a>
          <a href="#latest" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Iklan Terbaru</a>
          <hr class="my-2">
          <a href="login.php" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Masuk</a>
          <a href="register.php" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Daftar</a>
          <a href="post-ad.php" class="block px-3 py-2 rounded-md text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 text-center">Pasang Iklan</a>
        </div>
      </div>
    </div>
  </header>

  <main>
    <section class="bg-white border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl sm:text-3xl font-bold mb-4">Jual Beli Mudah di KF OLX</h1>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-3">
          <div class="lg:col-span-7">
            <label class="sr-only" for="keyword">Cari</label>
            <input id="keyword" type="text" placeholder="Cari mobil, motor, rumah, gadget..." class="w-full rounded-md border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
          </div>
          <div class="lg:col-span-2">
            <label class="sr-only" for="category">Kategori</label>
            <select id="category" class="w-full rounded-md border border-gray-300 px-3 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
              <option value="">Semua Kategori</option>
              <option>Mobil</option>
              <option>Motor</option>
              <option>Properti</option>
              <option>Elektronik</option>
            </select>
          </div>
          <div class="lg:col-span-2">
            <label class="sr-only" for="location">Lokasi</label>
            <select id="location" class="w-full rounded-md border border-gray-300 px-3 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
              <option value="">Seluruh Indonesia</option>
              <option>Jakarta</option>
              <option>Bandung</option>
              <option>Surabaya</option>
              <option>Medan</option>
            </select>
          </div>
          <div class="lg:col-span-1">
            <button class="w-full h-full bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700">Cari</button>
          </div>
        </div>
      </div>
    </section>

    <section id="categories" class="py-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-xl sm:text-2xl font-bold">Kategori Populer</h2>
          <a href="#" class="text-sm text-emerald-700 hover:underline">Lihat semua</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
          <a href="#" class="group bg-white border rounded-lg p-4 hover:shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded bg-gray-100 grid place-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-6 h-6 text-gray-600">
                <path d="M3 13h18l-2-4.5a3 3 0 0 0-2.7-1.8H7.7A3 3 0 0 0 5 8.5L3 13Z"/>
                <circle cx="7" cy="16" r="2"/>
                <circle cx="17" cy="16" r="2"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold">Mobil</div>
              <div class="text-xs text-gray-500">123 iklan</div>
            </div>
          </a>
          <a href="#" class="group bg-white border rounded-lg p-4 hover:shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded bg-gray-100 grid place-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-6 h-6 text-gray-600">
                <path d="M4 15h16l-1.5-3.5a2.5 2.5 0 0 0-2.3-1.5H7.8a2.5 2.5 0 0 0-2.3 1.5L4 15Z"/>
                <path d="M8 10l1.5-3h5L16 10"/>
                <circle cx="8" cy="17" r="2"/>
                <circle cx="16" cy="17" r="2"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold">Motor</div>
              <div class="text-xs text-gray-500">98 iklan</div>
            </div>
          </a>
          <a href="#" class="group bg-white border rounded-lg p-4 hover:shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded bg-gray-100 grid place-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-6 h-6 text-gray-600">
                <path d="M3 10.5L12 4l9 6.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-9.5Z"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold">Properti</div>
              <div class="text-xs text-gray-500">76 iklan</div>
            </div>
          </a>
          <a href="#" class="group bg-white border rounded-lg p-4 hover:shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded bg-gray-100 grid place-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-6 h-6 text-gray-600">
                <rect x="4" y="6" width="16" height="12" rx="2"/>
                <rect x="7" y="9" width="10" height="6" rx="1"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold">Elektronik</div>
              <div class="text-xs text-gray-500">210 iklan</div>
            </div>
          </a>
          <a href="#" class="group bg-white border rounded-lg p-4 hover:shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded bg-gray-100 grid place-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-6 h-6 text-gray-600">
                <path d="M4 10h4v4H4zM16 10h4v4h-4z"/>
                <path d="M8 12h8M6 18h12"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold">Hobi & Olahraga</div>
              <div class="text-xs text-gray-500">54 iklan</div>
            </div>
          </a>
          <a href="#" class="group bg-white border rounded-lg p-4 hover:shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded bg-gray-100 grid place-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-6 h-6 text-gray-600">
                <rect x="6" y="7" width="12" height="10" rx="2"/>
                <path d="M9 7V6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v1"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold">Pekerjaan</div>
              <div class="text-xs text-gray-500">31 iklan</div>
            </div>
          </a>
        </div>
      </div>
    </section>

    <section id="latest" class="py-10 bg-white border-t">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-xl sm:text-2xl font-bold">Iklan Terbaru</h2>
          <a href="#" class="text-sm text-emerald-700 hover:underline">Lihat semua</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
          <a href="#" class="border rounded-lg overflow-hidden bg-white hover:shadow-sm">
            <div class="aspect-[4/3] bg-gray-100">
              <img src="https://placehold.co/600x400" alt="iklan" class="w-full h-full object-cover" />
            </div>
            <div class="p-3 space-y-1">
              <div class="text-sm text-gray-500">Elektronik • Jakarta</div>
              <div class="font-semibold line-clamp-2">iPhone 13 128GB mulus</div>
              <div class="text-emerald-700 font-bold">Rp 9.500.000</div>
              <div class="text-xs text-gray-500">2 jam lalu</div>
            </div>
          </a>
          <a href="#" class="border rounded-lg overflow-hidden bg-white hover:shadow-sm">
            <div class="aspect-[4/3] bg-gray-100">
              <img src="https://placehold.co/600x400" alt="iklan" class="w-full h-full object-cover" />
            </div>
            <div class="p-3 space-y-1">
              <div class="text-sm text-gray-500">Mobil • Bandung</div>
              <div class="font-semibold line-clamp-2">Toyota Avanza 2018 AT</div>
              <div class="text-emerald-700 font-bold">Rp 165.000.000</div>
              <div class="text-xs text-gray-500">Kemarin</div>
            </div>
          </a>
          <a href="#" class="border rounded-lg overflow-hidden bg-white hover:shadow-sm">
            <div class="aspect-[4/3] bg-gray-100">
              <img src="https://placehold.co/600x400" alt="iklan" class="w-full h-full object-cover" />
            </div>
            <div class="p-3 space-y-1">
              <div class="text-sm text-gray-500">Properti • Surabaya</div>
              <div class="font-semibold line-clamp-2">Rumah 2 Lantai Strategis</div>
              <div class="text-emerald-700 font-bold">Rp 950.000.000</div>
              <div class="text-xs text-gray-500">3 hari lalu</div>
            </div>
          </a>
          <a href="#" class="border rounded-lg overflow-hidden bg-white hover:shadow-sm">
            <div class="aspect-[4/3] bg-gray-100">
              <img src="https://placehold.co/600x400" alt="iklan" class="w-full h-full object-cover" />
            </div>
            <div class="p-3 space-y-1">
              <div class="text-sm text-gray-500">Motor • Medan</div>
              <div class="font-semibold line-clamp-2">Honda Vario 2021 low KM</div>
              <div class="text-emerald-700 font-bold">Rp 18.500.000</div>
              <div class="text-xs text-gray-500">5 hari lalu</div>
            </div>
          </a>
        </div>
        <div class="text-center mt-8">
          <a href="#" class="inline-flex items-center gap-2 px-5 py-3 border rounded-md font-semibold hover:bg-gray-50">Muat lebih banyak</a>
        </div>
      </div>
    </section>

    <section class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-emerald-600 rounded-xl text-white p-8 flex flex-col md:flex-row items-center justify-between gap-6">
          <div>
            <div class="text-2xl font-bold">Punya barang bekas? Pasang iklan sekarang!</div>
            <div class="text-white/90">Gratis, cepat, dan mudah. Terhubung dengan jutaan pembeli.</div>
          </div>
          <a href="post-ad.php" class="px-5 py-3 bg-white text-emerald-700 rounded-md font-semibold hover:bg-gray-100">Pasang Iklan</a>
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
