<?php
// Ambil data dari tabel services
$query = mysqli_query($koneksi, "SELECT * FROM services ORDER BY id ASC");
$rows  = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="pagetitle">
  <h1>Data Services</h1>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Data Layanan</h5>

          <div class="mb-3 text-end">
            <a href="?page=tambah-service" class="btn btn-primary">Tambah</a>
          </div>

          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th width="5%">No</th>
                <th width="10%">Icon</th>
                <th width="20%">Judul</th>
                <th width="30%">Deskripsi</th>
                <th width="15%">Link</th>
                <th width="20%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $i => $row): ?>
                  <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                      <?php if (!empty($row['icon'])): ?>
                        <img src="uploads/services/<?= htmlspecialchars($row['icon']) ?>" 
                             alt="icon" width="40" height="40" class="img-fluid">
                      <?php else: ?>
                        <span class="text-muted">Tidak ada</span>
                      <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td>
                      <?php if (!empty($row['link'])): ?>
                        <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-sm btn-info">
                          Lihat
                        </a>
                      <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="?page=tambah-service&edit=<?= $row['id'] ?>" 
                         class="btn btn-sm btn-success">Edit</a>
                      <a href="?page=tambah-service&delete=<?= $row['id'] ?>"
                         onclick="return confirm('Apakah Anda yakin akan menghapus data ini?')"
                         class="btn btn-sm btn-danger">Delete</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center text-muted">Belum ada data layanan.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</section>
