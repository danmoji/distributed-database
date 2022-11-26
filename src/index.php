<html>

<head>
  <title>Hello World</title>
  <link rel="stylesheet" href="style.css">
  <style>
    nav {
      background-color:
        <?php
        echo $_ENV["HOST_THEME_COLOR"];
        ?>;
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <?php
  include_once 'includes/header.php';
  include_once 'classes/Note.class.php';

  ?>
  <main>
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <?php include_once './includes/note-form.php' ?>
        </div>
        <div class="col">
          <?php include_once './includes/note-list.php' ?>
        </div>
      </div>

    </div>

  </main>

</body>

</html>