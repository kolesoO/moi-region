<?php

declare(strict_types=1);

namespace kDevelop\System;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\NotImplementedException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\Type\DateTime;
use Bitrix\Sale\Configuration;
use Bitrix\Sale\Order;
use Bitrix\Sale\Shipment;
use CDatabase;
use CLang;
use CSaleOrderLoader as BaseCSaleOrderLoader;

class CSaleOrderLoader extends BaseCSaleOrderLoader
{
    /**
     * @param $arDocument
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws NotImplementedException
     * @throws ObjectException
     */
    protected function nodeHandlerPartialVersion($arDocument)
    {
        /**
         * @deprecated scheme
         */

        if(Configuration::useStoreControl() || Option::get('catalog', 'enable_reservation', 'N')=='Y')
            $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_USE_STORE_SALE");
        else
        {
            if(Option::get("main", "~sale_converted_15", 'N') <> 'Y')
                $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_CONVERT_SALE");
            else
            {
                if(Option::get("sale", "allow_deduction_on_delivery", "N") == 'Y')
                    $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_SALE_ALLOW_DEDUCTION_ON_DELIVERY_ERROR");
                else
                {
                    if(!self::getDefaultPaySystem())
                        $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_PS_ON_STATUS_PAYMENT_ORDER_ERROR");
                    else
                    {
                        $this->logMessage("OperationType: ".$arDocument['OPERATION_TYPE']);

                        switch($arDocument['OPERATION_TYPE'])
                        {
                            case 'order_operation':

                                /** @var Order $order */
                                if(strlen($arDocument["XML_1C_DOCUMENT_ID"])>0)
                                {
                                    $this->setVersion1C($arDocument["VERSION_1C"]);
                                    $this->setXMLDocumentID($arDocument["XML_1C_DOCUMENT_ID"]);

                                    $this->logMessage("Document.XML_1C_DOCUMENT_ID: ".$arDocument['XML_1C_DOCUMENT_ID']);
                                    $this->logMessage("Document.VERSION_1C: ".$arDocument['VERSION_1C']);

                                    if(intval($arDocument["ID"])>0)
                                    {
                                        $this->logMessage("UpdateOrder:");
                                        $this->logMessage("ID: ".$arDocument['ID']);

                                        $this->updateOrderWithoutShipmentsPayments($arDocument);
                                        if(strlen($this->strErrorDocument)<=0)
                                        {
                                            $order = Order::load($arDocument["ID"]);

                                            $this->updateEntityCompatible1C($order, $arDocument);

                                            $order->setField('UPDATED_1C', 'Y');
                                            $order->setField('VERSION_1C', $this->getVersion1C());
                                            $order->setField('ID_1C', $this->getXMLDocumentID());
                                            $r = $order->save();
                                            if (!$r->isSuccess())
                                                $this->strErrorDocument .= array_shift($r->getErrors())->getMessage();
                                        }
                                    }
                                    elseif(Option::get("sale", "1C_IMPORT_NEW_ORDERS", "Y") == "Y")
                                    {
                                        $this->logMessage("NewOrder:");

                                        $arOrder = $this->addOrderWithoutShipmentsPayments($arDocument);

                                        if(intval($arOrder['ID'])>0)
                                        {
                                            $order = Order::load($arOrder["ID"]);
                                            if(strlen($this->strErrorDocument)<=0)
                                            {
                                                $this->createEntityCompatible1C($order, $arDocument);

                                                $order->setField('EXTERNAL_ORDER','Y');
                                                $order->setField('UPDATED_1C','Y');
                                                $order->setField('VERSION_1C', $this->getVersion1C());
                                                $order->setField('ID_1C', $this->getXMLDocumentID());

                                                if(strlen($arDocument["DATE"])>0)
                                                    $order->setField('DATE_INSERT', new DateTime(CDatabase::FormatDate($arDocument["DATE"]." ".$arDocument["TIME"], "YYYY-MM-DD HH:MI:SS", CLang::GetDateFormat("FULL", LANG))));
                                                $r = $order->save();
                                                if(!$r->isSuccess())
                                                    $this->strErrorDocument .= array_shift($r->getErrors())->getMessage();
                                            }
                                        }
                                        else
                                            $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_ORDER_ERROR_2", Array('#XML_1C_DOCUMENT_ID#'=>$arDocument['XML_1C_DOCUMENT_ID']));
                                    }
                                }
                                else
                                {
                                    $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_ORDER_ERROR_1");
                                }
                                break;
//                            case 'pay_system_b_operation':
//                            case 'pay_system_c_operation':
//                            case 'pay_system_a_operation':
//
//                                /** @var Order $order */
//                                if(isset($arDocument['PAYMENT_ORDER_ID']) && strlen($arDocument['ORDER_ID'])<=0)
//                                    $arDocument['ORDER_ID'] = $arDocument['PAYMENT_ORDER_ID'];
//
//                                if(strlen($arDocument["XML_1C_DOCUMENT_ID"])>0)
//                                {
//                                    $this->setVersion1C($arDocument["VERSION_1C"]);
//                                    $this->setXMLDocumentID($arDocument["XML_1C_DOCUMENT_ID"]);
//
//                                    $this->logMessage("Document.XML_1C_DOCUMENT_ID: ".$arDocument['XML_1C_DOCUMENT_ID']);
//                                    $this->logMessage("Document.VERSION_1C: ".$arDocument['VERSION_1C']);
//
//                                    if($arDocument['ORDER_ID'] !== false)
//                                    {
//                                        if($order = Order::load($arDocument['ORDER_ID']))
//                                        {
//                                            if (!$order->isCanceled())
//                                            {
//                                                if ($order->getField("STATUS_ID") != "F")
//                                                {
//                                                    if($arDocument['CANCELED'] == "true")
//                                                    {
//                                                        $paymentCollection = $order->getPaymentCollection();
//
//                                                        if(strlen($arDocument["ID"])>0 && ($payment = $paymentCollection->getItemById($arDocument["ID"])))
//                                                        {
//                                                            $deletePayment = $this->deleteDocumentPayment($payment);
//                                                            if(!$deletePayment->isSuccess())
//                                                                $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_ORDER_ERROR_4", Array('#XML_1C_DOCUMENT_ID#'=>$arDocument['XML_1C_DOCUMENT_ID'])).array_shift($deletePayment->getErrors())->getMessage();
//                                                        }
//                                                        else
//                                                            $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_PAYMENT_ERROR_9", Array( '#ORDER_ID#'=>$arDocument['ORDER_ID'], '#XML_1C_DOCUMENT_ID#'=>$arDocument['XML_1C_DOCUMENT_ID']));
//                                                    }
//                                                    else
//                                                    {
//                                                        if(strlen($arDocument["ID"])>0)
//                                                        {
//                                                            $paymentCollection = $order->getPaymentCollection();
//
//                                                            if($payment = $paymentCollection->getItemById($arDocument["ID"]))
//                                                            {
//                                                                $this->beforePaidCompatible1C($order);
//
//                                                                $this->updatePaymentFromDocument($arDocument, $payment);
//
//                                                                if(strlen($this->strErrorDocument)<=0)
//                                                                {
//                                                                    $this->Paid($payment, $arDocument);
//
//                                                                    $this->afterPaidCompatible1C($order);
//
//                                                                    if(strlen($this->strErrorDocument)<=0)
//                                                                    {
//                                                                        $payment->setField('UPDATED_1C','Y');
//                                                                        $payment->setField('VERSION_1C', $this->getVersion1C());
//                                                                        $payment->setField('ID_1C',$this->getXMLDocumentID());
//                                                                    }
//                                                                }
//                                                            }
//                                                            else
//                                                                $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_PAYMENT_ERROR_3", Array("#ID#" => $arDocument["ID"], '#ORDER_ID#'=>$arDocument['ORDER_ID'], '#XML_1C_DOCUMENT_ID#'=>$arDocument['XML_1C_DOCUMENT_ID']));
//                                                        }
//                                                        elseif (Option::get("sale", "1C_IMPORT_NEW_PAYMENT", "Y") == 'Y') // create new payment (ofline 1C))
//                                                        {
//                                                            $this->beforePaidCompatible1C($order);
//
//                                                            $payment = $this->addPaymentFromDocumentByOrder($arDocument, $order);
//                                                            if(strlen($this->strErrorDocument)<=0 && !is_null($payment))
//                                                            {
//                                                                $this->Paid($payment, $arDocument);
//
//                                                                $this->afterPaidCompatible1C($order);
//
//                                                                if(strlen($this->strErrorDocument)<=0)
//                                                                {
//                                                                    $payment->setField('EXTERNAL_PAYMENT','Y');
//                                                                    $payment->setField('VERSION_1C', $this->getVersion1C());
//                                                                    $payment->setField('ID_1C',$this->getXMLDocumentID());
//                                                                }
//                                                            }
//                                                        }
//                                                    }
//                                                }
//                                                else
//                                                    $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_PAYMENT_ERROR_10", Array('#ORDER_ID#'=>$order->getId(), '#XML_1C_DOCUMENT_ID#'=>$arDocument['XML_1C_DOCUMENT_ID']));
//                                            }
//                                            else
//                                            {
//                                                $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_PAYMENT_ERROR_11", Array('#ORDER_ID#'=>$order->getId(), '#XML_1C_DOCUMENT_ID#'=>$arDocument['XML_1C_DOCUMENT_ID']));
//                                            }
//
//                                        }
//                                        else
//                                            $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_PAYMENT_ERROR_8",array('#ORDER_ID#'=>$order->getId(), '#XML_1C_DOCUMENT_ID#'=>$this->getXMLDocumentID()));
//                                    }
//                                    else
//                                        $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_PAYMENT_ERROR_5",array('#XML_1C_DOCUMENT_ID#'=>$this->getXMLDocumentID()));
//                                }
//                                else
//                                    $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_PAYMENT_ERROR_6");
//
//                                if(strlen($this->strErrorDocument)<=0)
//                                {
//                                    $order->setField('UPDATED_1C', 'Y');
//
//                                    $r = $order->save();
//                                    if(!$r->isSuccess())
//                                        $this->strErrorDocument .= array_shift($r->getErrors())->getMessage();
//                                }
//
//                                break;
                            case 'shipment_operation':

                                if(isset($arDocument['SHIPMENT_ORDER_ID']) && strlen($arDocument['ORDER_ID'])<=0)
                                    $arDocument['ORDER_ID'] = $arDocument['SHIPMENT_ORDER_ID'];

                                if(strlen($arDocument["XML_1C_DOCUMENT_ID"])>0)
                                {
                                    $this->setVersion1C($arDocument["VERSION_1C"]);
                                    $this->setXMLDocumentID($arDocument["XML_1C_DOCUMENT_ID"]);
                                    $this->setOrderIdOriginal($arDocument["ORDER_ID_ORIG"]);

                                    $this->logMessage("Document.XML_1C_DOCUMENT_ID: ".$arDocument['XML_1C_DOCUMENT_ID']);
                                    $this->logMessage("Document.VERSION_1C: ".$arDocument['VERSION_1C']);
                                    $this->logMessage("Document.ORDER_ID_ORIG: ".$arDocument['ORDER_ID_ORIG']);

                                    if($arDocument['ORDER_ID'] !== false)
                                    {
                                        /** @var Order $order */
                                        if($order = Order::load($arDocument['ORDER_ID']))
                                        {
                                            if ($order->getField("STATUS_ID") != "F")
                                            {
                                                if($arDocument["CANCELED"] == "true")
                                                {
                                                    if (strlen($arDocument["ID"])>0 && ($shipment = $order->getShipmentCollection()->getItemById($arDocument['ID'])))
                                                    {
                                                        $deleteShipment = $this->deleteDocumentShipment($shipment);
                                                        if(!$deleteShipment->isSuccess())
                                                            $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_ORDER_ERROR_4", Array('#XML_1C_DOCUMENT_ID#'=>$arDocument['XML_1C_DOCUMENT_ID'])).array_shift($deleteShipment->getErrors())->getMessage();
                                                    }
                                                    else
                                                        $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_SHIPMENT_ERROR_16", Array( '#ORDER_ID#'=>$arDocument['ORDER_ID'], '#XML_1C_DOCUMENT_ID#'=>$arDocument['XML_1C_DOCUMENT_ID']));
                                                }
                                                else
                                                {
                                                    if(strlen($arDocument["ID"])>0)
                                                    {
                                                        if ($shipment = $order->getShipmentCollection()->getItemById($arDocument['ID']))
                                                        {
                                                            /** @var Shipment $shipment */
                                                            if (!$shipment->isSystem())
                                                            {
                                                                if (!$shipment->isShipped())
                                                                {
                                                                    $this->deleteShipmentItemsByDocument($arDocument, $shipment);

                                                                    $this->updateShipmentQuantityFromDocument($arDocument, $shipment);

                                                                    if(strlen($this->strErrorDocument)<=0)
                                                                    {
                                                                        $this->Ship($shipment, $arDocument);

                                                                        $this->afterShippedCompatible1C($order);

                                                                        if(strlen($this->strErrorDocument)<=0)
                                                                        {
                                                                            $shipment->setField('UPDATED_1C','Y');
                                                                            $shipment->setField('VERSION_1C', $this->getVersion1C());
                                                                            $shipment->setField('ID_1C',$this->getXMLDocumentID());
                                                                        }
                                                                    }
                                                                }
                                                                else
                                                                    $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_SHIPMENT_ERROR_2", Array("#ID#" => $arDocument["ID"],'#ORDER_ID#'=>$arDocument['ORDER_ID'],'#XML_1C_DOCUMENT_ID#'=>$arDocument['XML_1C_DOCUMENT_ID']));
                                                            }
                                                            else
                                                                $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_SHIPMENT_ERROR_14", Array("#ID#" => $arDocument["ID"],'#ORDER_ID#'=>$arDocument['ORDER_ID'],'#XML_1C_DOCUMENT_ID#'=>$arDocument['XML_1C_DOCUMENT_ID']));
                                                        }
                                                        else
                                                            $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_SHIPMENT_ERROR_3", Array("#ID#" => $arDocument["ID"],'#ORDER_ID#'=>$arDocument['ORDER_ID'],'#XML_1C_DOCUMENT_ID#'=>$arDocument['XML_1C_DOCUMENT_ID']));
                                                    }
                                                    elseif(Option::get("sale", "1C_IMPORT_NEW_SHIPMENT", 'Y')=='Y')
                                                    {
                                                        $shipment = $this->addShipmentFromDocumentByOrder($arDocument, $order);

                                                        if(strlen($this->strErrorDocument)<=0)
                                                        {
                                                            $this->Ship($shipment, $arDocument);

                                                            $this->afterShippedCompatible1C($order);

                                                            if(strlen($this->strErrorDocument)<=0)
                                                            {
                                                                $shipment->setField('VERSION_1C',$this->getVersion1C());
                                                                $shipment->setField('ID_1C', $this->getXMLDocumentID());
                                                                $shipment->setField('EXTERNAL_DELIVERY','Y');
                                                                $shipment->setField('UPDATED_1C','Y');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            else
                                                $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_SHIPMENT_ERROR_18", Array('#ORDER_ID#'=>$order->getId(), '#XML_1C_DOCUMENT_ID#'=>$this->getXMLDocumentID()));
                                        }
                                        else
                                            $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_SHIPMENT_ERROR_15",array('#ORDER_ID#'=>$order->getId(),'#XML_1C_DOCUMENT_ID#'=>$this->getXMLDocumentID()));
                                    }
                                    elseif(Option::get("sale", "1C_IMPORT_NEW_ORDER_NEW_SHIPMENT", "Y") == 'Y') // create new shipment (ofline 1C))
                                    {
                                        if($arDocument["CANCELED"] != "true")
                                        {
                                            /** @var Order $order */
                                            $arOrder = $this->addOrderWithoutShipmentsPayments($arDocument);
                                            if($arOrder['ID']>0)
                                            {
                                                $order = Order::load($arOrder['ID']);
                                                $shipment = $this->addShipmentFromDocumentByOrder($arDocument, $order);

                                                if(strlen($this->strErrorDocument)<=0)
                                                {
                                                    $this->Ship($shipment, $arDocument);

                                                    if(strlen($this->strErrorDocument)<=0)
                                                    {
                                                        $shipment->setField('VERSION_1C', $this->getVersion1C());
                                                        $shipment->setField('ID_1C', $this->getXMLDocumentID());
                                                        $shipment->setField('EXTERNAL_DELIVERY', 'Y');
                                                        $shipment->setField('UPDATED_1C', 'Y');

                                                        $order->setField('VERSION_1C', $this->getVersion1C());
                                                        $order->setField('ID_1C', $this->getOrderIdOriginal());
                                                        $order->setField('EXTERNAL_ORDER', 'Y');

                                                    }
                                                }
                                            }
                                            else
                                                $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_SHIPMENT_ERROR_7", Array('#XML_1C_DOCUMENT_ID#'=>$this->getXMLDocumentID()));
                                        }
                                        else
                                            $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_SHIPMENT_ERROR_17", Array('#XML_1C_DOCUMENT_ID#'=>$this->getXMLDocumentID()));
                                    }
                                    else
                                        $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_SHIPMENT_ERROR_5", Array("#ID#" => $arDocument["ID"],'#XML_1C_DOCUMENT_ID#'=>$this->getXMLDocumentID()));
                                }
                                else
                                    $this->strErrorDocument .= "\n".GetMessage("CC_BSC1_SHIPMENT_ERROR_6", Array("#ID#" => $arDocument["ID"]));

                                if(strlen($this->strErrorDocument)<=0)
                                {
                                    if($order->isShipped())
                                    {
                                        if(strlen($this->arParams["FINAL_STATUS_ON_DELIVERY"])>0 &&
                                            $order->getField("STATUS_ID") != "F" &&
                                            $order->getField("STATUS_ID") != $this->arParams["FINAL_STATUS_ON_DELIVERY"]
                                        )
                                        {
                                            $order->setField("STATUS_ID", $this->arParams["FINAL_STATUS_ON_DELIVERY"]);
                                        }
                                    }

                                    $order->setField('UPDATED_1C', 'Y');

                                    $r=$order->save();
                                    if (!$r->isSuccess())
                                        $this->strErrorDocument .= array_shift($r->getErrorMessages());
                                }

                                break;
                        }
                    }
                }
            }
        }
        $this->logMessage("FinalExchange \r\n\r\n");

        Option::set('sale', 'onec_exchange_type', 'partial');
        Option::set('sale', 'onec_exchange_last_time', time());
    }
}
