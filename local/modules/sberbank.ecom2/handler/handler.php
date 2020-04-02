<?php

namespace Sale\Handlers\PaySystem;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\NotImplementedException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\Request;
use Bitrix\Main\SystemException;
use Bitrix\Main\Type\DateTime;
use Bitrix\Sale\Delivery\Services\Manager;
use Bitrix\Sale\PaySystem;
use Bitrix\Sale\Payment;
use Bitrix\Sale\Order;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Bitrix\Sale\PropertyValue;
use Bitrix\Sale\PropertyValueCollectionBase;
use Bitrix\Sale\Result;
use CSaleStatus;
use Sberbank\Payments\Gateway;

IncludeModuleLangFile(__FILE__);
require_once dirname(dirname(__FILE__)) . '/config.php';
Loader::includeModule( 'sberbank.ecom2' );

class sberbank_ecom2Handler extends PaySystem\ServiceHandler implements PaySystem\IPrePayable, PaySystem\IRefund
{
    public const MODULE_ID = 'sberbank.ecom2';

    /**
     * @param Payment $payment
     * @param Request|null $request
     * @return PaySystem\ServiceResult
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws LoaderException
     * @throws NotImplementedException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
	public function initiatePay(Payment $payment, Request $request = null)
	{

		$moduleId = self::MODULE_ID;

		$RBS_Gateway = new Gateway;


		// module settings
		$RBS_Gateway->setOptions(array(
			'module_id' => Option::get($moduleId, 'MODULE_ID'),
			'gate_url_prod' => Option::get($moduleId, 'SBERBANK_PROD_URL'),
			'gate_url_test' => Option::get($moduleId, 'SBERBANK_TEST_URL'),
			'module_version' => Option::get($moduleId, 'MODULE_VERSION'),
			'iso' => unserialize(Option::get($moduleId, 'ISO')),
			'cms_version' => 'Bitrix ' . SM_VERSION,
			'language' => 'ru',
		));

		// handler settings
		$RBS_Gateway->setOptions(array(
			'ofd_tax' => $this->getBusinessValue($payment, 'SBERBANK_OFD_TAX_SYSTEM') == 0 ? 0 : $this->getBusinessValue($payment, 'SBERBANK_OFD_TAX_SYSTEM'),
			'ofd_enabled' => $this->getBusinessValue($payment, 'SBERBANK_OFD_RECIEPT')  == 'Y' ? 1 : 0,
			'ffd_version' => $this->getBusinessValue($payment, 'SBERBANK_FFD_VERSION'),
			'ffd_payment_object' => $this->getBusinessValue($payment, 'SBERBANK_FFD_PAYMENT_OBJECT'),
			'ffd_payment_method' => $this->getBusinessValue($payment, 'SBERBANK_FFD_PAYMENT_METHOD'),
			'test_mode' => $this->getBusinessValue($payment, 'SBERBANK_GATE_TEST_MODE') == 'Y' ? 1 : 0,
			'handler_logging' => $this->getBusinessValue($payment, 'SBERBANK_HANDLER_LOGGING') == 'Y' ? 1 : 0,
			'handler_two_stage' => $this->getBusinessValue($payment, 'SBERBANK_HANDLER_TWO_STAGE') == 'Y' ? 1 : 0,
		));

		$RBS_Gateway->buildData(array(
			'orderNumber' => $this->getBusinessValue($payment, 'SBERBANK_ORDER_NUMBER'),
		    'amount' => $this->getBusinessValue($payment, 'SBERBANK_ORDER_AMOUNT'),
		    'userName' => $this->getBusinessValue($payment, 'SBERBANK_GATE_LOGIN'),
		    'password' => $this->getBusinessValue($payment, 'SBERBANK_GATE_PASSWORD'),
		    'description' => $this->getBusinessValue($payment, 'SBERBANK_ORDER_DESCRIPTION'),
		));

		$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== "off" ? 'https://' : 'http://';
		$domain_name = $_SERVER['HTTP_HOST'];


		if(SITE_DIR == '/' || strlen(SITE_DIR) == 0) {
			$site_dir = '/';
		} else {
			if(substr(SITE_DIR, 0, 1) != '/') {
			    $site_dir = '/' . SITE_DIR;
			}
			if(substr(SITE_DIR, -1, 1) != '/') {
			    $site_dir = SITE_DIR . '/';
			}
		}


		$RBS_Gateway->buildData(array(
		    'returnUrl' => $protocol . $domain_name . $site_dir  . 'sberbank/result.php' . '?PAYMENT=SBERBANK&ORDER_ID=' . $payment->getField('ORDER_ID') . '&PAYMENT_ID=' . $payment->getField('ID')
		));

		if ($RBS_Gateway->ofdEnable()) {

			$Order = Order::load($payment->getOrderId());
			$propertyCollection = $Order->getPropertyCollection();
			$Basket = $Order->getBasket();
			$basketItems = $Basket->getBasketItems();

			$phone_key = strlen(Option::get($moduleId, 'OPTION_PHONE')) > 0 ? Option::get($moduleId, 'OPTION_PHONE') : 'PHONE';
			$email_key = strlen(Option::get($moduleId, 'OPTION_EMAIL')) > 0 ? Option::get($moduleId, 'OPTION_EMAIL') : 'EMAIL';

			$RBS_Gateway->setOptions(array(
				'customer_name' => $this->getPropertyValueByCode($propertyCollection, 'FIO'),
				'customer_email' => $this->getPropertyValueByCode($propertyCollection, $email_key),
				'customer_phone' => $this->getPropertyValueByCode($propertyCollection, $phone_key),
			));

			$lastIndex = 0;
			foreach ($basketItems as $key => $BasketItem) {
				$lastIndex = $key + 1;
		        $RBS_Gateway->setPosition(array(
		            'positionId' => $key,
		            'itemCode' => $BasketItem->getProductId(),
		            'name' => $BasketItem->getField('NAME'),
		            'itemAmount' => $BasketItem->getFinalPrice(),
		            'itemPrice' => $BasketItem->getPrice(),
		            'quantity' => array(
		                'value' => $BasketItem->getQuantity(),
		                'measure' => $BasketItem->getField('MEASURE_NAME'),
		            ),
		            'tax' => array(
		                'taxType' =>  $RBS_Gateway->getTaxCode( $BasketItem->getField('VAT_RATE') * 100 ),
		            ),
		        ));
			}

			if($Order->getField('PRICE_DELIVERY') > 0) {

				Loader::includeModule('catalog');
				$deliveryInfo = Manager::getById($Order->getField('DELIVERY_ID'));

				$deliveryVatItem = \CCatalogVat::GetByID($deliveryInfo['VAT_ID'])->Fetch();
				$RBS_Gateway->setOptions(array(
				    'delivery' => true,
				));
				$RBS_Gateway->setPosition(array(
		            'positionId' => $lastIndex + 1,
		            'itemCode' => 'DELIVERY_' . $Order->getField('DELIVERY_ID'),
		            'name' => Loc::getMessage('SBERBANK_PAYMENT_FIRLD_DELIVERY'),
		            'itemAmount' => $Order->getField('PRICE_DELIVERY'),
		            'itemPrice' => $Order->getField('PRICE_DELIVERY'),
		            'quantity' => array(
		                'value' => 1,
		                'measure' => Loc::getMessage('SBERBANK_PAYMENT_FIELD_MEASURE'),
		            ),
		            'tax' => array(
		                'taxType' => $RBS_Gateway->getTaxCode($deliveryVatItem['RATE']),
		            ),
		        ));
			}
		}

		$gateResponse = $RBS_Gateway->registerOrder();

		$params = array(
	        'sberbank_result' => $gateResponse,
	        'payment_link' => $RBS_Gateway->getPaymentLink(),
	        'currency' => $payment->getField('CURRENCY')
	    );
	    $this->setExtraParams($params);

	    return $this->showTemplate($payment, "payment");
	}

    /**
     * @param Payment $payment
     * @param Request $request
     * @return PaySystem\ServiceResult
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws NotImplementedException
     * @throws ObjectException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
	public function processRequest(Payment $payment, Request $request)
	{
		global $APPLICATION;
		$moduleId = self::MODULE_ID;

		$RBS_Gateway = new Gateway;
		$RBS_Gateway->setOptions(array(
			// module settings
			'gate_url_prod' => Option::get($moduleId, 'SBERBANK_PROD_URL'),
			'gate_url_test' => Option::get($moduleId, 'SBERBANK_TEST_URL'),
			'test_mode' => $this->getBusinessValue($payment, 'SBERBANK_GATE_TEST_MODE') == 'Y' ? 1 : 0,
		));

		$RBS_Gateway->buildData(array(
		    'userName' => $this->getBusinessValue($payment, 'SBERBANK_GATE_LOGIN'),
		    'password' => $this->getBusinessValue($payment, 'SBERBANK_GATE_PASSWORD'),
		    'orderId' => $request->get('orderId'),
		));

		$gateResponse = $RBS_Gateway->checkOrder();

		$resultId = $gateResponse['orderNumber'];
        $successPayment = true;

        if($resultId != $this->getBusinessValue($payment, 'SBERBANK_ORDER_NUMBER')) {
			$successPayment = false;
		}

        if( $gateResponse['errorCode'] != 0 || ($gateResponse['orderStatus'] != 1 && $gateResponse['orderStatus'] != 2) ) {
        	$successPayment = false;
        }

        if($successPayment && !$payment->isPaid()) {

        	// set payment status
        	$order = Order::load($payment->getOrderId());
			$paymentCollection = $order->getPaymentCollection();

			foreach ($paymentCollection as $col_payment) {
				if($col_payment->getField('ID') == $payment->getField('ID')) {
					$col_payment->setPaid("Y");
					$col_payment->setFields(array(
		                "PS_SUM" => $gateResponse["amount"] / 100,
		                "PS_CURRENCY" => $gateResponse["currency"],
		                "PS_RESPONSE_DATE" => new DateTime(),
		                "PS_STATUS" => "Y",
		                "PS_STATUS_DESCRIPTION" => $gateResponse["cardAuthInfo"]["pan"] . ";" . $gateResponse['cardAuthInfo']["cardholderName"],
		                "PS_STATUS_MESSAGE" => $gateResponse["paymentAmountInfo"]["paymentState"],
		                "PS_STATUS_CODE" =>  $gateResponse['orderStatus'],
	        		));

	        		break;
				}
			}

			//order props
            $transactionProperty = $this->getOrderProperty(
                $order->getPropertyCollection(),
                'TRANSACTION_ID'
            );
            if (!is_null($transactionProperty)) {
                $transactionProperty->setValue(
                    $RBS_Gateway->getOrderAttribute($gateResponse['attributes'], 'mdOrder')
                );
            }
            //end

			$option_order_status = Option::get($moduleId, 'RESULT_ORDER_STATUS');

			$statuses = array();
			$dbStatus = CSaleStatus::GetList(Array("SORT" => "ASC"), Array("LID" => LANGUAGE_ID), false, false, Array("ID", "NAME", "SORT"));
			while ($arStatus = $dbStatus->GetNext()) {
			    $statuses[$arStatus["ID"]] = "[" . $arStatus["ID"] . "] " . $arStatus["NAME"];
			}

			if($order->isPaid()) {
				// // set order status
				if(array_key_exists($option_order_status, $statuses)) {
					$order->setField('STATUS_ID', $option_order_status);
				} else {
					echo '<span style="display:block; font-size:16px; display:block; color:red;padding:20px 0;">ERROR! CANT CHANGE ORDER STATUS</span>';
				}
				// set delivery status
				if($this->getBusinessValue($payment, 'SBERBANK_HANDLER_SHIPMENT') == 'Y') {
					$shipmentCollection = $order->getShipmentCollection();
					foreach ($shipmentCollection as $shipment){
					    if (!$shipment->isSystem()) {
			        		$shipment->allowDelivery();
					    }
			    	}
		    	}
	    	}

		    $order->save();
        }


		echo '<div class="sberbank-result-message">';
        if($successPayment) {
        	$APPLICATION->SetTitle(Loc::getMessage('SBERBANK_PAYMENT_MESSAGE_THANKS'));
        	echo Loc::getMessage('SBERBANK_PAYMENT_MESSAGE_THANKS_DESCRIPTION', [
        	    '#ORDER_NUMBER#' => $this->getBusinessValue($payment, 'SBERBANK_ORDER_NUMBER')
            ]);
        } else {
        	$APPLICATION->SetTitle(Loc::getMessage('SBERBANK_PAYMENT_MESSAGE_ERROR'));
        	echo Loc::getMessage('SBERBANK_PAYMENT_MESSAGE_ERROR') . ' #' . $this->getBusinessValue($payment, 'SBERBANK_ORDER_NUMBER');
        }
        echo "</div>";

        return new PaySystem\ServiceResult();
	}

    /**
     * @param Request $request
     * @return int|mixed
     */
	public function getPaymentIdFromRequest(Request $request)
	{
	    $paymentId = $request->get('PAYMENT_ID');
	    return intval($paymentId);
	}

    /**
     * @return array
     */
	public function getCurrencyList()
	{
		return array('RUB');
	}

    /**
     * @return array
     */
	public static function getIndicativeFields()
	{
		return array('PAYMENT' => 'SBERBANK');
	}

    /**
     * @param Request $request
     * @param $paySystemId
     * @return bool
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws NotImplementedException
     * @throws ObjectNotFoundException
     */
	static protected function isMyResponseExtended(Request $request, $paySystemId)
	{
		$order = Order::load($request->get('ORDER_ID'));
		if(!$order) {
			$order = Order::loadByAccountNumber($request->get('ORDER_ID'));
		}
		if(!$order) {
			echo Loc::getMessage('RBS_MESSAGE_ERROR_BAD_ORDER');
			return false;
		}

		$paymentIds = $order->getPaymentSystemId();
		return in_array($paySystemId, $paymentIds);
	}

    /**
     * @param $propertyCollection
     * @param $code
     * @return mixed
     */
	private function getPropertyValueByCode($propertyCollection, $code) {
		$property = '';
		foreach ($propertyCollection as $property)
	    {
	        if($property->getField('CODE') == $code)
	            return $property->getValue();
	    }
	}

	/**
	 * @return array
	 */
	protected function getUrlList()
	{
		return array(

		);
	}

	/**
	 * @return array
	 */
	public function getProps()
	{
		$data = array();

		return $data;
	}

    /**
     * @param Payment|null $payment
     * @param Request $request
     * @return bool
     */
	public function initPrePayment(Payment $payment = null, Request $request)
	{
		return true;
	}

	/**
	 * @param array $orderData
	 */
	public function payOrder($orderData = array())
	{

	}

	/**
	 * @param array $orderData
	 * @return bool|string
	 */
	public function BasketButtonAction($orderData = array())
	{
		return true;
	}

	/**
	 * @param array $orderData
	 */
	public function setOrderConfig($orderData = array())
	{
		if ($orderData)
			$this->prePaymentSetting = array_merge($this->prePaymentSetting, $orderData);
	}

	public function isTuned(){}

    /**
     * @return bool
     */
	public function isRefundableExtended()
    {
	    return true;
	}

    /**
     * @param Payment $payment
     */
	public function confirm(Payment $payment){}

    /**
     * @param Payment $payment
     */
	public function cancel(Payment $payment){}

    /**
     * @param Payment $payment
     * @param $refundableSum
     * @return Result|void
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws NotImplementedException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
	public function refund(Payment $payment, $refundableSum)
    {
        $refundableSum = $refundableSum * 100;
        $order = $payment->getOrder();

        $transactionProperty = $this->getOrderProperty(
            $order->getPropertyCollection(),
            'TRANSACTION_ID'
        );

        if (is_null($transactionProperty)) return;

        //gateway
        $RBS_Gateway = new Gateway;
        $RBS_Gateway->setOptions(array(
            // module settings
            'gate_url_prod' => Option::get(self::MODULE_ID, 'SBERBANK_PROD_URL'),
            'gate_url_test' => Option::get(self::MODULE_ID, 'SBERBANK_TEST_URL'),
            'test_mode' => $this->getBusinessValue($payment, 'SBERBANK_GATE_TEST_MODE') == 'Y' ? 1 : 0,
        ));
        $RBS_Gateway->buildData(array(
            'userName' => $this->getBusinessValue($payment, 'SBERBANK_GATE_LOGIN'),
            'password' => $this->getBusinessValue($payment, 'SBERBANK_GATE_PASSWORD'),
            'orderId' => $transactionProperty->getValue(),
            'amount' => $refundableSum,
        ));
        //end

        $gateResponse = $RBS_Gateway->checkOrder();

        if ((int) $gateResponse['errorCode'] !== 0) return;

        $RBS_Gateway->buildData([
            'orderId' => $RBS_Gateway->getOrderAttribute($gateResponse['attributes'], 'mdOrder')
        ]);

        //basket items
        $basketItems = $order->getBasket()->getBasketItems();
        $basketItemsCount = 0;

        foreach ($basketItems as $key => $BasketItem) {
            $basketItemsCount += (int) $BasketItem->getQuantity();
        }

        $refSumPerItem = $refundableSum / $basketItemsCount;

        foreach ($basketItems as $key => $BasketItem) {
            $RBS_Gateway->setPosition([
                'positionId' => $key,
                'name' => $BasketItem->getField('NAME'),
                'quantity' => array(
                    'value' => $BasketItem->getQuantity(),
                    'measure' => $BasketItem->getField('MEASURE_NAME'),
                ),
                'itemAmount' => $refSumPerItem / (int) $BasketItem->getQuantity(),
                'itemCode' => $BasketItem->getProductId(),
                'itemPrice' => $refSumPerItem,
            ]);
        }
        //end

        $RBS_Gateway->buildData([
            'refundItems' => [
                'items' => $RBS_Gateway->getBasket(),
            ],
        ]);

        $RBS_Gateway->refund();

        return new Result();
    }

    /**
     * @param PaySystem\ServiceResult $result
     * @param Request $request
     * @return mixed|void
     */
	public function sendResponse(PaySystem\ServiceResult $result, Request $request){}

    /**
     * @param PropertyValueCollectionBase $collection
     * @param string $code
     * @return PropertyValue|null
     */
	protected function getOrderProperty(PropertyValueCollectionBase $collection, string $code): ?PropertyValue
    {
        foreach ($collection as $property)
        {
            /** @var PropertyValue $property */
            if($property->getField('CODE') == $code)
                return $property;
        }

        return null;
    }
}
