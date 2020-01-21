<?
/**
 * @global $APPLICATION
 */

use \Bitrix\Main;

$rsManager = Main\EventManager::getInstance();

//Классы
require $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/vendor/autoload.php';

Main\Loader::registerAutoLoadClasses(null, [
    "\kDevelop\Help\Mobile_Detect" => "/local/php_interface/classes/help/mobile_detect.php",
    "\kDevelop\Help\Tools" => "/local/php_interface/classes/help/tools.php",
    "\kDevelop\Settings\Store" => "/local/php_interface/classes/settings/store.php",
    "\kDevelop\ModuleBankApi\General" => "/local/php_interface/classes/moduleBankApi/general.php",
]);
//end

//Обработчики событий
if (strpos($APPLICATION->GetCurDir(), "/bitrix/admin") === false) {
    //main module
    $rsManager->addEventHandler("main", "OnProlog", ["\kDevelop\Help\Tools", "setDeviceType"], false, 100);
    $rsManager->addEventHandler("main", "OnProlog", ["\kDevelop\Settings\Store", "setStore"], false, 200);
    $rsManager->addEventHandler("main", "OnProlog", ["\kDevelop\Help\Tools", "defineAjax"], false, 300);
    //end
    \kDevelop\Help\Tools::definders();
} else {
    //iblock module

    //end
}
//end

/*$test = new \kDevelop\ModuleBankApi\General(
    '1cc17aa0-bbc4-4768-b1bc-2f94b68c4b98',
    'B827F16F8E038F41057B5DA1E319DEA3',
    true
);
$test->createPayment([
    'amount' => 10,
    'order_id' => '123',
    'description' => 'test order',
    'success_url' => 'https://moi-region.ru/',
    'fail_url' => 'https://moi-region.ru/?fail=true',
]);
die();*/
