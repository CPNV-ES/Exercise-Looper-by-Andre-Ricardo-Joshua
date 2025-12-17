<h1><?= $field->label ?></h1>
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
                        echo "<font color=\"red\">No answer provided</font>";
                    }
                ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>