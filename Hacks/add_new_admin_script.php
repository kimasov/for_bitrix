<?
/*
 * Бывает ситуация когда копию сайта дают, а доступы забывают
 * В таком случае дело не хитрое добавить новго админа через апи
 * Достаточно куда нибудь выложить этот файл и обратиться к нему
 */

//Подключаем пролог
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

$oUser = new CUser;

//Пишем идентификаторы групп для нашего сайта
$arGroups = array(1);

//Заполняем поля пользователя
$arFields = array(
    'NAME' => 'Платон',
    'LAST_NAME' => 'Шукин',
    'EMAIL' => 'platon@test.com',
    'ACTIVE' => 'Y',
    'GROUP_ID' => $arGroups,
    'LOGIN' => 'root',
    'PASSWORD' => '123qwe',
    'CONFIRM_PASSWORD' => '123qwe'
);

$iId = $oUser->Add($arFields);

if(intval($iId) > 0)
{
    echo 'Добавлен новый админ';
}
else
{
    throw new Exception($oUser->LAST_ERROR);
}
