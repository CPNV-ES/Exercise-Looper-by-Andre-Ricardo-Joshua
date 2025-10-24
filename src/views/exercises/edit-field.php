<h1>Editing Field</h1>
<div class="row">
    <section class="column">
        <h1>Edit Field</h1>
        <form action="/exercises/<?= $exerciseId ?>/fields/<?= $field->id ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="field">
                <label for="field_label">Label</label>
                <input type="text" name="field[label]" id="field_label" value="<?= htmlspecialchars($field->label) ?>">
            </div>

            <div class="field">
                <label for="field_value_kind">Value kind</label>
                <select name="field[value_kind]" id="field_value_kind">
                    <?php
                    $options = [
                        'single_line' => 'Single line text',
                        'single_line_list' => 'List of single lines',
                        'multi_line' => 'Multi-line text'
                    ];
                    foreach ($options as $value => $label): ?>
                        <option value="<?= $value ?>" <?= ($field->value_kind === $value) ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="actions">
                <input type="submit" value="Update Field">
            </div>
        </form>
    </section>
</div>