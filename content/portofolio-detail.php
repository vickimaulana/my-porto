<?php
// 🔹 Ambil semua data portofolio dari tabel 'portofolios'
$queryPortofolio = mysqli_query($koneksi, "SELECT * FROM portofolios ORDER BY id DESC");
$rowPortofolio = mysqli_fetch_all($queryPortofolio, MYSQLI_ASSOC);

// 🔹 Ambil daftar kategori unik
$queryCategories = mysqli_query($koneksi, "SELECT DISTINCT category FROM portofolios ORDER BY category ASC");
$categories = [];
while ($c = mysqli_fetch_assoc($queryCategories)) {
    $categories[] = $c['category'];
}


// 🔹 Fungsi untuk membuat slug dari kategori (contoh: "Web Design" → "web-design")
function slugify($text)
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}
?>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

<!-- Portfolio Section -->
<section id="portofolio-detail" class="portfolio section bg-light">
    <div class="container section-title" data-aos="fade-up">
        <h2>All Portofolio</h2>
        <p>A collection of works and projects that have been completed.</p>
    </div>

    <div class="container">
        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

            <!-- 🔹 Filter Kategori -->
            <ul class="portfolio-filters isotope-filters mb-4 text-center" data-aos="fade-up" data-aos-delay="100">
                <li data-filter="*" class="filter-active">All</li>
                <?php foreach ($categories as $cat): ?>
                    <?php $catSlug = slugify($cat); ?>
                    <li data-filter=".filter-<?= $catSlug ?>">
                        <?= ucfirst(htmlspecialchars($cat)) ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- 🔹 Semua Portofolio -->
            <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
                <?php foreach ($rowPortofolio as $p): ?>
                    <?php
                    $catSlug  = slugify($p['category']); // slug kategori untuk filter
                    $catClass = 'filter-' . $catSlug;
                    $imgFile  = !empty($p['image']) ? htmlspecialchars($p['image']) : 'no-image.png';
                    ?>
                    <div class="col-lg-4 col-md-6 isotope-item <?= $catClass; ?>">
                        <div class="card h-100 shadow-sm border-0">

                            <!-- 🔹 Gambar Portofolio -->
                            <img src="admin/uploads/<?= $imgFile ?>"
                                class="portfolio-card-img"
                                alt="<?= htmlspecialchars($p['title']) ?>">

                            <!-- 🔹 Isi card -->
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($p['title']) ?></h5>
                                <p class="card-text small text-muted">
                                    <?= htmlspecialchars($p['description']) ?>
                                </p>

                                <!-- 🔹 Tags (pisah koma → jadi badge) -->
                                <?php if (!empty($p['tags'])): ?>
                                    <div class="mb-2">
                                        <?php foreach (explode(',', $p['tags']) as $tag): ?>
                                            <span class="badge-tag me-1">
                                                #<?= htmlspecialchars(trim($tag)) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- 🔹 Bagian footer (zoom & link eksternal) -->
                            <div class="card-footer d-flex justify-content-between bg-white border-0">
                                <!-- Zoom (popup gambar) -->
                                <a href="admin/uploads/<?= $imgFile ?>"
                                    title="<?= htmlspecialchars($p['title']) ?>"
                                    data-gallery="portofolio-gallery-<?= $catSlug ?>"
                                    class="glightbox preview-link text-decoration-none">
                                    <i class="bi bi-zoom-in fs-5"></i>
                                </a>

                                <!-- Link eksternal (opsional) -->
                                <?php if (!empty($p['link'])): ?>
                                    <a href="<?= htmlspecialchars($p['link']) ?>"
                                        title="More Details"
                                        class="details-link text-decoration-none"
                                        target="_blank" rel="noopener">
                                        <i class="bi bi-link-45deg fs-5"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- 🔹 Tombol Kembali -->
            <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="300">
                <a href="?page=home" class="btn btn-outline-secondary">
                    ⬅️ Back to Homepage
                </a>
            </div>
        </div>
    </div>
</section>