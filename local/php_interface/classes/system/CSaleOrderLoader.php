<?php

declare(strict_types=1);

namespace kDevelop\System;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Error;
use Bitrix\Main\NotImplementedException;
use Bitrix\Main\NotSupportedException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\Type\DateTime;
use Bitrix\Sale\Configuration;
use Bitrix\Sale;
use Bitrix\Sale\Order;
use Bitrix\Sale\Shipment;
use CDatabase;
use CDataXML;
use CLang;
use CSaleOrderLoader as BaseCSaleOrderLoader;
use CSaleOrderProps;
use CSaleOrderUserProps;
use CSaleOrderUserPropsValue;
use CSalePersonType;
use CSaleUser;
use CUser;
use CXMLFileStream;

class CSaleOrderLoader extends BaseCSaleOrderLoader
{
    /**
     * @param $arDocument
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws NotImplementedException
     * @throws ObjectException
     * @throws NotSupportedException
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

    function nodeHandler(CDataXML $dataXml, CXMLFileStream $fileStream)
    {
        $value = $dataXml->GetArray();
        $xmlStream = $this->getXMLStream($fileStream);
        $importer = $this->importer;

        if($importer instanceof Sale\Exchange\ImportOneCBase)
        {
            $r = new Sale\Result();

            if($importer instanceof Sale\Exchange\ImportOneCSubordinateSale)
            {
                $documentData = array($value[GetMessage("CC_BSC1_DOCUMENT")]);
            }
            elseif($importer instanceof Sale\Exchange\ImportOneCPackage)
            {
                $documentData = $value[GetMessage("CC_BSC1_CONTAINER")]['#'][GetMessage("CC_BSC1_DOCUMENT")];
            }
            else
            {
                $documentData = array($value[GetMessage("CC_BSC1_AGENT")]["#"]);
            }

            if(!is_array($documentData) || count($documentData)<=0)
                $r->addError(new Error(GetMessage("CC_BSC1_DOCUMENT_XML_EMPTY")));

            if($r->isSuccess())
            {
                /** @var Sale\Result $r */
                $r = $importer::checkSettings();
                if($r->isSuccess())
                {
                    if(strlen($xmlStream)>0)
                        $importer->setRawData($xmlStream);

                    $r = $importer->process($documentData);
                }
            }

            if(!$r->isSuccess())
            {
                foreach($r->getErrorMessages() as $errorMessages)
                {
                    if(strlen($errorMessages)>0)
                        $this->strError .= "\n".$errorMessages;
                }
            }

            if($r->hasWarnings())
            {
                if(count($r->getWarningMessages())>0)
                {
                    foreach($r->getWarningMessages() as $warningMessages)
                    {
                        if(strlen($warningMessages)>0)
                            $this->strError .= "\n".$warningMessages;
                    }
                }
            }

            Option::set('sale', 'onec_exchange_type', 'container');
            Option::set('sale', 'onec_exchange_last_time', time());
        }
        elseif(!empty($value[GetMessage("CC_BSC1_DOCUMENT")]))
        {
            $this->nodeHandlerDefaultModuleOneC($dataXml);
        }
        elseif(Option::get("sale", "1C_IMPORT_NEW_ORDERS", "Y") == "Y")
        {
            /**
             * @deprecated
             */
            $value = $value[GetMessage("CC_BSC1_AGENT")]["#"];
            $arAgentInfo = $this->collectAgentInfo($value);

            if(!empty($arAgentInfo["AGENT"]))
            {
                $mode = false;
                $arErrors = array();
                $dbUProp = CSaleOrderUserProps::GetList(array(), array("XML_ID" => $arAgentInfo["AGENT"]["ID"]), false, false, array("ID", "NAME", "USER_ID", "PERSON_TYPE_ID", "XML_ID", "VERSION_1C"));
                if($arUProp = $dbUProp->Fetch())
                {
                    if($arUProp["VERSION_1C"] != $arAgentInfo["AGENT"]["VERSION"])
                    {
                        $mode = "update";
                        $arAgentInfo["PROFILE_ID"] = $arUProp["ID"];
                        $arAgentInfo["PERSON_TYPE_ID"] = $arUProp["PERSON_TYPE_ID"];
                        $arAgentInfo["USER_ID"] = $arUProp["USER_ID"];
                    }
                }
                else
                {
                    $user = Sale\Exchange\Entity\UserProfileImportLoader::getUserByCode($arAgentInfo["AGENT"]["ID"]);
                    if(!empty($user))
                    {
                        $arAgentInfo["USER_ID"] = $user['ID'];
                    }
                    else
                    {
                        $arUser = array(
                            "NAME" => $arAgentInfo["AGENT"]["ITEM_NAME"],
                            "EMAIL" => $arAgentInfo["AGENT"]["CONTACT"]["MAIL_NEW"],
                        );

                        if(strlen($arUser["NAME"]) <= 0)
                            $arUser["NAME"] = $arAgentInfo["AGENT"]["CONTACT"]["CONTACT_PERSON"];

                        $emServer = $_SERVER["SERVER_NAME"];
                        if(strpos($_SERVER["SERVER_NAME"], ".") === false)
                            $emServer .= ".bx";
                        if(strlen($arUser["EMAIL"]) <= 0)
                            $arUser["EMAIL"] = "buyer".time().GetRandomCode(2)."@".$emServer;

                        $arAgentInfo["USER_ID"] = CSaleUser::DoAutoRegisterUser($arUser["EMAIL"], $arUser["NAME"], $this->arParams["SITE_NEW_ORDERS"], $arErrors, array("XML_ID"=>$arAgentInfo["AGENT"]["ID"], "EXTERNAL_AUTH_ID"=>Sale\Exchange\Entity\UserImportBase::EXTERNAL_AUTH_ID));
                    }

                    if(IntVal($arAgentInfo["USER_ID"]) > 0)
                    {
                        $mode = "add";

                        $obUser = new CUser;
                        $userFields[] = array();

                        if(strlen($arAgentInfo["AGENT"]["CONTACT"]["PHONE"])>0)
                            $userFields["WORK_PHONE"] = $arAgentInfo["AGENT"]["CONTACT"]["PHONE"];

                        if(count($userFields)>0)
                        {
                            if(!$obUser->Update($arAgentInfo["USER_ID"], $userFields, true))
                                $this->strError .= "\n".$obUser->LAST_ERROR;
                        }
                    }
                    else
                    {
                        $this->strError .= "\n".GetMessage("CC_BSC1_AGENT_USER_PROBLEM", Array("#ID#" => $arAgentInfo["AGENT"]["ID"]));
                        if(!empty($arErrors))
                        {
                            foreach($arErrors as $v)
                            {
                                $this->strError .= "\n".$v["TEXT"];
                            }
                        }
                    }
                }

                if($mode)
                {
                    if(empty($arPersonTypesIDs))
                    {
                        $dbPT = CSalePersonType::GetList(array(), array("ACTIVE" => "Y", "LIDS" => $this->arParams["SITE_NEW_ORDERS"]));
                        while($arPT = $dbPT->Fetch())
                        {
                            $arPersonTypesIDs[] = $arPT["ID"];
                        }
                    }

                    if(empty($arExportInfo))
                    {
                        $dbExport = CSaleExport::GetList(array(), array("PERSON_TYPE_ID" => $arPersonTypesIDs));
                        while($arExport = $dbExport->Fetch())
                        {
                            $arExportInfo[$arExport["PERSON_TYPE_ID"]] = unserialize($arExport["VARS"]);
                        }
                    }

                    if(IntVal($arAgentInfo["PERSON_TYPE_ID"]) <= 0)
                    {
                        foreach($arExportInfo as $pt => $value)
                        {
                            if(($value["IS_FIZ"] == "Y" && $arAgentInfo["AGENT"]["TYPE"] == "FIZ")
                                || ($value["IS_FIZ"] == "N" && $arAgentInfo["AGENT"]["TYPE"] != "FIZ")
                            )
                                $arAgentInfo["PERSON_TYPE_ID"] = $pt;
                        }
                    }

                    if(IntVal($arAgentInfo["PERSON_TYPE_ID"]) > 0)
                    {
                        $arAgentInfo["ORDER_PROPS_VALUE"] = array();
                        $arAgentInfo["PROFILE_PROPS_VALUE"] = array();

                        $arAgent = $arExportInfo[$arAgentInfo["PERSON_TYPE_ID"]];

                        foreach($arAgent as $k => $v)
                        {
                            if(strlen($v["VALUE"]) <= 0 || $v["TYPE"] != "PROPERTY")
                                unset($arAgent[$k]);
                        }

                        foreach($arAgent as $k => $v)
                        {
                            if(!empty($arAgentInfo["ORDER_PROPS"][$k]))
                                $arAgentInfo["ORDER_PROPS_VALUE"][$v["VALUE"]] = $arAgentInfo["ORDER_PROPS"][$k];
                        }

                        if (IntVal($arAgentInfo["PROFILE_ID"]) > 0)
                        {
                            CSaleOrderUserProps::Update($arUProp["ID"], array("VERSION_1C" => $arAgentInfo["AGENT"]["VERSION"], "NAME" => $arAgentInfo["AGENT"]["AGENT_NAME"], "USER_ID" => $arAgentInfo["USER_ID"]));
                            $dbUPV = CSaleOrderUserPropsValue::GetList(array(), array("USER_PROPS_ID" => $arAgentInfo["PROFILE_ID"]));
                            while($arUPV = $dbUPV->Fetch())
                            {
                                $arAgentInfo["PROFILE_PROPS_VALUE"][$arUPV["ORDER_PROPS_ID"]] = array("ID" => $arUPV["ID"], "VALUE" => $arUPV["VALUE"]);
                            }
                        }

                        if(empty($arOrderProps[$arAgentInfo["PERSON_TYPE_ID"]]))
                        {
                            $dbOrderProperties = CSaleOrderProps::GetList(
                                array("SORT" => "ASC"),
                                array(
                                    "PERSON_TYPE_ID" => $arAgentInfo["PERSON_TYPE_ID"],
                                    "ACTIVE" => "Y",
                                    "UTIL" => "N",
                                    "USER_PROPS" => "Y",
                                ),
                                false,
                                false,
                                array("ID", "TYPE", "NAME", "CODE", "USER_PROPS", "SORT", "MULTIPLE")
                            );
                            while ($arOrderProperties = $dbOrderProperties->Fetch())
                            {
                                $arOrderProps[$arAgentInfo["PERSON_TYPE_ID"]][] = $arOrderProperties;
                            }
                        }

                        foreach($arOrderProps[$arAgentInfo["PERSON_TYPE_ID"]] as $arOrderProperties)
                        {
                            $curVal = $arAgentInfo["ORDER_PROPS_VALUE"][$arOrderProperties["ID"]];

                            if (strlen($curVal) > 0)
                            {
                                if (IntVal($arAgentInfo["PROFILE_ID"]) <= 0)
                                {
                                    $arFields = array(
                                        "NAME" => $arAgentInfo["AGENT"]["AGENT_NAME"],
                                        "USER_ID" => $arAgentInfo["USER_ID"],
                                        "PERSON_TYPE_ID" => $arAgentInfo["PERSON_TYPE_ID"],
                                        "XML_ID" => $arAgentInfo["AGENT"]["ID"],
                                        "VERSION_1C" => $arAgentInfo["AGENT"]["VERSION"],
                                    );
                                    $arAgentInfo["PROFILE_ID"] = CSaleOrderUserProps::Add($arFields);
                                }
                                if(IntVal($arAgentInfo["PROFILE_ID"]) > 0)
                                {
                                    $arFields = array(
                                        "USER_PROPS_ID" => $arAgentInfo["PROFILE_ID"],
                                        "ORDER_PROPS_ID" => $arOrderProperties["ID"],
                                        "NAME" => $arOrderProperties["NAME"],
                                        "VALUE" => $curVal
                                    );
                                    if(empty($arAgentInfo["PROFILE_PROPS_VALUE"][$arOrderProperties["ID"]]))
                                    {
                                        CSaleOrderUserPropsValue::Add($arFields);
                                    }
                                    elseif($arAgentInfo["PROFILE_PROPS_VALUE"][$arOrderProperties["ID"]]["VALUE"] != $curVal)
                                    {
                                        CSaleOrderUserPropsValue::Update($arAgentInfo["PROFILE_PROPS_VALUE"][$arOrderProperties["ID"]]["ID"], $arFields);
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        $this->strError .= "\n".GetMessage("CC_BSC1_AGENT_PERSON_TYPE_PROBLEM", Array("#ID#" => $arAgentInfo["AGENT"]["ID"]));
                    }
                }
            }
            else
            {
                $this->strError .= "\n".GetMessage("CC_BSC1_AGENT_NO_AGENT_ID");
            }
        };
    }
}
