<?php

declare(strict_types=1);

namespace kDevelop\Service;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\NotImplementedException;
use Bitrix\Sale\Payment;
use Bitrix\Sale\PaySystem\Service;
use CEvent;
use Throwable;

/**
 * Class Order
 */
class Order
{
    public const CANCELED_STATUS = 'C';

    public const BUILD_STATUS = 'S';

    public const FINALLY_PAYED_STATUS = 'P';

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
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws NotImplementedException
     */
    public static function OnOrderUpdateHandler($id, $arFields)
    {
        global $APPLICATION;

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

        if ($order->getField('STATUS_ID') == self::CANCELED_STATUS) {
            if ($resultPayment->getSumPaid() > 0) {
                try {
                    $resultPaySystem->refund($resultPayment);
                } catch (Throwable $ex) {
                    AddMessage2Log($ex->getMessage());
                }
            }
            $order->setField('CANCELED', 'Y');
            $order->save();
        } elseif ($order->getField('STATUS_ID') == self::BUILD_STATUS) {
            ob_start();
            $APPLICATION->IncludeComponent(
                "bitrix:sale.personal.order.detail.mail",
                "",
                [
                    "ID" => $order->getId(),
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
            $orderList = ob_get_clean();

            try {
                $propertyCollection = $order->getPropertyCollection();
                CEvent::sendImmediate(
                    'CREATE_PAYMENT_FOR_ORDER',
                    's1',
                    [
                        'ORDER_ID' => $order->getId(),
                        'ORDER_LIST' => $orderList,
                        'EMAIL' => $propertyCollection->getUserEmail()->getValue() ?? '',
                    ]
                );
            } catch (Throwable $exception) {
            }

            $orderSum = $order->getPrice();
            $orderSumPaid = $resultPayment->getSumPaid();

            if ($orderSumPaid > $orderSum) {
                $resultPayment->setField('SUM', $orderSum);
                try {
                    $refund = $resultPaySystem->refund($resultPayment, (int) ($orderSumPaid - $orderSum));
                } catch (Throwable $ex) {
                    AddMessage2Log([
                        'exception' => $ex->getMessage(),
                    ]);
                }
            }

            $order->setField('STATUS_ID', self::FINALLY_PAYED_STATUS);
            $order->save();
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
        ob_start();
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
        $return = ob_get_clean();

        $arFields["ORDER_LIST"] = $return;
        //end
    }
}
