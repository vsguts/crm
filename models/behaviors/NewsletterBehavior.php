<?php

namespace app\models\behaviors;

use Yii;
use yii\base\Behavior;
use app\models\NewsletterLog;
use app\models\Partner;

class NewsletterBehavior extends Behavior
{

    public function send($display_log = false)
    {
        $mailer = Yii::$app->mailer;
        $newsletter = $this->owner;

        $log = new NewsletterLog;
        $log->link('newsletter', $newsletter);
        
        $appendToLog = function($string, $skip_eol = false) use($log, $display_log){
            $content = $string . ($skip_eol ? '' : PHP_EOL);
            if ($display_log) {
                echo nl2br($content);
            }
            $log->content .= $content;
            $log->save();
        };

        $errors = [];

        foreach ($newsletter->mailingLists as $list) {
            if ($list->from_email) {
                $from_email = $list->from_email;
                $from_name = $list->from_name ?: null;
            } else {
                $from_email = Yii::$app->params['supportEmail'];
                $from_name = $list->from_name ?: Yii::$app->params['companyName'];
            }
            foreach ($list->partners as $partner) {
                if (!$partner->email) {
                    $appendToLog(sprintf("Partner #%s didn't have email. Skipping.", $partner->id));
                    continue;
                }

                $appendToLog($partner->email . ': ', true);

                $error = '';

                $content = $newsletter->processContent($newsletter->body, $partner);

                try {
                    $mail = $mailer
                        ->compose()
                        ->setHtmlBody($content)
                        ->setFrom($from_email, $from_name)
                        ->setTo($partner->email)
                        ->setSubject($newsletter->subject);
                    
                    if ($list->reply_to) {
                        $mail->setReplyTo($list->reply_to);
                    }

                    foreach ($newsletter->getAttachments() as $attachment) {
                        $mail->attach($attachment->getPath());
                    }
                    
                    $result = $mail->send();
                    $appendToLog($result ? __('Success') : __('Failed'));
                } catch (\Swift_SwiftException $e) {
                    $appendToLog(__('Failed') . ': ' . $e->getMessage());
                    $errors[] = $e->getMessage();
                }
                
            }
        }

        return $errors;
    }

}
