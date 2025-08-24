<?php
// Query data portofolio
$query = mysqli_query($koneksi, "SELECT * FROM portofolios ORDER BY id DESC");
$rowPortofolio = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Helper slugify
function slugify($text)
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    return strtolower($text ?: 'n-a');
}
?>

<!-- ====== Portfolio Section ====== -->
<section id="portfolio" class="portfolio section py-5">

    <div class="container" data-aos="fade-up">
        <h2 class="mb-4 text-center ">Portofolio</h2>
        <p class="mb-4 text-center">Ini portofolio yang sudah saya kerjakan.</p>
        <!-- Filter Buttons -->
        <ul class="portfolio-filters list-inline mb-4 text-center">
            <li class="list-inline-item filter-active" data-filter="*">All</li>
            <?php
            $categories = array_unique(array_column($rowPortofolio, 'category'));
            foreach ($categories as $cat):
                $catSlug = slugify($cat);
            ?>
                <li class="list-inline-item" data-filter=".filter-<?= $catSlug ?>"><?= htmlspecialchars($cat) ?></li>
            <?php endforeach; ?>
        </ul>

        <!-- Portfolio Grid -->
        <div class="row gy-4 isotope-container">
            <?php foreach ($rowPortofolio as $p): ?>
                <?php
                $catSlug = slugify($p['category']);
                $imgFile = !empty($p['image']) ? htmlspecialchars($p['image']) : 'no-image.png';
                ?>
                <div class="col-lg-4 col-md-6 isotope-item filter-<?= $catSlug ?>">
                    <div class="card h-100 shadow-sm border-0">

                        <!-- Image -->
                        <img src="admin/uploads/<?= $imgFile ?>"
                            class="card-img-top"
                            alt="<?= htmlspecialchars($p['title']) ?>"
                            style="height:250px; object-fit:cover; width:100%;">

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($p['title']) ?></h5>
                            <p class="card-text small text-muted"><?= htmlspecialchars($p['description']) ?></p>

                            <!-- Tags -->
                            <div class="mb-2">
                                <?php
                                // Warna badge tanpa 'secondary'
                                $colors = ['primary', 'success', 'danger', 'warning', 'info', 'dark'];
                                $tags = !empty($p['tags']) ? explode(',', $p['tags']) : ['No tags'];
                                foreach ($tags as $tag):
                                    $tag = trim($tag);
                                    $color = $colors[array_rand($colors)];
                                ?>
                                    <span class="badge bg-<?= $color ?> me-1">#<?= htmlspecialchars($tag) ?></span>
                                <?php endforeach; ?>
                            </div>

                            <!-- Footer (Zoom & Link) -->
                            <div class="d-flex justify-content-between bg-white border-0">
                                <a href="admin/uploads/<?= $imgFile ?>"
                                    title="<?= htmlspecialchars($p['title']) ?>"
                                    data-gallery="portofolio-gallery"
                                    class="glightbox preview-link">
                                    <i class="bi bi-zoom-in fs-5"></i>
                                </a>
                                <?php if (!empty($p['link'])): ?>
                                    <a href="<?= htmlspecialchars($p['link']) ?>" target="_blank" rel="noopener" class="details-link text-decoration-none">
                                        <i class="bi bi-link-45deg fs-5"></i>
                                    </a>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- ====== CSS Library ====== -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">

<!-- ====== JS Library ====== -->
<script src="https://cdn.jsdelivr.net/npm/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
    // Isotope Init
    document.addEventListener('DOMContentLoaded', function() {
        let iso = new Isotope('.isotope-container', {
            itemSelector: '.isotope-item'
        });

        // Filter buttons
        document.querySelectorAll('.portfolio-filters li').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelector('.portfolio-filters .filter-active')?.classList.remove('filter-active');
                this.classList.add('filter-active');
                let filter = this.getAttribute('data-filter');
                iso.arrange({
                    filter: filter
                });
            });
        });

        // GLightbox Init
        GLightbox({
            selector: '.glightbox'
        });
    });
</script>