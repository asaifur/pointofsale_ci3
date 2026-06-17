<section class="hero-card" style="padding:18px">
  <h1 style="margin-top:0"><?php echo htmlspecialchars($project->title); ?></h1>
  <div class="text-muted" style="margin-bottom:8px"><?php echo $project->location ? htmlspecialchars($project->location).' • ' : ''; ?><?php echo $project->client ? htmlspecialchars($project->client) : ''; ?> <?php echo $project->value ? '• '.$project->value : ''; ?> <?php echo $project->year ? '• '.$project->year : ''; ?></div>

  <?php if(!empty($images)): ?>
    <div style="display:flex;gap:8px;overflow:auto;margin-bottom:12px">
      <?php foreach($images as $img): ?>
        <div style="min-width:180px;border-radius:8px;overflow:hidden;box-shadow:0 6px 12px rgba(11,37,64,0.04)">
          <img src="<?php echo base_url('assets/img/projects/'. $img->filename); ?>" alt="<?php echo htmlspecialchars($img->caption); ?>" style="width:100%;height:120px;object-fit:cover;display:block;">
          <?php if($img->caption): ?><div style="padding:6px;font-size:13px;color:var(--muted)"><?php echo htmlspecialchars($img->caption); ?></div><?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div style="line-height:1.7">
    <?php echo $project->content; // content contains HTML trusted from admin/seed ?>
  </div>

  <div style="margin-top:14px">
    <a class="cta" href="<?php echo site_url('korra/projects'); ?>">Kembali ke Projects</a>
  </div>
</section>
