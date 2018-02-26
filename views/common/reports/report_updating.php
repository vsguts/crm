<?php

$updating_now = !empty($updating_now);
$last_timestamp = !empty($last_timestamp) ? $last_timestamp : null;

?>

<?php if ($updating_now) : ?>
    <div class="alert alert-info">
        <?= __("Currently we are recalculating data. Please, visit this page a little bit later to see accurate sums.") ?>
    </div>
<?php endif; ?>

<div class="alert alert-warning" role="alert">
    <strong><?= __('Note') ?>:</strong>
    <?= __("The report is updated each 3 hours (i.e. at 06:00, 09:00, 12:00 etc.). To see the newest data press \"Recalculate\" under the gear icon.") ?>
    <?php if ($last_timestamp) : ?>
        <?= __("Last prepared: {time}", ['time' => Yii::$app->formatter->asDatetime($last_timestamp)]) ?>
    <?php endif ?>
</div>
