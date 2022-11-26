<form class="flex p-5 border" action="scripts/save-data.php" method="post">
  <h3>Create Note</h3>
  <div class="form-floating">
    <input required style="width: 500px;" type="text" name="note_title" id="note_title" class="form-control mb-3" placeholder="Todo: clean up the room.">
    <label for="note_title">Note title</label>
  </div>
  <div class="form-floating mb-3">
    <textarea required style="height: 200px; width: 500px;" class="form-control" placeholder="Write your note description here." id="note_description" name="note_description"></textarea>
    <label for="note_description">Note Description</label>
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
</form>