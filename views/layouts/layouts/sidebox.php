<?php
$sidebox_size = !empty($this->params['sidebox_size']) ? $this->params['sidebox_size'] : 2;
$content_size = 12 - $sidebox_size;
?>

<div class="row">
    <div class="col-sm-<?= $sidebox_size ?>">
        <?= $this->blocks['sidebox'] ?>
    </div>
    <div class="col-sm-<?= $content_size ?>">
        <?= $breadcrumbs ?>
        <?= $alerts ?>
        <?= $content ?>
    </div>
</div>