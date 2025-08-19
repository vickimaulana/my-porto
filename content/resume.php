<?php
// Query Resume
$queryResumes = mysqli_query($koneksi, "SELECT * FROM resumes ORDER BY start_year DESC");
$rowResumes   = mysqli_fetch_all($queryResumes, MYSQLI_ASSOC);

// Kelompokkan data sesuai type
$nonformal    = array_filter($rowResumes, fn($r) => strtolower($r['type']) === 'nonformal');
$education  = array_filter($rowResumes, fn($r) => strtolower($r['type']) === 'education');
$experience = array_filter($rowResumes, fn($r) => strtolower($r['type']) === 'experience');
$certification = array_filter($rowResumes, fn($r) => strtolower($r['type']) === 'certification');
?>

<section id="resume" class="resume section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Resume</h2>
    <p>Perjalanan pendidikan dan pengalaman profesional saya.</p>
  </div><!-- End Section Title -->

  <div class="container">
    <div class="row">

      <!-- Kolom Kiri -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">

        <!-- Nonformal -->
        <?php if (!empty($nonformal)): ?>
          <h3 class="resume-title">Non Formal</h3>
          <?php foreach ($nonformal as $s): ?>
            <div class="resume-item">
              <h4><?= htmlspecialchars($s['title']) ?></h4>
              <h5><?= htmlspecialchars($s['start_year']) ?> - <?= htmlspecialchars($s['end_year']) ?></h5>
              <p><em><?= htmlspecialchars($s['institution']) ?></em></p>
              <p><?= nl2br(htmlspecialchars($s['description'])) ?></p>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

        <!-- Education -->
        <?php if (!empty($education)): ?>
          <h3 class="resume-title">Education</h3>
          <?php foreach ($education as $edu): ?>
            <div class="resume-item">
              <h4><?= htmlspecialchars($edu['title']) ?></h4>
              <h5><?= htmlspecialchars($edu['start_year']) ?> - <?= htmlspecialchars($edu['end_year']) ?></h5>
              <p><em><?= htmlspecialchars($edu['institution']) ?></em></p>
              <p><?= nl2br(htmlspecialchars($edu['description'])) ?></p>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Kolom Kanan -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
        <!-- Experience -->
        <?php if (!empty($experience)): ?>
          <h3 class="resume-title">Professional Experience</h3>
          <?php foreach ($experience as $exp): ?>
            <div class="resume-item">
              <h4><?= htmlspecialchars($exp['title']) ?></h4>
              <h5><?= htmlspecialchars($exp['start_year']) ?> - <?= htmlspecialchars($exp['end_year']) ?></h5>
              <p><em><?= htmlspecialchars($exp['institution']) ?></em></p>
              <p><?= nl2br(htmlspecialchars($exp['description'])) ?></p>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
            <!-- Sertifikasi-->
        <?php if (!empty($certification)): ?>
          <h3 class="resume-title">Sertifikasi</h3>
          <?php foreach ($certification as $exp): ?>
            <div class="resume-item">
              <h4><?= htmlspecialchars($exp['title']) ?></h4>
              <h5><?= htmlspecialchars($exp['start_year']) ?>  <?= htmlspecialchars($exp['end_year']) ?></h5>
              <p><em><?= htmlspecialchars($exp['institution']) ?></em></p>
              <p><?= nl2br(htmlspecialchars($exp['description'])) ?></p>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>
