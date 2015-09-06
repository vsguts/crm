<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use app\models\NewsletterLog;
use app\models\Partner;

class NewsletterBehavior extends Behavior
{

    public function send()
    {
        $mailer = Yii::$app->mailer;
        $newsletter = $this->owner;

        $log = new NewsletterLog;
        $log->link('newsletter', $newsletter);
        
        $appendToLog = function($string, $skip_eol = false) use($log){
            $eol = $skip_eol ? '' : PHP_EOL;
            $log->content .= $string . $eol;
            $log->save();
        };

        foreach ($newsletter->mailingLists as $list) {
            $from_name = $list->from_name ?: null;
            foreach ($list->partners as $partner) {
                if (!$partner->email) {
                    $appendToLog(sprintf("Partner #%s didn't have email. Skipping.", $partner->id));
                    continue;
                }

                $appendToLog($partner->email . ': ', true);

                $content = $newsletter->processContent($newsletter->body, $partner);
                $mail = $mailer
                    ->compose('simple', ['content' => $content])
                    ->setFrom($list->from_email, $from_name)
                    ->setTo($partner->email)
                    ->setSubject($newsletter->subject);
                
                if ($list->reply_to) {
                    $mail->setReplyTo($list->reply_to);
                }
                
                $result = $mail->send();
                
                $appendToLog($result ? __('Success') : __('Failed'));
            }
        }
    }

}
