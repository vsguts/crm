<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Partners');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php echo $this->render('_search', ['model' => $searchModel, 'tags' => $tags]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create partner'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            
            'id',

            ['class' => 'app\widgets\grid\LinkedTextColumn', 'attribute' => 'name'],
            // 'name',
            // 'firstname',
            // 'lastname',
            ['attribute' => 'typeName', 'label' => Yii::t('app', 'Type')],
            ['attribute' => 'statusName', 'label' => Yii::t('app', 'Status')],
            'email:email',
            // 'country_id',
            // 'state_id',
            // 'state',
            // 'city',
            // 'address',
            // 'church_id',
            // 'volunteer',
            // 'candidate',
            // 'notes:ntext',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{delete}'], // FIXME
        ],
    ]); ?>

</div>
