<h1><?= $titleExercice ?></h1>
<dl>
    <?php for ($i = 0; $i < count($fields); $i++) { ?>
    <dt><b><?= $fields[$i]->label ?></b></dt>
    <dd><?= $answers[$i + 1] ?></dd>
    <?php } ?>
</dl>