<?php
/**
 * @var \App\Models\Exercise $exercise The exercise being taken.
 * @var \App\Models\Field[] $fields The fields of the exercise.
 * @var \App\Models\Fulfillment|null $fulfillment The fulfillment being edited, or null for a new one.
 * @var array $answers An array of answers for the fulfillment, indexed by field_id.
 * @var string $form_action The URL to submit the form to.
 */

$is_editing = $fulfillment !== null;
?>

<h1><?= htmlspecialchars($title) ?></h1>

<?php if ($is_editing): ?>
    <p>Bookmark this page, it's yours. You'll be able to come back later to finish.</p>
<?php else: ?>
    <p>If you'd like to come back later to finish, simply submit it with blanks.</p>
<?php endif; ?>

<form action="<?= $form_action ?>" method="post">
    <?= csrf_field() ?>
    <?php if ($is_editing): ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif; ?>

    <?php foreach ($fields as $field):
        $answer_value = $answers[$field->id] ?? '';
        ?>
        <div class="field">
            <label for="answer_<?= $field->id ?>"><?= htmlspecialchars($field->label) ?></label>
            <?php
            // Render the correct input type based on the field's value_kind.
            switch ($field->value_kind) {
                case 'multi_line':
                case 'single_line_list':
                    $placeholder = ($field->value_kind == 'single_line_list') ? 'Enter each item on a new line.' : '';
                    ?>
                    <textarea name="answers[<?= $field->id ?>]" id="answer_<?= $field->id ?>" placeholder="<?= $placeholder ?>"><?= htmlspecialchars($answer_value) ?></textarea>
                    <?php
                    break;
                case 'single_line':
                default:
                    ?>
                    <input type="text" name="answers[<?= $field->id ?>]" id="answer_<?= $field->id ?>" value="<?= htmlspecialchars($answer_value) ?>">
                    <?php break;
            } ?>
        </div>
    <?php endforeach; ?>

    <div class="actions">
        <input type="submit" value="Save">
    </div>
</form>