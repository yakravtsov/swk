<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 30.10.2015
 * Time: 14:19
 * All rights are reserved
 */
namespace app\components;

use Yii;
use yii\base\Component;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRule;
use yii\web\UrlRuleInterface;

class UniversityUrlRule extends Component implements UrlRuleInterface {

	/**
	 * Parses the given request and returns the corresponding route and parameters.
	 *
	 * @param UrlManager $manager the URL manager
	 * @param Request    $request the request component
	 *
	 * @return array|boolean the parsing result. The route and the parameters are returned as an array.
	 * If false, it means this rule cannot be used to parse this path info.
	 */
	public function parseRequest($manager, $request) {
		$pathInfo = $request->getPathInfo();
		Yii::$app->university->pathInfo = $pathInfo;
		if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches)) {
			$subdomain = Yii::$app->university->name;
			if(!Yii::$app->university->model) {
//				$manager-
			}
		}

		return false;
	}

	/**
	 * Creates a URL according to the given route and parameters.
	 *
	 * @param UrlManager $manager the URL manager
	 * @param string     $route   the route. It should not have slashes at the beginning or the end.
	 * @param array      $params  the parameters
	 *
	 * @return string|boolean the created URL, or false if this rule cannot be used for creating this URL.
	 */
	public function createUrl($manager, $route, $params) {
		// TODO: Implement createUrl() method.
	}
}