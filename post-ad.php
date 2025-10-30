<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pasang Iklan - KF OLX</title>
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
          <a href="/KF-OLX/login.php" class="px-3 py-2 text-sm font-medium hover:text-emerald-700">Masuk</a>
          <a href="/KF-OLX/register.php" class="px-3 py-2 text-sm font-medium hover:text-emerald-700">Daftar</a>
          <a href="/KF-OLX/post-ad.php" class="px-4 py-2 bg-emerald-600 text-white rounded-md text-sm font-semibold hover:bg-emerald-700">Pasang Iklan</a>
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
          <a href="/KF-OLX/post-ad.php" class="block px-3 py-2 rounded-md text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 text-center">Pasang Iklan</a>
        </div>
      </div>
    </div>
  </header>

  <main>
    <section class="bg-white border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl sm:text-3xl font-bold mb-2">Pasang Iklan Baru</h1>
        <p class="text-gray-600">Lengkapi detail iklan Anda di bawah ini.</p>
      </div>
    </section>

    <section class="py-10">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
          <form action="#" method="post" enctype="multipart/form-data" class="bg-white border rounded-lg p-6 space-y-6">
            <div>
              <label for="category_id" class="block text-sm font-medium mb-1">Kategori</label>
              <select id="category_id" name="category_id" class="w-full rounded-md border border-gray-300 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                <option value="">Pilih kategori</option>
                <option value="1">Mobil</option>
                <option value="2">Motor</option>
                <option value="3">Properti</option>
                <option value="4">Elektronik</option>
              </select>
            </div>

            <div>
              <label for="title" class="block text-sm font-medium mb-1">Judul Iklan</label>
              <input type="text" id="title" name="title" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Contoh: iPhone 13 128GB mulus" maxlength="150" required>
            </div>

            <div>
              <label for="description" class="block text-sm font-medium mb-1">Deskripsi</label>
              <textarea id="description" name="description" rows="6" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Tulis detail produk, kondisi, kelengkapan, dan lainnya..."></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label for="price" class="block text-sm font-medium mb-1">Harga (Rp)</label>
                <input type="number" step="0.01" min="0" id="price" name="price" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Contoh: 1000000" required>
              </div>
              <div>
                <label for="location" class="block text-sm font-medium mb-1">Lokasi</label>
                <input type="text" id="location" name="location" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Contoh: Jakarta, Bandung" required>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium mb-2">Foto Produk</label>
              <div class="text-xs text-gray-500 mb-2">Unggah hingga 5 foto. Format: JPG, PNG. Maks 2MB per foto.</div>
              <input type="file" name="images[]" accept="image/*" multiple class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
              <div class="mt-3 grid grid-cols-3 sm:grid-cols-5 gap-2">
                <div class="aspect-square bg-gray-100 rounded border grid place-items-center text-gray-400 text-xs">Preview</div>
                <div class="aspect-square bg-gray-100 rounded border grid place-items-center text-gray-400 text-xs">Preview</div>
                <div class="aspect-square bg-gray-100 rounded border grid place-items-center text-gray-400 text-xs">Preview</div>
              </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
              <a href="/KF-OLX/" class="px-4 py-2 border rounded-md font-semibold hover:bg-gray-50">Batal</a>
              <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700">Pasang Iklan</button>
            </div>
          </form>
        </div>

        <aside class="space-y-6">
          <div class="bg-white border rounded-lg p-5">
            <h3 class="font-semibold mb-2">Tips membuat iklan menarik</h3>
            <ul class="list-disc ml-5 text-sm text-gray-700 space-y-1">
              <li>Gunakan judul yang jelas dan deskriptif.</li>
              <li>Foto asli, terang, dan dari beberapa sudut.</li>
              <li>Tuliskan kondisi barang dan kelengkapan.</li>
              <li>Tentukan harga yang kompetitif.</li>
            </ul>
          </div>
          <div class="bg-white border rounded-lg p-5">
            <h3 class="font-semibold mb-2">Keamanan transaksi</h3>
            <p class="text-sm text-gray-700">Selalu bertemu di tempat umum yang aman dan periksa barang sebelum membayar. Hindari transfer sebelum bertemu penjual.</p>
          </div>
        </aside>
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
