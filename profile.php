<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require __DIR__ . '/config.php';

function h($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

if (empty($_SESSION['user_id'])) {
  header('Location: login.php?need=1&redirect=' . urlencode('profile.php'));
  exit;
}

$userId = (int)$_SESSION['user_id'];
$errors = [];

// Fetch current user
$stmt = $pdo->prepare('SELECT id, name, email, whatsapp, password, created_at FROM users WHERE id = ? LIMIT 1');
$stmt->execute([$userId]);
$user = $stmt->fetch();
if (!$user) { header('Location: index.php'); exit; }

$name = $user['name'];
$email = $user['email'];
$whatsapp = $user['whatsapp'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $whatsapp = trim($_POST['whatsapp'] ?? '');
  $new_password = $_POST['new_password'] ?? '';
  $confirm_password = $_POST['confirm_password'] ?? '';

  if ($name === '') { $errors[] = 'Nama wajib diisi.'; }
  if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Email tidak valid.'; }

  if ($whatsapp !== '') {
    if (!preg_match('/^\+?[0-9]{8,20}$/', $whatsapp)) {
      $errors[] = 'Nomor WhatsApp tidak valid.';
    }
  } else {
    $whatsapp = null;
  }

  if ($new_password !== '' || $confirm_password !== '') {
    if ($new_password !== $confirm_password) {
      $errors[] = 'Konfirmasi password tidak sama.';
    } elseif (strlen($new_password) < 6) {
      $errors[] = 'Password minimal 6 karakter.';
    }
  }

  // Unique email (exclude current user)
  if (!$errors) {
    $st = $pdo->prepare('SELECT id FROM users WHERE email = ? AND id <> ? LIMIT 1');
    $st->execute([$email, $userId]);
    if ($st->fetch()) {
      $errors[] = 'Email sudah digunakan pengguna lain.';
    }
  }

  if (!$errors) {
    if ($new_password !== '') {
      $hash = password_hash($new_password, PASSWORD_DEFAULT);
      $up = $pdo->prepare('UPDATE users SET name=?, email=?, whatsapp=?, password=? WHERE id=?');
      $up->execute([$name, $email, $whatsapp, $hash, $userId]);
    } else {
      $up = $pdo->prepare('UPDATE users SET name=?, email=?, whatsapp=? WHERE id=?');
      $up->execute([$name, $email, $whatsapp, $userId]);
    }

    // refresh session display values
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_whatsapp'] = $whatsapp;
    $_SESSION['flash'] = 'Profil berhasil diperbarui';
    header('Location: profile.php');
    exit;
  }
}

// Avatar seed
$avatarUrl = '';
$seed = $_SESSION['user_email'] ?? ($_SESSION['user_name'] ?? (string)$userId);
$avatarUrl = 'https://i.pravatar.cc/48?u=' . urlencode($seed);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil - KF OLX</title>
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
        <a href="index.php" class="flex items-center gap-2">
          <div class="w-8 h-8 rounded bg-emerald-600 text-white grid place-items-center font-extrabold">KF</div>
          <span class="text-xl font-bold">OLX</span>
        </a>
        <div class="hidden md:flex items-center gap-3">
          <a href="profile.php" class="flex items-center gap-2">
            <img src="<?php echo h($avatarUrl); ?>" alt="avatar" class="w-8 h-8 rounded-full border" />
            <div class="px-1 py-2 text-sm font-semibold">Halo, <?php echo h($_SESSION['user_name'] ?? 'Pengguna'); ?></div>
          </a>
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
        <h1 class="text-2xl sm:text-3xl font-bold mb-2">Profil Saya</h1>
        <p class="text-gray-600">Kelola informasi profil Anda.</p>
      </div>
    </section>

    <section class="py-10">
      <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border rounded-lg p-6">
          <?php if (!empty($errors)): ?>
            <div class="mb-4 rounded-md border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
              <?php foreach ($errors as $e): ?>
                <div><?php echo h($e); ?></div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <form method="post" class="grid grid-cols-1 gap-4" novalidate>
            <div class="flex items-center gap-3 pb-2">
              <img src="<?php echo h($avatarUrl); ?>" alt="avatar" class="w-10 h-10 rounded-full border" />
              <div class="text-sm text-gray-600">Bergabung: <?php echo date('d M Y', strtotime($user['created_at'])); ?></div>
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Nama</label>
              <input name="name" type="text" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" value="<?php echo h($name); ?>" required />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Email</label>
              <input name="email" type="email" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" value="<?php echo h($email); ?>" required />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">WhatsApp (opsional)</label>
              <input name="whatsapp" type="text" placeholder="mis. +6281234567890" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" value="<?php echo h($whatsapp ?? ''); ?>" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium mb-1">Password Baru (opsional)</label>
                <input name="new_password" type="password" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="••••••••" />
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
                <input name="confirm_password" type="password" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="••••••••" />
              </div>
            </div>
            <div class="flex items-center gap-3">
              <button class="px-4 py-2 bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700">Simpan Perubahan</button>
              <a href="index.php" class="px-4 py-2 border rounded-md font-semibold hover:bg-gray-50">Batal</a>
            </div>
          </form>
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
      const flash = document.getElementById('flashBanner');
      if (flash) setTimeout(()=>flash.classList.add('hidden'), 5000);
    })();
  </script>
</body>
</html>
