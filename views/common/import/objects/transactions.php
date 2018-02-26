<?php

echo $form->field($model, 'bank_account_id')->dropDownList($model->getBankAccounts());
