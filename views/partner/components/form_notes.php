
<?= $form->field($model, 'publicTags')->widget('app\widgets\Tags', []); ?>

<?= $form->field($model, 'personalTags')->widget('app\widgets\Tags', []); ?>

<?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

