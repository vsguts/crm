<?php

echo $form->field($model, 'roles')->checkboxList($model->getAllRoles(['plain' => true, 'exclude_self' => true]), ['unselect' => null])->label('');
