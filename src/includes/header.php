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

    nav ul li .btn {
      background-color: transparent !important;
      text-decoration: none;
    }

    nav ul li .btn:hover {
      text-decoration: underline;
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script>
    //TODO get checkbox element by id
    //TODO get form element by id
    //TODO add event listener on checkbox
    //TODO if checkbox is checked fire a submit on form element
    //document.getElementById("myForm").submit();

    /*
    function doalert(checkboxElem) {
      if (checkboxElem.checked) {
        alert ("hi");
      } else {
        alert ("bye");
      }
    }
    */
  </script>
</head>

<body>
  <header class="mb-3">
    <nav class="px-5 navbar navbar-expand flex justify-content-between">
      <ul class="navbar-nav">
        <li class="text-light p-1 mx-2"><?php echo $_ENV["HOST_NAME"]; ?></li>
        <li><a class="btn btn-link text-light mx-2" href="/">Domov</a></li>
        <li>
          <?php
          $pmaLink = 'http://' . $_ENV["HOST_ADRESS"] . ':' . $_ENV["HOST_PMA_PORT"];
          echo  "<a class='btn btn-link text-light mx-2' href=$pmaLink target='none'>PhpMyAdmin</a>";
          ?>
        </li>
        <li><a class="btn btn-link text-light mx-2" href="php-info.php">php info</a></li>
      </ul>
      <ul class="navbar-nav">
        <li>
          <form id="migrate-person-form" action="scripts/migrate-note.php" method="post">
            <button class="btn btn-link mx-2 text-light" type="submit">Migrate Host</button>
          </form>
        </li>
        <li>
          <form id="migrate-queue-form" action="scripts/migrate-queue.php" method="post">
            <button class="btn btn-link text-light mx-2" type="submit">Migrate Queue</button>
          </form>
        </li>
        <li>
          <div class="form-check form-switch">
            <form action="scripts/switch-connection.php">
              <!-- TODO check if value checked false makes false -->
              <!-- TODO echo the checked value based on ENV variable connection -->
              <input class="form-check-input bg-danger py-1" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked="false">
            </form>
          </div>
        </li>
      </ul>
    </nav>
  </header>
  <main>