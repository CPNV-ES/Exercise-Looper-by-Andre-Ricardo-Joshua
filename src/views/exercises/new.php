<h1>New Exercise</h1>

<?php display_flash_messages(); ?>

<form action="/exercises" accept-charset="UTF-8" method="post">
    <?= csrf_field() ?>
  <div class="field">
    <label for="exercise_title">Title</label>
    <input type="text" minlength="4" name="exercise[title]" id="exercise_title" required>
  </div>
  <div class="actions">
    <input type="submit" name="commit" value="Create Exercise" data-disable-with="Create Exercise" onclick="if(document.getElementById('exercise_title').value.trim().length < 4) { alert('Must have at least 4 characters'); return false; } ">
  </div>
</form>