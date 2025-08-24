<?php
// Koneksi database
include "koneksi.php";

// Ambil data pertama dari tabel settings (jika ada)
$query  = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");
$row    = mysqli_fetch_assoc($query);

// Fungsi upload gambar
function uploadImage($file, $row = [], $field = 'logo', $uploadDir = "uploads/")
{
  if (!empty($file['name'])) {
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $fileName   = time() . "-" . basename($file['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
      // Hapus file lama jika ada
      if (!empty($row[$field]) && file_exists($uploadDir . $row[$field])) {
        unlink($uploadDir . $row[$field]);
      }
      return $fileName;
    }
  }
  return $row[$field] ?? null; // Jika tidak upload baru → pakai lama
}

// Proses simpan data
if (isset($_POST['simpan'])) {
  $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
  $phone    = mysqli_real_escape_string($koneksi, $_POST['phone']);
  $address  = mysqli_real_escape_string($koneksi, $_POST['address']);
  $ig       = mysqli_real_escape_string($koneksi, $_POST['instagram']);
  $fb       = mysqli_real_escape_string($koneksi, $_POST['facebook']);
  $twitter  = mysqli_real_escape_string($koneksi, $_POST['twitter']);
  $linkedin = mysqli_real_escape_string($koneksi, $_POST['linkedin']);

  // Upload file (logo & image)
  $logo_name = uploadImage($_FILES['logo'], $row, 'logo');
  $image_bg  = uploadImage($_FILES['image'], $row, 'image');

  if (!empty($row)) {
    // UPDATE
    $id_setting = $row['id'];
    $update = mysqli_query($koneksi, "UPDATE settings SET 
                        email    = '$email',
                        phone    = '$phone',
                        address  = '$address',
                        logo     = '$logo_name',
                        image    = '$image_bg',
                        twitter  = '$twitter',
                        fb       = '$fb',
                        ig       = '$ig',
                        linkedin = '$linkedin'
                    WHERE id = '$id_setting'");

    if ($update) {
      header("Location: ?page=setting&ubah=berhasil");
      exit;
    }
  } else {
    // INSERT
    $insert = mysqli_query($koneksi, "INSERT INTO settings 
                    (email, phone, address, logo, image, twitter, fb, ig, linkedin) 
                VALUES 
                    ('$email','$phone','$address','$logo_name','$image_bg','$twitter','$fb','$ig','$linkedin')");

    if ($insert) {
      header("Location: ?page=setting&tambah=berhasil");
      exit;
    }
  }
}
?>

<!-- ====== FORM INPUT SETTINGS ====== -->
<div class="pagetitle">
  <h1>Pengaturan Website</h1>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Form Pengaturan</h5>

          <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control"
                value="<?= htmlspecialchars($row['email'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
              <label>Phone</label>
              <input type="text" name="phone" class="form-control"
                value="<?= htmlspecialchars($row['phone'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
              <label>Address</label>
              <textarea name="address" class="form-control" rows="3" required><?= htmlspecialchars($row['address'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
              <label>Logo</label><br>
              <?php if (!empty($row['logo'])): ?>
                <img src="uploads/<?= $row['logo'] ?>" width="100" class="mb-2"><br>
              <?php endif; ?>
              <input type="file" name="logo" class="form-control">
            </div>

            <div class="mb-3">
              <label>Background Image</label><br>
              <?php if (!empty($row['image'])): ?>
                <img src="uploads/<?= $row['image'] ?>" width="150" class="mb-2"><br>
              <?php endif; ?>
              <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
              <label>Facebook</label>
              <input type="text" name="facebook" class="form-control"
                value="<?= htmlspecialchars($row['fb'] ?? '') ?>">
            </div>

            <div class="mb-3">
              <label>Instagram</label>
              <input type="text" name="instagram" class="form-control"
                value="<?= htmlspecialchars($row['ig'] ?? '') ?>">
            </div>

            <div class="mb-3">
              <label>Twitter</label>
              <input type="text" name="twitter" class="form-control"
                value="<?= htmlspecialchars($row['twitter'] ?? '') ?>">
            </div>

            <div class="mb-3">
              <label>LinkedIn</label>
              <input type="text" name="linkedin" class="form-control"
                value="<?= htmlspecialchars($row['linkedin'] ?? '') ?>">
            </div>

            <div class="mb-3">
              <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>