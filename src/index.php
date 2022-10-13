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

      <div>
        <li><a href="/">Domov</a></li>
        <?php
        $pmaLink = 'http://' . $_ENV["HOST_ADRESS"] . ':' . $_ENV["HOST_PMA_PORT"];
        echo  "<li><a href=$pmaLink target='none'>PhpMyAdmin</a></li>";
        ?>
      </div>
      <div>
        <li>
          <form id="migrate-person-form" action="migrate-person.php" method="post">
            <button type="submit">Migrate Host</button>
          </form>
        </li>
        <li>
          <form action="script.php" method="get">
          <button type="submit">Ping nodes</button>
        </form>
      </li>
      </div>
    </ul>
  </nav>
  <main>
    <form class="main-form" action="save-data.php" method="post">
      <h3>Formulár</h3>
      <label for="name">
        Meno
        <input type="text" name="name" id="name">
      </label>
      <button type="submit">Odoslať</button>
    </form>
    <table>
      <thead>
        <th>id</th>
        <th>info</th>
        <th>creator_nodes_name</th>

      </thead>
      <tbody>

        <?php
        include_once './pdo.php';
        $sql = "SELECT * FROM person";
        $stmt = pdo()->query($sql);
        while ($row = $stmt->fetch()) {
          echo '<tr>';
          echo '<td>' . $row['person_id'] . '</td>' . '<td>' . $row['personal_information'] . '</td>' . '<td>' . $row['creator_nodes_name'] . '</td>';
          echo '</tr>';
          echo  "<br />\n";
        };

        // $stmt = $pdo->query("SELECT * FROM users");
        // while ($row = $stmt->fetch()) {
        // echo $row['name']."<br />\n";
        ?>
      </tbody>
    </table>
  </main>


</body>

</html>