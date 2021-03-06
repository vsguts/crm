<?php

use yii\db\Migration;
use yii\db\Schema;

class m160000_100100_common extends Migration
{
    public function up()
    {
        $this->createTable('lookup', [
            'id'       => $this->primaryKey(),
            'table'    => $this->string(32)->notNull(),
            'field'    => $this->string(32)->notNull(),
            'code'     => $this->string(64)->notNull(),
            'position' => $this->integer()->notNull()->defaultValue(0),
            'name'     => $this->string()->notNull(),
        ], $this->getTableOptions());
        $this->insert('lookup', ['table'=>'user', 'field'=>'status', 'position'=>10, 'code'=>1, 'name'=>'Active']);
        $this->insert('lookup', ['table'=>'user', 'field'=>'status', 'position'=>20, 'code'=>2, 'name'=>'Disabled']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'type', 'position'=>10, 'code'=>1, 'name'=>'People']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'type', 'position'=>20, 'code'=>2, 'name'=>'Organization']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'type', 'position'=>30, 'code'=>3, 'name'=>'NPO']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'type', 'position'=>40, 'code'=>4, 'name'=>'Church']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'status', 'position'=>10, 'code'=>1, 'name'=>'Unachieved']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'status', 'position'=>20, 'code'=>2, 'name'=>'Knows']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'status', 'position'=>30, 'code'=>3, 'name'=>'Interested']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'status', 'position'=>40, 'code'=>4, 'name'=>'Prays']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'status', 'position'=>50, 'code'=>5, 'name'=>'Financial partner']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'email', 'name'=>'E-mail']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'postmail', 'name'=>'Postmail']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'phone', 'name'=>'Phone']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'vk', 'name'=>'VK']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'facebook', 'name'=>'Facebook']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'skype', 'name'=>'Skype']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'viber', 'name'=>'Viber']);
        $this->insert('lookup', ['table'=>'partner', 'field'=>'communication_method', 'code'=>'telegram', 'name'=>'Telegram']);
        $this->insert('lookup', ['table'=>'communication', 'field'=>'type', 'code'=>'email', 'name'=>'E-mail']);
        $this->insert('lookup', ['table'=>'communication', 'field'=>'type', 'code'=>'visit', 'name'=>'Visit']);
        $this->insert('lookup', ['table'=>'communication', 'field'=>'type', 'code'=>'call', 'name'=>'Call']);
        $this->insert('lookup', ['table'=>'print_template', 'field'=>'status', 'position'=>10, 'code'=>1, 'name'=>'Active']);
        $this->insert('lookup', ['table'=>'print_template', 'field'=>'status', 'position'=>20, 'code'=>2, 'name'=>'Disabled']);
        $this->insert('lookup', ['table'=>'print_template', 'field'=>'format', 'position'=>10, 'code'=>'A4', 'name'=>'A4']);
        $this->insert('lookup', ['table'=>'print_template', 'field'=>'format', 'position'=>20, 'code'=>'A5', 'name'=>'A5']);
        $this->insert('lookup', ['table'=>'print_template', 'field'=>'format', 'position'=>30, 'code'=>'C5E', 'name'=>'C5']);
        $this->insert('lookup', ['table'=>'print_template', 'field'=>'format', 'position'=>40, 'code'=>'DLE', 'name'=>'Е65']);
        $this->insert('lookup', ['table'=>'setting', 'field'=>'mailSendMethod', 'position'=>10, 'code'=>'php_mail', 'name'=>'via PHP mail function']);
        $this->insert('lookup', ['table'=>'setting', 'field'=>'mailSendMethod', 'position'=>20, 'code'=>'smtp', 'name'=>'via SMTP server']);
        $this->insert('lookup', ['table'=>'setting', 'field'=>'mailSendMethod', 'position'=>30, 'code'=>'file', 'name'=>'save to local EML files']);
        $this->insert('lookup', ['table'=>'setting', 'field'=>'smtpEncrypt', 'position'=>10, 'code'=>'none', 'name'=>'Disabled']);
        $this->insert('lookup', ['table'=>'setting', 'field'=>'smtpEncrypt', 'position'=>20, 'code'=>'tls', 'name'=>'TLS']);
        $this->insert('lookup', ['table'=>'setting', 'field'=>'smtpEncrypt', 'position'=>30, 'code'=>'ssl', 'name'=>'SSL']);
        $this->insert('lookup', ['table'=>'mailing_list', 'field'=>'status', 'code'=>1, 'position'=>10, 'name'=>'Active']);
        $this->insert('lookup', ['table'=>'mailing_list', 'field'=>'status', 'code'=>2, 'position'=>20, 'name'=>'Disabled']);


        $this->createTable('setting', [
            'name' => Schema::TYPE_STRING . '(128) NOT NULL PRIMARY KEY',
            'value' => $this->text(),
        ], $this->getTableOptions());


        $this->createTable('language', [
            'id'         => $this->primaryKey(),
            'code'       => $this->string()->notNull(),
            'short_name' => $this->string()->notNull(),
            'name'       => $this->string()->notNull(),
        ], $this->getTableOptions());
        $this->insert('language', ['code'=>'en-US', 'name'=>'English', 'short_name'=>'EN']);
        $this->insert('language', ['code'=>'ru-RU', 'name'=>'Русский', 'short_name'=>'RU']);


        $this->createTable('attachment', [
            'id'          => $this->primaryKey(),
            'table'       => $this->string()->notNull(),
            'object_id'   => $this->integer()->notNull(),
            'object_type' => $this->string(32)->notNull()->defaultValue('main'),
            'filename'    => $this->string()->notNull(),
            'filesize'    => $this->integer()->notNull(),
        ], $this->getTableOptions());


        $this->createTable('image', [
            'id'          => $this->primaryKey(),
            'table'       => $this->string()->notNull(),
            'object_id'   => $this->integer()->notNull(),
            'object_type' => $this->string(32)->notNull()->defaultValue('main'),
            'filename'    => $this->string()->notNull(),
            'default'     => $this->integer(),
        ], $this->getTableOptions());


        $this->createTable('country', [
            'id'   => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'code' => $this->string(),
        ], $this->getTableOptions());

        $this->insert('country', ['id' => 1, 'name' => 'Андорра', 'code' => 'AD']);
        $this->insert('country', ['id' => 2, 'name' => 'Объединенные Арабские Эмираты(ОАЭ)', 'code' => 'AE']);
        $this->insert('country', ['id' => 3, 'name' => 'Афганистан', 'code' => 'AF']);
        $this->insert('country', ['id' => 4, 'name' => 'Антигуа и Барбуда', 'code' => 'AG']);
        $this->insert('country', ['id' => 5, 'name' => 'Ангилья', 'code' => 'AI']);
        $this->insert('country', ['id' => 6, 'name' => 'Албания', 'code' => 'AL']);
        $this->insert('country', ['id' => 7, 'name' => 'Армения', 'code' => 'AM']);
        $this->insert('country', ['id' => 8, 'name' => 'Ангола', 'code' => 'AO']);
        $this->insert('country', ['id' => 9, 'name' => 'Антарктида', 'code' => 'AQ']);
        $this->insert('country', ['id' => 10, 'name' => 'Аргентина', 'code' => 'AR']);
        $this->insert('country', ['id' => 11, 'name' => 'Американское Самоа', 'code' => 'AS']);
        $this->insert('country', ['id' => 12, 'name' => 'Австрия', 'code' => 'AT']);
        $this->insert('country', ['id' => 13, 'name' => 'Австралия', 'code' => 'AU']);
        $this->insert('country', ['id' => 14, 'name' => 'Аруба', 'code' => 'AW']);
        $this->insert('country', ['id' => 15, 'name' => 'Азербайджан', 'code' => 'AZ']);
        $this->insert('country', ['id' => 16, 'name' => 'Босния и Герцеговина', 'code' => 'BA']);
        $this->insert('country', ['id' => 17, 'name' => 'Барбадос', 'code' => 'BB']);
        $this->insert('country', ['id' => 18, 'name' => 'Бангладеш', 'code' => 'BD']);
        $this->insert('country', ['id' => 19, 'name' => 'Бельгия', 'code' => 'BE']);
        $this->insert('country', ['id' => 20, 'name' => 'Буркина-Фасо', 'code' => 'BF']);
        $this->insert('country', ['id' => 21, 'name' => 'Болгария', 'code' => 'BG']);
        $this->insert('country', ['id' => 22, 'name' => 'Бахрейн', 'code' => 'BH']);
        $this->insert('country', ['id' => 23, 'name' => 'Бурунди', 'code' => 'BI']);
        $this->insert('country', ['id' => 24, 'name' => 'Бенин', 'code' => 'BJ']);
        $this->insert('country', ['id' => 25, 'name' => 'Бермуды', 'code' => 'BM']);
        $this->insert('country', ['id' => 26, 'name' => 'Бруней Даруссалам', 'code' => 'BN']);
        $this->insert('country', ['id' => 27, 'name' => 'Боливия', 'code' => 'BO']);
        $this->insert('country', ['id' => 28, 'name' => 'Бразилия', 'code' => 'BR']);
        $this->insert('country', ['id' => 29, 'name' => 'Багамские острова', 'code' => 'BS']);
        $this->insert('country', ['id' => 30, 'name' => 'Бутан', 'code' => 'BT']);
        $this->insert('country', ['id' => 31, 'name' => 'остров Буве', 'code' => 'BV']);
        $this->insert('country', ['id' => 32, 'name' => 'Ботсвана', 'code' => 'BW']);
        $this->insert('country', ['id' => 33, 'name' => 'Беларусь', 'code' => 'BY']);
        $this->insert('country', ['id' => 34, 'name' => 'Белиз', 'code' => 'BZ']);
        $this->insert('country', ['id' => 35, 'name' => 'Канада', 'code' => 'CA']);
        $this->insert('country', ['id' => 36, 'name' => 'Кокосовые острова(острова Килинг)', 'code' => 'CC']);
        $this->insert('country', ['id' => 37, 'name' => 'Центральноафриканская Республика', 'code' => 'CF']);
        $this->insert('country', ['id' => 38, 'name' => 'Конго', 'code' => 'CG']);
        $this->insert('country', ['id' => 39, 'name' => 'Швейцария', 'code' => 'CH']);
        $this->insert('country', ['id' => 40, 'name' => 'Кот-д\' Ивуар', 'code' => 'CI']);
        $this->insert('country', ['id' => 41, 'name' => 'острова Кука', 'code' => 'CK']);
        $this->insert('country', ['id' => 42, 'name' => 'Чили', 'code' => 'CL']);
        $this->insert('country', ['id' => 43, 'name' => 'Камерун', 'code' => 'CM']);
        $this->insert('country', ['id' => 44, 'name' => 'Китай', 'code' => 'CN']);
        $this->insert('country', ['id' => 45, 'name' => 'Колумбия', 'code' => 'CO']);
        $this->insert('country', ['id' => 46, 'name' => 'Коста-Рика', 'code' => 'CR']);
        $this->insert('country', ['id' => 47, 'name' => 'Куба', 'code' => 'CU']);
        $this->insert('country', ['id' => 48, 'name' => 'Кабо-Верде', 'code' => 'CV']);
        $this->insert('country', ['id' => 49, 'name' => 'остров Рождества', 'code' => 'CX']);
        $this->insert('country', ['id' => 50, 'name' => 'Кипр', 'code' => 'CY']);
        $this->insert('country', ['id' => 51, 'name' => 'Чехия', 'code' => 'CZ']);
        $this->insert('country', ['id' => 52, 'name' => 'Германия', 'code' => 'DE']);
        $this->insert('country', ['id' => 53, 'name' => 'Джибути', 'code' => 'DJ']);
        $this->insert('country', ['id' => 54, 'name' => 'Дания', 'code' => 'DK']);
        $this->insert('country', ['id' => 55, 'name' => 'Доминика', 'code' => 'DM']);
        $this->insert('country', ['id' => 56, 'name' => 'Доминиканская Республика', 'code' => 'DO']);
        $this->insert('country', ['id' => 57, 'name' => 'Алжир', 'code' => 'DZ']);
        $this->insert('country', ['id' => 58, 'name' => 'Эквадор', 'code' => 'EC']);
        $this->insert('country', ['id' => 59, 'name' => 'Эстония', 'code' => 'EE']);
        $this->insert('country', ['id' => 60, 'name' => 'Египт', 'code' => 'EG']);
        $this->insert('country', ['id' => 61, 'name' => 'Западная Сахара', 'code' => 'EH']);
        $this->insert('country', ['id' => 62, 'name' => 'Эритрея', 'code' => 'ER']);
        $this->insert('country', ['id' => 63, 'name' => 'Испания', 'code' => 'ES']);
        $this->insert('country', ['id' => 64, 'name' => 'Эфиопия', 'code' => 'ET']);
        $this->insert('country', ['id' => 65, 'name' => 'Финляндия', 'code' => 'FI']);
        $this->insert('country', ['id' => 66, 'name' => 'Фиджи', 'code' => 'FJ']);
        $this->insert('country', ['id' => 67, 'name' => 'Фолклендские острова (Мальвинские)', 'code' => 'FK']);
        $this->insert('country', ['id' => 68, 'name' => 'Микронезия', 'code' => 'FM']);
        $this->insert('country', ['id' => 69, 'name' => 'Фарерские острова', 'code' => 'FO']);
        $this->insert('country', ['id' => 70, 'name' => 'Франция', 'code' => 'FR']);
        $this->insert('country', ['id' => 71, 'name' => 'метрополия Франции', 'code' => 'FX']);
        $this->insert('country', ['id' => 72, 'name' => 'Габон', 'code' => 'GA']);
        $this->insert('country', ['id' => 73, 'name' => 'Соединённое Королевство (Великобритания)', 'code' => 'GB']);
        $this->insert('country', ['id' => 74, 'name' => 'Гренада', 'code' => 'GD']);
        $this->insert('country', ['id' => 75, 'name' => 'Грузия', 'code' => 'GE']);
        $this->insert('country', ['id' => 76, 'name' => 'Французская Гвиана', 'code' => 'GF']);
        $this->insert('country', ['id' => 77, 'name' => 'Гана', 'code' => 'GH']);
        $this->insert('country', ['id' => 78, 'name' => 'Гибралтар', 'code' => 'GI']);
        $this->insert('country', ['id' => 79, 'name' => 'Гренландия', 'code' => 'GL']);
        $this->insert('country', ['id' => 80, 'name' => 'Гамбия', 'code' => 'GM']);
        $this->insert('country', ['id' => 81, 'name' => 'Гвинея', 'code' => 'GN']);
        $this->insert('country', ['id' => 82, 'name' => 'Гваделупа', 'code' => 'GP']);
        $this->insert('country', ['id' => 83, 'name' => 'Экваториальная Гвинея', 'code' => 'GQ']);
        $this->insert('country', ['id' => 84, 'name' => 'Греция', 'code' => 'GR']);
        $this->insert('country', ['id' => 85, 'name' => 'Гватемала', 'code' => 'GT']);
        $this->insert('country', ['id' => 86, 'name' => 'Гуам', 'code' => 'GU']);
        $this->insert('country', ['id' => 87, 'name' => 'Гвинея-Бисау', 'code' => 'GW']);
        $this->insert('country', ['id' => 88, 'name' => 'Гайана', 'code' => 'GY']);
        $this->insert('country', ['id' => 89, 'name' => 'Гонконг', 'code' => 'HK']);
        $this->insert('country', ['id' => 90, 'name' => 'острова Херд и Макдональд', 'code' => 'HM']);
        $this->insert('country', ['id' => 91, 'name' => 'Гондурас', 'code' => 'HN']);
        $this->insert('country', ['id' => 92, 'name' => 'Хорватия', 'code' => 'HR']);
        $this->insert('country', ['id' => 93, 'name' => 'Гаити', 'code' => 'HT']);
        $this->insert('country', ['id' => 94, 'name' => 'Венгрия', 'code' => 'HU']);
        $this->insert('country', ['id' => 95, 'name' => 'Индонезия', 'code' => 'ID']);
        $this->insert('country', ['id' => 96, 'name' => 'Ирландия', 'code' => 'IE']);
        $this->insert('country', ['id' => 97, 'name' => 'Израиль', 'code' => 'IL']);
        $this->insert('country', ['id' => 98, 'name' => 'Индия', 'code' => 'IN']);
        $this->insert('country', ['id' => 99, 'name' => 'Британская территория в Индийском океане', 'code' => 'IO']);
        $this->insert('country', ['id' => 100, 'name' => 'Ирак', 'code' => 'IQ']);
        $this->insert('country', ['id' => 101, 'name' => 'Исламская Республика Иран', 'code' => 'IR']);
        $this->insert('country', ['id' => 102, 'name' => 'Исландия', 'code' => 'IS']);
        $this->insert('country', ['id' => 103, 'name' => 'Италия', 'code' => 'IT']);
        $this->insert('country', ['id' => 104, 'name' => 'Остров Мэн', 'code' => 'IM']);
        $this->insert('country', ['id' => 105, 'name' => 'Ямайка', 'code' => 'JM']);
        $this->insert('country', ['id' => 106, 'name' => 'Иордания', 'code' => 'JO']);
        $this->insert('country', ['id' => 107, 'name' => 'Япония', 'code' => 'JP']);
        $this->insert('country', ['id' => 108, 'name' => 'Кения', 'code' => 'KE']);
        $this->insert('country', ['id' => 109, 'name' => 'Киргизия', 'code' => 'KG']);
        $this->insert('country', ['id' => 110, 'name' => 'Камбоджа', 'code' => 'KH']);
        $this->insert('country', ['id' => 111, 'name' => 'Кирибати', 'code' => 'KI']);
        $this->insert('country', ['id' => 112, 'name' => 'Коморские Острова', 'code' => 'KM']);
        $this->insert('country', ['id' => 113, 'name' => 'Сент-Китс и Невис', 'code' => 'KN']);
        $this->insert('country', ['id' => 114, 'name' => 'Северная Корея(КНДР)', 'code' => 'KP']);
        $this->insert('country', ['id' => 115, 'name' => 'Южная Корея', 'code' => 'KR']);
        $this->insert('country', ['id' => 116, 'name' => 'Кувейт', 'code' => 'KW']);
        $this->insert('country', ['id' => 117, 'name' => 'Каймановы острова', 'code' => 'KY']);
        $this->insert('country', ['id' => 118, 'name' => 'Казахстан', 'code' => 'KZ']);
        $this->insert('country', ['id' => 119, 'name' => 'Лаос', 'code' => 'LA']);
        $this->insert('country', ['id' => 120, 'name' => 'Ливан', 'code' => 'LB']);
        $this->insert('country', ['id' => 121, 'name' => 'Сент-Люсия', 'code' => 'LC']);
        $this->insert('country', ['id' => 122, 'name' => 'Лихтенштейн', 'code' => 'LI']);
        $this->insert('country', ['id' => 123, 'name' => 'Шри-Ланка', 'code' => 'LK']);
        $this->insert('country', ['id' => 124, 'name' => 'Либерия', 'code' => 'LR']);
        $this->insert('country', ['id' => 125, 'name' => 'Лесото', 'code' => 'LS']);
        $this->insert('country', ['id' => 126, 'name' => 'Литва', 'code' => 'LT']);
        $this->insert('country', ['id' => 127, 'name' => 'Люксембург', 'code' => 'LU']);
        $this->insert('country', ['id' => 128, 'name' => 'Латвия', 'code' => 'LV']);
        $this->insert('country', ['id' => 129, 'name' => 'Ливийская Арабская Джамахирия', 'code' => 'LY']);
        $this->insert('country', ['id' => 130, 'name' => 'Марокко', 'code' => 'MA']);
        $this->insert('country', ['id' => 131, 'name' => 'Монако', 'code' => 'MC']);
        $this->insert('country', ['id' => 132, 'name' => 'Молдова', 'code' => 'MD']);
        $this->insert('country', ['id' => 133, 'name' => 'Мадагаскар', 'code' => 'MG']);
        $this->insert('country', ['id' => 134, 'name' => 'Маршалловы острова', 'code' => 'MH']);
        $this->insert('country', ['id' => 135, 'name' => 'Македония', 'code' => 'MK']);
        $this->insert('country', ['id' => 136, 'name' => 'Мали', 'code' => 'ML']);
        $this->insert('country', ['id' => 137, 'name' => 'Мьянма', 'code' => 'MM']);
        $this->insert('country', ['id' => 138, 'name' => 'Монголия', 'code' => 'MN']);
        $this->insert('country', ['id' => 139, 'name' => 'Черногория', 'code' => 'ME']);
        $this->insert('country', ['id' => 140, 'name' => 'Макау', 'code' => 'MO']);
        $this->insert('country', ['id' => 141, 'name' => 'Марианские острова', 'code' => 'MP']);
        $this->insert('country', ['id' => 142, 'name' => 'остров Мартиника', 'code' => 'MQ']);
        $this->insert('country', ['id' => 143, 'name' => 'Мавритания', 'code' => 'MR']);
        $this->insert('country', ['id' => 144, 'name' => 'Монтсеррат', 'code' => 'MS']);
        $this->insert('country', ['id' => 145, 'name' => 'Мальта', 'code' => 'MT']);
        $this->insert('country', ['id' => 146, 'name' => 'Маврикий', 'code' => 'MU']);
        $this->insert('country', ['id' => 147, 'name' => 'Мальдивы', 'code' => 'MV']);
        $this->insert('country', ['id' => 148, 'name' => 'Малави', 'code' => 'MW']);
        $this->insert('country', ['id' => 149, 'name' => 'Мексика', 'code' => 'MX']);
        $this->insert('country', ['id' => 150, 'name' => 'Малайзия', 'code' => 'MY']);
        $this->insert('country', ['id' => 151, 'name' => 'Мозамбик', 'code' => 'MZ']);
        $this->insert('country', ['id' => 152, 'name' => 'Намибия', 'code' => 'NA']);
        $this->insert('country', ['id' => 153, 'name' => 'остров Новая Каледония', 'code' => 'NC']);
        $this->insert('country', ['id' => 154, 'name' => 'Нигер', 'code' => 'NE']);
        $this->insert('country', ['id' => 155, 'name' => 'остров Норфолк', 'code' => 'NF']);
        $this->insert('country', ['id' => 156, 'name' => 'Нигерия', 'code' => 'NG']);
        $this->insert('country', ['id' => 157, 'name' => 'Никарагуа', 'code' => 'NI']);
        $this->insert('country', ['id' => 158, 'name' => 'Нидерланды', 'code' => 'NL']);
        $this->insert('country', ['id' => 159, 'name' => 'Норвегия', 'code' => 'NO']);
        $this->insert('country', ['id' => 160, 'name' => 'Непал', 'code' => 'NP']);
        $this->insert('country', ['id' => 161, 'name' => 'Науру', 'code' => 'NR']);
        $this->insert('country', ['id' => 162, 'name' => 'Ниуэ', 'code' => 'NU']);
        $this->insert('country', ['id' => 163, 'name' => 'Новая Зеландия', 'code' => 'NZ']);
        $this->insert('country', ['id' => 164, 'name' => 'Оман', 'code' => 'OM']);
        $this->insert('country', ['id' => 165, 'name' => 'Панама', 'code' => 'PA']);
        $this->insert('country', ['id' => 166, 'name' => 'Перу', 'code' => 'PE']);
        $this->insert('country', ['id' => 167, 'name' => 'Французская Полинезия', 'code' => 'PF']);
        $this->insert('country', ['id' => 168, 'name' => 'Папуа - Новая Гвинея', 'code' => 'PG']);
        $this->insert('country', ['id' => 169, 'name' => 'Филипины', 'code' => 'PH']);
        $this->insert('country', ['id' => 170, 'name' => 'Пакистан', 'code' => 'PK']);
        $this->insert('country', ['id' => 171, 'name' => 'Польша', 'code' => 'PL']);
        $this->insert('country', ['id' => 172, 'name' => 'Сент-Пьер и Микелон', 'code' => 'PM']);
        $this->insert('country', ['id' => 173, 'name' => 'Питкэрн', 'code' => 'PN']);
        $this->insert('country', ['id' => 174, 'name' => 'Пуэрто-Рико', 'code' => 'PR']);
        $this->insert('country', ['id' => 175, 'name' => 'Палестинская автономия', 'code' => 'PS']);
        $this->insert('country', ['id' => 176, 'name' => 'Португалия', 'code' => 'PT']);
        $this->insert('country', ['id' => 177, 'name' => 'Палан', 'code' => 'PW']);
        $this->insert('country', ['id' => 178, 'name' => 'Парагвай', 'code' => 'PY']);
        $this->insert('country', ['id' => 179, 'name' => 'Катар', 'code' => 'QA']);
        $this->insert('country', ['id' => 180, 'name' => 'Реюньон', 'code' => 'RE']);
        $this->insert('country', ['id' => 181, 'name' => 'Румыния', 'code' => 'RO']);
        $this->insert('country', ['id' => 182, 'name' => 'Российская Федерация', 'code' => 'RU']);
        $this->insert('country', ['id' => 183, 'name' => 'Руанда', 'code' => 'RW']);
        $this->insert('country', ['id' => 184, 'name' => 'Саудовская Аравия', 'code' => 'SA']);
        $this->insert('country', ['id' => 185, 'name' => 'Сербия', 'code' => 'CS']);
        $this->insert('country', ['id' => 186, 'name' => 'Соломоновы Острова', 'code' => 'SB']);
        $this->insert('country', ['id' => 187, 'name' => 'Сейшельские Острова', 'code' => 'SC']);
        $this->insert('country', ['id' => 188, 'name' => 'Судан', 'code' => 'SD']);
        $this->insert('country', ['id' => 189, 'name' => 'Швеция', 'code' => 'SE']);
        $this->insert('country', ['id' => 190, 'name' => 'Сингапур', 'code' => 'SG']);
        $this->insert('country', ['id' => 191, 'name' => 'остров Св. Елены', 'code' => 'SH']);
        $this->insert('country', ['id' => 192, 'name' => 'Словения', 'code' => 'SI']);
        $this->insert('country', ['id' => 193, 'name' => 'острова Свалбард и Ян Мейен', 'code' => 'SJ']);
        $this->insert('country', ['id' => 194, 'name' => 'Словакия', 'code' => 'SK']);
        $this->insert('country', ['id' => 195, 'name' => 'Сьерра-Леоне', 'code' => 'SL']);
        $this->insert('country', ['id' => 196, 'name' => 'Сан-Марино', 'code' => 'SM']);
        $this->insert('country', ['id' => 197, 'name' => 'Сенегал', 'code' => 'SN']);
        $this->insert('country', ['id' => 198, 'name' => 'Сомали', 'code' => 'SO']);
        $this->insert('country', ['id' => 199, 'name' => 'Суринам', 'code' => 'SR']);
        $this->insert('country', ['id' => 200, 'name' => 'Сан-Томе и Принсипи', 'code' => 'ST']);
        $this->insert('country', ['id' => 201, 'name' => 'Сальвадор', 'code' => 'SV']);
        $this->insert('country', ['id' => 202, 'name' => 'Сирийская Арабская Республика', 'code' => 'SY']);
        $this->insert('country', ['id' => 203, 'name' => 'Свазиленд', 'code' => 'SZ']);
        $this->insert('country', ['id' => 204, 'name' => 'острова Теркс и Кайкос', 'code' => 'TC']);
        $this->insert('country', ['id' => 205, 'name' => 'Чад', 'code' => 'TD']);
        $this->insert('country', ['id' => 206, 'name' => 'Французские Южные Территории', 'code' => 'TF']);
        $this->insert('country', ['id' => 207, 'name' => 'Того', 'code' => 'TG']);
        $this->insert('country', ['id' => 208, 'name' => 'Таиланд', 'code' => 'TH']);
        $this->insert('country', ['id' => 209, 'name' => 'Таджикистан', 'code' => 'TJ']);
        $this->insert('country', ['id' => 210, 'name' => 'острова Токелау', 'code' => 'TK']);
        $this->insert('country', ['id' => 211, 'name' => 'Туркменистан', 'code' => 'TM']);
        $this->insert('country', ['id' => 212, 'name' => 'Тунис', 'code' => 'TN']);
        $this->insert('country', ['id' => 213, 'name' => 'Tonga', 'code' => 'TO']);
        $this->insert('country', ['id' => 214, 'name' => 'Восточный Тимор', 'code' => 'TL']);
        $this->insert('country', ['id' => 215, 'name' => 'Турция', 'code' => 'TR']);
        $this->insert('country', ['id' => 216, 'name' => 'Тринидад и Тобаго', 'code' => 'TT']);
        $this->insert('country', ['id' => 217, 'name' => 'Тувалу', 'code' => 'TV']);
        $this->insert('country', ['id' => 218, 'name' => 'Тайвань', 'code' => 'TW']);
        $this->insert('country', ['id' => 219, 'name' => 'Танзания', 'code' => 'TZ']);
        $this->insert('country', ['id' => 220, 'name' => 'Украина', 'code' => 'UA']);
        $this->insert('country', ['id' => 221, 'name' => 'Уганда', 'code' => 'UG']);
        $this->insert('country', ['id' => 222, 'name' => 'Соединенные Штаты Америки', 'code' => 'US']);
        $this->insert('country', ['id' => 223, 'name' => 'Уругвай', 'code' => 'UY']);
        $this->insert('country', ['id' => 224, 'name' => 'Узбекистан', 'code' => 'UZ']);
        $this->insert('country', ['id' => 225, 'name' => 'Ватикан', 'code' => 'VA']);
        $this->insert('country', ['id' => 226, 'name' => 'Сент-Винсент и Гренадины', 'code' => 'VC']);
        $this->insert('country', ['id' => 227, 'name' => 'Венесуэла', 'code' => 'VE']);
        $this->insert('country', ['id' => 228, 'name' => 'Британские Виргинские Острова', 'code' => 'VG']);
        $this->insert('country', ['id' => 229, 'name' => 'Виргинские Острова США', 'code' => 'VI']);
        $this->insert('country', ['id' => 230, 'name' => 'Вьетнам', 'code' => 'VN']);
        $this->insert('country', ['id' => 231, 'name' => 'Вануату', 'code' => 'VU']);
        $this->insert('country', ['id' => 232, 'name' => 'острова Уоллис и Футуна', 'code' => 'WF']);
        $this->insert('country', ['id' => 233, 'name' => 'Самоа', 'code' => 'WS']);
        $this->insert('country', ['id' => 234, 'name' => 'Йемен', 'code' => 'YE']);
        $this->insert('country', ['id' => 235, 'name' => 'Майотте', 'code' => 'YT']);
        $this->insert('country', ['id' => 236, 'name' => 'Южно-Африканская Республика(ЮАР)', 'code' => 'ZA']);
        $this->insert('country', ['id' => 237, 'name' => 'Замбия', 'code' => 'ZM']);
        $this->insert('country', ['id' => 238, 'name' => 'Заир', 'code' => 'ZR']);
        $this->insert('country', ['id' => 239, 'name' => 'Зимбабве', 'code' => 'ZW']);
        $this->insert('country', ['id' => 240, 'name' => 'Демократическая республика Конго', 'code' => 'CD']);
        $this->insert('country', ['id' => 241, 'name' => 'Азиатско-Тихоокеанский регион', 'code' => 'AP']);
        $this->insert('country', ['id' => 242, 'name' => 'Республика Сербия', 'code' => 'RS']);
        $this->insert('country', ['id' => 243, 'name' => 'Аландские острова', 'code' => 'AX']);
        $this->insert('country', ['id' => 244, 'name' => 'Европа', 'code' => 'EU']);
        $this->insert('country', ['id' => 245, 'name' => 'Гернси', 'code' => 'GG']);
        $this->insert('country', ['id' => 246, 'name' => 'Джерси', 'code' => 'JE']);
        $this->insert('country', ['id' => 247, 'name' => 'Кюрасао', 'code' => 'CW']);
        $this->insert('country', ['id' => 248, 'name' => 'Синт-Мартен', 'code' => 'SX']);


        $this->createTable('state', [
            'id'         => $this->primaryKey(),
            'country_id' => $this->integer(),
            'name'       => $this->string()->notNull(),
            'code'       => $this->string(),
        ], $this->getTableOptions());
        $this->addForeignKey('state_country', 'state', 'country_id', 'country', 'id', 'RESTRICT', 'RESTRICT');

        $this->insert('state', ['id' => 15, 'country_id' => 222, 'name' => 'California', 'code' => 'CA']);
        $this->insert('state', ['id' => 13, 'country_id' => 222, 'name' => 'Arkansas', 'code' => 'AR']);
        $this->insert('state', ['id' => 12, 'country_id' => 222, 'name' => 'Arizona', 'code' => 'AZ']);
        $this->insert('state', ['id' => 11, 'country_id' => 222, 'name' => 'Alaska', 'code' => 'AK']);
        $this->insert('state', ['id' => 10, 'country_id' => 222, 'name' => 'Alabama', 'code' => 'AL']);
        $this->insert('state', ['id' => 16, 'country_id' => 222, 'name' => 'Colorado', 'code' => 'CO']);
        $this->insert('state', ['id' => 17, 'country_id' => 222, 'name' => 'Connecticut', 'code' => 'CT']);
        $this->insert('state', ['id' => 18, 'country_id' => 222, 'name' => 'Delaware', 'code' => 'DE']);
        $this->insert('state', ['id' => 19, 'country_id' => 222, 'name' => 'District of Columbia', 'code' => 'DC']);
        $this->insert('state', ['id' => 20, 'country_id' => 222, 'name' => 'Florida', 'code' => 'FL']);
        $this->insert('state', ['id' => 21, 'country_id' => 222, 'name' => 'Georgia', 'code' => 'GA']);
        $this->insert('state', ['id' => 22, 'country_id' => 222, 'name' => 'Guam', 'code' => 'GU']);
        $this->insert('state', ['id' => 23, 'country_id' => 222, 'name' => 'Hawaii', 'code' => 'HI']);
        $this->insert('state', ['id' => 24, 'country_id' => 222, 'name' => 'Idaho', 'code' => 'ID']);
        $this->insert('state', ['id' => 25, 'country_id' => 222, 'name' => 'Illinois', 'code' => 'IL']);
        $this->insert('state', ['id' => 26, 'country_id' => 222, 'name' => 'Indiana', 'code' => 'IN']);
        $this->insert('state', ['id' => 27, 'country_id' => 222, 'name' => 'Iowa', 'code' => 'IA']);
        $this->insert('state', ['id' => 28, 'country_id' => 222, 'name' => 'Kansas', 'code' => 'KS']);
        $this->insert('state', ['id' => 29, 'country_id' => 222, 'name' => 'Kentucky', 'code' => 'KY']);
        $this->insert('state', ['id' => 30, 'country_id' => 222, 'name' => 'Louisiana', 'code' => 'LA']);
        $this->insert('state', ['id' => 31, 'country_id' => 222, 'name' => 'Maine', 'code' => 'ME']);
        $this->insert('state', ['id' => 32, 'country_id' => 222, 'name' => 'Maryland', 'code' => 'MD']);
        $this->insert('state', ['id' => 33, 'country_id' => 222, 'name' => 'Massachusetts', 'code' => 'MA']);
        $this->insert('state', ['id' => 34, 'country_id' => 222, 'name' => 'Michigan', 'code' => 'MI']);
        $this->insert('state', ['id' => 35, 'country_id' => 222, 'name' => 'Minnesota', 'code' => 'MN']);
        $this->insert('state', ['id' => 36, 'country_id' => 222, 'name' => 'Mississippi', 'code' => 'MS']);
        $this->insert('state', ['id' => 37, 'country_id' => 222, 'name' => 'Missouri', 'code' => 'MO']);
        $this->insert('state', ['id' => 38, 'country_id' => 222, 'name' => 'Montana', 'code' => 'MT']);
        $this->insert('state', ['id' => 39, 'country_id' => 222, 'name' => 'Nebraska', 'code' => 'NE']);
        $this->insert('state', ['id' => 40, 'country_id' => 222, 'name' => 'Nevada', 'code' => 'NV']);
        $this->insert('state', ['id' => 41, 'country_id' => 222, 'name' => 'New Hampshire', 'code' => 'NH']);
        $this->insert('state', ['id' => 42, 'country_id' => 222, 'name' => 'New Jersey', 'code' => 'NJ']);
        $this->insert('state', ['id' => 43, 'country_id' => 222, 'name' => 'New Mexico', 'code' => 'NM']);
        $this->insert('state', ['id' => 44, 'country_id' => 222, 'name' => 'New York', 'code' => 'NY']);
        $this->insert('state', ['id' => 45, 'country_id' => 222, 'name' => 'North Carolina', 'code' => 'NC']);
        $this->insert('state', ['id' => 46, 'country_id' => 222, 'name' => 'North Dakota', 'code' => 'ND']);
        $this->insert('state', ['id' => 47, 'country_id' => 222, 'name' => 'Ohio', 'code' => 'OH']);
        $this->insert('state', ['id' => 48, 'country_id' => 222, 'name' => 'Oklahoma', 'code' => 'OK']);
        $this->insert('state', ['id' => 49, 'country_id' => 222, 'name' => 'Oregon', 'code' => 'OR']);
        $this->insert('state', ['id' => 50, 'country_id' => 222, 'name' => 'Pennsylvania', 'code' => 'PA']);
        $this->insert('state', ['id' => 51, 'country_id' => 222, 'name' => 'Puerto Rico', 'code' => 'PR']);
        $this->insert('state', ['id' => 52, 'country_id' => 222, 'name' => 'Rhode Island', 'code' => 'RI']);
        $this->insert('state', ['id' => 53, 'country_id' => 222, 'name' => 'South Carolina', 'code' => 'SC']);
        $this->insert('state', ['id' => 54, 'country_id' => 222, 'name' => 'South Dakota', 'code' => 'SD']);
        $this->insert('state', ['id' => 55, 'country_id' => 222, 'name' => 'Tennessee', 'code' => 'TN']);
        $this->insert('state', ['id' => 56, 'country_id' => 222, 'name' => 'Texas', 'code' => 'TX']);
        $this->insert('state', ['id' => 57, 'country_id' => 222, 'name' => 'Utah', 'code' => 'UT']);
        $this->insert('state', ['id' => 58, 'country_id' => 222, 'name' => 'Vermont', 'code' => 'VT']);
        $this->insert('state', ['id' => 59, 'country_id' => 222, 'name' => 'Virgin Islands', 'code' => 'VI']);
        $this->insert('state', ['id' => 60, 'country_id' => 222, 'name' => 'Virginia', 'code' => 'VA']);
        $this->insert('state', ['id' => 61, 'country_id' => 222, 'name' => 'Washington', 'code' => 'WA']);
        $this->insert('state', ['id' => 62, 'country_id' => 222, 'name' => 'West Virginia', 'code' => 'WV']);
        $this->insert('state', ['id' => 63, 'country_id' => 222, 'name' => 'Wisconsin', 'code' => 'WI']);
        $this->insert('state', ['id' => 64, 'country_id' => 222, 'name' => 'Wyoming', 'code' => 'WY']);
        $this->insert('state', ['id' => 74, 'country_id' => 70, 'name' => 'Ain', 'code' => '01']);
        $this->insert('state', ['id' => 66, 'country_id' => 70, 'name' => 'Aisne', 'code' => '02']);
        $this->insert('state', ['id' => 67, 'country_id' => 70, 'name' => 'Allier', 'code' => '03']);
        $this->insert('state', ['id' => 68, 'country_id' => 70, 'name' => 'Alpes-de-Haute-Provence', 'code' => '04']);
        $this->insert('state', ['id' => 69, 'country_id' => 70, 'name' => 'Alpes-Maritimes', 'code' => '06']);
        $this->insert('state', ['id' => 70, 'country_id' => 70, 'name' => 'Ardèche', 'code' => '07']);
        $this->insert('state', ['id' => 71, 'country_id' => 70, 'name' => 'Ardennes', 'code' => '08']);
        $this->insert('state', ['id' => 72, 'country_id' => 70, 'name' => 'Ariège', 'code' => '09']);
        $this->insert('state', ['id' => 73, 'country_id' => 70, 'name' => 'Aube', 'code' => '10']);
        $this->insert('state', ['id' => 75, 'country_id' => 70, 'name' => 'Aude', 'code' => '11']);
        $this->insert('state', ['id' => 76, 'country_id' => 70, 'name' => 'Aveyron', 'code' => '12']);
        $this->insert('state', ['id' => 77, 'country_id' => 70, 'name' => 'Bouches-du-Rhône', 'code' => '13']);
        $this->insert('state', ['id' => 78, 'country_id' => 70, 'name' => 'Calvados', 'code' => '14']);
        $this->insert('state', ['id' => 79, 'country_id' => 70, 'name' => 'Cantal', 'code' => '15']);
        $this->insert('state', ['id' => 80, 'country_id' => 70, 'name' => 'Charente', 'code' => '16']);
        $this->insert('state', ['id' => 81, 'country_id' => 70, 'name' => 'Charente-Maritime', 'code' => '17']);
        $this->insert('state', ['id' => 82, 'country_id' => 70, 'name' => 'Cher', 'code' => '18']);
        $this->insert('state', ['id' => 83, 'country_id' => 70, 'name' => 'Corrèze', 'code' => '19']);
        $this->insert('state', ['id' => 84, 'country_id' => 70, 'name' => 'Corse-du-Sud', 'code' => '2A']);
        $this->insert('state', ['id' => 85, 'country_id' => 70, 'name' => 'Côte-d\'Or', 'code' => '21']);
        $this->insert('state', ['id' => 86, 'country_id' => 70, 'name' => 'Côtes-d\'Armor', 'code' => '22']);
        $this->insert('state', ['id' => 87, 'country_id' => 70, 'name' => 'Creuse', 'code' => '23']);
        $this->insert('state', ['id' => 88, 'country_id' => 70, 'name' => 'Dordogne', 'code' => '24']);
        $this->insert('state', ['id' => 89, 'country_id' => 70, 'name' => 'Doubs', 'code' => '25']);
        $this->insert('state', ['id' => 90, 'country_id' => 70, 'name' => 'Drôme', 'code' => '26']);
        $this->insert('state', ['id' => 91, 'country_id' => 70, 'name' => 'Essonne', 'code' => '91']);
        $this->insert('state', ['id' => 92, 'country_id' => 70, 'name' => 'Eure', 'code' => '27']);
        $this->insert('state', ['id' => 93, 'country_id' => 70, 'name' => 'Eure-et-Loir', 'code' => '28']);
        $this->insert('state', ['id' => 94, 'country_id' => 70, 'name' => 'Finistère', 'code' => '29']);
        $this->insert('state', ['id' => 95, 'country_id' => 70, 'name' => 'Gard', 'code' => '30']);
        $this->insert('state', ['id' => 96, 'country_id' => 70, 'name' => 'Gers', 'code' => '32']);
        $this->insert('state', ['id' => 97, 'country_id' => 70, 'name' => 'Gironde', 'code' => '33']);
        $this->insert('state', ['id' => 98, 'country_id' => 70, 'name' => 'Haute-Corse', 'code' => '2B']);
        $this->insert('state', ['id' => 99, 'country_id' => 70, 'name' => 'Haute-Garonne', 'code' => '31']);
        $this->insert('state', ['id' => 100, 'country_id' => 70, 'name' => 'Haute-Loire', 'code' => '43']);
        $this->insert('state', ['id' => 101, 'country_id' => 70, 'name' => 'Haute-Marne', 'code' => '52']);
        $this->insert('state', ['id' => 102, 'country_id' => 70, 'name' => 'Haute-Vienne', 'code' => '87']);
        $this->insert('state', ['id' => 103, 'country_id' => 70, 'name' => 'Haute-Vienne', 'code' => '05']);
        $this->insert('state', ['id' => 104, 'country_id' => 70, 'name' => 'Hauts-de-Seine', 'code' => '92']);
        $this->insert('state', ['id' => 105, 'country_id' => 70, 'name' => 'Hérault', 'code' => '34']);
        $this->insert('state', ['id' => 106, 'country_id' => 70, 'name' => 'Ille-et-Vilaine', 'code' => '35']);
        $this->insert('state', ['id' => 107, 'country_id' => 70, 'name' => 'Indre', 'code' => '36']);
        $this->insert('state', ['id' => 108, 'country_id' => 70, 'name' => 'Indre-et-Loire', 'code' => '37']);
        $this->insert('state', ['id' => 109, 'country_id' => 70, 'name' => 'Isère', 'code' => '38']);
        $this->insert('state', ['id' => 110, 'country_id' => 70, 'name' => 'Jura', 'code' => '39']);
        $this->insert('state', ['id' => 111, 'country_id' => 70, 'name' => 'Landes', 'code' => '40']);
        $this->insert('state', ['id' => 112, 'country_id' => 70, 'name' => 'Loir-et-Cher', 'code' => '41']);
        $this->insert('state', ['id' => 113, 'country_id' => 70, 'name' => 'Loire', 'code' => '42']);
        $this->insert('state', ['id' => 114, 'country_id' => 70, 'name' => 'Loire-Atlantique', 'code' => '44']);
        $this->insert('state', ['id' => 115, 'country_id' => 70, 'name' => 'Loiret', 'code' => '45']);
        $this->insert('state', ['id' => 116, 'country_id' => 70, 'name' => 'Lot', 'code' => '46']);
        $this->insert('state', ['id' => 117, 'country_id' => 70, 'name' => 'Lot-et-Garonne', 'code' => '47']);
        $this->insert('state', ['id' => 118, 'country_id' => 70, 'name' => 'Lozère', 'code' => '48']);
        $this->insert('state', ['id' => 119, 'country_id' => 70, 'name' => 'Maine-et-Loire', 'code' => '49']);
        $this->insert('state', ['id' => 120, 'country_id' => 70, 'name' => 'Manche', 'code' => '50']);
        $this->insert('state', ['id' => 121, 'country_id' => 70, 'name' => 'Marne', 'code' => '51']);
        $this->insert('state', ['id' => 122, 'country_id' => 70, 'name' => 'Paris', 'code' => '75']);
        $this->insert('state', ['id' => 123, 'country_id' => 70, 'name' => 'Seine-Saint-Denis', 'code' => '93']);
        $this->insert('state', ['id' => 124, 'country_id' => 70, 'name' => 'Somme', 'code' => '80']);
        $this->insert('state', ['id' => 125, 'country_id' => 70, 'name' => 'Tarn', 'code' => '81']);
        $this->insert('state', ['id' => 126, 'country_id' => 70, 'name' => 'Tarn-et-Garonne', 'code' => '82']);
        $this->insert('state', ['id' => 127, 'country_id' => 70, 'name' => 'Territoire de Belfort', 'code' => '90']);
        $this->insert('state', ['id' => 128, 'country_id' => 70, 'name' => 'Val-d\'Oise', 'code' => '95']);
        $this->insert('state', ['id' => 129, 'country_id' => 70, 'name' => 'Val-de-Marne', 'code' => '94']);
        $this->insert('state', ['id' => 130, 'country_id' => 70, 'name' => 'Var', 'code' => '83']);
        $this->insert('state', ['id' => 131, 'country_id' => 70, 'name' => 'Vaucluse', 'code' => '84']);
        $this->insert('state', ['id' => 132, 'country_id' => 70, 'name' => 'Vendée', 'code' => '85']);
        $this->insert('state', ['id' => 133, 'country_id' => 70, 'name' => 'Vienne', 'code' => '86']);
        $this->insert('state', ['id' => 134, 'country_id' => 70, 'name' => 'Vosges', 'code' => '88']);
        $this->insert('state', ['id' => 135, 'country_id' => 70, 'name' => 'Yonne', 'code' => '89']);
        $this->insert('state', ['id' => 136, 'country_id' => 35, 'name' => 'Alberta', 'code' => 'AB']);
        $this->insert('state', ['id' => 137, 'country_id' => 35, 'name' => 'British Columbia', 'code' => 'BC']);
        $this->insert('state', ['id' => 138, 'country_id' => 35, 'name' => 'Manitoba', 'code' => 'MB']);
        $this->insert('state', ['id' => 139, 'country_id' => 35, 'name' => 'New Brunswick', 'code' => 'NB']);
        $this->insert('state', ['id' => 140, 'country_id' => 35, 'name' => 'Newfoundland and Labrador', 'code' => 'NL']);
        $this->insert('state', ['id' => 141, 'country_id' => 35, 'name' => 'Northwest Territories', 'code' => 'NT']);
        $this->insert('state', ['id' => 142, 'country_id' => 35, 'name' => 'Nova Scotia', 'code' => 'NS']);
        $this->insert('state', ['id' => 143, 'country_id' => 35, 'name' => 'Nunavut', 'code' => 'NU']);
        $this->insert('state', ['id' => 144, 'country_id' => 35, 'name' => 'Ontario', 'code' => 'ON']);
        $this->insert('state', ['id' => 145, 'country_id' => 35, 'name' => 'Prince Edward Island', 'code' => 'PE']);
        $this->insert('state', ['id' => 146, 'country_id' => 35, 'name' => 'Quebec', 'code' => 'QC']);
        $this->insert('state', ['id' => 147, 'country_id' => 35, 'name' => 'Saskatchewan', 'code' => 'SK']);
        $this->insert('state', ['id' => 148, 'country_id' => 35, 'name' => 'Yukon', 'code' => 'YT']);
        $this->insert('state', ['id' => 149, 'country_id' => 13, 'name' => 'Australian Capital Territory', 'code' => 'ACT']);
        $this->insert('state', ['id' => 150, 'country_id' => 13, 'name' => 'New South Wales', 'code' => 'NSW']);
        $this->insert('state', ['id' => 151, 'country_id' => 13, 'name' => 'Northern Territory', 'code' => 'NT']);
        $this->insert('state', ['id' => 152, 'country_id' => 13, 'name' => 'Queensland', 'code' => 'QLD']);
        $this->insert('state', ['id' => 153, 'country_id' => 13, 'name' => 'South Australia', 'code' => 'SA']);
        $this->insert('state', ['id' => 154, 'country_id' => 13, 'name' => 'Tasmania', 'code' => 'TAS']);
        $this->insert('state', ['id' => 155, 'country_id' => 13, 'name' => 'Victoria', 'code' => 'VIC']);
        $this->insert('state', ['id' => 156, 'country_id' => 13, 'name' => 'Western Australia', 'code' => 'WA']);
        $this->insert('state', ['id' => 157, 'country_id' => 158, 'name' => 'Drenthe', 'code' => 'DR']);
        $this->insert('state', ['id' => 158, 'country_id' => 158, 'name' => 'Flevoland', 'code' => 'FL']);
        $this->insert('state', ['id' => 159, 'country_id' => 158, 'name' => 'Friesland', 'code' => 'FR']);
        $this->insert('state', ['id' => 160, 'country_id' => 158, 'name' => 'Gelderland', 'code' => 'GE']);
        $this->insert('state', ['id' => 161, 'country_id' => 158, 'name' => 'Groningen', 'code' => 'GR']);
        $this->insert('state', ['id' => 162, 'country_id' => 158, 'name' => 'Limburg', 'code' => 'LI']);
        $this->insert('state', ['id' => 163, 'country_id' => 158, 'name' => 'Noord Brabant', 'code' => 'NB']);
        $this->insert('state', ['id' => 164, 'country_id' => 158, 'name' => 'Noord Holland', 'code' => 'NH']);
        $this->insert('state', ['id' => 165, 'country_id' => 158, 'name' => 'Overijssel', 'code' => 'OV']);
        $this->insert('state', ['id' => 166, 'country_id' => 158, 'name' => 'Utrecht', 'code' => 'UT']);
        $this->insert('state', ['id' => 167, 'country_id' => 158, 'name' => 'Zeeland', 'code' => 'ZE']);
        $this->insert('state', ['id' => 168, 'country_id' => 158, 'name' => 'Zuid Holland', 'code' => 'ZH']);
        $this->insert('state', ['id' => 169, 'country_id' => 52, 'name' => 'Baden-Württemberg', 'code' => 'BAW']);
        $this->insert('state', ['id' => 170, 'country_id' => 52, 'name' => 'Bayern', 'code' => 'BAY']);
        $this->insert('state', ['id' => 171, 'country_id' => 52, 'name' => 'Berlin', 'code' => 'BER']);
        $this->insert('state', ['id' => 172, 'country_id' => 52, 'name' => 'Branderburg', 'code' => 'BRG']);
        $this->insert('state', ['id' => 173, 'country_id' => 52, 'name' => 'Bremen', 'code' => 'BRE']);
        $this->insert('state', ['id' => 174, 'country_id' => 52, 'name' => 'Hamburg', 'code' => 'HAM']);
        $this->insert('state', ['id' => 175, 'country_id' => 52, 'name' => 'Hessen', 'code' => 'HES']);
        $this->insert('state', ['id' => 176, 'country_id' => 52, 'name' => 'Mecklenburg-Vorpommern', 'code' => 'MEC']);
        $this->insert('state', ['id' => 177, 'country_id' => 52, 'name' => 'Niedersachsen', 'code' => 'NDS']);
        $this->insert('state', ['id' => 178, 'country_id' => 52, 'name' => 'Nordrhein-Westfalen', 'code' => 'NRW']);
        $this->insert('state', ['id' => 179, 'country_id' => 52, 'name' => 'Rheinland-Pfalz', 'code' => 'RHE']);
        $this->insert('state', ['id' => 180, 'country_id' => 52, 'name' => 'Saarland', 'code' => 'SAR']);
        $this->insert('state', ['id' => 181, 'country_id' => 52, 'name' => 'Sachsen', 'code' => 'SAS']);
        $this->insert('state', ['id' => 182, 'country_id' => 52, 'name' => 'Sachsen-Anhalt', 'code' => 'SAC']);
        $this->insert('state', ['id' => 183, 'country_id' => 52, 'name' => 'Schleswig-Holstein', 'code' => 'SCN']);
        $this->insert('state', ['id' => 184, 'country_id' => 52, 'name' => 'Thüringen', 'code' => 'THE']);
        $this->insert('state', ['id' => 185, 'country_id' => 73, 'name' => 'Aberdeen', 'code' => 'ABN']);
        $this->insert('state', ['id' => 186, 'country_id' => 73, 'name' => 'Aberdeenshire', 'code' => 'ABNS']);
        $this->insert('state', ['id' => 187, 'country_id' => 73, 'name' => 'Anglesey', 'code' => 'ANG']);
        $this->insert('state', ['id' => 188, 'country_id' => 73, 'name' => 'Angus', 'code' => 'AGS']);
        $this->insert('state', ['id' => 189, 'country_id' => 73, 'name' => 'Argyll and Bute', 'code' => 'ARY']);
        $this->insert('state', ['id' => 190, 'country_id' => 73, 'name' => 'Bedfordshire', 'code' => 'BEDS']);
        $this->insert('state', ['id' => 191, 'country_id' => 73, 'name' => 'Berkshire', 'code' => 'BERKS']);
        $this->insert('state', ['id' => 192, 'country_id' => 73, 'name' => 'Blaenau Gwent', 'code' => 'BLA']);
        $this->insert('state', ['id' => 193, 'country_id' => 73, 'name' => 'Bridgend', 'code' => 'BRI']);
        $this->insert('state', ['id' => 194, 'country_id' => 73, 'name' => 'Bristol', 'code' => 'BSTL']);
        $this->insert('state', ['id' => 195, 'country_id' => 73, 'name' => 'Buckinghamshire', 'code' => 'BUCKS']);
        $this->insert('state', ['id' => 196, 'country_id' => 73, 'name' => 'Caerphilly', 'code' => 'CAE']);
        $this->insert('state', ['id' => 197, 'country_id' => 73, 'name' => 'Cambridgeshire', 'code' => 'CAMBS']);
        $this->insert('state', ['id' => 198, 'country_id' => 73, 'name' => 'Cardiff', 'code' => 'CDF']);
        $this->insert('state', ['id' => 199, 'country_id' => 73, 'name' => 'Carmarthenshire', 'code' => 'CARM']);
        $this->insert('state', ['id' => 200, 'country_id' => 73, 'name' => 'Ceredigion', 'code' => 'CDGN']);
        $this->insert('state', ['id' => 201, 'country_id' => 73, 'name' => 'Cheshire', 'code' => 'CHES']);
        $this->insert('state', ['id' => 202, 'country_id' => 73, 'name' => 'Clackmannanshire', 'code' => 'CLACK']);
        $this->insert('state', ['id' => 203, 'country_id' => 73, 'name' => 'Conwy', 'code' => 'CON']);
        $this->insert('state', ['id' => 204, 'country_id' => 73, 'name' => 'Cornwall', 'code' => 'CORN']);
        $this->insert('state', ['id' => 205, 'country_id' => 73, 'name' => 'Denbighshire', 'code' => 'DNBG']);
        $this->insert('state', ['id' => 206, 'country_id' => 73, 'name' => 'Derbyshire', 'code' => 'DERBY']);
        $this->insert('state', ['id' => 207, 'country_id' => 73, 'name' => 'Devon', 'code' => 'DVN']);
        $this->insert('state', ['id' => 208, 'country_id' => 73, 'name' => 'Dorset', 'code' => 'DOR']);
        $this->insert('state', ['id' => 209, 'country_id' => 73, 'name' => 'Dumfries and Galloway', 'code' => 'DGL']);
        $this->insert('state', ['id' => 210, 'country_id' => 73, 'name' => 'Dundee', 'code' => 'DUND']);
        $this->insert('state', ['id' => 211, 'country_id' => 73, 'name' => 'Durham', 'code' => 'DHM']);
        $this->insert('state', ['id' => 212, 'country_id' => 73, 'name' => 'East Ayrshire', 'code' => 'ARYE']);
        $this->insert('state', ['id' => 213, 'country_id' => 73, 'name' => 'East Dunbartonshire', 'code' => 'DUNBE']);
        $this->insert('state', ['id' => 214, 'country_id' => 73, 'name' => 'East Lothian', 'code' => 'LOTE']);
        $this->insert('state', ['id' => 215, 'country_id' => 73, 'name' => 'East Renfrewshire', 'code' => 'RENE']);
        $this->insert('state', ['id' => 216, 'country_id' => 73, 'name' => 'East Riding of Yorkshire', 'code' => 'ERYS']);
        $this->insert('state', ['id' => 217, 'country_id' => 73, 'name' => 'East Sussex', 'code' => 'SXE']);
        $this->insert('state', ['id' => 218, 'country_id' => 73, 'name' => 'Edinburgh', 'code' => 'EDIN']);
        $this->insert('state', ['id' => 219, 'country_id' => 73, 'name' => 'Essex', 'code' => 'ESX']);
        $this->insert('state', ['id' => 220, 'country_id' => 73, 'name' => 'Falkirk', 'code' => 'FALK']);
        $this->insert('state', ['id' => 221, 'country_id' => 73, 'name' => 'Fife', 'code' => 'FFE']);
        $this->insert('state', ['id' => 222, 'country_id' => 73, 'name' => 'Flintshire', 'code' => 'FLINT']);
        $this->insert('state', ['id' => 223, 'country_id' => 73, 'name' => 'Glasgow', 'code' => 'GLAS']);
        $this->insert('state', ['id' => 224, 'country_id' => 73, 'name' => 'Gloucestershire', 'code' => 'GLOS']);
        $this->insert('state', ['id' => 225, 'country_id' => 73, 'name' => 'Greater London', 'code' => 'LDN']);
        $this->insert('state', ['id' => 226, 'country_id' => 73, 'name' => 'Greater Manchester', 'code' => 'MCH']);
        $this->insert('state', ['id' => 227, 'country_id' => 73, 'name' => 'Gwynedd', 'code' => 'GDD']);
        $this->insert('state', ['id' => 228, 'country_id' => 73, 'name' => 'Hampshire', 'code' => 'HANTS']);
        $this->insert('state', ['id' => 229, 'country_id' => 73, 'name' => 'Herefordshire', 'code' => 'HWR']);
        $this->insert('state', ['id' => 230, 'country_id' => 73, 'name' => 'Hertfordshire', 'code' => 'HERTS']);
        $this->insert('state', ['id' => 231, 'country_id' => 73, 'name' => 'Highlands', 'code' => 'HLD']);
        $this->insert('state', ['id' => 232, 'country_id' => 73, 'name' => 'Inverclyde', 'code' => 'IVER']);
        $this->insert('state', ['id' => 233, 'country_id' => 73, 'name' => 'Isle of Wight', 'code' => 'IOW']);
        $this->insert('state', ['id' => 234, 'country_id' => 73, 'name' => 'Kent', 'code' => 'KNT']);
        $this->insert('state', ['id' => 235, 'country_id' => 73, 'name' => 'Lancashire', 'code' => 'LANCS']);
        $this->insert('state', ['id' => 236, 'country_id' => 73, 'name' => 'Leicestershire', 'code' => 'LEICS']);
        $this->insert('state', ['id' => 237, 'country_id' => 73, 'name' => 'Lincolnshire', 'code' => 'LINCS']);
        $this->insert('state', ['id' => 238, 'country_id' => 73, 'name' => 'Merseyside', 'code' => 'MSY']);
        $this->insert('state', ['id' => 239, 'country_id' => 73, 'name' => 'Merthyr Tydfil', 'code' => 'MERT']);
        $this->insert('state', ['id' => 240, 'country_id' => 73, 'name' => 'Midlothian', 'code' => 'MLOT']);
        $this->insert('state', ['id' => 241, 'country_id' => 73, 'name' => 'Monmouthshire', 'code' => 'MMOUTH']);
        $this->insert('state', ['id' => 242, 'country_id' => 73, 'name' => 'Moray', 'code' => 'MORAY']);
        $this->insert('state', ['id' => 243, 'country_id' => 73, 'name' => 'Neath Port Talbot', 'code' => 'NPRTAL']);
        $this->insert('state', ['id' => 244, 'country_id' => 73, 'name' => 'Newport', 'code' => 'NEWPT']);
        $this->insert('state', ['id' => 245, 'country_id' => 73, 'name' => 'Norfolk', 'code' => 'NOR']);
        $this->insert('state', ['id' => 246, 'country_id' => 73, 'name' => 'North Ayrshire', 'code' => 'ARYN']);
        $this->insert('state', ['id' => 247, 'country_id' => 73, 'name' => 'North Lanarkshire', 'code' => 'LANN']);
        $this->insert('state', ['id' => 248, 'country_id' => 73, 'name' => 'North Yorkshire', 'code' => 'YSN']);
        $this->insert('state', ['id' => 249, 'country_id' => 73, 'name' => 'Northamptonshire', 'code' => 'NHM']);
        $this->insert('state', ['id' => 250, 'country_id' => 73, 'name' => 'Northumberland', 'code' => 'NLD']);
        $this->insert('state', ['id' => 251, 'country_id' => 73, 'name' => 'Nottinghamshire', 'code' => 'NOT']);
        $this->insert('state', ['id' => 252, 'country_id' => 73, 'name' => 'Orkney Islands', 'code' => 'ORK']);
        $this->insert('state', ['id' => 253, 'country_id' => 73, 'name' => 'Oxfordshire', 'code' => 'OFE']);
        $this->insert('state', ['id' => 254, 'country_id' => 73, 'name' => 'Pembrokeshire', 'code' => 'PEM']);
        $this->insert('state', ['id' => 255, 'country_id' => 73, 'name' => 'Perth and Kinross', 'code' => 'PERTH']);
        $this->insert('state', ['id' => 256, 'country_id' => 73, 'name' => 'Powys', 'code' => 'PWS']);
        $this->insert('state', ['id' => 257, 'country_id' => 73, 'name' => 'Renfrewshire', 'code' => 'REN']);
        $this->insert('state', ['id' => 258, 'country_id' => 73, 'name' => 'Rhondda Cynon Taff', 'code' => 'RHON']);
        $this->insert('state', ['id' => 259, 'country_id' => 73, 'name' => 'Rutland', 'code' => 'RUT']);
        $this->insert('state', ['id' => 260, 'country_id' => 73, 'name' => 'Scottish Borders', 'code' => 'BOR']);
        $this->insert('state', ['id' => 261, 'country_id' => 73, 'name' => 'Shetland Islands', 'code' => 'SHET']);
        $this->insert('state', ['id' => 262, 'country_id' => 73, 'name' => 'Shropshire', 'code' => 'SPE']);
        $this->insert('state', ['id' => 263, 'country_id' => 73, 'name' => 'Somerset', 'code' => 'SOM']);
        $this->insert('state', ['id' => 264, 'country_id' => 73, 'name' => 'South Ayrshire', 'code' => 'ARYS']);
        $this->insert('state', ['id' => 265, 'country_id' => 73, 'name' => 'South Lanarkshire', 'code' => 'LANS']);
        $this->insert('state', ['id' => 266, 'country_id' => 73, 'name' => 'Yorkshire', 'code' => 'YKS']);
        $this->insert('state', ['id' => 267, 'country_id' => 73, 'name' => 'Staffordshire', 'code' => 'SFD']);
        $this->insert('state', ['id' => 268, 'country_id' => 73, 'name' => 'Stirling', 'code' => 'STIR']);
        $this->insert('state', ['id' => 269, 'country_id' => 73, 'name' => 'Suffolk', 'code' => 'SFK']);
        $this->insert('state', ['id' => 270, 'country_id' => 73, 'name' => 'Surrey', 'code' => 'SRY']);
        $this->insert('state', ['id' => 271, 'country_id' => 73, 'name' => 'Swansea', 'code' => 'SWAN']);
        $this->insert('state', ['id' => 272, 'country_id' => 73, 'name' => 'Torfaen', 'code' => 'TORF']);
        $this->insert('state', ['id' => 273, 'country_id' => 73, 'name' => 'Tyne and Wear', 'code' => 'TWR']);
        $this->insert('state', ['id' => 274, 'country_id' => 73, 'name' => 'Vale of Glamorgan', 'code' => 'VGLAM']);
        $this->insert('state', ['id' => 275, 'country_id' => 73, 'name' => 'Warwickshire', 'code' => 'WARKS']);
        $this->insert('state', ['id' => 276, 'country_id' => 73, 'name' => 'West Dunbartonshire', 'code' => 'WDUN']);
        $this->insert('state', ['id' => 277, 'country_id' => 73, 'name' => 'West Lothian', 'code' => 'WLOT']);
        $this->insert('state', ['id' => 278, 'country_id' => 73, 'name' => 'West Midlands', 'code' => 'WMD']);
        $this->insert('state', ['id' => 279, 'country_id' => 73, 'name' => 'West Sussex', 'code' => 'SXW']);
        $this->insert('state', ['id' => 280, 'country_id' => 73, 'name' => 'West Yorkshire', 'code' => 'YSW']);
        $this->insert('state', ['id' => 281, 'country_id' => 73, 'name' => 'Western Isles', 'code' => 'WIL']);
        $this->insert('state', ['id' => 282, 'country_id' => 73, 'name' => 'Wiltshire', 'code' => 'WLT']);
        $this->insert('state', ['id' => 283, 'country_id' => 73, 'name' => 'Worcestershire', 'code' => 'WORCS']);
        $this->insert('state', ['id' => 284, 'country_id' => 73, 'name' => 'Wrexham', 'code' => 'WRX']);
        $this->insert('state', ['id' => 285, 'country_id' => 39, 'name' => 'Grisons', 'code' => 'GR']);
        $this->insert('state', ['id' => 286, 'country_id' => 39, 'name' => 'Berne', 'code' => 'BE']);
        $this->insert('state', ['id' => 287, 'country_id' => 39, 'name' => 'Valais', 'code' => 'VS']);
        $this->insert('state', ['id' => 288, 'country_id' => 39, 'name' => 'Vaud', 'code' => 'VD']);
        $this->insert('state', ['id' => 289, 'country_id' => 39, 'name' => 'Tessin', 'code' => 'TI']);
        $this->insert('state', ['id' => 290, 'country_id' => 39, 'name' => 'Saint-Gall', 'code' => 'SG']);
        $this->insert('state', ['id' => 291, 'country_id' => 39, 'name' => 'Zurich', 'code' => 'ZH']);
        $this->insert('state', ['id' => 292, 'country_id' => 39, 'name' => 'Fribourg', 'code' => 'FR']);
        $this->insert('state', ['id' => 293, 'country_id' => 39, 'name' => 'Lucerne', 'code' => 'LU']);
        $this->insert('state', ['id' => 294, 'country_id' => 39, 'name' => 'Argovie', 'code' => 'AG']);
        $this->insert('state', ['id' => 295, 'country_id' => 39, 'name' => 'Uri', 'code' => 'UR']);
        $this->insert('state', ['id' => 296, 'country_id' => 39, 'name' => 'Thurgovie', 'code' => 'TG']);
        $this->insert('state', ['id' => 297, 'country_id' => 39, 'name' => 'Schwytz', 'code' => 'SZ']);
        $this->insert('state', ['id' => 298, 'country_id' => 39, 'name' => 'Jura', 'code' => 'JU']);
        $this->insert('state', ['id' => 299, 'country_id' => 39, 'name' => 'Neuchâtel', 'code' => 'NE']);
        $this->insert('state', ['id' => 300, 'country_id' => 39, 'name' => 'Soleure', 'code' => 'SO']);
        $this->insert('state', ['id' => 301, 'country_id' => 39, 'name' => 'Glaris', 'code' => 'GL']);
        $this->insert('state', ['id' => 302, 'country_id' => 39, 'name' => 'Bâle-Campagne', 'code' => 'BL']);
        $this->insert('state', ['id' => 303, 'country_id' => 39, 'name' => 'Obwald', 'code' => 'OW']);
        $this->insert('state', ['id' => 304, 'country_id' => 39, 'name' => 'Schaffhouse', 'code' => 'SH']);
        $this->insert('state', ['id' => 305, 'country_id' => 39, 'name' => 'Genève', 'code' => 'GE']);
        $this->insert('state', ['id' => 306, 'country_id' => 39, 'name' => 'Nidwald', 'code' => 'NW']);
        $this->insert('state', ['id' => 307, 'country_id' => 39, 'name' => 'Appenzell Rhodes-Extérieures', 'code' => 'AR']);
        $this->insert('state', ['id' => 308, 'country_id' => 39, 'name' => 'Zoug', 'code' => 'ZG']);
        $this->insert('state', ['id' => 309, 'country_id' => 39, 'name' => 'Appenzell Rhodes-Intérieures', 'code' => 'AI']);
        $this->insert('state', ['id' => 310, 'country_id' => 39, 'name' => 'Bâle-Ville', 'code' => 'BS']);
        $this->insert('state', ['id' => 385, 'country_id' => 103, 'name' => 'Agrigento', 'code' => 'AG']);
        $this->insert('state', ['id' => 386, 'country_id' => 103, 'name' => 'Alessandria', 'code' => 'AL']);
        $this->insert('state', ['id' => 387, 'country_id' => 103, 'name' => 'Ancona', 'code' => 'AN']);
        $this->insert('state', ['id' => 388, 'country_id' => 103, 'name' => 'Aosta', 'code' => 'AO']);
        $this->insert('state', ['id' => 389, 'country_id' => 103, 'name' => 'Arezzo', 'code' => 'AR']);
        $this->insert('state', ['id' => 390, 'country_id' => 103, 'name' => 'Ascoli Piceno', 'code' => 'AP']);
        $this->insert('state', ['id' => 391, 'country_id' => 103, 'name' => 'Asti', 'code' => 'AT']);
        $this->insert('state', ['id' => 392, 'country_id' => 103, 'name' => 'Avellino', 'code' => 'AV']);
        $this->insert('state', ['id' => 393, 'country_id' => 103, 'name' => 'Bari', 'code' => 'BA']);
        $this->insert('state', ['id' => 394, 'country_id' => 103, 'name' => 'Belluno', 'code' => 'BL']);
        $this->insert('state', ['id' => 395, 'country_id' => 103, 'name' => 'Benevento', 'code' => 'BN']);
        $this->insert('state', ['id' => 396, 'country_id' => 103, 'name' => 'Bergamo', 'code' => 'BG']);
        $this->insert('state', ['id' => 397, 'country_id' => 103, 'name' => 'Biella', 'code' => 'BI']);
        $this->insert('state', ['id' => 398, 'country_id' => 103, 'name' => 'Bologna', 'code' => 'BO']);
        $this->insert('state', ['id' => 399, 'country_id' => 103, 'name' => 'Bolzano', 'code' => 'BZ']);
        $this->insert('state', ['id' => 400, 'country_id' => 103, 'name' => 'Brescia', 'code' => 'BS']);
        $this->insert('state', ['id' => 401, 'country_id' => 103, 'name' => 'Brindisi', 'code' => 'BR']);
        $this->insert('state', ['id' => 402, 'country_id' => 103, 'name' => 'Cagliari', 'code' => 'CA']);
        $this->insert('state', ['id' => 403, 'country_id' => 103, 'name' => 'Caltanissetta', 'code' => 'CL']);
        $this->insert('state', ['id' => 404, 'country_id' => 103, 'name' => 'Campobasso', 'code' => 'CB']);
        $this->insert('state', ['id' => 405, 'country_id' => 103, 'name' => 'Carbonia-Iglesias', 'code' => 'CI']);
        $this->insert('state', ['id' => 406, 'country_id' => 103, 'name' => 'Caserta', 'code' => 'CE']);
        $this->insert('state', ['id' => 407, 'country_id' => 103, 'name' => 'Catania', 'code' => 'CT']);
        $this->insert('state', ['id' => 408, 'country_id' => 103, 'name' => 'Catanzaro', 'code' => 'CZ']);
        $this->insert('state', ['id' => 409, 'country_id' => 103, 'name' => 'Chieti', 'code' => 'CH']);
        $this->insert('state', ['id' => 410, 'country_id' => 103, 'name' => 'Como', 'code' => 'CO']);
        $this->insert('state', ['id' => 411, 'country_id' => 103, 'name' => 'Cosenza', 'code' => 'CS']);
        $this->insert('state', ['id' => 412, 'country_id' => 103, 'name' => 'Cremona', 'code' => 'CR']);
        $this->insert('state', ['id' => 413, 'country_id' => 103, 'name' => 'Crotone', 'code' => 'KR']);
        $this->insert('state', ['id' => 414, 'country_id' => 103, 'name' => 'Cuneo', 'code' => 'CN']);
        $this->insert('state', ['id' => 415, 'country_id' => 103, 'name' => 'Enna', 'code' => 'EN']);
        $this->insert('state', ['id' => 416, 'country_id' => 103, 'name' => 'Ferrara', 'code' => 'FE']);
        $this->insert('state', ['id' => 417, 'country_id' => 103, 'name' => 'Firenze', 'code' => 'FI']);
        $this->insert('state', ['id' => 418, 'country_id' => 103, 'name' => 'Foggia', 'code' => 'FG']);
        $this->insert('state', ['id' => 419, 'country_id' => 103, 'name' => 'Forli-Cesena', 'code' => 'FC']);
        $this->insert('state', ['id' => 420, 'country_id' => 103, 'name' => 'Frosinone', 'code' => 'FR']);
        $this->insert('state', ['id' => 421, 'country_id' => 103, 'name' => 'Genova', 'code' => 'GE']);
        $this->insert('state', ['id' => 422, 'country_id' => 103, 'name' => 'Gorizia', 'code' => 'GO']);
        $this->insert('state', ['id' => 423, 'country_id' => 103, 'name' => 'Grosseto', 'code' => 'GR']);
        $this->insert('state', ['id' => 424, 'country_id' => 103, 'name' => 'Imperia', 'code' => 'IM']);
        $this->insert('state', ['id' => 425, 'country_id' => 103, 'name' => 'Isernia', 'code' => 'IS']);
        $this->insert('state', ['id' => 426, 'country_id' => 103, 'name' => 'La Spezia', 'code' => 'SP']);
        $this->insert('state', ['id' => 427, 'country_id' => 103, 'name' => 'L\'Aquila', 'code' => 'AQ']);
        $this->insert('state', ['id' => 428, 'country_id' => 103, 'name' => 'Latina', 'code' => 'LT']);
        $this->insert('state', ['id' => 429, 'country_id' => 103, 'name' => 'Lecce', 'code' => 'LE']);
        $this->insert('state', ['id' => 430, 'country_id' => 103, 'name' => 'Lecco', 'code' => 'LC']);
        $this->insert('state', ['id' => 431, 'country_id' => 103, 'name' => 'Livorno', 'code' => 'LI']);
        $this->insert('state', ['id' => 432, 'country_id' => 103, 'name' => 'Lodi', 'code' => 'LO']);
        $this->insert('state', ['id' => 433, 'country_id' => 103, 'name' => 'Lucca', 'code' => 'LU']);
        $this->insert('state', ['id' => 434, 'country_id' => 103, 'name' => 'Macerata', 'code' => 'MC']);
        $this->insert('state', ['id' => 435, 'country_id' => 103, 'name' => 'Mantova', 'code' => 'MN']);
        $this->insert('state', ['id' => 436, 'country_id' => 103, 'name' => 'Massa-Carrara', 'code' => 'MS']);
        $this->insert('state', ['id' => 437, 'country_id' => 103, 'name' => 'Matera', 'code' => 'MT']);
        $this->insert('state', ['id' => 438, 'country_id' => 103, 'name' => 'Messina', 'code' => 'ME']);
        $this->insert('state', ['id' => 439, 'country_id' => 103, 'name' => 'Milano', 'code' => 'MI']);
        $this->insert('state', ['id' => 440, 'country_id' => 103, 'name' => 'Modena', 'code' => 'MO']);
        $this->insert('state', ['id' => 441, 'country_id' => 103, 'name' => 'Napoli', 'code' => 'NA']);
        $this->insert('state', ['id' => 442, 'country_id' => 103, 'name' => 'Novara', 'code' => 'NO']);
        $this->insert('state', ['id' => 443, 'country_id' => 103, 'name' => 'Nuoro', 'code' => 'NU']);
        $this->insert('state', ['id' => 444, 'country_id' => 103, 'name' => 'Olbia-Tempio', 'code' => 'OT']);
        $this->insert('state', ['id' => 445, 'country_id' => 103, 'name' => 'Oristano', 'code' => 'OR']);
        $this->insert('state', ['id' => 446, 'country_id' => 103, 'name' => 'Padova', 'code' => 'PD']);
        $this->insert('state', ['id' => 447, 'country_id' => 103, 'name' => 'Palermo', 'code' => 'PA']);
        $this->insert('state', ['id' => 448, 'country_id' => 103, 'name' => 'Parma', 'code' => 'PR']);
        $this->insert('state', ['id' => 449, 'country_id' => 103, 'name' => 'Pavia', 'code' => 'PV']);
        $this->insert('state', ['id' => 450, 'country_id' => 103, 'name' => 'Perugia', 'code' => 'PG']);
        $this->insert('state', ['id' => 451, 'country_id' => 103, 'name' => 'Pesaro e Urbino', 'code' => 'PU']);
        $this->insert('state', ['id' => 452, 'country_id' => 103, 'name' => 'Pescara', 'code' => 'PE']);
        $this->insert('state', ['id' => 453, 'country_id' => 103, 'name' => 'Piacenza', 'code' => 'PC']);
        $this->insert('state', ['id' => 454, 'country_id' => 103, 'name' => 'Pisa', 'code' => 'PI']);
        $this->insert('state', ['id' => 455, 'country_id' => 103, 'name' => 'Pistoia', 'code' => 'PT']);
        $this->insert('state', ['id' => 456, 'country_id' => 103, 'name' => 'Pordenone', 'code' => 'PN']);
        $this->insert('state', ['id' => 457, 'country_id' => 103, 'name' => 'Potenza', 'code' => 'PZ']);
        $this->insert('state', ['id' => 458, 'country_id' => 103, 'name' => 'Prato', 'code' => 'PO']);
        $this->insert('state', ['id' => 459, 'country_id' => 103, 'name' => 'Ragusa', 'code' => 'RG']);
        $this->insert('state', ['id' => 460, 'country_id' => 103, 'name' => 'Ravenna', 'code' => 'RA']);
        $this->insert('state', ['id' => 461, 'country_id' => 103, 'name' => 'Reggio Calabria', 'code' => 'RC']);
        $this->insert('state', ['id' => 462, 'country_id' => 103, 'name' => 'Reggio Emilia', 'code' => 'RE']);
        $this->insert('state', ['id' => 463, 'country_id' => 103, 'name' => 'Rieti', 'code' => 'RI']);
        $this->insert('state', ['id' => 464, 'country_id' => 103, 'name' => 'Rimini', 'code' => 'RN']);
        $this->insert('state', ['id' => 465, 'country_id' => 103, 'name' => 'Roma', 'code' => 'RM']);
        $this->insert('state', ['id' => 466, 'country_id' => 103, 'name' => 'Rovigo', 'code' => 'RO']);
        $this->insert('state', ['id' => 467, 'country_id' => 103, 'name' => 'Salerno', 'code' => 'SA']);
        $this->insert('state', ['id' => 468, 'country_id' => 103, 'name' => 'Medio Campidano', 'code' => 'VS']);
        $this->insert('state', ['id' => 469, 'country_id' => 103, 'name' => 'Sassari', 'code' => 'SS']);
        $this->insert('state', ['id' => 470, 'country_id' => 103, 'name' => 'Savona', 'code' => 'SV']);
        $this->insert('state', ['id' => 471, 'country_id' => 103, 'name' => 'Siena', 'code' => 'SI']);
        $this->insert('state', ['id' => 472, 'country_id' => 103, 'name' => 'Siracusa', 'code' => 'SR']);
        $this->insert('state', ['id' => 473, 'country_id' => 103, 'name' => 'Sondrio', 'code' => 'SO']);
        $this->insert('state', ['id' => 474, 'country_id' => 103, 'name' => 'Taranto', 'code' => 'TA']);
        $this->insert('state', ['id' => 475, 'country_id' => 103, 'name' => 'Teramo', 'code' => 'TE']);
        $this->insert('state', ['id' => 476, 'country_id' => 103, 'name' => 'Terni', 'code' => 'TR']);
        $this->insert('state', ['id' => 477, 'country_id' => 103, 'name' => 'Torino', 'code' => 'TO']);
        $this->insert('state', ['id' => 478, 'country_id' => 103, 'name' => 'Ogliastra', 'code' => 'OG']);
        $this->insert('state', ['id' => 479, 'country_id' => 103, 'name' => 'Trapani', 'code' => 'TP']);
        $this->insert('state', ['id' => 480, 'country_id' => 103, 'name' => 'Trento', 'code' => 'TN']);
        $this->insert('state', ['id' => 481, 'country_id' => 103, 'name' => 'Treviso', 'code' => 'TV']);
        $this->insert('state', ['id' => 482, 'country_id' => 103, 'name' => 'Trieste', 'code' => 'TS']);
        $this->insert('state', ['id' => 483, 'country_id' => 103, 'name' => 'Udine', 'code' => 'UD']);
        $this->insert('state', ['id' => 484, 'country_id' => 103, 'name' => 'Varese', 'code' => 'VA']);
        $this->insert('state', ['id' => 485, 'country_id' => 103, 'name' => 'Venezia', 'code' => 'VE']);
        $this->insert('state', ['id' => 486, 'country_id' => 103, 'name' => 'Verbano-Cusio-Ossola', 'code' => 'VB']);
        $this->insert('state', ['id' => 487, 'country_id' => 103, 'name' => 'Vercelli', 'code' => 'VC']);
        $this->insert('state', ['id' => 488, 'country_id' => 103, 'name' => 'Verona', 'code' => 'VR']);
        $this->insert('state', ['id' => 489, 'country_id' => 103, 'name' => 'Vibo Valentia', 'code' => 'VV']);
        $this->insert('state', ['id' => 490, 'country_id' => 103, 'name' => 'Vicenza', 'code' => 'VI']);
        $this->insert('state', ['id' => 491, 'country_id' => 103, 'name' => 'Viterbo', 'code' => 'VT']);
        $this->insert('state', ['id' => 492, 'country_id' => 73, 'name' => 'County Antrim', 'code' => 'ANT']);
        $this->insert('state', ['id' => 493, 'country_id' => 73, 'name' => 'County Armagh', 'code' => 'ARM']);
        $this->insert('state', ['id' => 494, 'country_id' => 73, 'name' => 'County Down', 'code' => 'DOW']);
        $this->insert('state', ['id' => 495, 'country_id' => 73, 'name' => 'County Fermanagh', 'code' => 'FER']);
        $this->insert('state', ['id' => 496, 'country_id' => 73, 'name' => 'County Londonderry', 'code' => 'LDY']);
        $this->insert('state', ['id' => 497, 'country_id' => 73, 'name' => 'County Tyrone', 'code' => 'TYR']);
        $this->insert('state', ['id' => 498, 'country_id' => 222, 'name' => 'Northern Mariana Islands', 'code' => 'MP']);
        $this->insert('state', ['id' => 499, 'country_id' => 73, 'name' => 'Avon', 'code' => 'AVN']);
        $this->insert('state', ['id' => 500, 'country_id' => 73, 'name' => 'Cleveland', 'code' => 'CLV']);
        $this->insert('state', ['id' => 501, 'country_id' => 73, 'name' => 'Cumbria', 'code' => 'CMA']);
        $this->insert('state', ['id' => 502, 'country_id' => 73, 'name' => 'Middlesex', 'code' => 'MDX']);
        $this->insert('state', ['id' => 503, 'country_id' => 73, 'name' => 'Isles of Scilly', 'code' => 'IOS']);
        $this->insert('state', ['id' => 504, 'country_id' => 73, 'name' => 'Humberside', 'code' => 'HUM']);
        $this->insert('state', ['id' => 505, 'country_id' => 73, 'name' => 'South Yorkshire', 'code' => 'SYK']);
        $this->insert('state', ['id' => 506, 'country_id' => 73, 'name' => 'Banffshire', 'code' => 'BAN']);
        $this->insert('state', ['id' => 507, 'country_id' => 73, 'name' => 'Berwickshire', 'code' => 'BEW']);
        $this->insert('state', ['id' => 508, 'country_id' => 73, 'name' => 'Caithness', 'code' => 'CAI']);
        $this->insert('state', ['id' => 509, 'country_id' => 73, 'name' => 'Dumfries-shire', 'code' => 'DFS']);
        $this->insert('state', ['id' => 510, 'country_id' => 73, 'name' => 'Inverness-shire', 'code' => 'INV']);
        $this->insert('state', ['id' => 511, 'country_id' => 73, 'name' => 'Kincardineshire', 'code' => 'KCD']);
        $this->insert('state', ['id' => 512, 'country_id' => 73, 'name' => 'Nairnshire', 'code' => 'NAI']);
        $this->insert('state', ['id' => 513, 'country_id' => 73, 'name' => 'Peebles-shire', 'code' => 'PEE']);
        $this->insert('state', ['id' => 514, 'country_id' => 73, 'name' => 'Roxburghshire', 'code' => 'ROX']);
        $this->insert('state', ['id' => 515, 'country_id' => 73, 'name' => 'Selkirkshire', 'code' => 'SEL']);
        $this->insert('state', ['id' => 516, 'country_id' => 73, 'name' => 'Stirlingshire', 'code' => 'STI']);
        $this->insert('state', ['id' => 517, 'country_id' => 73, 'name' => 'Sutherland', 'code' => 'SUT']);
        $this->insert('state', ['id' => 518, 'country_id' => 73, 'name' => 'Wigtownshire', 'code' => 'WIG']);
        $this->insert('state', ['id' => 519, 'country_id' => 73, 'name' => 'Clwyd', 'code' => 'CWD']);
        $this->insert('state', ['id' => 520, 'country_id' => 73, 'name' => 'Dyfed', 'code' => 'DFD']);
        $this->insert('state', ['id' => 521, 'country_id' => 73, 'name' => 'Merionethshire', 'code' => 'MER']);
        $this->insert('state', ['id' => 522, 'country_id' => 182, 'name' => 'Республика Адыгея', 'code' => 'AD']);
        $this->insert('state', ['id' => 523, 'country_id' => 182, 'name' => 'Республика Алтай', 'code' => 'AL']);
        $this->insert('state', ['id' => 524, 'country_id' => 182, 'name' => 'Республика Башкортостан', 'code' => 'BA']);
        $this->insert('state', ['id' => 525, 'country_id' => 182, 'name' => 'Республика Бурятия', 'code' => 'BU']);
        $this->insert('state', ['id' => 526, 'country_id' => 182, 'name' => 'Республика Дагестан', 'code' => 'DA']);
        $this->insert('state', ['id' => 527, 'country_id' => 182, 'name' => 'Республика Ингушетия', 'code' => 'IN']);
        $this->insert('state', ['id' => 528, 'country_id' => 182, 'name' => 'Кабардино-Балкарская Республика', 'code' => 'KB']);
        $this->insert('state', ['id' => 529, 'country_id' => 182, 'name' => 'Республика Калмыкия', 'code' => 'KL']);
        $this->insert('state', ['id' => 530, 'country_id' => 182, 'name' => 'Карачаево-Черкесская республика', 'code' => 'KC']);
        $this->insert('state', ['id' => 531, 'country_id' => 182, 'name' => 'Республика Карелия', 'code' => 'KR']);
        $this->insert('state', ['id' => 532, 'country_id' => 182, 'name' => 'Республика Коми', 'code' => 'KO']);
        $this->insert('state', ['id' => 533, 'country_id' => 182, 'name' => 'Республика Марий Эл', 'code' => 'ME']);
        $this->insert('state', ['id' => 534, 'country_id' => 182, 'name' => 'Республика Мордовия', 'code' => 'MO']);
        $this->insert('state', ['id' => 535, 'country_id' => 182, 'name' => 'Республика Саха (Якутия)', 'code' => 'SA']);
        $this->insert('state', ['id' => 536, 'country_id' => 182, 'name' => 'Республика Северная Осетия — Алания', 'code' => 'SE']);
        $this->insert('state', ['id' => 537, 'country_id' => 182, 'name' => 'Республика Татарстан', 'code' => 'TA']);
        $this->insert('state', ['id' => 538, 'country_id' => 182, 'name' => 'Республика Тыва', 'code' => 'TY']);
        $this->insert('state', ['id' => 539, 'country_id' => 182, 'name' => 'Удмуртская Республика', 'code' => 'UD']);
        $this->insert('state', ['id' => 540, 'country_id' => 182, 'name' => 'Республика Хакасия', 'code' => 'KK']);
        $this->insert('state', ['id' => 541, 'country_id' => 182, 'name' => 'Чеченская республика', 'code' => 'CE']);
        $this->insert('state', ['id' => 542, 'country_id' => 182, 'name' => 'Чувашская Республика', 'code' => 'CU']);
        $this->insert('state', ['id' => 543, 'country_id' => 182, 'name' => 'Алтайский край', 'code' => 'ALT']);
        $this->insert('state', ['id' => 544, 'country_id' => 182, 'name' => 'Краснодарский край', 'code' => 'KDA']);
        $this->insert('state', ['id' => 545, 'country_id' => 182, 'name' => 'Красноярский край', 'code' => 'KIA']);
        $this->insert('state', ['id' => 546, 'country_id' => 182, 'name' => 'Пермский край', 'code' => 'PER']);
        $this->insert('state', ['id' => 547, 'country_id' => 182, 'name' => 'Приморский край', 'code' => 'PRI']);
        $this->insert('state', ['id' => 548, 'country_id' => 182, 'name' => 'Ставропольский край', 'code' => 'STA']);
        $this->insert('state', ['id' => 549, 'country_id' => 182, 'name' => 'Хабаровский край', 'code' => 'KHA']);
        $this->insert('state', ['id' => 550, 'country_id' => 182, 'name' => 'Амурская область', 'code' => 'AMU']);
        $this->insert('state', ['id' => 551, 'country_id' => 182, 'name' => 'Архангельская область', 'code' => 'ARK']);
        $this->insert('state', ['id' => 552, 'country_id' => 182, 'name' => 'Астраханская область', 'code' => 'AST']);
        $this->insert('state', ['id' => 553, 'country_id' => 182, 'name' => 'Белгородская область', 'code' => 'BEL']);
        $this->insert('state', ['id' => 554, 'country_id' => 182, 'name' => 'Брянская область', 'code' => 'BRY']);
        $this->insert('state', ['id' => 555, 'country_id' => 182, 'name' => 'Владимирская область', 'code' => 'VLA']);
        $this->insert('state', ['id' => 556, 'country_id' => 182, 'name' => 'Волгоградская область', 'code' => 'VGG']);
        $this->insert('state', ['id' => 557, 'country_id' => 182, 'name' => 'Вологодская область', 'code' => 'VLG']);
        $this->insert('state', ['id' => 558, 'country_id' => 182, 'name' => 'Воронежская область', 'code' => 'VOR']);
        $this->insert('state', ['id' => 559, 'country_id' => 182, 'name' => 'Ивановская область', 'code' => 'IVA']);
        $this->insert('state', ['id' => 560, 'country_id' => 182, 'name' => 'Иркутская область', 'code' => 'IRK']);
        $this->insert('state', ['id' => 561, 'country_id' => 182, 'name' => 'Калининградская область', 'code' => 'KGD']);
        $this->insert('state', ['id' => 562, 'country_id' => 182, 'name' => 'Калужская область', 'code' => 'KLU']);
        $this->insert('state', ['id' => 564, 'country_id' => 182, 'name' => 'Кемеровская область', 'code' => 'KEM']);
        $this->insert('state', ['id' => 565, 'country_id' => 182, 'name' => 'Кировская область', 'code' => 'KIR']);
        $this->insert('state', ['id' => 566, 'country_id' => 182, 'name' => 'Костромская область', 'code' => 'KOS']);
        $this->insert('state', ['id' => 567, 'country_id' => 182, 'name' => 'Курганская область', 'code' => 'KGN']);
        $this->insert('state', ['id' => 568, 'country_id' => 182, 'name' => 'Курская область', 'code' => 'KRS']);
        $this->insert('state', ['id' => 569, 'country_id' => 182, 'name' => 'Ленинградская область', 'code' => 'LEN']);
        $this->insert('state', ['id' => 570, 'country_id' => 182, 'name' => 'Липецкая область', 'code' => 'LIP']);
        $this->insert('state', ['id' => 571, 'country_id' => 182, 'name' => 'Магаданская область', 'code' => 'MAG']);
        $this->insert('state', ['id' => 572, 'country_id' => 182, 'name' => 'Московская область', 'code' => 'MOS']);
        $this->insert('state', ['id' => 573, 'country_id' => 182, 'name' => 'Мурманская область', 'code' => 'MUR']);
        $this->insert('state', ['id' => 574, 'country_id' => 182, 'name' => 'Нижегородская область', 'code' => 'NIZ']);
        $this->insert('state', ['id' => 575, 'country_id' => 182, 'name' => 'Новгородская область', 'code' => 'NGR']);
        $this->insert('state', ['id' => 576, 'country_id' => 182, 'name' => 'Новосибирская область', 'code' => 'NVS']);
        $this->insert('state', ['id' => 577, 'country_id' => 182, 'name' => 'Омская область', 'code' => 'OMS']);
        $this->insert('state', ['id' => 578, 'country_id' => 182, 'name' => 'Оренбургская область', 'code' => 'ORE']);
        $this->insert('state', ['id' => 579, 'country_id' => 182, 'name' => 'Орловская область', 'code' => 'ORL']);
        $this->insert('state', ['id' => 580, 'country_id' => 182, 'name' => 'Пензенская область', 'code' => 'PNZ']);
        $this->insert('state', ['id' => 581, 'country_id' => 182, 'name' => 'Псковская область', 'code' => 'PSK']);
        $this->insert('state', ['id' => 582, 'country_id' => 182, 'name' => 'Ростовская область', 'code' => 'ROS']);
        $this->insert('state', ['id' => 583, 'country_id' => 182, 'name' => 'Рязанская область', 'code' => 'RYA']);
        $this->insert('state', ['id' => 584, 'country_id' => 182, 'name' => 'Самарская область', 'code' => 'SAM']);
        $this->insert('state', ['id' => 585, 'country_id' => 182, 'name' => 'Саратовская область', 'code' => 'SAR']);
        $this->insert('state', ['id' => 586, 'country_id' => 182, 'name' => 'Сахалинская область', 'code' => 'SAK']);
        $this->insert('state', ['id' => 587, 'country_id' => 182, 'name' => 'Свердловская область', 'code' => 'SVE']);
        $this->insert('state', ['id' => 588, 'country_id' => 182, 'name' => 'Смоленская область', 'code' => 'SMO']);
        $this->insert('state', ['id' => 589, 'country_id' => 182, 'name' => 'Тамбовская область', 'code' => 'TAM']);
        $this->insert('state', ['id' => 590, 'country_id' => 182, 'name' => 'Тверская область', 'code' => 'TVE']);
        $this->insert('state', ['id' => 591, 'country_id' => 182, 'name' => 'Томская область', 'code' => 'TOM']);
        $this->insert('state', ['id' => 592, 'country_id' => 182, 'name' => 'Тульская область', 'code' => 'TUL']);
        $this->insert('state', ['id' => 593, 'country_id' => 182, 'name' => 'Тюменская область', 'code' => 'TYU']);
        $this->insert('state', ['id' => 594, 'country_id' => 182, 'name' => 'Ульяновская область', 'code' => 'ULY']);
        $this->insert('state', ['id' => 595, 'country_id' => 182, 'name' => 'Челябинская область', 'code' => 'CHE']);
        $this->insert('state', ['id' => 597, 'country_id' => 182, 'name' => 'Ярославская область', 'code' => 'YAR']);
        $this->insert('state', ['id' => 598, 'country_id' => 182, 'name' => 'Москва', 'code' => 'MOW']);
        $this->insert('state', ['id' => 599, 'country_id' => 182, 'name' => 'Санкт-Петербург', 'code' => 'SPE']);
        $this->insert('state', ['id' => 600, 'country_id' => 182, 'name' => 'Еврейская автономная область', 'code' => 'YEV']);
        $this->insert('state', ['id' => 603, 'country_id' => 182, 'name' => 'Ненецкий автономный округ', 'code' => 'NEN']);
        $this->insert('state', ['id' => 605, 'country_id' => 182, 'name' => 'Ханты-Мансийский автономный округ — Югра', 'code' => 'KHM']);
        $this->insert('state', ['id' => 606, 'country_id' => 182, 'name' => 'Чукотский автономный округ', 'code' => 'CHU']);
        $this->insert('state', ['id' => 607, 'country_id' => 182, 'name' => 'Ямало-Ненецкий автономный округ', 'code' => 'YAN']);
        $this->insert('state', ['id' => 608, 'country_id' => 182, 'name' => 'Забайкальский край', 'code' => 'ZAB']);
        $this->insert('state', ['id' => 609, 'country_id' => 182, 'name' => 'Камчатский край', 'code' => 'KAM']);
        $this->insert('state', ['id' => 610, 'country_id' => 70, 'name' => 'Mayenne', 'code' => '53']);
        $this->insert('state', ['id' => 611, 'country_id' => 70, 'name' => 'Meurthe-et-Moselle', 'code' => '54']);
        $this->insert('state', ['id' => 612, 'country_id' => 70, 'name' => 'Meuse', 'code' => '55']);
        $this->insert('state', ['id' => 613, 'country_id' => 70, 'name' => 'Morbihan', 'code' => '56']);
        $this->insert('state', ['id' => 614, 'country_id' => 70, 'name' => 'Moselle', 'code' => '57']);
        $this->insert('state', ['id' => 615, 'country_id' => 70, 'name' => 'Nièvre', 'code' => '58']);
        $this->insert('state', ['id' => 616, 'country_id' => 70, 'name' => 'Nord', 'code' => '59']);
        $this->insert('state', ['id' => 617, 'country_id' => 70, 'name' => 'Oise', 'code' => '60']);
        $this->insert('state', ['id' => 618, 'country_id' => 70, 'name' => 'Orne', 'code' => '61']);
        $this->insert('state', ['id' => 619, 'country_id' => 70, 'name' => 'Pas-de-Calais', 'code' => '62']);
        $this->insert('state', ['id' => 620, 'country_id' => 70, 'name' => 'Puy-de-Dôme', 'code' => '63']);
        $this->insert('state', ['id' => 621, 'country_id' => 70, 'name' => 'Pyrénées-Atlantiques', 'code' => '64']);
        $this->insert('state', ['id' => 622, 'country_id' => 70, 'name' => 'Hautes-Pyrénées', 'code' => '65']);
        $this->insert('state', ['id' => 623, 'country_id' => 70, 'name' => 'Pyrénées-Orientales', 'code' => '66']);
        $this->insert('state', ['id' => 624, 'country_id' => 70, 'name' => 'Bas-Rhin', 'code' => '67']);
        $this->insert('state', ['id' => 625, 'country_id' => 70, 'name' => 'Haut-Rhin', 'code' => '68']);
        $this->insert('state', ['id' => 626, 'country_id' => 70, 'name' => 'Rhône', 'code' => '69']);
        $this->insert('state', ['id' => 627, 'country_id' => 70, 'name' => 'Haute-Saône', 'code' => '70']);
        $this->insert('state', ['id' => 628, 'country_id' => 70, 'name' => 'Saône-et-Loire', 'code' => '71']);
        $this->insert('state', ['id' => 629, 'country_id' => 70, 'name' => 'Sarthe', 'code' => '72']);
        $this->insert('state', ['id' => 630, 'country_id' => 70, 'name' => 'Savoie', 'code' => '73']);
        $this->insert('state', ['id' => 631, 'country_id' => 70, 'name' => 'Haute-Savoie', 'code' => '74']);
        $this->insert('state', ['id' => 632, 'country_id' => 70, 'name' => 'Seine-Maritime', 'code' => '76']);
        $this->insert('state', ['id' => 633, 'country_id' => 70, 'name' => 'Seine-et-Marne', 'code' => '77']);
        $this->insert('state', ['id' => 634, 'country_id' => 70, 'name' => 'Yvelines', 'code' => '78']);
        $this->insert('state', ['id' => 635, 'country_id' => 70, 'name' => 'Deux-Sèvres', 'code' => '79']);
        $this->insert('state', ['id' => 636, 'country_id' => 63, 'name' => 'A Coruña', 'code' => 'C']);
        $this->insert('state', ['id' => 637, 'country_id' => 63, 'name' => 'Álava', 'code' => 'VI']);
        $this->insert('state', ['id' => 638, 'country_id' => 63, 'name' => 'Albacete', 'code' => 'AB']);
        $this->insert('state', ['id' => 639, 'country_id' => 63, 'name' => 'Alicante', 'code' => 'A']);
        $this->insert('state', ['id' => 640, 'country_id' => 63, 'name' => 'Almería', 'code' => 'AL']);
        $this->insert('state', ['id' => 641, 'country_id' => 63, 'name' => 'Asturias', 'code' => 'O']);
        $this->insert('state', ['id' => 642, 'country_id' => 63, 'name' => 'Ávila', 'code' => 'AV']);
        $this->insert('state', ['id' => 643, 'country_id' => 63, 'name' => 'Badajoz', 'code' => 'BA']);
        $this->insert('state', ['id' => 644, 'country_id' => 63, 'name' => 'Baleares', 'code' => 'PM']);
        $this->insert('state', ['id' => 645, 'country_id' => 63, 'name' => 'Barcelona', 'code' => 'B']);
        $this->insert('state', ['id' => 646, 'country_id' => 63, 'name' => 'Burgos', 'code' => 'BU']);
        $this->insert('state', ['id' => 647, 'country_id' => 63, 'name' => 'Cáceres', 'code' => 'CC']);
        $this->insert('state', ['id' => 648, 'country_id' => 63, 'name' => 'Cádiz', 'code' => 'CA']);
        $this->insert('state', ['id' => 649, 'country_id' => 63, 'name' => 'Cantabria', 'code' => 'S']);
        $this->insert('state', ['id' => 650, 'country_id' => 63, 'name' => 'Castellón', 'code' => 'CS']);
        $this->insert('state', ['id' => 651, 'country_id' => 63, 'name' => 'Ceuta', 'code' => 'CE']);
        $this->insert('state', ['id' => 652, 'country_id' => 63, 'name' => 'Ciudad Real', 'code' => 'CR']);
        $this->insert('state', ['id' => 653, 'country_id' => 63, 'name' => 'Córdoba', 'code' => 'CO']);
        $this->insert('state', ['id' => 654, 'country_id' => 63, 'name' => 'Cuenca', 'code' => 'CU']);
        $this->insert('state', ['id' => 655, 'country_id' => 63, 'name' => 'Girona', 'code' => 'GI']);
        $this->insert('state', ['id' => 656, 'country_id' => 63, 'name' => 'Granada', 'code' => 'GR']);
        $this->insert('state', ['id' => 657, 'country_id' => 63, 'name' => 'Guadalajara', 'code' => 'GU']);
        $this->insert('state', ['id' => 658, 'country_id' => 63, 'name' => 'Guipúzcoa', 'code' => 'SS']);
        $this->insert('state', ['id' => 659, 'country_id' => 63, 'name' => 'Huelva', 'code' => 'H']);
        $this->insert('state', ['id' => 660, 'country_id' => 63, 'name' => 'Huesca', 'code' => 'HU']);
        $this->insert('state', ['id' => 661, 'country_id' => 63, 'name' => 'Jaén', 'code' => 'J']);
        $this->insert('state', ['id' => 662, 'country_id' => 63, 'name' => 'La Rioja', 'code' => 'LO']);
        $this->insert('state', ['id' => 663, 'country_id' => 63, 'name' => 'Las Palmas', 'code' => 'GC']);
        $this->insert('state', ['id' => 664, 'country_id' => 63, 'name' => 'León', 'code' => 'LE']);
        $this->insert('state', ['id' => 665, 'country_id' => 63, 'name' => 'Lleida', 'code' => 'L']);
        $this->insert('state', ['id' => 666, 'country_id' => 63, 'name' => 'Lugo', 'code' => 'LU']);
        $this->insert('state', ['id' => 667, 'country_id' => 63, 'name' => 'Madrid', 'code' => 'M']);
        $this->insert('state', ['id' => 668, 'country_id' => 63, 'name' => 'Málaga', 'code' => 'MA']);
        $this->insert('state', ['id' => 669, 'country_id' => 63, 'name' => 'Melilla', 'code' => 'ML']);
        $this->insert('state', ['id' => 670, 'country_id' => 63, 'name' => 'Murcia', 'code' => 'MU']);
        $this->insert('state', ['id' => 671, 'country_id' => 63, 'name' => 'Navarra', 'code' => 'NA']);
        $this->insert('state', ['id' => 672, 'country_id' => 63, 'name' => 'Ourense', 'code' => 'OR']);
        $this->insert('state', ['id' => 673, 'country_id' => 63, 'name' => 'Palencia', 'code' => 'P']);
        $this->insert('state', ['id' => 674, 'country_id' => 63, 'name' => 'Pontevedra', 'code' => 'PO']);
        $this->insert('state', ['id' => 675, 'country_id' => 63, 'name' => 'Salamanca', 'code' => 'SA']);
        $this->insert('state', ['id' => 676, 'country_id' => 63, 'name' => 'Santa Cruz de Tenerife', 'code' => 'TF']);
        $this->insert('state', ['id' => 677, 'country_id' => 63, 'name' => 'Segovia', 'code' => 'SG']);
        $this->insert('state', ['id' => 678, 'country_id' => 63, 'name' => 'Sevilla', 'code' => 'SE']);
        $this->insert('state', ['id' => 679, 'country_id' => 63, 'name' => 'Soria', 'code' => 'SO']);
        $this->insert('state', ['id' => 680, 'country_id' => 63, 'name' => 'Tarragona', 'code' => 'T']);
        $this->insert('state', ['id' => 681, 'country_id' => 63, 'name' => 'Teruel', 'code' => 'TE']);
        $this->insert('state', ['id' => 682, 'country_id' => 63, 'name' => 'Toledo', 'code' => 'TO']);
        $this->insert('state', ['id' => 683, 'country_id' => 63, 'name' => 'Valencia', 'code' => 'V']);
        $this->insert('state', ['id' => 684, 'country_id' => 63, 'name' => 'Valladolid', 'code' => 'VA']);
        $this->insert('state', ['id' => 685, 'country_id' => 63, 'name' => 'Vizcaya', 'code' => 'BI']);
        $this->insert('state', ['id' => 686, 'country_id' => 63, 'name' => 'Zamora', 'code' => 'ZA']);
        $this->insert('state', ['id' => 687, 'country_id' => 63, 'name' => 'Zaragoza', 'code' => 'Z']);
        $this->insert('state', ['id' => 688, 'country_id' => 21, 'name' => 'София', 'code' => 'SF']);


        $this->createTable('user', [
            'id'                   => $this->primaryKey(),
            'email'                => $this->string()->notNull(),
            'name'                 => $this->string()->notNull(),
            'auth_key'             => $this->string(32)->notNull(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'status'               => $this->integer()->defaultValue(1),
            'country_id'           => $this->integer(),
            'state_id'             => $this->integer(),
            'state'                => $this->string(),
            'city'                 => $this->string(),
            'address'              => $this->string(),
            'created_at'           => $this->integer()->notNull(),
            'updated_at'           => $this->integer()->notNull(),
        ], $this->getTableOptions());
        $this->addForeignKey('user_country', 'user', 'country_id', 'country', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('user_state', 'user', 'state_id', 'state', 'id', 'RESTRICT', 'RESTRICT');

        $this->insert('user', [ // Auth: root@example.com/root
            'id' => 1,
            'name' => 'Root Admin',
            'email' => 'root@example.com',
            'auth_key' => 'JxTq8CyzZwAa85PYUVy1GuI0X3WmUWUW',
            'password_hash' => '$2y$13$CPWVAx9rW6IYpVD7dU.mNe/mUWty8WN6Dheo0IrRkVAvubamuPqxK',
            'status' => 1,
            'created_at' => 0,
            'updated_at' => 0,
        ]);

    }

    public function down()
    {
        $this->dropTable('user');
        $this->dropTable('state');
        $this->dropTable('country');
        $this->dropTable('image');
        $this->dropTable('attachment');
        $this->dropTable('language');
        $this->dropTable('lookup');
        $this->dropTable('setting');
    }

    protected function getTableOptions()
    {
        if ($this->db->driverName === 'mysql') {
            return 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
    }

}
