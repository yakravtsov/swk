<?php
/**
 * Created by PhpStorm.
 * User: workplace
 * Date: 15.02.2016
 * Time: 14:08
 */

namespace app\components;

use app\components\ErrorHandler;
use Yii;
use yii\log\EmailTarget;
use app\models\User;

class EmailTargetTrue extends EmailTarget
{
	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init();
	}

	/**
	 * Sends log messages to specified email addresses.
	 */
	public function export() {
		//Yii::$app->errorHandler->exceptionView = '@app/views/errors/mail/errorHandler/exception.php';
		// moved initialization of subject here because of the following issue
		// https://github.com/yiisoft/yii2/issues/1446
		if (empty($this->message['subject'])) {
			$this->message['subject'] = 'Application Log';
		}
		$messages = array_map([$this, 'formatMessage'], $this->messages);
		//$body = wordwrap(implode("\n", $messages), 70);
		//$body = implode("\n", $messages);
		//$body = '';
		/*foreach($this->messages as $m){
			$body.= $m[4] . "<br><br>";
		}*/
		$this->composeMessage($this->messages)->send($this->mailer);
	}

	protected function composeMessage($messages) {
		$errorHandler                        = Yii::$app->errorHandler;
		$exception                           = $errorHandler->exception;
		$view_path                           = '@app/views/errors/mail/errorHandler/';
		$errorHandler->callStackItemView     = $view_path . 'callStackItem.php';
		$errorHandler->previousExceptionView = $view_path . 'previousException.php';
		$body                                = $errorHandler->renderFile($view_path . 'exception.php', ['exception' => $exception]);

		$message = $this->mailer->compose('/errors/mail/emailDev', ['body' => $body, 'exception' => $exception]);
		Yii::configure($message, $this->message);

		//$message->setHtmlBody($body);

		return $message;
	}
}