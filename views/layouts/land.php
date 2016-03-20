<?php
$this->beginPage()
?>
	<!doctype html>
	<html>
	<head>
		<title>Электронное портфолио обучающегося для вузов по ФГОС 3+</title>
		<?php $this->head() ?>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta property="og:url" content="studentsonline.onlineconsulting.pro">
		<meta property="og:title"
		      content="Электронное портфолио обучающегося — готовое решение для вузов согласно ФГОС 3+">
		<meta property="og:description"
		      content="Ознакомьтесь с возможностями и посмотрите демоверсию «Students Online» на сайте.">
		<meta property="og:image" content="/landing/i/og_image.jpg">
		<link rel="image_src" href="/i/og_image.jpg">

		<link rel="stylesheet" href="/landing/css/reset-min.css" media="all" type="text/css">
		<link rel="stylesheet/less" href="/landing/css/main.less" type="text/css">

		<link rel="stylesheet" href="/landing/css/tooltip.css" media="all" type="text/css">

		<script src="/landing/js/less.min.js" type="text/javascript"></script>
		<script src="/landing/js/jquery-1.11.0.min.js" type="text/javascript"></script>

		<script src="/landing/js/jquery.easing.1.3.js" type="text/javascript"></script>

		<link href="/landing/js/fancybox/jquery.fancybox.css" rel="stylesheet" media="all" type="text/css">
		<script src="/landing/js/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>

		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.0.6/jquery.mousewheel.min.js"
		        type="text/javascript"></script>
		<script src="/landing/js/SmoothScroll.js" type="text/javascript" charset="utf-8"></script>

		<script src="/landing/js/core.js" type="text/javascript"></script>

		<link rel="shortcut icon" type="image/x-icon" href="/landing/i/favicon.png">

		<script>
			(function (i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] || function () {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

			ga('create', 'UA-69522824-1', 'auto');
			ga('send', 'pageview');

		</script>
	</head>
	<body>
	<div class="wrapper">
			<?php $this->beginBody() ?>
			<header id="home">
				<div class="container">
					<div class="logo left">
						<?
						$phone = $this->params['agent']['phone'];
						$phone_href = str_replace([' ','-'],'',$phone);
							//str_replace(' ', '', $string);

						$controller = Yii::$app->controller;
						if($controller->action->id == "success"){
							?><a href="/?a=<?=$this->params['agent']['shortname'];?>"><img src="/landing/i/logo.png" alt="StudentsOnline.ru"/></a><?
						} else {
							?><img src="/landing/i/logo.png" alt="StudentsOnline.ru"/><?
						}
						?>
					</div>
					<div class="contacts right">
						<a class="phone" href="tel:<?=$phone_href;?>"><?=$this->params['agent']['phone'];?></a>
						<a class="email" href="mailto:<?=$this->params['agent']['email'];?>"><?=$this->params['agent']['email'];?></a>
					</div>
					<div class="clear"></div>
				</div>
			</header>

		<div class="wrapper-content">

			<?= $content ?>

		</div>
			<footer>
				<div class="container">
					<div class="logo left">
						<img src="/landing/i/footer/logo.png" alt="Students Online"/>
						<img src="/landing/i/onlineconsulting.png" alt="Онлайн Консалтинг"/>
						<img src="/landing/i/footer/made_in_Russia.png" alt="Сделано в России"/>
					</div>
					<div class="contacts right">
						<a class="phone" href="tel:<?=$this->params['agent']['phone'];?>"><?=$this->params['agent']['phone'];?></a>
						<a class="email" href="mailto:<?=$this->params['agent']['email'];?>"><?=$this->params['agent']['email'];?></a>
					</div>
					<div class="clear"></div>
					<div class="legal">© Онлайн Консалтинг, 2015. ОГРН 1137847243060. 198097, Санкт-Петербург, улица
						Маршала
						Говорова, 29 литер А.
					</div>
				</div>
			</footer>


	<?php $this->endBody() ?>
	<!-- Yandex.Metrika counter -->
	<script type="text/javascript">

	</script>
	<noscript>
		<div><img src="https://mc.yandex.ru/watch/33339158" style="position:absolute; left:-9999px;" alt=""/></div>
	</noscript>
	<!-- /Yandex.Metrika counter -->
	<script type="text/javascript">
		(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=OnIkfvwX*xE8olSxP9XTNczV90dj7492eH0iTwlAh9/ZU5/OyY460yxAAm9DZ2DfAv8lRmOLtrlzExXAN7X/a1198MwUtneQVuzqoVY4hs3JArv/vkjLcddVY53PUianTHwPV*i5Gcon9E/aqCtgnPEq*qL9ApTsUzPEH*S6hZ8-';</script>
	</body>
	</html>
<?php $this->endPage() ?>