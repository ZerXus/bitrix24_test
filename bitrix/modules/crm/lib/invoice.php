<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage crm
 * @copyright 2013-2013 Bitrix
 */
namespace Bitrix\Crm;

use Bitrix\Main\Entity;
use Bitrix\Main\Event;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

/**
 * Class InvoiceTable
 *
 * DO NOT WRITE ANYTHING BELOW THIS
 *
 * <<< ORMENTITYANNOTATION
 * @method static EO_Invoice_Query query()
 * @method static EO_Invoice_Result getByPrimary($primary, array $parameters = [])
 * @method static EO_Invoice_Result getById($id)
 * @method static EO_Invoice_Result getList(array $parameters = [])
 * @method static EO_Invoice_Entity getEntity()
 * @method static \Bitrix\Crm\EO_Invoice createObject($setDefaultValues = true)
 * @method static \Bitrix\Crm\EO_Invoice_Collection createCollection()
 * @method static \Bitrix\Crm\EO_Invoice wakeUpObject($row)
 * @method static \Bitrix\Crm\EO_Invoice_Collection wakeUpCollection($rows)
 */
class InvoiceTable extends Entity\DataManager
{
	private static $STATUS_INIT = false;
	private static $WORK_STATUSES = array();
	private static $CANCEL_STATUSES = array();

	public static function getUfId()
	{
		return 'CRM_INVOICE';
	}

	public static function getTableName()
	{
		return 'b_crm_invoice';
	}

	public static function getMap()
	{
		global $DB;

		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
			),
			'DATE_INSERT' => array(
				'data_type' => 'datetime'
			),
			'DATE_INS' => array(
				'data_type' => 'datetime',
				'expression' => array(
					$DB->datetimeToDateFunction('%s'), 'DATE_INSERT'
				)
			),
			'DATE_UPDATE' => array(
				'data_type' => 'datetime'
			),
			'DATE_UPDATE_SHORT' => array(
				'data_type' => 'datetime',
				'expression' => array(
					$DB->datetimeToDateFunction('%s'), 'DATE_UPDATE'
				)
			),
			'PRODUCTS_QUANT' => array(
				'data_type' => 'float',
				'expression' => array(
					'(SELECT  SUM(b_crm_invoice_basket.QUANTITY)
						FROM b_crm_invoice_basket
						WHERE b_crm_invoice_basket.ORDER_ID = %s)', 'ID'
				)
			),
			'PRICE' => array(
				'data_type' => 'float'
			),
			'PRICE_PAYED' => array(
				'data_type' => 'float',
				'expression' => array(
					'CASE WHEN %s = \'P\' THEN %s ELSE 0 END',
					'STATUS_ID', 'PRICE'
				),
				'values' => array(0, 1)
			),
			'STATUS_ID' => array(
				'data_type' => 'string'
			),
			'STATUS_BY' => array(
				'data_type' => 'Status',
				'reference' => array(
					'=this.STATUS_ID' => 'ref.STATUS_ID',
					'=ref.ENTITY_ID' => array('?', 'INVOICE_STATUS'),
				)
			),
			'PAY_SYSTEM_ID' => array(
				'data_type' => 'integer'
			),
			'SUM_PAID' => array(
				'data_type' => 'float'
			),
			'SUM_PAID_FORREP' => array(
				'data_type' => 'float',
				'expression' => array(
					'CASE WHEN %s = \'Y\' THEN %s ELSE %s END', 'PAYED', 'PRICE', 'SUM_PAID'
				)
			),
			'PAY_VOUCHER_NUM' => array(
				'data_type' => 'string'
			),
			'PAY_VOUCHER_DATE' => array(
				'data_type' => 'datetime'
			),
			'PAY_VOUCHER_DATE_SHORT' => array(
				'data_type' => 'datetime',
				'expression' => array(
					$DB->datetimeToDateFunction('%s'), 'PAY_VOUCHER_DATE'
				)
			),
			'LID' => array(
				'data_type' => 'string'
			),
			'COMMENTS' => array(
				'data_type' => 'string'
			),
			'USER_DESCRIPTION' => [
				'data_type' => 'string'
			],
			'PERSON_TYPE_ID' => array(
				'data_type' => 'string'
			),
			'IS_PAYED' => array(
				'data_type' => 'boolean',
				'expression' => array(
					'CASE WHEN %s = \'P\' THEN 1 ELSE 0 END',
					'STATUS_ID'
				),
				'values' => array(0, 1)
			),
			'INVOICE_UTS' => array(
				'data_type' => 'InvoiceStUts',
				'reference' => array(
					'=this.ID' => 'ref.VALUE_ID'
				)
			),
			'ACCOUNT_NUMBER' => array(
				'data_type' => 'string'
			),
			'ORDER_TOPIC' => array(
				'data_type' => 'string'
			),
			'DATE_BILL' => array(
				'data_type' => 'datetime'
			),
			'DATE_BILL_SHORT' => array(
				'data_type' => 'datetime',
				'expression' => array(
					$DB->datetimeToDateFunction('%s'), 'DATE_BILL'
				)
			),
			'DATE_PAY_BEFORE' => array(
				'data_type' => 'datetime'
			),
			'DATE_PAY_BEFORE_SHORT' => array(
				'data_type' => 'datetime',
				'expression' => array(
					$DB->datetimeToDateFunction('%s'), 'DATE_PAY_BEFORE'
				)
			),
			'DATE_MARKED' => array(
				'data_type' => 'datetime'
			),
			'DATE_MARKED_SHORT' => array(
				'data_type' => 'datetime',
				'expression' => array(
					$DB->datetimeToDateFunction('%s'), 'DATE_MARKED'
				)
			),
			'REASON_MARKED' => array(
				'data_type' => 'string'
			),
			'RESPONSIBLE_ID' => array(
				'data_type' => 'integer'
			),
			'ASSIGNED_BY' => array(
				'data_type' => 'Bitrix\Main\User',
				'reference' => array('=this.RESPONSIBLE_ID' => 'ref.ID')
			),
			'CURRENCY' => array(
				'data_type' => 'string'
			),
			'DATE_BEGIN_SHORT' => array(
				'data_type' => 'datetime',
				'expression' => array(
					$DB->datetimeToDateFunction($DB->IsNull('%s', '%s')),
					'DATE_BILL', 'DATE_INSERT'
				)
			),
			'IS_RECURRING' =>array(
				'data_type' => 'boolean',
				'values' => array('N', 'Y'),
				'default_value' => 'N'
			),
			'SEARCH_CONTENT' =>array(
				'data_type' => 'text'
			)
		);
	}

	private static function ensureStatusesLoaded()
	{
		if(self::$STATUS_INIT)
		{
			return;
		}

		global $DB;

		$paidStatus = null;
		$arStatuses = array();
		$arStatuses = \CCrmInvoice::GetStatusList();
		foreach ($arStatuses as $statusID => $arStatus)
		{
			if(!$paidStatus && strval($statusID) === 'P')
			{
				$paidStatus = $arStatus;
				continue;
			}
		}

		self::$WORK_STATUSES = array();
		self::$CANCEL_STATUSES = array();

		if($paidStatus)
		{
			$paidStatusSort = intval($paidStatus['SORT']);
			foreach($arStatuses as $statusID => $arStatus)
			{
				$sort = intval($arStatus['SORT']);
				if($sort < $paidStatusSort)
				{
					self::$WORK_STATUSES[] = '\''.$DB->ForSql($statusID).'\'';
				}
				elseif($sort > $paidStatusSort)
				{
					self::$CANCEL_STATUSES[] = '\''.$DB->ForSql($statusID).'\'';
				}
			}
		}

		self::$STATUS_INIT = true;
	}

	public static function processQueryOptions(&$options)
	{
		$stub = '_BX_STATUS_STUB_';
		self::ensureStatusesLoaded();
		$options['WORK_STATUS_IDS'] = '('.(!empty(self::$WORK_STATUSES) ? implode(',', self::$WORK_STATUSES) : "'$stub'").')';
		$options['CANCEL_STATUS_IDS'] = '('.(!empty(self::$CANCEL_STATUSES) ? implode(',', self::$CANCEL_STATUSES) : "'$stub'").')';
	}

	/**
	 * OnSalePsServiceProcessRequestBeforePaid event handler.
	 * Redetermine information about pay system in invoice
	 *
	 * @param \Bitrix\Main\Event $event Event object.
	 * @return void
	 */
	public static function redeterminePaySystem(Event $event)
	{
		$parameters = $event->getParameters();

		/** @var \Bitrix\Sale\Payment $payment*/
		$payment = $parameters['payment'];
		if ($payment::getRegistryType() !== REGISTRY_TYPE_CRM_INVOICE)
		{
			return;
		}

		$status = $parameters['status'];
		$paySystemId = $parameters['pay_system_id'];

		if ($status === 'Y')
		{
			$paysystem = \Bitrix\Sale\PaySystem\Manager::getById($paySystemId);
			$payment->setField("PAY_SYSTEM_ID", $paySystemId);
			$payment->setField("PAY_SYSTEM_NAME", $paysystem['NAME']);
		}
	}

	public static function getFieldCaption($fieldName)
	{
		$result = Loc::getMessage("CRM_INVOICE_ENTITY_{$fieldName}_FIELD");
		return is_string($result) ? $result : '';
	}
}
