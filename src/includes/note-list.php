<?php
require_once 'scripts/delete-data.php'
?>
  <h2 class="mx-3">List of Notes:</h2>
  
  <div class="border bg-light" style="height: 100%; max-height: 80vh; overflow-y: scroll">
  <?php
  include_once 'classes/Note.class.php';
  $notes = Note::fetchAllNotesFromDb();

  foreach ($notes as $note) { ?>
    <div class="card m-3">
      <div class="card-body">
        <h5 class="card-title"><?php echo $note['note_title'] ?></h5>
        <p class="card-text"><?php echo $note['note_description'] ?></p>
        <div class="d-flex justify-content-end">

        <form class="delete-form ml-3" action="scripts/edit-data.php" method="post">
          <input type="text" name="note_title" hidden value="<?php echo $note['note_title'] ?>">
          <input type="text" name="note_description" hidden value="<?php echo $note['note_description'] ?>">
          <input type="text" name="note_hash_key" hidden value="<?php echo $note['note_hash_key'] ?>">
          <button type="submit" class="btn btn-light text-primary">Edit </button>
        </form>

        <form class="delete-form mx-3" action="scripts/delete-data.php" method="post">
          <input type="text" name="note_hash_key" hidden value="<?php echo $note['note_hash_key'] ?>">
          <button type="submit" class="btn btn-light">Delete</button>
        </form>
        </div>

      </div>
    </div>
  <?php } ?>

</div>