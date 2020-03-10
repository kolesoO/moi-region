<?php

declare(strict_types=1);

namespace kDevelop\Service;

use Bitrix\Sale\Payment;
use Bitrix\Sale\PaySystem\Service;

/**
 * Class Order
 */
class Order
{
    /** @var array */
    private static $methodMap = [
        "SALE_NEW_ORDER" => "saleNewOrderHandler"
    ];

    /**
     * @param $orderID
     * @param $eventName
     * @param $arFields
     */
    public static function OnOrderNewSendEmailHandler($orderID, &$eventName, &$arFields)
    {
        forward_static_call_array([self::class, self::$methodMap[$eventName]], [$orderID, &$arFields]);
    }

    /**
     * @param $id
     * @param $arFields
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\NotImplementedException
     */
    public static function OnOrderUpdateHandler($id, $arFields)
    {
        $order = \Bitrix\Sale\Order::load($id);
        if (!$order) return;

        $paymentCollection = $order->getPaymentCollection();
        if (!$paymentCollection) return;

        $resultPaySystem = null;
        $resultPayment = null;
        /** @var Payment $payment */
        foreach ($paymentCollection as $payment) {
            $resultPaySystem = $payment->getPaySystem();
            $resultPayment = $payment;
            break;
        }
        if (is_null($resultPaySystem) || is_null($resultPayment)) {
            return;
        }

        /** @var Service $resultPaySystem */
        /** @var Payment $resultPayment */

        if ($order->getField('STATUS_ID') == 'C') {
            if ($resultPayment->getSumPaid() > 0) {
                try {
                    AddMessage2Log([
                        'action' => 'Try to refund order sum',
                        'order_id' => $order->getId(),
                        'order_sum' => $order->getPrice(),
                        'refund_sum' => $resultPayment->getSumPaid()
                    ]);
                    $resultPaySystem->refund($resultPayment);
                } catch (\Throwable $ex) {
                    AddMessage2Log($ex->getMessage());
                }
            }
            $order->setField('CANCELED', 'Y');
            $order->save();
        } elseif ($order->getField('STATUS_ID') == 'S') {
            \CEvent::sendImmediate(
                'CREATE_PAYMENT_FOR_ORDER',
                SITE_ID,
                [
                    'ORDER_ID' => $order->getId()
                ]
            );
        }
    }

    /**
     * @param $orderID
     * @param $arFields
     */
    protected static function saleNewOrderHandler($orderID, &$arFields)
    {
        global $APPLICATION;

        //содержиое письма
        \ob_start();
        $APPLICATION->IncludeComponent(
            "bitrix:sale.personal.order.detail.mail",
            "",
            [
                "ID" => $orderID,
                "SHOW_ORDER_BASKET" => "Y",
                "SHOW_ORDER_BASE" => "Y",
                "SHOW_ORDER_USER" => "Y",
                "SHOW_ORDER_PARAMS" => "Y",
                "SHOW_ORDER_BUYER" => "Y",
                "SHOW_ORDER_DELIVERY" => "Y",
                "SHOW_ORDER_PAYMENT" => "Y",
                "SHOW_ORDER_SUM" => "Y",
                "CUSTOM_SELECT_PROPS" => array("NAME", "DISCOUNT_PRICE_PERCENT_FORMATED", "PRICE_FORMATED", "QUANTITY"),
                "PROP_1" => array(),
                "PROP_2" => array(),
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "PICTURE_WIDTH" => "110",
                "PICTURE_HEIGHT" => "110",
                "PICTURE_RESAMPLE_TYPE" => "1",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
                "PATH_TO_LIST" => "",
                "PATH_TO_CANCEL" => "",
                "PATH_TO_PAYMENT" => "",
                "DISALLOW_CANCEL" => "Y"
            ]
        );
        $return = \ob_get_contents();
        \ob_end_clean();

        $arFields["ORDER_LIST"] = $return;
        //end
    }
}
