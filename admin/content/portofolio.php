<?php
// Query JOIN dengan pengecekan error
// Ambil data dari tabel portofolios saja
$sql   = "SELECT * FROM portofolios ORDER BY id ASC";
$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Query error: " . mysqli_error($koneksi));
}

$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

function changeIsActive($isActive)
{
    switch ($isActive) {
        case '1':
            $title = "<span class='badge bg-primary'>Publish</span>";
            break;
        default:
            $title = "<span class='badge bg-secondary'>Draft</span>";
            break;
    }
    return $title;
}
?>

<div class="pagetitle">
    <h1>Data Portofolio</h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Portofolio</h5>

                    <div class="mb-3 text-end">
                        <a href="?page=tambah-portofolio" class="btn btn-primary">Tambah</a>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Kategori</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($rows)): ?>
                                <?php foreach ($rows as $i => $row): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><img src="uploads/<?= $row['image'] ?>" alt="" width="100"></td>
                                        <td><?= $row['id_category'] ?></td>
                                        <td><?= $row['title'] ?></td>
                                        <td><?= changeIsActive($row['is_active']) ?></td>
                                        <td>
                                            <a href="?page=tambah-portofolio&edit=<?= $row['id'] ?>" class="btn btn-sm btn-success">Edit</a>
                                            <a onclick="return confirm('Apakah anda yakin akan menghapus data ini??')"
                                                href="?page=tambah-portofolio&delete=<?= $row['id'] ?>"
                                                class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data portofolio</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>