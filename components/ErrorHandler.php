<?php
namespace app\components;

use Yii;
use yii\base\UserException;
use yii\web\HttpException;
use yii\web\Response;

class ErrorHandler extends \yii\web\ErrorHandler {

	public $exceptionUserView;
	/**
	 * @var string the path of the view file for rendering exceptions.
	 */
	//public $exceptionView = '@app/views/errors/mail/errorHandler/exception.php';
	/**
	 * @var string the path of the view file for rendering exceptions and errors call stack element.
	 */
	//public $callStackItemView = '@app/views/errors/mail/errorHandler/callStackItem.php';
	/**
	 * @var string the path of the view file for rendering previous exceptions.
	 */
	//public $previousExceptionView = '@app/views/errors/mail/errorHandler/previousException.php';

	/**
	 * Renders the exception.
	 * @param \Exception $exception the exception to be rendered.
	 */
	protected function renderException($exception)
	{
		if (Yii::$app->has('response')) {
			$response = Yii::$app->getResponse();
			// reset parameters of response to avoid interference with partially created response data
			// in case the error occurred while sending the response.
			$response->isSent = false;
			$response->stream = null;
			$response->data = null;
			$response->content = null;
		} else {
			$response = new Response();
		}

		$useErrorView = $response->format === Response::FORMAT_HTML && $exception instanceof UserException;
		if ($useErrorView && $this->errorAction !== null) {
			$result = Yii::$app->runAction($this->errorAction);
			if ($result instanceof Response) {
				$response = $result;
			} else {
				$response->data = $result;
			}
		} elseif ($response->format === Response::FORMAT_HTML) {
			if (YII_ENV_TEST || isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
				// AJAX request
				$response->data = '<pre>' . $this->htmlEncode(static::convertExceptionToString($exception)) . '</pre>';
			} else {
				// if there is an error during error rendering it's useful to
				// display PHP error in debug mode instead of a blank screen
				//echo var_dump(Yii::$app->controller->action->id);

				if (Yii::$app->user->isGod()) {
					ini_set('display_errors', 1);
				}
				$file = Yii::$app->user->isGod() ? $this->exceptionView : $this->exceptionUserView;
				$response->data = $this->renderFile($file, [
					'exception' => $exception,
				]);
			}
		} elseif ($response->format === Response::FORMAT_RAW) {
			$response->data = static::convertExceptionToString($exception);
		} else {
			$response->data = $this->convertExceptionToArray($exception);
		}

		if ($exception instanceof HttpException) {
			$response->setStatusCode($exception->statusCode);
		} else {
			$response->setStatusCode(500);
		}

		$response->send();
	}

	public function addTypeLinks($code,$style='')
	{
		if (preg_match('/(.*?)::([^(]+)/', $code, $matches)) {
			$class = $matches[1];
			$method = $matches[2];
			$text = $this->htmlEncode($class) . '::' . $this->htmlEncode($method);
		} else {
			$class = $code;
			$method = null;
			$text = $this->htmlEncode($class);
		}

		$url = $this->getTypeUrl($class, $method);

		if (!$url) {
			return $text;
		}

		return '<a href="' . $url . '" style="' . $style . '" target="_blank">' . $text . '</a>';
	}

	public function createHttpStatusLink($statusCode, $statusDescription,$style='')
	{
		return '<a href="http://en.wikipedia.org/wiki/List_of_HTTP_status_codes#' . (int) $statusCode . '" style="' . $style . '" target="_blank">HTTP ' . (int) $statusCode . ' &ndash; ' . $statusDescription . '</a>';
	}

	public function renderPreviousExceptions($exception)
	{
		if (($previous = $exception->getPrevious()) !== null) {
			return $this->renderFile($this->previousExceptionView, ['exception' => $previous]);
		} else {
			return '';
		}
	}

}