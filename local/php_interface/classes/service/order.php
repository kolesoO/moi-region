<?php

declare(strict_types=1);

namespace kDevelop\Service;

use Bitrix\Sale\Payment;
use Bitrix\Sale\PaySystem\Service;

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

        if ($order->getField('STATUS_ID') == 'S') {
            if ($order->getPrice() < $resultPayment->getField('SUM')) {
                try {
                    $resultPaySystem->refund(
                        $resultPayment,
                        ($resultPayment->getField('SUM') - $order->getPrice())
                    );
                } catch (\Throwable $ex) {
                }
            }
            $order->setField('STATUS_ID', 'P');
            $order->save();
        }
    }
}
