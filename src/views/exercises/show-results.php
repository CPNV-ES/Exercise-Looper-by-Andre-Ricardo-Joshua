<table>
    <thead>
        <tr>
            <th>Take</th>
            <?php foreach($fields as $field){ ?>
            <th><a href="#"><?= $field->label ?></a></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($fulfillments as $fulfillment) { ?>
        <tr>
            <td><a href="#"><?= $fulfillment ? $fulfillment->timestamp : null ?></a></td>
            <?php foreach ($answers[$fulfillment->id] as $answer) { ?>
                <td><?= $answer ?></td>
            <?php } ?>
        </tr>
     <?php } ?>
    </tbody>
</table>

