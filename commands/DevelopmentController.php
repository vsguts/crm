<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\db\Query;

class DevelopmentController extends Controller
{
    /**
     * Remove sensitive information
     */
    public function actionPrepareDb()
    {
        $cmd = function(){
            return Yii::$app->db->createCommand();
        };


        /**
         * Users
         */
        
        $cmd()->update('user', [ // Auth: root@example.com/admin1
            'id' => 1,
            'email' => 'root@example.com',
            'name' => 'Root Admin',
            'auth_key' => 'nPG7M3jo41o8rdWt7ixqyVKeD9W-P3yc',
            'password_hash' => '$2y$13$UHlh5k62toggwD7aTzS4N.WHOy82oJ.RFc8iHroj2EwV2bz5sd.Yu',
            'password_reset_token' => null,
            'status' => 1,
        ], ['id' => 1])->execute();

        $cmd()->update('user', [ // Change passwords to "admin1"
            'auth_key' => 'nPG7M3jo41o8rdWt7ixqyVKeD9W-P3yc',
            'password_hash' => '$2y$13$UHlh5k62toggwD7aTzS4N.WHOy82oJ.RFc8iHroj2EwV2bz5sd.Yu',
            'password_reset_token' => null,
        ], ['>', 'id', 1])->execute();


    }

}
