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

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Icon</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Link</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td>
                                        <!-- Menampilkan icon dari database -->
                                        <i class="<?= $row['icon'] ?>" style="font-size: 24px;"></i>
                                    </td>
                                    <td><?= $row['title'] ?></td>
                                    <td><?= $row['description'] ?></td>
                                    <td>
                                        <?php if ($row['link']): ?>
                                            <a href="<?= $row['link'] ?>" target="_blank">Lihat</a>
                                        <?php else: ?>
                                            -
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <a href="?page=tambah-service&edit=<?= $row['id'] ?>" class="btn btn-sm btn-success">Edit</a>
                                        <a href="?page=tambah-service&delete=<?= $row['id'] ?>"
                                            onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"
                                            class="btn btn-sm btn-danger">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>