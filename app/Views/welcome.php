<?= $this->extend('layouts/template'); ?>

<?= $this->section('section'); ?>

<div class="container mt-4">
  <div class="row">
    <div class="col-lg-12">
      <h3>Daftar Nama Orang</h3>
      <div class="mt-3">
        <a href="/tambahdata" class="btn btn-primary">Tambah Data</a>
      </div>
      <table class="table mt-3">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Gambar</th>
            <th scope="col">Name</th>
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">Tanggal Masuk</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($data) > 0) : ?>
            <?php $no = 1; ?>
            <?php foreach ($data as $row) : ?>
              <tr>
                <th scope="row"><?= $no++; ?></th>
                <td>
                  <img src="<?= base_url('/img/' . $row['gambar']); ?>" class="sampul" />
                </td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['jenis_kelamin']; ?></td>
                <td><?= $row['created_at']; ?></td>
                <td>
                  <a href="<?= base_url('/detail/' . $row['slug']); ?>" class="btn btn-info text-light">Detail</a>
                  |
                  <a href="<?= base_url('/edit/' . $row['slug']); ?>" class="btn btn-warning text-light">Edit</a>
                  |
                  <form action="<?= base_url('/hapus/' . $row['id']); ?>" method="POST" class="d-inline">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="__method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="6">Maaf, data masih kosong!</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endsection(); ?>