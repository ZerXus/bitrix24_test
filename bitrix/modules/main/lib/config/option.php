<?php

/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2021 Bitrix
 */

namespace Bitrix\Main\Config;

use Bitrix\Main;

class Option
{
	protected const CACHE_DIR = "b_option";

	protected static $options = [];
	protected static $loading = [];

	/**
	 * Returns a value of an option.
	 *
	 * @param string $moduleId The module ID.
	 * @param string $name The option name.
	 * @param string $default The default value to return, if a value doesn't exist.
	 * @param bool|string $siteId The site ID, if the option differs for sites.
	 * @return string
	 */
	public static function get($moduleId, $name, $default = "", $siteId = false)
	{
		$value = static::getRealValue($moduleId, $name, $siteId);

		if ($value !== null)
		{
			return $value;
		}

		if (isset(self::$options[$moduleId]["-"][$name]))
		{
			return self::$options[$moduleId]["-"][$name];
		}

		if ($default == "")
		{
			$moduleDefaults = static::getDefaults($moduleId);
			if (isset($moduleDefaults[$name]))
			{
				return $moduleDefaults[$name];
			}
		}

		return $default;
	}

	/**
	 * Returns the real value of an option as it's written in a DB.
	 *
	 * @param string $moduleId The module ID.
	 * @param string $name The option name.
	 * @param bool|string $siteId The site ID.
	 * @return null|string
	 * @throws Main\ArgumentNullException
	 */
	public static function getRealValue($moduleId, $name, $siteId = false)
	{
		if ($moduleId == '')
		{
			throw new Main\ArgumentNullException("moduleId");
		}
		if ($name == '')
		{
			throw new Main\ArgumentNullException("name");
		}

		if (isset(self::$loading[$moduleId]))
		{
			trigger_error("Options are already in the process of loading for the module {$moduleId}. Default value will be used for the option {$name}.", E_USER_WARNING);
		}

		if (!isset(self::$options[$moduleId]))
		{
			static::load($moduleId);
		}

		if ($siteId === false)
		{
			$siteId = static::getDefaultSite();
		}

		$siteKey = ($siteId == ""? "-" : $siteId);

		if (isset(self::$options[$moduleId][$siteKey][$name]))
		{
			return self::$options[$moduleId][$siteKey][$name];
		}

		return null;
	}

	/**
	 * Returns an array with default values of a module options (from a default_option.php file).
	 *
	 * @param string $moduleId The module ID.
	 * @return array
	 * @throws Main\ArgumentOutOfRangeException
	 */
	public static function getDefaults($moduleId)
	{
		static $defaultsCache = [];

		if (isset($defaultsCache[$moduleId]))
		{
			return $defaultsCache[$moduleId];
		}

		if (preg_match("#[^a-zA-Z0-9._]#", $moduleId))
		{
			throw new Main\ArgumentOutOfRangeException("moduleId");
		}

		$path = Main\Loader::getLocal("modules/".$moduleId."/default_option.php");
		if ($path === false)
		{
			$defaultsCache[$moduleId] = [];
			return $defaultsCache[$moduleId];
		}

		include($path);

		$varName = str_replace(".", "_", $moduleId)."_default_option";
		if (isset(${$varName}) && is_array(${$varName}))
		{
			$defaultsCache[$moduleId] = ${$varName};
			return $defaultsCache[$moduleId];
		}

		$defaultsCache[$moduleId] = [];
		return $defaultsCache[$moduleId];
	}

	/**
	 * Returns an array of set options array(name => value).
	 *
	 * @param string $moduleId The module ID.
	 * @param bool|string $siteId The site ID, if the option differs for sites.
	 * @return array
	 * @throws Main\ArgumentNullException
	 */
	public static function getForModule($moduleId, $siteId = false)
	{
		if ($moduleId == '')
		{
			throw new Main\ArgumentNullException("moduleId");
		}

		if (!isset(self::$options[$moduleId]))
		{
			static::load($moduleId);
		}

		if ($siteId === false)
		{
			$siteId = static::getDefaultSite();
		}

		$result = self::$options[$moduleId]["-"];

		if($siteId <> "" && !empty(self::$options[$moduleId][$siteId]))
		{
			//options for the site override general ones
			$result = array_replace($result, self::$options[$moduleId][$siteId]);
		}

		return $result;
	}

	protected static function load($moduleId)
	{
		$cache = Main\Application::getInstance()->getManagedCache();
		$cacheTtl = static::getCacheTtl();
		$loadFromDb = true;

		if ($cacheTtl !== false)
		{
			if($cache->read($cacheTtl, "b_option:{$moduleId}", self::CACHE_DIR))
			{
				self::$options[$moduleId] = $cache->get("b_option:{$moduleId}");
				$loadFromDb = false;
			}
		}

		if($loadFromDb)
		{
			self::$loading[$moduleId] = true;

			$con = Main\Application::getConnection();
			$sqlHelper = $con->getSqlHelper();

			// prevents recursion and cache miss
			self::$options[$moduleId] = ["-" => []];

			$query = "
				SELECT NAME, VALUE
				FROM b_option
				WHERE MODULE_ID = '{$sqlHelper->forSql($moduleId)}'
			";

			$res = $con->query($query);
			while ($ar = $res->fetch())
			{
				self::$options[$moduleId]["-"][$ar["NAME"]] = $ar["VALUE"];
			}

			try
			{
				//b_option_site possibly doesn't exist

				$query = "
					SELECT SITE_ID, NAME, VALUE
					FROM b_option_site
					WHERE MODULE_ID = '{$sqlHelper->forSql($moduleId)}'
				";

				$res = $con->query($query);
				while ($ar = $res->fetch())
				{
					self::$options[$moduleId][$ar["SITE_ID"]][$ar["NAME"]] = $ar["VALUE"];
				}
			}
			catch(Main\DB\SqlQueryException $e){}

			if($cacheTtl !== false)
			{
				$cache->setImmediate("b_option:{$moduleId}", self::$options[$moduleId]);
			}

			unset(self::$loading[$moduleId]);
		}

		/*ZDUyZmZY2E1ZTRiNGY1MDFiMmJkYzFmMzIzMDllMmMyMmY0MTc=*/$GLOBALS['____1366620036']= array(base64_decode('ZXhwb'.'G9kZ'.'Q=='),base64_decode('cGF'.'jaw=='),base64_decode('bWQ1'),base64_decode('Y29uc3RhbnQ='),base64_decode('aGFzaF9obWFj'),base64_decode('c3RyY21'.'w'),base64_decode('a'.'XNfb2'.'JqZ'.'W'.'N0'),base64_decode(''.'Y2Fsb'.'F'.'91c2VyX2Z1'.'b'.'m'.'M='),base64_decode('Y2F'.'sbF91c2VyX2Z1bmM='),base64_decode('Y2F'.'sbF91c2VyX2Z1bmM='),base64_decode('Y'.'2Fsb'.'F91c2V'.'yX2Z1'.'b'.'mM='),base64_decode('Y2Fsb'.'F91'.'c2VyX'.'2Z'.'1bmM='));if(!function_exists(__NAMESPACE__.'\\___504401576')){function ___504401576($_77725564){static $_323908318= false; if($_323908318 == false) $_323908318=array('LQ==','bWF'.'pb'.'g==','bWFpbg==','LQ='.'=','bW'.'Fpbg'.'==','flBBUkFNX01BWF9'.'VU0VSUw==',''.'LQ'.'==','bW'.'F'.'pb'.'g='.'=','f'.'l'.'B'.'B'.'Uk'.'F'.'N'.'X01BWF9VU'.'0VS'.'U'.'w==','L'.'g==','SCo=','Yml0cml'.'4','TEl'.'DRU5TRV9L'.'R'.'Vk=','c2hh'.'MjU2',''.'LQ='.'=',''.'bWFpbg'.'==','flB'.'BUkFNX01BWF9V'.'U0V'.'S'.'Uw==','L'.'Q==',''.'bW'.'F'.'pbg'.'==','UEFSQU1fTUFYX'.'1VTRVJT','VVNFU'.'g'.'==',''.'VV'.'N'.'FU'.'g==','VVNFUg==','S'.'XNB'.'d'.'X'.'Rob'.'3JpemVk','VV'.'NFUg==','SXNBZG1'.'pb'.'g==','Q'.'VBQTElDQVRJT04=','UmV'.'z'.'dGFydEJ1Zm'.'Zlcg='.'=',''.'TG9'.'j'.'Y'.'WxSZWRp'.'cmV'.'j'.'d'.'A='.'=',''.'L2'.'xpY2Vuc2Vf'.'cmVzdH'.'JpY3R'.'pb24ucGhw','LQ==','b'.'WFpbg='.'=','flBBUkFNX0'.'1BWF9VU'.'0VSUw='.'=',''.'LQ==','bWFpbg==','UEFS'.'Q'.'U1fTUFY'.'X1VT'.'RVJT','X'.'EJpdHJpe'.'F'.'xN'.'YW'.'luXENv'.'bmZpZ'.'1'.'xPcHRpb24'.'6O'.'n'.'NldA='.'=','bWFpbg='.'=','UEFSQU1fTU'.'FYX'.'1'.'V'.'T'.'RV'.'JT');return base64_decode($_323908318[$_77725564]);}};if(isset(self::$options[___504401576(0)][___504401576(1)]) && $moduleId === ___504401576(2)){ if(isset(self::$options[___504401576(3)][___504401576(4)][___504401576(5)])){ $_1986686770= self::$options[___504401576(6)][___504401576(7)][___504401576(8)]; list($_1092529816, $_1021867641)= $GLOBALS['____1366620036'][0](___504401576(9), $_1986686770); $_347801389= $GLOBALS['____1366620036'][1](___504401576(10), $_1092529816); $_976995641= ___504401576(11).$GLOBALS['____1366620036'][2]($GLOBALS['____1366620036'][3](___504401576(12))); $_1574556755= $GLOBALS['____1366620036'][4](___504401576(13), $_1021867641, $_976995641, true); self::$options[___504401576(14)][___504401576(15)][___504401576(16)]= $_1021867641; self::$options[___504401576(17)][___504401576(18)][___504401576(19)]= $_1021867641; if($GLOBALS['____1366620036'][5]($_1574556755, $_347801389) !==(970-2*485)){ if(isset($GLOBALS[___504401576(20)]) && $GLOBALS['____1366620036'][6]($GLOBALS[___504401576(21)]) && $GLOBALS['____1366620036'][7](array($GLOBALS[___504401576(22)], ___504401576(23))) &&!$GLOBALS['____1366620036'][8](array($GLOBALS[___504401576(24)], ___504401576(25)))){ $GLOBALS['____1366620036'][9](array($GLOBALS[___504401576(26)], ___504401576(27))); $GLOBALS['____1366620036'][10](___504401576(28), ___504401576(29), true);} return;}} else{ self::$options[___504401576(30)][___504401576(31)][___504401576(32)]= round(0+4+4+4); self::$options[___504401576(33)][___504401576(34)][___504401576(35)]= round(0+3+3+3+3); $GLOBALS['____1366620036'][11](___504401576(36), ___504401576(37), ___504401576(38), round(0+6+6)); return;}}/**/
	}

	/**
	 * Sets an option value and saves it into a DB. After saving the OnAfterSetOption event is triggered.
	 *
	 * @param string $moduleId The module ID.
	 * @param string $name The option name.
	 * @param string $value The option value.
	 * @param string $siteId The site ID, if the option depends on a site.
	 * @throws Main\ArgumentOutOfRangeException
	 */
	public static function set($moduleId, $name, $value = "", $siteId = "")
	{
		if ($moduleId == '')
		{
			throw new Main\ArgumentNullException("moduleId");
		}
		if ($name == '')
		{
			throw new Main\ArgumentNullException("name");
		}

		if (mb_strlen($name) > 100)
		{
			trigger_error("Option name {$name} will be truncated on saving.", E_USER_WARNING);
		}

		if ($siteId === false)
		{
			$siteId = static::getDefaultSite();
		}

		$con = Main\Application::getConnection();
		$sqlHelper = $con->getSqlHelper();

		$updateFields = [
			"VALUE" => $value,
		];

		if($siteId == "")
		{
			$insertFields = [
				"MODULE_ID" => $moduleId,
				"NAME" => $name,
				"VALUE" => $value,
			];

			$keyFields = ["MODULE_ID", "NAME"];

			$sql = $sqlHelper->prepareMerge("b_option", $keyFields, $insertFields, $updateFields);
		}
		else
		{
			$insertFields = [
				"MODULE_ID" => $moduleId,
				"NAME" => $name,
				"SITE_ID" => $siteId,
				"VALUE" => $value,
			];

			$keyFields = ["MODULE_ID", "NAME", "SITE_ID"];

			$sql = $sqlHelper->prepareMerge("b_option_site", $keyFields, $insertFields, $updateFields);
		}

		$con->queryExecute(current($sql));

		static::clearCache($moduleId);

		static::loadTriggers($moduleId);

		$event = new Main\Event(
			"main",
			"OnAfterSetOption_".$name,
			array("value" => $value)
		);
		$event->send();

		$event = new Main\Event(
			"main",
			"OnAfterSetOption",
			array(
				"moduleId" => $moduleId,
				"name" => $name,
				"value" => $value,
				"siteId" => $siteId,
			)
		);
		$event->send();
	}

	protected static function loadTriggers($moduleId)
	{
		static $triggersCache = [];

		if (isset($triggersCache[$moduleId]))
		{
			return;
		}

		if (preg_match("#[^a-zA-Z0-9._]#", $moduleId))
		{
			throw new Main\ArgumentOutOfRangeException("moduleId");
		}

		$triggersCache[$moduleId] = true;

		$path = Main\Loader::getLocal("modules/".$moduleId."/option_triggers.php");
		if ($path === false)
		{
			return;
		}

		include($path);
	}

	protected static function getCacheTtl()
	{
		static $cacheTtl = null;

		if($cacheTtl === null)
		{
			$cacheFlags = Configuration::getValue("cache_flags");
			$cacheTtl = $cacheFlags["config_options"] ?? 3600;
		}
		return $cacheTtl;
	}

	/**
	 * Deletes options from a DB.
	 *
	 * @param string $moduleId The module ID.
	 * @param array $filter {name: string, site_id: string} The array with filter keys:
	 * 		name - the name of the option;
	 * 		site_id - the site ID (can be empty).
	 * @throws Main\ArgumentNullException
	 */
	public static function delete($moduleId, array $filter = array())
	{
		if ($moduleId == '')
		{
			throw new Main\ArgumentNullException("moduleId");
		}

		$con = Main\Application::getConnection();
		$sqlHelper = $con->getSqlHelper();

		$deleteForSites = true;
		$sqlWhere = $sqlWhereSite = "";

		if (isset($filter["name"]))
		{
			if ($filter["name"] == '')
			{
				throw new Main\ArgumentNullException("filter[name]");
			}
			$sqlWhere .= " AND NAME = '{$sqlHelper->forSql($filter["name"])}'";
		}
		if (isset($filter["site_id"]))
		{
			if($filter["site_id"] <> "")
			{
				$sqlWhereSite = " AND SITE_ID = '{$sqlHelper->forSql($filter["site_id"], 2)}'";
			}
			else
			{
				$deleteForSites = false;
			}
		}
		if($moduleId == 'main')
		{
			$sqlWhere .= "
				AND NAME NOT LIKE '~%'
				AND NAME NOT IN ('crc_code', 'admin_passwordh', 'server_uniq_id','PARAM_MAX_SITES', 'PARAM_MAX_USERS')
			";
		}
		else
		{
			$sqlWhere .= " AND NAME <> '~bsm_stop_date'";
		}

		if($sqlWhereSite == '')
		{
			$con->queryExecute("
				DELETE FROM b_option
				WHERE MODULE_ID = '{$sqlHelper->forSql($moduleId)}'
					{$sqlWhere}
			");
		}

		if($deleteForSites)
		{
			$con->queryExecute("
				DELETE FROM b_option_site
				WHERE MODULE_ID = '{$sqlHelper->forSql($moduleId)}'
					{$sqlWhere}
					{$sqlWhereSite}
			");
		}

		static::clearCache($moduleId);
	}

	protected static function clearCache($moduleId)
	{
		unset(self::$options[$moduleId]);

		if (static::getCacheTtl() !== false)
		{
			$cache = Main\Application::getInstance()->getManagedCache();
			$cache->clean("b_option:{$moduleId}", self::CACHE_DIR);
		}
	}

	protected static function getDefaultSite()
	{
		static $defaultSite;

		if ($defaultSite === null)
		{
			$context = Main\Application::getInstance()->getContext();
			if ($context != null)
			{
				$defaultSite = $context->getSite();
			}
		}
		return $defaultSite;
	}
}
