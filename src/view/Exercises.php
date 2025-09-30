<ul class="ansering-list">
    <?php foreach ( $exercices as $exercice ) { ?>
    <li class="row">
      <div class="column card">
        <div class="title"><?= $exercice['title'] ?></div>
      </div>
    </li>
    <?php } ?>
</ul>