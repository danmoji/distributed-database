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
  </ul>
</nav>
</header>