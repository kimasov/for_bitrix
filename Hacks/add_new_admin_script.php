<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

$oUser = new CUser;

$arGroups = array(1);

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
