<?php
$query = mysqli_query($koneksi, "SELECT * FROM contacts ORDER BY id DESC");
$rows  = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="pagetitle">
    <h1>Data Contact</h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Contact</h5>

                    <div class="mb-3" align="right">
                        <a href="?page=tambah-contact" class="btn btn-primary">Tambah</a>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Map</th>

                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php foreach ($rows as $key => $row): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= htmlspecialchars($row['phone']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td>
                                        <?php if (!empty($row['map_embed'])): ?>
                                            <div style="width:100%; max-width:300px; overflow:hidden; border-radius:8px;">
                                                <?= $row['map_embed'] ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">Tidak ada map</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="?page=tambah-contact&edit=<?= $row['id'] ?>" class="btn btn-sm btn-success">Edit</a>
                                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"
                                            href="?page=tambah-contact&delete=<?= $row['id'] ?>"
                                            class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</section>