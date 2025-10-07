<ul class="ansering-list">
    <?php foreach ( $exercises as $exercise ) { ?>
    <li class="row">
      <div class="column card">
        <div class="title"><?= $exercice->title ?></div>
        <a class="button" href="" disabled>Take it</a>
      </div>
    </li>
    <?php } ?>
</ul>