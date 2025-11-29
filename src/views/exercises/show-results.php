<table>
    <thead>
        <tr>
            <th>Take</th>
            <th><a href="#">Titre de la question (à remplir)</a></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($fulfillments as $fulfillment) { ?>
        <tr>
            <td><a href="#"><?= $fulfillment ? $fulfillment->timestamp : null ?></a></td>
        </tr>
     <?php } ?>
    </tbody>
</table>

