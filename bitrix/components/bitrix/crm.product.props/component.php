<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if (!CModule::IncludeModule('crm'))
{
	ShowError(GetMessage('CRM_MODULE_NOT_INSTALLED'));
	return;
}

if(!CAllCrmInvoice::installExternalEntities())
	return;

if (!CModule::IncludeModule('currency'))
{
	ShowError(GetMessage('CRM_MODULE_NOT_INSTALLED_CURRENCY'));
	return;
}
if (!CModule::IncludeModule('catalog'))
{
	ShowError(GetMessage('CRM_MODULE_NOT_INSTALLED_CATALOG'));
	return;
}
if (!CModule::IncludeModule('sale'))
{
	ShowError(GetMessage('CRM_MODULE_NOT_INSTALLED_SALE'));
	return;
}

if (!\Bitrix\Catalog\Access\AccessController::getCurrent()->check(\Bitrix\Catalog\Access\ActionDictionary::ACTION_CATALOG_READ))
{
	$this->IncludeComponentTemplate('productprops_error');
	
	return;
}

global $APPLICATION;

$componentPage = '';
$arDefaultUrlTemplates404 = array(
	'productprops_list' => '',
	'productprops_add' => 'add/',
	'productprops_edit' => 'edit/#prop_id#/',
);

if ($arParams['SEF_MODE'] === 'Y')
{
	$arDefaultVariableAliases404 = array();
	$arComponentVariables = array('prop_id');
	$arVariables = array();
	$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultUrlTemplates404, $arParams['SEF_URL_TEMPLATES']);
	$arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases404, $arParams['VARIABLE_ALIASES']);
	$componentPage = CComponentEngine::ParseComponentPath($arParams['SEF_FOLDER'], $arUrlTemplates, $arVariables);

	if (!(is_string($componentPage) && isset($componentPage[0]) && isset($arDefaultUrlTemplates404[$componentPage])))
	{
		$componentPage = 'productprops_list';
	}

	CComponentEngine::InitComponentVariables($componentPage, $arComponentVariables, $arVariableAliases, $arVariables);

	foreach ($arUrlTemplates as $url => $value)
	{
		$key = 'PATH_TO_'.mb_strtoupper($url);
		$arResult[$key] = isset($arParams[$key][0]) ? $arParams[$key] : $arParams['SEF_FOLDER'].$value;
	}
}
else
{
	$arComponentVariables = array(
		isset($arParams['VARIABLE_ALIASES']['prop_id']) ? $arParams['VARIABLE_ALIASES']['prop_id'] : 'prop_id'
	);

	$arDefaultVariableAliases = array(
		'prop_id' => 'prop_id'
	);
	$arVariables = array();
	$arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases, $arParams['VARIABLE_ALIASES']);
	CComponentEngine::InitComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);

	$componentPage = 'productprops_list';
	if (isset($_REQUEST['edit']))
	{
		$componentPage = 'productprops_edit';
	}

	$curPage = $APPLICATION->GetCurPage();

	$arResult['PATH_TO_PRODUCTPROPS_LIST'] = $curPage;
	$arResult['PATH_TO_PRODUCTPROPS_ADD'] = $curPage.'?add';
	$arResult['PATH_TO_PRODUCTPROPS_EDIT'] = $curPage.'?'.$arVariableAliases['prop_id'].'=#prop_id#&edit';
}

$arResult =
	array_merge(
		array(
			'VARIABLES' => $arVariables,
			'ALIASES' => $arParams['SEF_MODE'] == 'Y' ? array(): $arVariableAliases,
			'PROP_ID' => isset($arVariables['prop_id']) ? strval($arVariables['prop_id']) : ''
		),
		$arResult
	);

$this->IncludeComponentTemplate($componentPage);
?>