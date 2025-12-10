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
                <td class="answer">
                <?php
                    if(strlen($answer) > 0 && strlen($answer) < 10){
                        echo "<i class=\"fa fa-check short\"></i>";
                    } else if(strlen($answer) > 10){
                        echo "<i class=\"fa fa-check-double filled\"></i>";
                    } else {
                        echo "<i class=\"fa fa-times empty\"></i>";
                    }
                ?></td>
            <?php } ?>
        </tr>
     <?php } ?>
    </tbody>
</table>

