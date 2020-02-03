<?
/**
 * @global $APPLICATION
 */

use Bitrix\Main;

$rsManager = Main\EventManager::getInstance();

//Классы
require $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/vendor/autoload.php';

Main\Loader::registerAutoLoadClasses(null, [
    "\kDevelop\Help\Mobile_Detect" => "/local/php_interface/classes/help/mobile_detect.php",
    "\kDevelop\Help\Tools" => "/local/php_interface/classes/help/tools.php",
    "\kDevelop\Settings\Store" => "/local/php_interface/classes/settings/store.php",
    "\kDevelop\Service\Order" => "/local/php_interface/classes/service/order.php",
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
}

$rsManager->addEventHandler("sale", "OnOrderUpdate", ["\kDevelop\Service\Order", "OnOrderUpdateHandler"], false, 300);
//end
