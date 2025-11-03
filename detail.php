<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require __DIR__ . '/config.php';

function h($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
function time_ago($datetime){
  $ts = is_numeric($datetime) ? (int)$datetime : strtotime($datetime);
  $diff = time() - $ts; if ($diff < 0) $diff = 0;
  $hrs = max(1, floor($diff/3600)); if ($hrs < 24) return $hrs.' jam lalu';
  $days = floor($hrs/24); if ($days < 7) return $days.' hari lalu';
  return date('d M Y', $ts);
}

$adId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$ad = null; $images = [];
if ($adId > 0) {
  $stmt = $pdo->prepare("SELECT a.*, c.name AS category_name, u.name AS seller_name, u.email AS seller_email, u.whatsapp AS seller_whatsapp, u.created_at AS seller_joined FROM ads a JOIN categories c ON c.id=a.category_id JOIN users u ON u.id=a.user_id WHERE a.id=? LIMIT 1");
  $stmt->execute([$adId]);
  $ad = $stmt->fetch();
  if ($ad) {
    $stmt2 = $pdo->prepare('SELECT image_path FROM ad_images WHERE ad_id = ? ORDER BY id ASC');
    $stmt2->execute([$adId]);
    $images = $stmt2->fetchAll();
    // similar ads (same category, exclude current)
    $stmt3 = $pdo->prepare("SELECT a.id, a.title, a.price, a.location, a.created_at,
      (SELECT image_path FROM ad_images i WHERE i.ad_id=a.id ORDER BY i.id ASC LIMIT 1) AS image_path
      FROM ads a WHERE a.category_id = ? AND a.id <> ? ORDER BY a.created_at DESC, a.id DESC LIMIT 8");
    $stmt3->execute([(int)$ad['category_id'], (int)$adId]);
    $similarAds = $stmt3->fetchAll();
  }
}

$avatarUrl = '';
if (!empty($ad['seller_email']) || !empty($ad['seller_name'])) {
  $seed = $ad['seller_email'] ?? $ad['seller_name'];
  $avatarUrl = 'https://i.pravatar.cc/48?u=' . urlencode($seed);
}

$mainImg = 'https://placehold.co/1200x900';
if (!empty($images)) {
  $p = $images[0]['image_path'];
  if ($p && is_file(__DIR__ . '/' . $p)) { $mainImg = $p; }
}
?>
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
          <?php if (!empty($_SESSION['user_id'])): ?>
            <?php $hdrSeed = $_SESSION['user_email'] ?? ($_SESSION['user_name'] ?? (string)$_SESSION['user_id']); $hdrAvatar = 'https://i.pravatar.cc/40?u=' . urlencode($hdrSeed); ?>
            <img src="<?php echo h($hdrAvatar); ?>" alt="avatar" class="w-8 h-8 rounded-full border" />
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
      <div id="mobileMenu" class="md:hidden hidden border-t">
        <div class="px-4 py-3 space-y-2 bg-white">
          <a href="/KF-OLX/" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Beranda</a>
          <a href="/KF-OLX/#categories" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Kategori</a>
          <a href="/KF-OLX/#latest" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">Iklan Terbaru</a>
          <hr class="my-2">
          <?php if (!empty($_SESSION['user_id'])): ?>
            <?php $hdrSeed2 = $_SESSION['user_email'] ?? ($_SESSION['user_name'] ?? (string)$_SESSION['user_id']); $hdrAvatar2 = 'https://i.pravatar.cc/40?u=' . urlencode($hdrSeed2); ?>
            <div class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium">
              <img src="<?php echo h($hdrAvatar2); ?>" alt="avatar" class="w-8 h-8 rounded-full border" />
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
    <section class="bg-white border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="text-sm text-gray-600 flex flex-wrap items-center gap-1">
          <a href="/KF-OLX/" class="hover:text-emerald-700">Beranda</a>
          <span>/</span>
          <a href="#" class="hover:text-emerald-700"><?php echo $ad ? h($ad['category_name']) : 'Kategori'; ?></a>
          <span>/</span>
          <span class="text-gray-800"><?php echo $ad ? h($ad['title']) : 'Detail Iklan'; ?></span>
        </nav>
      </div>
    </section>

    <section class="py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
          <div class="bg-white border rounded-lg overflow-hidden">
            <?php
              $urls = [];
              if (!empty($images)) {
                foreach ($images as $im) {
                  $p = $im['image_path'];
                  $urls[] = ($p && is_file(__DIR__ . '/' . $p)) ? h($p) : 'https://placehold.co/1200x900';
                }
              } else {
                $urls[] = (strpos($mainImg,'http')===0) ? $mainImg : h($mainImg);
              }
            ?>
            <div id="adCarousel" class="relative select-none">
              <div class="overflow-hidden">
                <div class="flex transition-transform duration-300" data-carousel-track>
                  <?php foreach ($urls as $u): ?>
                    <div class="min-w-full aspect-[4/3] bg-gray-100">
                      <img src="<?php echo $u; ?>" alt="foto" class="w-full h-full object-cover" />
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
              <?php if (count($urls) > 1): ?>
                <button type="button" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white border rounded-full w-9 h-9 grid place-items-center" data-carousel-prev aria-label="Sebelumnya">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18 9 12l6-6"/></svg>
                </button>
                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white border rounded-full w-9 h-9 grid place-items-center" data-carousel-next aria-label="Berikutnya">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </button>
                <div class="absolute bottom-2 left-0 right-0 flex items-center justify-center gap-2" data-carousel-dots>
                  <?php foreach ($urls as $i => $_): ?>
                    <button type="button" class="w-2.5 h-2.5 rounded-full border border-white/70 bg-white/50" data-dot-index="<?php echo $i; ?>" aria-label="Ke slide <?php echo $i+1; ?>"></button>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <div class="mt-6 bg-white border rounded-lg p-5 space-y-4">
            <h1 class="text-2xl font-bold"><?php echo $ad ? h($ad['title']) : 'Detail Iklan'; ?></h1>
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
              <span class="inline-flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 10.5L12 4l9 6.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-9.5Z"/></svg> <?php echo $ad ? h($ad['category_name']) : '-'; ?></span>
              <span class="inline-flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Z"/></svg> <?php echo $ad ? h($ad['location']) : '-'; ?></span>
              <span class="inline-flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 12h12M6 8h12M6 16h8"/></svg> <?php echo $ad ? h(time_ago($ad['created_at'])) : '-'; ?></span>
            </div>
            <div class="text-3xl font-extrabold text-emerald-700">Rp <?php echo $ad ? number_format((float)$ad['price'], 0, ',', '.') : '0'; ?></div>
          </div>

          <div class="mt-6 bg-white border rounded-lg p-5 space-y-3">
            <h2 class="text-lg font-semibold">Deskripsi Produk</h2>
            <div class="text-gray-700 leading-relaxed whitespace-pre-line"><?php echo $ad ? nl2br(h($ad['description'])) : ''; ?></div>
          </div>
        </div>

        <aside class="lg:col-span-1 space-y-6">
          <div class="bg-white border rounded-lg p-5">
            <div class="flex items-center gap-3">
              <?php $sellerAvatar = $avatarUrl ?: 'https://i.pravatar.cc/48?u=anon'; ?>
              <img src="<?php echo h($sellerAvatar); ?>" alt="seller" class="w-12 h-12 rounded-full border" />
              <div>
                <div class="font-semibold"><?php echo $ad ? h($ad['seller_name']) : '-'; ?></div>
                <div class="text-xs text-gray-500">Bergabung <?php echo $ad ? date('Y', strtotime($ad['seller_joined'])) : '-'; ?></div>
              </div>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-2">
              <?php 
                $wa = $ad['seller_whatsapp'] ?? ''; 
                $waPlain = preg_replace('/\D+/', '', (string)$wa); 
                $waLink = $waPlain ? 'https://wa.me/'.$waPlain.'?text='.urlencode('Halo, saya tertarik dengan iklan: '.$ad['title']) : '#';
                $isLogged = !empty($_SESSION['user_id']);
                $currentUrl = 'detail.php?id=' . (int)$adId;
                if (!$isLogged) {
                  $loginRedirect = 'login.php?need=1&redirect=' . urlencode($currentUrl);
                }
                $chatHref = ($isLogged && $waPlain) ? $waLink : ($loginRedirect ?? '#');
                $callHref = ($isLogged && $waPlain) ? 'https://wa.me/'.$waPlain : ($loginRedirect ?? '#');
                $btnStateClass = ($isLogged && $waPlain) ? '' : '';
              ?>
              <a href="<?php echo h($chatHref); ?>" <?php echo ($isLogged && $waPlain) ? 'target="_blank" rel="noopener"' : ''; ?> class="inline-flex items-center justify-center gap-2 px-3 py-2 border rounded-md text-sm font-semibold hover:bg-gray-50<?php echo $btnStateClass; ?>" <?php echo ($isLogged && $waPlain) ? 'data-wa-phone="'.h($waPlain).'" data-wa-msg="'.h('Halo, saya tertarik dengan iklan: '.$ad['title']).'" data-wa="chat"' : ''; ?>>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <path d="M12 2a10 10 0 0 0-8.94 14.56L2 22l5.6-1.47A10 10 0 1 0 12 2Z"/>
                  <path d="M16.5 14.5c-.5 1.2-2.3 1.1-3.6.6-2.3-.9-4.1-2.7-5-5-.5-1.3-.6-3.1.6-3.6.5-.2 1.1 0 1.4.5l.8 1.2c.3.4.2 1-.1 1.3l-.4.4c.8 1.6 2.1 2.9 3.7 3.7l.4-.4c.3-.3.9-.4 1.3-.1l1.2.8c.5.3.7.9.5 1.4Z"/>
                </svg>
                Chat
              </a>
              <a href="<?php echo h($callHref); ?>" <?php echo ($isLogged && $waPlain) ? 'target="_blank" rel="noopener"' : ''; ?> class="inline-flex items-center justify-center gap-2 px-3 py-2 border rounded-md text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700<?php echo $btnStateClass; ?>" <?php echo ($isLogged && $waPlain) ? 'data-wa-phone="'.h($waPlain).'" data-wa="call"' : ''; ?>>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <path d="M12 2a10 10 0 0 0-8.94 14.56L2 22l5.6-1.47A10 10 0 1 0 12 2Z"/>
                  <path d="M16.5 14.5c-.5 1.2-2.3 1.1-3.6.6-2.3-.9-4.1-2.7-5-5-.5-1.3-.6-3.1.6-3.6.5-.2 1.1 0 1.4.5l.8 1.2c.3.4.2 1-.1 1.3l-.4.4c.8 1.6 2.1 2.9 3.7 3.7l.4-.4c.3-.3.9-.4 1.3-.1l1.2.8c.5.3.7.9.5 1.4Z"/>
                </svg>
                Telepon
              </a>
            </div>
            <div class="mt-4 text-sm text-gray-600">
              Penjual: <?php echo $ad ? h($ad['seller_name']) : '-'; ?>
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
          <?php if (!empty($similarAds)): ?>
            <?php foreach ($similarAds as $sa): ?>
              <a href="detail.php?id=<?php echo (int)$sa['id']; ?>" class="border rounded-lg overflow-hidden bg-white hover:shadow-sm">
                <div class="aspect-square sm:aspect-[4/3] bg-gray-100">
                  <?php
                    $p = $sa['image_path'] ?? '';
                    $url = 'https://placehold.co/600x400';
                    if ($p && is_file(__DIR__ . '/' . $p)) { $url = h($p); }
                  ?>
                  <img src="<?php echo $url; ?>" alt="iklan" class="w-full h-full object-cover" />
                </div>
                <div class="p-3 space-y-1">
                  <div class="text-sm text-gray-500"><?php echo h($ad['category_name']); ?> • <?php echo h($sa['location']); ?></div>
                  <div class="font-semibold line-clamp-2"><?php echo h($sa['title']); ?></div>
                  <div class="text-emerald-700 font-bold">Rp <?php echo number_format((float)$sa['price'], 0, ',', '.'); ?></div>
                </div>
              </a>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-span-full text-center text-sm text-gray-500 py-8">Belum ada iklan serupa.</div>
          <?php endif; ?>
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

      // Carousel logic
      const carousel = document.getElementById('adCarousel');
      if (carousel) {
        const track = carousel.querySelector('[data-carousel-track]');
        const slides = Array.from(track ? track.children : []);
        const btnPrev = carousel.querySelector('[data-carousel-prev]');
        const btnNext = carousel.querySelector('[data-carousel-next]');
        const dotsWrap = carousel.querySelector('[data-carousel-dots]');
        const dots = dotsWrap ? Array.from(dotsWrap.querySelectorAll('[data-dot-index]')) : [];
        let index = 0;

        const update = () => {
          track.style.transform = `translateX(-${index * 100}%)`;
          dots.forEach((d, i) => {
            d.classList.toggle('bg-emerald-600', i === index);
            d.classList.toggle('border-emerald-600', i === index);
            d.classList.toggle('bg-white/50', i !== index);
          });
          if (btnPrev) btnPrev.disabled = slides.length <= 1;
          if (btnNext) btnNext.disabled = slides.length <= 1;
        };

        if (btnPrev) btnPrev.addEventListener('click', () => {
          index = (index - 1 + slides.length) % slides.length;
          update();
        });
        if (btnNext) btnNext.addEventListener('click', () => {
          index = (index + 1) % slides.length;
          update();
        });
        if (dotsWrap) {
          dotsWrap.addEventListener('click', (e) => {
            const target = e.target.closest('[data-dot-index]');
            if (!target) return;
            const i = parseInt(target.getAttribute('data-dot-index'), 10);
            if (!Number.isNaN(i)) { index = i; update(); }
          });
        }
        // Keyboard support
        document.addEventListener('keydown', (e) => {
          if (!carousel) return;
          if (e.key === 'ArrowLeft') { index = (index - 1 + slides.length) % slides.length; update(); }
          else if (e.key === 'ArrowRight') { index = (index + 1) % slides.length; update(); }
        });
        update();
      }
    })();
  </script>
</body>
</html>
