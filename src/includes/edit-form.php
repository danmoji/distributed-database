<?php 
//chcek the post params and get the note with the id
//populate the form
$noteTitle = $_POST['note_title'];
$noteDescription = $_POST['note_description'];
$noteHashKey = $_POST['note_description'];

?>

<form class="flex p-5 border" action="scripts/save-data.php" method="post">
  <h3>Edit the Note</h3>
  <div class="form-floating">
    <input required style="width: 500px;" type="text" name="note_title" id="note_title" class="form-control mb-3" placeholder="Todo: clean up the room.">
    <label for="note_title">Note title</label>
  </div>
  <div class="form-floating mb-3">
    <textarea required style="height: 200px; width: 500px;" class="form-control" placeholder="Write your note description here." id="note_description" name="note_description" value></textarea>
    <label for="note_description">Note Description</label>
    <input type="text" name="method" hidden value="<?php echo $note['edit'] ?>">
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
  <!-- hidden input with value of edit -->
</form>