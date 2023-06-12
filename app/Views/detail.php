<?= $this->extend('layouts/template'); ?>

<?= $this->section('section'); ?>

<div class="container mt-4">
  <div class="row">
    <div class="col-lg-12">
      <h3>Detail <?= $data['name']; ?></h3>
      <div class="d-flex position-relative mt-3">
        <img src="<?= base_url('/img/' . $data['gambar']); ?>" class="flex-shrink-0 me-3 sampul" alt="...">
        <div>
          <h5 class="mt-0"><?= $data['name']; ?></h5>
          <h5 class="mt-0"><?= $data['jenis_kelamin']; ?></h5>
          <p><?= $data['created_at']; ?></p>
          <a href="<?= base_url('/'); ?>" class="stretched-link">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endsection(); ?>