<?php
/**
 * Created by PhpStorm.
 * User: workplace
 * Date: 06.06.2015
 * Time: 18:26
 */

?>

<div class="alert alert-warning" role="alert">
    <div class="pull-right">
        <a href="" class="btn btn-success">
            <i class="glyphicon glyphicon-edit"></i>
            Продлить лицензию
        </a>
    </div>

    <h5>Вы используете демоверсию электронного портфолио. До окончания пробного периода осталось <?=date('d');?> дней.</h5>
    <h5>Закажите подключение </h5>
</div>

<h1>Инструкция по заполнению электронного портфолио</h1>
<a href="javascript:window.history.go(-1);" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-menu-left"></i>
    Вернуться назад</a>
<a href="/site/getmanual" target="_blank" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-download"></i>
    Скачать инструкцию в pdf</a>
<div>&nbsp;</div>
<p>
    1. Для работы с портфолио необходимо зайти на сайт <a
        href="//<?= Yii::$app->university->model->subdomain ?>.studentsonline.ru" target="_blank"
        title="Откроется в новом окне"><i
            class="glyphicon glyphicon-share"></i> <?= Yii::$app->university->model->subdomain ?>.studentsonline.ru</a>,
    кликнуть в правом верхнем углу ссылку
    «войти» и ввести свой логин и пароль и перейти в личный кабинет.
</p>
<p>
    2. Во всплывающем окне следует вести адрес электронной почты. Адрес необходим для восстановления пароля и передачи
    портфолио после окончания обучения.
</p>
<p>
    3. Для редактирования страницы «Общая информация» нужно нажать синюю кнопку «Редактировать». В появившемся поле
    необходимо:
</p>
<ul>
    <li>Разместить свою фотографию</li>
    <li>Создать 3 обязательных раздела (Образование, Опыт работы, Дополнительная информация)</li>
    <li>Дополнить и украсить первую страницу своего портфолио по собственному желанию</li>
</ul>
<p>
    4. На странице «Учебная деятельность» необходимо загрузить свои учебные работы, дипломы учебных олимпиад, документы
    о прохождении образовательных программ и т.д. Для загрузки документа следует нажать кнопку «Добавить запись». В поле
    «Название» вводится полное название документа. В поле «Текст записи» дается описание документа, обосновывается его
    значимость. Например: «Данная курсовая работа заняла первое место университетском конкурсе» или «Всероссийская
    студенческая олимпиада по физике. Проходила в 2013 году». В поле «Прикрепленные файлы» прикрепляется документ в
    любом формате. После загрузки документа необходимо нажать кнопку «Создать». Обратите внимание, что для возврата на
    страницу «Общая информация» необходимо кликнуть на свое ФИО в верхней строке белого поля.
<p>

    5. Страницы «Научно-исследовательская деятельность», «Культурно-творческая деятельность», «Общественная
    деятельность» заполняются в том случае, если у студента есть успехи и достижения в этих областях<span
        class="text-info">*</span>. Желательно
    заполнить хотя бы одну из этих вкладок. Примерное содержание страниц представлено ниже.
</p>

<div class="row">
    <div class="col-xs-4">
        <strong>Научно-исследовательская</strong>
        <ul>
            <li>Научные публикации</li>
            <li>Документы, подтверждающие получение грантов</li>
            <li>Программы конференций, в которых студент принимал участие и т.д.</li>
        </ul>
    </div>
    <div class="col-xs-4">
        <strong>Общественная деятельность</strong>
        <ul>
            <li>Участие в профессиональных конкурсах</li>
            <li>Участие в общественно-значимых проектах</li>
            <li>Участие в политической деятельности и т.д.</li>
        </ul>
    </div>
    <div class="col-xs-4">
        <strong>Культурно-творческая деятельность</strong>
        <ul>
            <li>Кружки и секции в которых занимается студент</li>
            <li>Награды, полученные в различных смотрах и конкурсах</li>
            <li>Спортивные достижения и т.д.</li>
        </ul>
    </div>
</div>


<div class="alert alert-info">
    * Как правило в портфолио размещаются лучшие работы, благодарственные письма, отзывы, грамоты, фотографии,
    публикации, удостоверения о присвоении квалификации, дипломы и прочие регалии.
</div>