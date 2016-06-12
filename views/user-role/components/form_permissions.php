<?php

foreach ($model->getAllPermissions() as $section => $permissions) {
    echo $form->field($model, 'permissions')->checkboxList($permissions, ['unselect' => null])->label($section);
}
