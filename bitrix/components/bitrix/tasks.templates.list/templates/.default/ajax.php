<?
define('STOP_STATISTICS', true);
define('NO_AGENT_CHECK', true);
define('DisableEventsCheck', true);

if (isset($_POST['SITE_ID']) && (string)$_POST['SITE_ID'] != '')
{
	$siteId = mb_substr(trim((string)$_POST['SITE_ID']), 0, 2);
	if (preg_match('#^[a-zA-Z0-9]{2}$#', $siteId))
	{
		define('SITE_ID', $siteId);
	}
}

require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule('tasks');
CBitrixComponent::includeComponentClass("bitrix:tasks.base");

$helper = require(__DIR__.'/helper.php');
TasksBaseComponent::executeComponentAjax(array(), array('RUNTIME_ACTIONS' => $helper->getRunTimeActions()));
TasksBaseComponent::doFinalActions();