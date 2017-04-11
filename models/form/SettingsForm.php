<?php

namespace app\models\form;

use app\models\components\LookupTrait;
use app\models\Setting;
use yii\base\Model;

/**
 * SettingsForm is the model behind the contact form.
 */
class SettingsForm extends Model
{
    use LookupTrait;

    /**
     * Settings
     */
    // General
    public $brandName;
    public $applicationName;
    public $companyName;
    public $poweredBy;
    public $adminEmail;
    public $supportEmail;

    // Email
    public $mailSendMethod;
    public $smtpHost;
    public $smtpUsername;
    public $smtpPassword;
    public $smtpEncrypt;

    // Descriptions
    public $mainpage_description;
    public $aboutpage_description;
    public $faqpage_description;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [$this->attributes(), 'safe'],
            [['adminEmail', 'supportEmail'], 'email'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            // General
            'brandName' => __('Brand name'),
            'applicationName' => __('Application name'),
            'companyName' => __('Company name'),
            'poweredBy' => __('Powered by'),
            'adminEmail' => __('Admin email'),
            'supportEmail' => __('Support email'),

            // Email
            'mailSendMethod' => __('Method of sending emails'),
            'smtpHost' => __('SMTP host'),
            'smtpUsername' => __('SMTP username'),
            'smtpPassword' => __('SMTP password'),
            'smtpEncrypt' => __('SMTP encrypted connection'),

            // Descriptions
            'mainpage_description' => __('Main page'),
            'aboutpage_description' => __('About'),
            'faqpage_description' => __('FAQ'),
        ];
    }

    public function init()
    {
        $settings = Setting::findAll($this->attributes());
        foreach ($settings as $setting) {
            $this->{$setting->name} = $setting->value;
        }
    }

    public function saveSettings()
    {
        $settings = [];
        foreach (Setting::findAll($this->attributes()) as $setting) {
            $settings[$setting->name] = $setting;
        }

        foreach ($this->attributes() as $attribute) {
            if (!empty($settings[$attribute])) {
                if ($settings[$attribute]->value != $this->$attribute) {
                    $settings[$attribute]->value = $this->$attribute;
                    $settings[$attribute]->save();
                }
            } else {
                $setting = new Setting;
                $setting->name = $attribute;
                $setting->value = $this->$attribute;
                $setting->save();
            }
        }

        // GC
        foreach (Setting::find()->where(['not in', 'name', $this->attributes()])->all() as $setting) {
            $setting->delete();
        }
    }

    protected function getLookupTable()
    {
        return 'setting';
    }

}
