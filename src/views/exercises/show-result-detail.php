<h1><?= $fields->label ?></h1>
<table>
    <thead>
        <tr>
            <th>Take</th>
            <th>Content</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($fulfillments as $fulfillment) { ?>
        <tr>
            <td>
                <a href="/exercises/<?= $exercise->id ?>/fulfillments/<?= $fulfillment->id ?>"><?= $fulfillment ? $fulfillment->timestamp . " UTC" : null ?></a>
            </td>
            <td>
                <?php 
                    if (isset($answers[$fulfillment->id])) {
                        echo nl2br(htmlspecialchars($answers[$fulfillment->id]));
                    } else {
                        echo "No answer provided";
                    }
                ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php 
// Debug
// var_dump($fulfillments);
// var_dump($answers);
// var_dump($fields);
?>