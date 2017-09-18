<?php
// Default values
$sidebox_side = !empty($this->params['sidebox_side']) ? $this->params['sidebox_side'] : 'left';
$sidebox_size = !empty($this->params['sidebox_size']) ? $this->params['sidebox_size'] : 2;
$content_size = 12 - $sidebox_size;

$this->beginBlock('sidebox');
echo <<<EOF
    <div class="col-sm-{$sidebox_size}">
        {$this->blocks['sidebox']}
    </div>
EOF;
$this->endBlock();

?>

<div class="row">

    <?= $sidebox_side == 'left' ? $this->blocks['sidebox'] : '' ?>

    <div class="col-sm-<?= $content_size ?>">
        <?= $this->render('simple', [
            'breadcrumbs' => $breadcrumbs,
            'alerts' => $alerts,
            'content' => $content,
        ]); ?>
    </div>

    <?= $sidebox_side == 'right' ? $this->blocks['sidebox'] : '' ?>

</div>
