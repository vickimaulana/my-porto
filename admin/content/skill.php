<?php
$query = mysqli_query($koneksi, "SELECT * FROM skills ORDER BY id ASC");
$rows   = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="pagetitle">
    <h1>Data Skills</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Skills</h5>

                    <div class="mb-3 text-end">
                        <a href="?page=tambah-skill" class="btn btn-primary">Tambah</a>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Persentase</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['persentase'] ?></td>
                                    <td>
                                        <a href="?page=tambah-skill&edit=<?= $row['id'] ?>" class="btn btn-sm btn-success">Edit</a>
                                        <a href="?page=tambah-skill&delete=<?= $row['id'] ?>"
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