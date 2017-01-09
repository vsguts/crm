<?php

echo $form->field($model, 'roles')->checkboxList($roles, [
    'id' => $form_id . '-roles',
    'unselect' => null,
]);
