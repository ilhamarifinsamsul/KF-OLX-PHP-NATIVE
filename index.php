<?php
session_start();
require __DIR__ . '/config.php';

// Helpers
function h($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
function time_ago($datetime){
  $ts = is_numeric($datetime) ? (int)$datetime : strtotime($datetime);
  $diff = time() - $ts;
  if ($diff < 0) { $diff = 0; }
  $hrs = max(1, floor($diff / 3600));
  if ($hrs < 24) return $hrs.' jam lalu';
  $days = floor($hrs / 24);
  if ($days < 7) return $days.' hari lalu';
  return date('d M Y', $ts);
}

// Inputs
$q = trim($_GET['q'] ?? '');
$filter_category = trim($_GET['category'] ?? '');
$filter_location = trim($_GET['location'] ?? '');

// Avatar URL (random but stable per user)
$avatarUrl = '';
if (!empty($_SESSION['user_id'])) {
  $seed = $_SESSION['user_email'] ?? ($_SESSION['user_name'] ?? (string)$_SESSION['user_id']);
  $avatarUrl = 'https://i.pravatar.cc/40?u=' . urlencode($seed);
}

// Categories with counts
$categories = [];
$stmt = $pdo->query('SELECT c.id, c.name, COUNT(a.id) as cnt FROM categories c LEFT JOIN ads a ON a.category_id=c.id GROUP BY c.id, c.name ORDER BY c.name');
$categories = $stmt->fetchAll();

// Locations distinct
$locations = [];
$stmt = $pdo->query("SELECT DISTINCT location FROM ads WHERE location IS NOT NULL AND location<>'' ORDER BY location");
$locations = array_map(fn($r)=>$r['location'], $stmt->fetchAll());

// Build ads query
$sql = "SELECT a.id, a.title, a.price, a.location, a.created_at, c.name AS category_name,
        (SELECT image_path FROM ad_images i WHERE i.ad_id = a.id ORDER BY i.id ASC LIMIT 1) AS image_path
        FROM ads a JOIN categories c ON c.id=a.category_id";
$where = [];
$params = [];
if ($q !== '') { $where[] = '(a.title LIKE ? OR a.description LIKE ?)'; $params[] = "%$q%"; $params[] = "%$q%"; }
if ($filter_category !== '' && ctype_digit($filter_category)) { $where[] = 'a.category_id = ?'; $params[] = (int)$filter_category; }
if ($filter_location !== '') { $where[] = 'a.location = ?'; $params[] = $filter_location; }
if ($where) { $sql .= ' WHERE ' . implode(' AND ', $where); }
$sql .= ' ORDER BY a.created_at DESC, a.id DESC LIMIT 12';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$ads = $stmt->fetchAll();
?>
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
          <?php if (!empty($_SESSION['user_id'])): ?>
            <img src="<?php echo h($avatarUrl); ?>" alt="avatar" class="w-8 h-8 rounded-full border" />
            <div class="px-1 py-2 text-sm font-semibold">Halo, <?php echo h($_SESSION['user_name'] ?? 'Pengguna'); ?></div>
            <a href="logout.php" class="px-3 py-2 text-sm font-medium text-red-600 hover:text-red-700">Keluar</a>
            <a href="post-ad.php" class="px-4 py-2 bg-emerald-600 text-white rounded-md text-sm font-semibold hover:bg-emerald-700">Pasang Iklan</a>
          <?php else: ?>
            <a href="login.php" class="px-3 py-2 text-sm font-medium hover:text-emerald-700">Masuk</a>
            <a href="register.php" class="px-3 py-2 text-sm font-medium hover:text-emerald-700">Daftar</a>
            <a href="post-ad.php" class="px-4 py-2 bg-emerald-600 text-white rounded-md text-sm font-semibold hover:bg-emerald-700">Pasang Iklan</a>
          <?php endif; ?>
        </div>
      </div>
      <!-- Mobile menu panel -->
      <div id="mobileMenu" class="md:hidden hidden border-t">
        <div class="px-4 py-3 space-y-2 bg-white">
          <a href="#" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Beranda</a>
          <a href="#categories" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Kategori</a>
          <a href="#latest" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Iklan Terbaru</a>
          <hr class="my-2">
          <?php if (!empty($_SESSION['user_id'])): ?>
            <div class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium">
              <img src="<?php echo h($avatarUrl); ?>" alt="avatar" class="w-8 h-8 rounded-full border" />
              <span>Halo, <?php echo h($_SESSION['user_name'] ?? 'Pengguna'); ?></span>
            </div>
            <a href="logout.php" class="block px-3 py-2 rounded-md text-sm font-medium text-red-600 hover:bg-gray-50">Keluar</a>
            <a href="post-ad.php" class="block px-3 py-2 rounded-md text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 text-center">Pasang Iklan</a>
          <?php else: ?>
            <a href="login.php" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Masuk</a>
            <a href="register.php" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Daftar</a>
            <a href="post-ad.php" class="block px-3 py-2 rounded-md text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 text-center">Pasang Iklan</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>

  <main>
    <?php if (!empty($_SESSION['flash'])): ?>
      <div id="flashBanner" class="bg-emerald-50 border-b border-emerald-200 text-emerald-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-sm">
          <?php echo h($_SESSION['flash']); unset($_SESSION['flash']); ?>
        </div>
      </div>
    <?php endif; ?>
    <section class="bg-white border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl sm:text-3xl font-bold mb-4">Jual Beli Mudah di KF OLX</h1>
        <form class="grid grid-cols-1 lg:grid-cols-12 gap-3" method="get" action="">
          <div class="lg:col-span-7">
            <label class="sr-only" for="keyword">Cari</label>
            <input id="keyword" name="q" type="text" value="<?php echo h($q); ?>" placeholder="Cari mobil, motor, rumah, gadget..." class="w-full rounded-md border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
          </div>
          <div class="lg:col-span-2">
            <label class="sr-only" for="category">Kategori</label>
            <select id="category" name="category" class="w-full rounded-md border border-gray-300 px-3 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
              <option value="">Semua Kategori</option>
              <?php foreach ($categories as $c): ?>
                <option value="<?php echo (int)$c['id']; ?>" <?php echo ($filter_category!=='' && (int)$filter_category===(int)$c['id'])?'selected':''; ?>>
                  <?php echo h($c['name']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="lg:col-span-2">
            <label class="sr-only" for="location">Lokasi</label>
            <select id="location" name="location" class="w-full rounded-md border border-gray-300 px-3 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
              <option value="">Seluruh Indonesia</option>
              <?php foreach ($locations as $loc): ?>
                <option value="<?php echo h($loc); ?>" <?php echo ($filter_location!=='' && $filter_location===$loc)?'selected':''; ?>><?php echo h($loc); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="lg:col-span-1">
            <button class="w-full h-full bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700">Cari</button>
          </div>
        </form>
      </div>
    </section>

    <section id="categories" class="py-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-xl sm:text-2xl font-bold">Kategori Populer</h2>
          <a href="#" class="text-sm text-emerald-700 hover:underline">Lihat semua</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
          <?php foreach ($categories as $c): ?>
            <a href="?category=<?php echo (int)$c['id']; ?>" class="group bg-white border rounded-lg p-4 hover:shadow-sm flex items-center gap-3">
              <div class="w-10 h-10 rounded bg-gray-100 grid place-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-6 h-6 text-gray-600">
                  <path d="M3 10.5L12 4l9 6.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-9.5Z"/>
                </svg>
              </div>
              <div>
                <div class="font-semibold"><?php echo h($c['name']); ?></div>
                <div class="text-xs text-gray-500"><?php echo (int)$c['cnt']; ?> iklan</div>
              </div>
            </a>
          <?php endforeach; ?>
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
          <?php foreach ($ads as $ad): ?>
            <a href="detail.php?id=<?php echo (int)$ad['id']; ?>" class="border rounded-lg overflow-hidden bg-white hover:shadow-sm">
              <div class="aspect-square sm:aspect-[4/3] bg-gray-100">
                <?php
                  $imgPath = $ad['image_path'] ?? '';
                  $imgUrl = 'https://placehold.co/600x400';
                  if ($imgPath && is_file(__DIR__ . '/' . $imgPath)) {
                    $imgUrl = h($imgPath);
                  }
                ?>
                <img src="<?php echo $imgUrl; ?>" alt="iklan" loading="lazy" class="w-full h-full object-cover object-center" />
              </div>
              <div class="p-3 space-y-1">
                <div class="text-sm text-gray-500"><?php echo h($ad['category_name']); ?> • <?php echo h($ad['location']); ?></div>
                <div class="font-semibold line-clamp-2"><?php echo h($ad['title']); ?></div>
                <div class="text-emerald-700 font-bold">Rp <?php echo number_format((float)$ad['price'], 0, ',', '.'); ?></div>
                <div class="text-xs text-gray-500"><?php echo h(time_ago($ad['created_at'])); ?></div>
              </div>
            </a>
          <?php endforeach; ?>
          <?php if (empty($ads)): ?>
            <div class="col-span-full text-center text-sm text-gray-500 py-8">Tidak ada iklan yang cocok.</div>
          <?php endif; ?>
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
      if (btn && menu) {
        btn.addEventListener('click', function(){
          const isHidden = menu.classList.contains('hidden');
          menu.classList.toggle('hidden');
          btn.setAttribute('aria-expanded', String(isHidden));
        });
      }

      // Auto-dismiss flash after 5s
      const flash = document.getElementById('flashBanner');
      if (flash) {
        setTimeout(function(){
          flash.classList.add('hidden');
        }, 5000);
      }
    })();
  </script>
</body>
</html>
