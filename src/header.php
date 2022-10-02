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
      display: flex;
      align-content: center;
    }

    nav ul li a {
      background:
        <?php
        echo $_ENV["HOST_THEME_COLOR"];
        ?>
    }
  </style>
</head>

<body>
  <nav>

    <div class="system-info">

      <?php
      echo $_ENV["HOST_NAME"];
      ?>
    </div>
    <ul>
      <div>
        <li><a href="/">Domov</a></li>
        <li><a href="info.php">Info</a></li>
      </div>
      <div>
        <li>
          <form action="migrate.php" method="post">
            <button type="submit">Migrate host</button>
          </form>
        </li>
        <li>
          <form action="migrate-all.php" method="post">
            <button type="submit">Migrate all nodes</button>
          </form>
      </li>
      </div>
    </ul>
  </nav>