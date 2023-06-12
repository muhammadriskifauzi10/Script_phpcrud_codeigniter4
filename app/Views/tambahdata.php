<?= $this->extend('layouts/template'); ?>

<?= $this->section('section'); ?>

<div class="container mt-4">
  <div class="row">
    <div class="col-lg-6">
      <h3>Tambah Data</h3>
      <?php if (session()->getFlashdata('messageSuccess')) : ?>
        <div class="alert alert-success mt-4" role="alert">
          <?= session()->getFlashdata('messageSuccess'); ?>
        </div>
      <?php endif; ?>
      <form class="mt-4" action="<?= base_url('/tambahdata/simpan'); ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" name="name" class="form-control <?= (session()->getFlashdata('name')) ? 'is-invalid' : ''; ?>" id="name" placeholder="Nama" value="<?= (old('name')) ? old('name') : ''; ?>">
          <div class="invalid-feedback">
            <?= session()->getFlashdata('name'); ?>
          </div>
        </div>
        <div class="mb-3">
          <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
          <select name="jenis_kelamin" class="form-select" id="jenis_kelamin">
            <option selected>-- Jenis Kelamin --</option>
            <option value="Laki-Laki" <?= (old('jenis_kelamin') == 'Laki-Laki') ? 'selected' : '' ?>>Laki-Laki</option>
            <option value="Perempuan" <?= (old('jenis_kelamin') == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
          </select>
        </div>
        <div class="mb-3 d-flex align-items-start gap-4">
          <img src="<?= base_url('/img/none.jpg'); ?>" class="sampul" id="img-preview" />
          <div class=" m-0">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" name="gambar" class="form-control <?= (session()->getFlashdata('gambar')) ? 'is-invalid' : ''; ?>" id="gambar" onchange="imgPreview()">
            <div class="invalid-feedback">
              <?= session()->getFlashdata('gambar'); ?>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <button type="submit" class="btn btn-primary">Simpan!</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endsection(); ?>