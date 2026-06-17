<div class="hero-card">
  <h3>Terima kasih!</h3>
  <p>Pesan Anda telah tersimpan dengan ID: <?php echo $insert_id; ?></p>
  <?php if($email_sent): ?>
    <p class="text-muted">Notifikasi email berhasil dikirim ke admin.</p>
  <?php else: ?>
    <p class="text-muted">Gagal mengirim email notifikasi. Silakan hubungi kami langsung: korra@korra.co.id</p>
  <?php endif; ?>
  <a class="cta" href="<?php echo site_url('korra'); ?>">Kembali ke Beranda</a>
</div>
