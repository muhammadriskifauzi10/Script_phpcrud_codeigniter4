<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>
  <link rel="stylesheet" href="<?= base_url('/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('/css/mystyle.css'); ?>">
</head>

<body>

  <?= $this->include('layouts/navbar'); ?>
  <?= $this->renderSection('section'); ?>

  <script src="<?= base_url('/js/bootstrap.bundle.min.js'); ?>"></script>

  <script>
    function imgPreview() {
      const imgPreview = document.querySelector('#img-preview');
      const gambar = document.querySelector('#gambar');

      const fileGambar = new FileReader()
      fileGambar.readAsDataURL(gambar.files[0])

      fileGambar.onload = function(e) {
        imgPreview.src = e.target.result
      }
    }
  </script>
</body>

</html>