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
    <!-- TODO drop down list with links to other hosts -->
    <div class="system-info">

      <?php
      echo $_ENV["HOST_NAME"];
      ?>
    </div>
    <ul>
      <!-- TODO link with DB connection check -->
      <!-- TODO JS async function that chcekc connection to other nodes -->
      <!-- TODO status bar with connection check to other nodes -->
      <div>
        <li><a href="/">Domov</a></li>
        <li><a href="info.php">Info</a></li>
      </div>
      <div>
        <li>
          <form action="migrate-person.php" method="post">
            <!-- JS popup/modal with confirmation messge -->
            <button type="submit">Migrate host</button>
          </form>
        </li>
        <li>
          <form action="migrate-all-person.php" method="post">
            <!-- JS popup/modal with confirmation messge -->
            <button type="submit">Migrate all nodes</button>
          </form>
      </li>
      </div>
    </ul>
  </nav>