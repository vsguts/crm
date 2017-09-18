<?php

use yii\db\Migration;

class m161129_081655_print_template_items_per_page extends Migration
{
    public function up()
    {
        $this->addColumn('print_template', 'items_per_page', $this->smallInteger()->notNull()->defaultValue(0)->after('margin_right'));

        // Meanwhile
        $this->alterColumn('print_template', 'margin_top', $this->smallInteger()->notNull()->defaultValue(0));
        $this->alterColumn('print_template', 'margin_bottom', $this->smallInteger()->notNull()->defaultValue(0));
        $this->alterColumn('print_template', 'margin_left', $this->smallInteger()->notNull()->defaultValue(0));
        $this->alterColumn('print_template', 'margin_right', $this->smallInteger()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('print_template', 'items_per_page');

        // Meanwhile
        $this->alterColumn('print_template', 'margin_top', $this->integer());
        $this->alterColumn('print_template', 'margin_bottom', $this->integer());
        $this->alterColumn('print_template', 'margin_left', $this->integer());
        $this->alterColumn('print_template', 'margin_right', $this->integer());
    }

}
