<?
/**
 * @global $APPLICATION
 */

use Bitrix\Main;
use kDevelop\Service\Order;
use kDevelop\Service\User;
use kDevelop\Help\Tools;
use kDevelop\Settings\Store;

$rsManager = Main\EventManager::getInstance();

//Классы

Main\Loader::registerAutoLoadClasses(null, [
    "\kDevelop\Help\Mobile_Detect" => "/local/php_interface/classes/help/mobile_detect.php",
    "\kDevelop\Help\Tools" => "/local/php_interface/classes/help/tools.php",
    "\kDevelop\Settings\Store" => "/local/php_interface/classes/settings/store.php",
    "\kDevelop\Service\Order" => "/local/php_interface/classes/service/order.php",
    "\kDevelop\Service\User" => "/local/php_interface/classes/service/user.php",
]);
//end

//Обработчики событий
if (strpos($APPLICATION->GetCurDir(), "/bitrix/admin") === false) {

    //main module
    $rsManager->addEventHandler("main", "OnProlog", [Tools::class, "setDeviceType"], false, 100);
    $rsManager->addEventHandler("main", "OnProlog", [Store::class, "setStore"], false, 200);
    $rsManager->addEventHandler("main", "OnProlog", [Tools::class, "defineAjax"], false, 300);
    $rsManager->addEventHandler("main", "OnBeforeUserAdd", [User::class, "OnBeforeUserAddHandler"], false, 300);
    //end

    //module sale
    $rsManager->addEventHandler("sale", "OnOrderNewSendEmail", [Order::class, "OnOrderNewSendEmailHandler"], false, 100);
    //end

    Tools::definders();
}

$rsManager->addEventHandler("sale", "OnOrderUpdate", [Order::class, "OnOrderUpdateHandler"], false, 300);
//end
