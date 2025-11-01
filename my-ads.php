<?php
session_start();
require __DIR__ . '/config.php';

function h($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

if (empty($_SESSION['user_id'])) {
  $redirect = 'my-ads.php';
  header('Location: login.php?need=1&redirect=' . urlencode($redirect));
  exit;
}

$userId = (int)$_SESSION['user_id'];
$errors = [];
$success = '';

// Filters & pagination inputs
$q = trim($_GET['q'] ?? '');
$f_category = trim($_GET['category'] ?? '');
$sort = trim($_GET['sort'] ?? 'new'); // new, old, price_asc, price_desc
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 9;

// Load categories for filter/edit
$categories = [];
$stmt = $pdo->query('SELECT id, name FROM categories ORDER BY name');
$categories = $stmt->fetchAll();

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
  $adId = (int)($_POST['ad_id'] ?? 0);
  if ($adId > 0) {
    $pdo->beginTransaction();
    try {
      // verify ownership
      $st = $pdo->prepare('SELECT id FROM ads WHERE id=? AND user_id=?');
      $st->execute([$adId, $userId]);
      $own = $st->fetch();
      if (!$own) { throw new Exception('Iklan tidak ditemukan atau bukan milik Anda'); }

      // delete images (files optional)
      $st = $pdo->prepare('SELECT image_path FROM ad_images WHERE ad_id=?');
      $st->execute([$adId]);
      $imgs = $st->fetchAll();
      foreach ($imgs as $im) {
        $p = $im['image_path'];
        if ($p && is_file(__DIR__ . '/' . $p)) {
          @unlink(__DIR__ . '/' . $p);
        }
      }
      $pdo->prepare('DELETE FROM ad_images WHERE ad_id=?')->execute([$adId]);
      $pdo->prepare('DELETE FROM ads WHERE id=? AND user_id=?')->execute([$adId, $userId]);
      $pdo->commit();
      $_SESSION['flash'] = 'Iklan berhasil dihapus';
      header('Location: my-ads.php');
      exit;
    } catch (Exception $e) {
      $pdo->rollBack();
      $errors[] = $e->getMessage();
    }
  }
}

// Handle delete single image
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete_image') {
  $imgId = (int)($_POST['image_id'] ?? 0);
  $adId = (int)($_POST['ad_id'] ?? 0);
  if ($imgId > 0 && $adId > 0) {
    // verify ownership via ad
    $st = $pdo->prepare('SELECT id FROM ads WHERE id=? AND user_id=?');
    $st->execute([$adId, $userId]);
    if ($st->fetch()) {
      $st2 = $pdo->prepare('SELECT image_path FROM ad_images WHERE id=? AND ad_id=?');
      $st2->execute([$imgId, $adId]);
      if ($row = $st2->fetch()) {
        $p = $row['image_path'];
        if ($p && is_file(__DIR__ . '/' . $p)) { @unlink(__DIR__ . '/' . $p); }
        $pdo->prepare('DELETE FROM ad_images WHERE id=?')->execute([$imgId]);
        $_SESSION['flash'] = 'Gambar berhasil dihapus';
        header('Location: my-ads.php?edit='.(int)$adId);
        exit;
      }
    }
  }
}

// Handle add images
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add_images') {
  $adId = (int)($_POST['ad_id'] ?? 0);
  // verify ownership
  $st = $pdo->prepare('SELECT id FROM ads WHERE id=? AND user_id=?');
  $st->execute([$adId, $userId]);
  if ($st->fetch()) {
    if (!empty($_FILES['images']) && is_array($_FILES['images']['name'])) {
      $uploadDir = __DIR__ . '/uploads';
      if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0777, true); }
      for ($i=0; $i<count($_FILES['images']['name']); $i++) {
        $name = $_FILES['images']['name'][$i] ?? '';
        $tmp = $_FILES['images']['tmp_name'][$i] ?? '';
        $err = $_FILES['images']['error'][$i] ?? UPLOAD_ERR_NO_FILE;
        if ($err === UPLOAD_ERR_OK && is_uploaded_file($tmp)) {
          $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
          if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) continue;
          $newName = 'ad_'.$adId.'_'.time().'_'.bin2hex(random_bytes(4)).'.'.$ext;
          $dest = $uploadDir . '/' . $newName;
          if (move_uploaded_file($tmp, $dest)) {
            $relPath = 'uploads/' . $newName;
            $pdo->prepare('INSERT INTO ad_images (ad_id, image_path) VALUES (?, ?)')->execute([$adId, $relPath]);
          }
        }
      }
      $_SESSION['flash'] = 'Gambar berhasil diunggah';
      header('Location: my-ads.php?edit='.(int)$adId);
      exit;
    }
  }
}

// Handle Update (basic fields)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
  $adId = (int)($_POST['ad_id'] ?? 0);
  $title = trim($_POST['title'] ?? '');
  $price = trim($_POST['price'] ?? '');
  $location = trim($_POST['location'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $category_id = (int)($_POST['category_id'] ?? 0);

  if ($title === '') $errors[] = 'Judul wajib diisi';
  if ($price === '' || !is_numeric($price)) $errors[] = 'Harga tidak valid';
  if ($category_id <= 0) $errors[] = 'Kategori wajib dipilih';

  if (!$errors && $adId > 0) {
    // verify ownership
    $st = $pdo->prepare('SELECT id FROM ads WHERE id=? AND user_id=?');
    $st->execute([$adId, $userId]);
    if (!$st->fetch()) {
      $errors[] = 'Iklan tidak ditemukan atau bukan milik Anda';
    } else {
      $stmt = $pdo->prepare('UPDATE ads SET title=?, price=?, location=?, description=?, category_id=? WHERE id=? AND user_id=?');
      $stmt->execute([$title, (float)$price, $location, $description, $category_id, $adId, $userId]);
      $_SESSION['flash'] = 'Iklan berhasil diperbarui';
      header('Location: my-ads.php');
      exit;
    }
  }
  // keep edit state on error
  $_GET['edit'] = (string)$adId;
}

// If in edit mode, load ad data
$editAd = null;
$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
if ($editId > 0) {
  $st = $pdo->prepare('SELECT * FROM ads WHERE id=? AND user_id=?');
  $st->execute([$editId, $userId]);
  $editAd = $st->fetch();
}

// Load images for edit view
$editImages = [];
if ($editAd) {
  $st = $pdo->prepare('SELECT id, image_path FROM ad_images WHERE ad_id=? ORDER BY id ASC');
  $st->execute([$editAd['id']]);
  $editImages = $st->fetchAll();
}

// Load user's ads with filter/sort + pagination
$where = ['a.user_id = ?'];
$params = [$userId];
if ($q !== '') { $where[] = '(a.title LIKE ? OR a.description LIKE ?)'; $params[] = "%$q%"; $params[] = "%$q%"; }
if ($f_category !== '' && ctype_digit($f_category)) { $where[] = 'a.category_id = ?'; $params[] = (int)$f_category; }

$order = 'a.created_at DESC, a.id DESC';
if ($sort === 'old') $order = 'a.created_at ASC, a.id ASC';
elseif ($sort === 'price_asc') $order = 'a.price ASC, a.id DESC';
elseif ($sort === 'price_desc') $order = 'a.price DESC, a.id DESC';

// count
$countSql = 'SELECT COUNT(*) AS cnt FROM ads a WHERE '.implode(' AND ', $where);
$stc = $pdo->prepare($countSql);
$stc->execute($params);
$total = (int)($stc->fetch()['cnt'] ?? 0);
$pages = max(1, (int)ceil($total / $perPage));
if ($page > $pages) $page = $pages;
$offset = ($page - 1) * $perPage;

$sql = "SELECT a.id, a.title, a.price, a.location, a.created_at, c.name AS category_name,
        (SELECT image_path FROM ad_images i WHERE i.ad_id = a.id ORDER BY i.id ASC LIMIT 1) AS image_path
        FROM ads a JOIN categories c ON c.id=a.category_id
        WHERE ".implode(' AND ', $where)." ORDER BY $order LIMIT $perPage OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$ads = $stmt->fetchAll();

// Helper for header avatar
$avatarUrl = '';
if (!empty($_SESSION['user_id'])) {
  $seed = $_SESSION['user_email'] ?? ($_SESSION['user_name'] ?? (string)$_SESSION['user_id']);
  $avatarUrl = 'https://i.pravatar.cc/40?u=' . urlencode($seed);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iklan Saya - KF OLX</title>
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
          <a href="my-ads.php" class="text-emerald-700 font-semibold">Iklan Saya</a>
        </nav>
        <div class="hidden md:flex items-center gap-3">
          <img src="<?php echo h($avatarUrl); ?>" alt="avatar" class="w-8 h-8 rounded-full border" />
          <div class="px-1 py-2 text-sm font-semibold">Halo, <?php echo h($_SESSION['user_name'] ?? 'Pengguna'); ?></div>
          <a href="logout.php" class="px-3 py-2 text-sm font-medium text-red-600 hover:text-red-700">Keluar</a>
          <a href="post-ad.php" class="px-4 py-2 bg-emerald-600 text-white rounded-md text-sm font-semibold hover:bg-emerald-700">Pasang Iklan</a>
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
        <h1 class="text-2xl sm:text-3xl font-bold mb-2">Iklan Saya</h1>
        <p class="text-gray-600">Kelola iklan yang Anda pasang.</p>
      </div>
    </section>

    <?php if ($editAd): ?>
      <section class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="bg-white border rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Perbarui Iklan</h2>
            <?php if (!empty($errors)): ?>
              <div class="mb-4 rounded-md border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                <?php foreach ($errors as $e): ?>
                  <div><?php echo h($e); ?></div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <form method="post" class="grid grid-cols-1 gap-4">
              <input type="hidden" name="action" value="update" />
              <input type="hidden" name="ad_id" value="<?php echo (int)$editAd['id']; ?>" />
              <div>
                <label class="block text-sm font-medium mb-1">Judul</label>
                <input name="title" type="text" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" value="<?php echo h($editAd['title']); ?>" required />
              </div>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                  <label class="block text-sm font-medium mb-1">Harga</label>
                  <input name="price" type="number" step="1" min="0" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" value="<?php echo h($editAd['price']); ?>" required />
                </div>
                <div>
                  <label class="block text-sm font-medium mb-1">Lokasi</label>
                  <input name="location" type="text" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" value="<?php echo h($editAd['location']); ?>" />
                </div>
                <div>
                  <label class="block text-sm font-medium mb-1">Kategori</label>
                  <select name="category_id" class="w-full rounded-md border border-gray-300 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($categories as $c): ?>
                      <option value="<?php echo (int)$c['id']; ?>" <?php echo ((int)$editAd['category_id']===(int)$c['id'])?'selected':''; ?>><?php echo h($c['name']); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="description" rows="5" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500"><?php echo h($editAd['description']); ?></textarea>
              </div>
              <div class="flex items-center gap-3">
                <button class="px-4 py-2 bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700">Simpan Perubahan</button>
                <a href="my-ads.php" class="px-4 py-2 border rounded-md font-semibold hover:bg-gray-50">Batal</a>
              </div>
            </form>

            <div class="mt-6">
              <label class="block text-sm font-medium mb-2">Gambar</label>
              <?php if (!empty($editImages)): ?>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 mb-3">
                  <?php foreach ($editImages as $im): $p=$im['image_path']; $url = (is_file(__DIR__ . '/' . $p)) ? h($p) : 'https://placehold.co/200x150'; ?>
                    <div class="relative group border rounded overflow-hidden">
                      <img src="<?php echo $url; ?>" alt="img" class="w-full h-24 object-cover" />
                      <form method="post" class="absolute top-1 right-1 hidden group-hover:block" onsubmit="return confirm('Hapus gambar ini?');">
                        <input type="hidden" name="action" value="delete_image" />
                        <input type="hidden" name="ad_id" value="<?php echo (int)$editAd['id']; ?>" />
                        <input type="hidden" name="image_id" value="<?php echo (int)$im['id']; ?>" />
                        <button class="px-2 py-1 text-xs rounded bg-white border text-red-600 hover:bg-red-50">Hapus</button>
                      </form>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <form method="post" enctype="multipart/form-data" class="space-y-2">
                <input type="hidden" name="action" value="add_images" />
                <input type="hidden" name="ad_id" value="<?php echo (int)$editAd['id']; ?>" />
                <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm" />
                <button class="px-3 py-2 border rounded-md text-sm font-semibold hover:bg-gray-50">Unggah Gambar</button>
              </form>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <?php if (!$editAd): ?>
    <section class="py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="get" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">
          <input type="text" name="q" placeholder="Cari judul/deskripsi" value="<?php echo h($q); ?>" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
          <select name="category" class="w-full rounded-md border border-gray-300 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="">Semua Kategori</option>
            <?php foreach ($categories as $c): ?>
              <option value="<?php echo (int)$c['id']; ?>" <?php echo ($f_category!=='' && (int)$f_category===(int)$c['id'])?'selected':''; ?>><?php echo h($c['name']); ?></option>
            <?php endforeach; ?>
          </select>
          <select name="sort" class="w-full rounded-md border border-gray-300 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="new" <?php echo $sort==='new'?'selected':''; ?>>Terbaru</option>
            <option value="old" <?php echo $sort==='old'?'selected':''; ?>>Terlama</option>
            <option value="price_asc" <?php echo $sort==='price_asc'?'selected':''; ?>>Harga termurah</option>
            <option value="price_desc" <?php echo $sort==='price_desc'?'selected':''; ?>>Harga termahal</option>
          </select>
          <button class="w-full md:w-auto px-4 py-2 bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700">Terapkan</button>
        </form>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <?php foreach ($ads as $ad): ?>
            <div class="border rounded-lg overflow-hidden bg-white">
              <a href="detail.php?id=<?php echo (int)$ad['id']; ?>" class="block">
                <div class="aspect-[4/3] bg-gray-100">
                  <?php
                    $imgPath = $ad['image_path'] ?? '';
                    $imgUrl = 'https://placehold.co/600x400';
                    if ($imgPath && is_file(__DIR__ . '/' . $imgPath)) {
                      $imgUrl = h($imgPath);
                    }
                  ?>
                  <img src="<?php echo $imgUrl; ?>" alt="foto" class="w-full h-full object-cover" />
                </div>
              </a>
              <div class="p-4 space-y-1">
                <div class="text-sm text-gray-500"><?php echo h($ad['category_name']); ?> • <?php echo h($ad['location']); ?></div>
                <div class="font-semibold line-clamp-2"><?php echo h($ad['title']); ?></div>
                <div class="text-emerald-700 font-bold">Rp <?php echo number_format((float)$ad['price'], 0, ',', '.'); ?></div>
                <div class="text-xs text-gray-500"><?php echo h(date('d M Y', strtotime($ad['created_at']))); ?></div>
                <div class="pt-3 flex items-center gap-2">
                  <a href="my-ads.php?edit=<?php echo (int)$ad['id']; ?>" class="px-3 py-2 border rounded-md text-sm font-semibold hover:bg-gray-50">Edit</a>
                  <form method="post" onsubmit="return confirm('Hapus iklan ini?');">
                    <input type="hidden" name="action" value="delete" />
                    <input type="hidden" name="ad_id" value="<?php echo (int)$ad['id']; ?>" />
                    <button class="px-3 py-2 border rounded-md text-sm font-semibold text-red-600 hover:bg-red-50">Hapus</button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          <?php if (empty($ads)): ?>
            <div class="col-span-full text-center text-sm text-gray-500 py-12">Anda belum memiliki iklan.</div>
          <?php endif; ?>
        </div>
        <?php if ($pages > 1): ?>
          <div class="mt-6 flex items-center justify-center gap-2">
            <?php 
              $baseParams = $_GET; unset($baseParams['page']);
              $baseQuery = http_build_query($baseParams);
            ?>
            <a class="px-3 py-2 border rounded <?php echo $page<=1 ? 'pointer-events-none opacity-50' : 'hover:bg-gray-50'; ?>" href="?<?php echo $baseQuery.'&page=' . max(1,$page-1); ?>">Sebelumnya</a>
            <span class="px-3 py-2 text-sm">Halaman <?php echo $page; ?> dari <?php echo $pages; ?></span>
            <a class="px-3 py-2 border rounded <?php echo $page>=$pages ? 'pointer-events-none opacity-50' : 'hover:bg-gray-50'; ?>" href="?<?php echo $baseQuery.'&page=' . min($pages,$page+1); ?>">Berikutnya</a>
          </div>
        <?php endif; ?>
      </div>
    </section>
    <?php endif; ?>
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
      const flash = document.getElementById('flashBanner');
      if (flash) setTimeout(()=>flash.classList.add('hidden'), 5000);
    })();
  </script>
</body>
</html>