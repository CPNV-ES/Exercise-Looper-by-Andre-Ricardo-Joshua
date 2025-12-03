<div class="row">
  <section class="column">
    <h1>Building</h1>
    <table class="records">
      <thead>
        <tr>
          <th>Title</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ( $exercisesBuilding as $exercise ) { ?>
        <tr>
            <td><?= $exercise->title ?></td>
            <td>
                <form id="answer-form-<?= $exercise->id ?>" action="/exercises/<?= $exercise->id ?>" method="POST" onsubmit="return confirm('Are you sure? You won\'t be able to further edit this exercise');" style="display: inline;">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="exercise[status]" value="answering">
                    <?= csrf_field() ?>
                </form>
                <a href="#" title="Answer" onclick="if (confirm('Are you sure?')) { document.getElementById('answer-form-<?= $exercise->id ?>').submit(); } return false;"><i class="fa fa-comment icons"></i></a>
                <a title="Manage fields" href="/exercises/<?= $exercise->id ?>/fields"><i class="fa fa-edit"></i></a>
                <form id="delete-form-building-<?= $exercise->id ?>" action="/exercises/<?= $exercise->id ?>" method="POST" style="display: none;">
                    <input type="hidden" name="_method" value="DELETE">
                    <?= csrf_field() ?>
                </form>
                <a href="#" title="Destroy" onclick="if (confirm('Are you sure?')) { document.getElementById('delete-form-building-<?= $exercise->id ?>').submit(); } return false;"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </section>

  <section class="column">
    <h1>Answering</h1>
    <table class="records">
      <thead>
        <tr>
          <th>Title</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ( $exercisesAnswering as $exercise ) { ?>
          <tr>
            <td><?= $exercise->title ?></td>
            <td>
                <a title="Show results" href="/exercises/<?= $exercise->id ?>/results"><i class="fa fa-chart-bar"></i></a>
                <form id="close-form-<?= $exercise->id ?>" action="/exercises/<?= $exercise->id ?>" method="POST" onsubmit="return confirm('Are you sure? You won\'t be able to further edit this exercise');" style="display: inline;">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="exercise[status]" value="closing">
                    <?= csrf_field() ?>
                </form>
                <a href="#" title="Close" onclick="if (confirm('Are you sure?')) { document.getElementById('close-form-<?= $exercise->id ?>').submit(); } return false;"><i class="fa fa-minus-circle"></i></a>
            </td>
          </tr>
      <?php } ?>
      </tbody>
    </table>
  </section>

  <section class="column">
    <h1>Closed</h1>
    <table class="records">
      <thead>
        <tr>
          <th>Title</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ( $exercisesClosing as $exercise ) { ?>
          <tr>
            <td><?= $exercise->title ?></td>
            <td class="display-buttons-column">
                <a class="a-ajusted-size" title="Show results" href="/exercises/22/results"><i class="fa fa-chart-bar"></i></a>
                <form id="delete-form-closed-<?= $exercise->id ?>" action="/exercises/<?= $exercise->id ?>" method="POST" style="display: none;">
                    <input type="hidden" name="_method" value="DELETE">
                    <?= csrf_field() ?>
                </form>
                <a class="a-ajusted-size" href="#" title="Destroy" onclick="if (confirm('Are you sure?')) { document.getElementById('delete-form-closed-<?= $exercise->id ?>').submit(); } return false;"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </section>
</div>
