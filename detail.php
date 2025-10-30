<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detail Iklan - KF OLX</title>
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
          <a href="#login" class="px-3 py-2 text-sm font-medium hover:text-emerald-700">Masuk</a>
          <a href="#register" class="px-3 py-2 text-sm font-medium hover:text-emerald-700">Daftar</a>
          <a href="#post-ad" class="px-4 py-2 bg-emerald-600 text-white rounded-md text-sm font-semibold hover:bg-emerald-700">Pasang Iklan</a>
        </div>
      </div>
      <div id="mobileMenu" class="md:hidden hidden border-t">
        <div class="px-4 py-3 space-y-2 bg-white">
          <a href="/KF-OLX/" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Beranda</a>
          <a href="/KF-OLX/#categories" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Kategori</a>
          <a href="/KF-OLX/#latest" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Iklan Terbaru</a>
          <hr class="my-2">
          <a href="#login" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Masuk</a>
          <a href="#register" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Daftar</a>
          <a href="#post-ad" class="block px-3 py-2 rounded-md text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 text-center">Pasang Iklan</a>
        </div>
      </div>
    </div>
  </header>

  <main>
    <section class="bg-white border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="text-sm text-gray-600 flex flex-wrap items-center gap-1">
          <a href="/KF-OLX/" class="hover:text-emerald-700">Beranda</a>
          <span>/</span>
          <a href="#" class="hover:text-emerald-700">Elektronik</a>
          <span>/</span>
          <span class="text-gray-800">iPhone 13 128GB mulus</span>
        </nav>
      </div>
    </section>

    <section class="py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
          <div class="bg-white border rounded-lg overflow-hidden">
            <div class="aspect-[4/3] bg-gray-100">
              <img src="https://placehold.co/1200x900" alt="Foto utama" class="w-full h-full object-cover" />
            </div>
            <div class="p-3 grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-3 bg-white">
              <img src="https://placehold.co/200x150" alt="thumb" class="w-full h-20 object-cover rounded border" />
              <img src="https://placehold.co/200x150" alt="thumb" class="w-full h-20 object-cover rounded border" />
              <img src="https://placehold.co/200x150" alt="thumb" class="w-full h-20 object-cover rounded border" />
              <img src="https://placehold.co/200x150" alt="thumb" class="w-full h-20 object-cover rounded border" />
              <img src="https://placehold.co/200x150" alt="thumb" class="w-full h-20 object-cover rounded border hidden sm:block" />
              <img src="https://placehold.co/200x150" alt="thumb" class="w-full h-20 object-cover rounded border hidden md:block" />
            </div>
          </div>

          <div class="mt-6 bg-white border rounded-lg p-5 space-y-4">
            <h1 class="text-2xl font-bold">iPhone 13 128GB mulus</h1>
            <div class="flex items-center gap-2">
              <div class="flex items-center text-amber-400">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 text-gray-300" fill="currentColor"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
              </div>
              <div class="text-sm text-gray-600">4.0 • 132 ulasan</div>
            </div>
            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
              <span class="inline-flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 10.5L12 4l9 6.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-9.5Z"/></svg> Elektronik</span>
              <span class="inline-flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Z"/></svg> Jakarta</span>
              <span class="inline-flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 12h12M6 8h12M6 16h8"/></svg> Diposting 2 jam lalu</span>
            </div>
            <div class="text-3xl font-extrabold text-emerald-700">Rp 9.500.000</div>
          </div>

          <div class="mt-6 bg-white border rounded-lg p-5 space-y-3">
            <h2 class="text-lg font-semibold">Deskripsi Produk</h2>
            <p class="text-gray-700 leading-relaxed">Dijual iPhone 13 warna midnight, kapasitas 128GB. Kondisi mulus 99%, baterai 90%, semua fungsi normal. Bonus case dan tempered glass. Alasan dijual: upgrade.</p>
            <ul class="list-disc ml-6 text-gray-700">
              <li>IMEI aman, iCloud kosong</li>
              <li>Unit original, belum pernah servis</li>
              <li>Include charger dan box</li>
            </ul>
          </div>
        </div>

        <aside class="lg:col-span-1 space-y-6">
          <div class="bg-white border rounded-lg p-5">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 grid place-items-center font-bold">KS</div>
              <div>
                <div class="font-semibold">Kevin Senjaya</div>
                <div class="text-xs text-gray-500">Bergabung 2023</div>
              </div>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-2">
              <a href="#" class="inline-flex items-center justify-center gap-2 px-3 py-2 border rounded-md text-sm font-semibold hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <path d="M12 2a10 10 0 0 0-8.94 14.56L2 22l5.6-1.47A10 10 0 1 0 12 2Z"/>
                  <path d="M16.5 14.5c-.5 1.2-2.3 1.1-3.6.6-2.3-.9-4.1-2.7-5-5-.5-1.3-.6-3.1.6-3.6.5-.2 1.1 0 1.4.5l.8 1.2c.3.4.2 1-.1 1.3l-.4.4c.8 1.6 2.1 2.9 3.7 3.7l.4-.4c.3-.3.9-.4 1.3-.1l1.2.8c.5.3.7.9.5 1.4Z"/>
                </svg>
                Chat
              </a>
              <a href="#" class="inline-flex items-center justify-center gap-2 px-3 py-2 border rounded-md text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <path d="M12 2a10 10 0 0 0-8.94 14.56L2 22l5.6-1.47A10 10 0 1 0 12 2Z"/>
                  <path d="M16.5 14.5c-.5 1.2-2.3 1.1-3.6.6-2.3-.9-4.1-2.7-5-5-.5-1.3-.6-3.1.6-3.6.5-.2 1.1 0 1.4.5l.8 1.2c.3.4.2 1-.1 1.3l-.4.4c.8 1.6 2.1 2.9 3.7 3.7l.4-.4c.3-.3.9-.4 1.3-.1l1.2.8c.5.3.7.9.5 1.4Z"/>
                </svg>
                Telepon
              </a>
            </div>
            <div class="mt-4 text-sm text-gray-600">
              Tersedia COD di Jakarta Pusat
            </div>
          </div>

          <div class="bg-white border rounded-lg p-5 space-y-3">
            <h3 class="font-semibold">Detail Barang</h3>
            <div class="text-sm text-gray-700 grid grid-cols-2 gap-y-2">
              <div>Kondisi</div><div class="font-medium">Bekas</div>
              <div>Garansi</div><div class="font-medium">Tidak ada</div>
              <div>Warna</div><div class="font-medium">Midnight</div>
            </div>
          </div>
        </aside>
      </div>
    </section>

    <section class="py-8 bg-white border-t">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-xl sm:text-2xl font-bold">Iklan Serupa</h2>
          <a href="#" class="text-sm text-emerald-700 hover:underline">Lihat semua</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
          <a href="#" class="border rounded-lg overflow-hidden bg-white hover:shadow-sm">
            <div class="aspect-[4/3] bg-gray-100">
              <img src="https://placehold.co/600x400" alt="iklan" class="w-full h-full object-cover" />
            </div>
            <div class="p-3 space-y-1">
              <div class="text-sm text-gray-500">Elektronik • Jakarta</div>
              <div class="font-semibold line-clamp-2">iPhone 12 128GB mulus</div>
              <div class="text-emerald-700 font-bold">Rp 7.800.000</div>
            </div>
          </a>
          <a href="#" class="border rounded-lg overflow-hidden bg-white hover:shadow-sm">
            <div class="aspect-[4/3] bg-gray-100">
              <img src="https://placehold.co/600x400" alt="iklan" class="w-full h-full object-cover" />
            </div>
            <div class="p-3 space-y-1">
              <div class="text-sm text-gray-500">Elektronik • Bandung</div>
              <div class="font-semibold line-clamp-2">iPhone 13 Mini 128GB</div>
              <div class="text-emerald-700 font-bold">Rp 8.300.000</div>
            </div>
          </a>
          <a href="#" class="border rounded-lg overflow-hidden bg-white hover:shadow-sm">
            <div class="aspect-[4/3] bg-gray-100">
              <img src="https://placehold.co/600x400" alt="iklan" class="w-full h-full object-cover" />
            </div>
            <div class="p-3 space-y-1">
              <div class="text-sm text-gray-500">Elektronik • Surabaya</div>
              <div class="font-semibold line-clamp-2">iPhone 13 256GB fullset</div>
              <div class="text-emerald-700 font-bold">Rp 10.200.000</div>
            </div>
          </a>
          <a href="#" class="border rounded-lg overflow-hidden bg-white hover:shadow-sm">
            <div class="aspect-[4/3] bg-gray-100">
              <img src="https://placehold.co/600x400" alt="iklan" class="w-full h-full object-cover" />
            </div>
            <div class="p-3 space-y-1">
              <div class="text-sm text-gray-500">Elektronik • Medan</div>
              <div class="font-semibold line-clamp-2">iPhone 12 Pro 128GB</div>
              <div class="text-emerald-700 font-bold">Rp 9.900.000</div>
            </div>
          </a>
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
