<ul class="ansering-list">
    <?php foreach ( $exercises as $exercise ) { ?>
    <li class="row">
      <div class="column card">
        <div class="title"><?= $exercise->title ?></div>
      </div>
    </li>
    <?php } ?>
</ul>