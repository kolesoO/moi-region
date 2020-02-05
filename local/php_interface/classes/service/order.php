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
                    $resultPaySystem->refund($resultPayment, $resultPayment->getSumPaid());
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
}
