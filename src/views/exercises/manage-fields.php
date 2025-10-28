<div class="row">
  <section class="column">
    <h1>Fields</h1>
    <table class="records">
      <thead>
        <tr>
          <th>Label</th>
          <th>Value kind</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($fields)): ?>
          <tr>
            <td colspan="3">No fields have been added to this exercise yet.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($fields as $field): ?>
            <tr>
              <td><?= htmlspecialchars($field->label) ?></td>
              <td><?= htmlspecialchars($field->value_kind) ?></td>
              <td>
                <a title="Edit" href="/exercises/<?= $exerciseId ?>/fields/<?= $field->id ?>/edit"><i class="fa fa-edit"></i></a>
                <form id="delete-form-<?= $field->id ?>" action="/exercises/<?= $exerciseId ?>/fields/<?= $field->id ?>" method="POST" style="display: none;">
                    <input type="hidden" name="_method" value="DELETE">
                    <?= csrf_field() ?>
                </form>
                <a href="#" title="Destroy" onclick="if (confirm('Are you sure?')) { document.getElementById('delete-form-<?= $field->id ?>').submit(); } return false;"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
    <form action="/exercises/<?= $exerciseId ?>" method="POST" onsubmit="return confirm('Are you sure? You won\'t be able to further edit this exercise');" style="display: inline;">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="exercise[status]" value="answering">
        <?= csrf_field() ?>
        <button type="submit" class="button">
            <i class="fa fa-comment"></i> Complete and be ready for answers
        </button>
    </form>
  </section>
  <section class="column">
    <h1>New Field</h1>
    <form action="/exercises/<?= $exerciseId ?>/fields" method="post">
      <?= csrf_field() ?>
      <div class="field">
        <label for="field_label">Label</label>
        <input type="text" name="field[label]" id="field_label">
      </div>
      <div class="field">
        <label for="field_value_kind">Value kind</label>
        <select name="field[value_kind]" id="field_value_kind">
          <option selected="selected" value="single_line">Single line text</option>
          <option value="single_line_list">List of single lines</option>
          <option value="multi_line">Multi-line text</option>
        </select>
      </div>
      <div class="actions">
        <input type="submit" name="commit" value="Create Field" data-disable-with="Create Field">
      </div>
    </form>
  </section>
</div>