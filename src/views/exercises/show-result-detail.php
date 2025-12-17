<h1><?= htmlspecialchars($field->label) ?></h1>

<table>
    <thead>
        <tr>
            <th>Take</th>
            <?php foreach($fields as $field){ ?>
            <th>Content</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($fulfillments as $fulfillment) { ?>
        <tr>
            <td><a href="/exercises/<?= $exercise->id ?>/results/<?= $fulfillment->id ?>"><?= $fulfillment ? htmlspecialchars($fulfillment->timestamp) . " UTC" : null ?></a></td>
            <?php foreach ($answers[$fulfillment->id] as $answer) { ?>
                <td class="result">
                <?php
                    if ($answer !== null) {
                        echo nl2br(htmlspecialchars($answer));
                    } else {
                        echo 'No answer provided.';
                    }
                ?></td>
            <?php } ?>
        </tr>
     <?php } ?>
    </tbody>
</table>