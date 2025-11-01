<?php
require __DIR__ . '/config.php';

$errors = [];
$success = '';
$old = ['name' => '', 'email' => '', 'whatsapp' => ''];

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['password_confirmation'] ?? '';
    $whatsapp = trim($_POST['whatsapp'] ?? '');

    // Store old data
    $old['name'] = $name;
    $old['email'] = $email;
    $old['whatsapp'] = $whatsapp;

    // Validation
    if ($name === '') {
        $errors[] = 'Nama wajib diisi.';
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email tidak valid.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter.';
    }
    if ($password !== $password_confirmation) {
        $errors[] = 'Konfirmasi password tidak cocok.';
    }

    // Optional WhatsApp validation (allow + and digits, 8-20 chars)
    if ($whatsapp !== '') {
        if (!preg_match('/^\+?[0-9]{8,20}$/', $whatsapp)) {
            $errors[] = 'Nomor WhatsApp tidak valid.';
        }
    }
    
    // Check if email is already registered
    if (!$errors) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Email sudah terdaftar.';
        }
    }

    // Register user
    if (!$errors) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password, whatsapp) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $email, $hash, $whatsapp !== '' ? $whatsapp : null]);
        $success = 'Pendaftaran berhasil. Silakan masuk.';
        $old = ['name' => '', 'email' => '', 'whatsapp' => ''];
    }
}
?>
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
          <?php if (!empty($errors)): ?>
            <div class="mb-4 rounded-md border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
              <?php foreach ($errors as $e): ?>
                <div><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <?php if ($success): ?>
            <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 text-emerald-700 px-4 py-3 text-sm">
              <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?>
              <a href="login.php" class="underline font-semibold ml-1">Masuk</a>
            </div>
          <?php endif; ?>
          <form action="" method="post" class="space-y-4" novalidate>
            <div>
              <label for="name" class="block text-sm font-medium mb-1">Nama Lengkap</label>
              <input type="text" id="name" name="name" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Nama lengkap" required value="<?php echo htmlspecialchars($old['name'], ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div>
              <label for="email" class="block text-sm font-medium mb-1">Email</label>
              <input type="email" id="email" name="email" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="nama@email.com" required value="<?php echo htmlspecialchars($old['email'], ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div>
              <label for="whatsapp" class="block text-sm font-medium mb-1">WhatsApp (opsional)</label>
              <input type="text" id="whatsapp" name="whatsapp" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="mis. +6281234567890" value="<?php echo htmlspecialchars($old['whatsapp'], ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div>
              <label for="password" class="block text-sm font-medium mb-1">Password</label>
              <div class="relative">
                <input type="password" id="password" name="password" class="w-full rounded-md border border-gray-300 pr-10 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="••••••••" required>
                <button type="button" class="absolute inset-y-0 right-0 px-3 grid place-items-center text-gray-500 hover:text-gray-700" aria-label="Toggle password" data-toggle="password" data-target="password" aria-pressed="false">
                  <span class="pointer-events-none">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                  </span>
                </button>
              </div>
            </div>
            <div>
              <label for="password_confirmation" class="block text-sm font-medium mb-1">Konfirmasi Password</label>
              <div class="relative">
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full rounded-md border border-gray-300 pr-10 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="••••••••" required>
                <button type="button" class="absolute inset-y-0 right-0 px-3 grid place-items-center text-gray-500 hover:text-gray-700" aria-label="Toggle password" data-toggle="password" data-target="password_confirmation" aria-pressed="false">
                  <span class="pointer-events-none">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                  </span>
                </button>
              </div>
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
      <div class="mt-8 text-xs text-gray-500">  <?php echo date('Y'); ?> KF olx. All rights reserved.</div>
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
      const togglers = document.querySelectorAll('[data-toggle="password"]');
      togglers.forEach(function(t){
        t.addEventListener('click', function(){
          const targetId = t.getAttribute('data-target');
          const input = document.getElementById(targetId);
          if (!input) return;
          const isPassword = input.getAttribute('type') === 'password';
          input.setAttribute('type', isPassword ? 'text' : 'password');
          t.setAttribute('aria-pressed', String(isPassword));
        });
      });
    })();
  </script>
</body>
</html>
