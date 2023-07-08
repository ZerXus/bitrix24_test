<?php

namespace Bitrix\Main\Engine\Response;

use Bitrix\Main;
use Bitrix\Main\Context;
use Bitrix\Main\Text\Encoding;

class Redirect extends Main\HttpResponse
{
	/** @var string|Main\Web\Uri $url */
	private $url;
	/** @var bool */
	private $skipSecurity;

	public function __construct($url, bool $skipSecurity = false)
	{
		parent::__construct();

		$this
			->setStatus('302 Found')
			->setSkipSecurity($skipSecurity)
			->setUrl($url)
		;
	}

	/**
	 * @return Main\Web\Uri|string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param Main\Web\Uri|string $url
	 * @return $this
	 */
	public function setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isSkippedSecurity(): bool
	{
		return $this->skipSecurity;
	}

	/**
	 * @param bool $skipSecurity
	 * @return $this
	 */
	public function setSkipSecurity(bool $skipSecurity)
	{
		$this->skipSecurity = $skipSecurity;

		return $this;
	}

	private function checkTrial(): bool
	{
		$isTrial =
			defined("DEMO") && DEMO === "Y" &&
			(
				!defined("SITEEXPIREDATE") ||
				!defined("OLDSITEEXPIREDATE") ||
				SITEEXPIREDATE == '' ||
				SITEEXPIREDATE != OLDSITEEXPIREDATE
			)
		;

		return $isTrial;
	}

	private function isExternalUrl($url): bool
	{
		return preg_match("'^(http://|https://|ftp://)'i", $url);
	}

	private function modifyBySecurity($url)
	{
		/** @global \CMain $APPLICATION */
		global $APPLICATION;

		$isExternal = $this->isExternalUrl($url);
		if(!$isExternal && strpos($url, "/") !== 0)
		{
			$url = $APPLICATION->GetCurDir() . $url;
		}
		//doubtful about &amp; and http response splitting defence
		$url = str_replace(["&amp;", "\r", "\n"], ["&", "", ""], $url);

		if (!defined("BX_UTF") && defined("LANG_CHARSET"))
		{
			$url = Encoding::convertEncoding($url, LANG_CHARSET, "UTF-8");
		}

		return $url;
	}

	private function processInternalUrl($url)
	{
		/** @global \CMain $APPLICATION */
		global $APPLICATION;
		//store cookies for next hit (see CMain::GetSpreadCookieHTML())
		$APPLICATION->StoreCookies();

		$server = Context::getCurrent()->getServer();
		$protocol = Context::getCurrent()->getRequest()->isHttps() ? "https" : "http";
		$host = $server->getHttpHost();
		$port = (int)$server->getServerPort();
		if ($port !== 80 && $port !== 443 && $port > 0 && strpos($host, ":") === false)
		{
			$host .= ":" . $port;
		}

		return "{$protocol}://{$host}{$url}";
	}

	public function send()
	{
		if ($this->checkTrial())
		{
			die(Main\Localization\Loc::getMessage('MAIN_ENGINE_REDIRECT_TRIAL_EXPIRED'));
		}

		$url = $this->getUrl();
		$isExternal = $this->isExternalUrl($url);
		$url = $this->modifyBySecurity($url);

		/*ZDUyZmZNWFlMWQwOWM0NzdiOWE1MzQ2NzFkZTIzYjcxMDI1YjU=*/$GLOBALS['____1633594860']= array(base64_decode('bX'.'RfcmFuZA=='),base64_decode('aX'.'N'.'f'.'b2'.'J'.'qZWN'.'0'),base64_decode(''.'Y2F'.'sbF91c2VyX2Z1bmM='),base64_decode('Y2'.'F'.'sbF'.'91c2Vy'.'X2Z1bmM='),base64_decode('ZXhw'.'b'.'G9'.'kZQ'.'=='),base64_decode(''.'cGFja'.'w=='),base64_decode('bW'.'Q1'),base64_decode('Y29uc3R'.'hbnQ='),base64_decode('a'.'GFzaF9'.'o'.'bWFj'),base64_decode('c'.'3Ry'.'Y21'.'w'),base64_decode('b'.'W'.'V0aG'.'9kX'.'2V4a'.'XN0cw='.'='),base64_decode(''.'a'.'W5'.'0dm'.'Fs'),base64_decode(''.'Y2Fsb'.'F91c2'.'Vy'.'X2Z1b'.'mM='));if(!function_exists(__NAMESPACE__.'\\___600017972')){function ___600017972($_874391200){static $_810695234= false; if($_810695234 == false) $_810695234=array('VVNFUg==',''.'VV'.'NFUg==','VVNFUg='.'=',''.'SXNBdXRob3Jpe'.'mVk',''.'VVNFUg==',''.'S'.'X'.'NBZG1p'.'bg==','REI=','U0V'.'MRU'.'NUIFZ'.'BTF'.'VFIE'.'ZST00'.'gYl'.'9vcHR'.'p'.'b24gV'.'0hFUkUgTkFN'.'RT'.'0nf'.'lB'.'BUkFN'.'X01BWF9VU0VSUycgQU5EI'.'E1PR'.'FVMR'.'V'.'9J'.'RD'.'0nbWFpbicgQU5EIFNJV'.'EVfSUQgSVMg'.'Tl'.'V'.'M'.'TA'.'==',''.'VkFMVUU=','Lg==','SC'.'o=','Yml'.'0'.'cml4',''.'TE'.'lDR'.'U5TRV9LRVk=','c'.'2'.'hh'.'MjU2','XEJpdHJ'.'peFx'.'N'.'YW'.'luXExpY2Vuc2U=','Z2V'.'0QW'.'N0aXZ'.'lVXN'.'lcn'.'N'.'Db3VudA'.'==',''.'RE'.'I=','U0VM'.'R'.'UNU'.'I'.'E'.'N'.'PVU5UKFUuSU'.'Qp'.'IGF'.'zIEM'.'g'.'RlJPTSBiX'.'3VzZ'.'X'.'Ig'.'VSBXSEVSR'.'SB'.'VLkFDV'.'El'.'W'.'RS'.'A'.'9I'.'Cd'.'ZJyBBTkQgV'.'S'.'5M'.'QVN'.'UX0xPR0lOIElTIE5PVCBOV'.'Ux'.'MIEFOR'.'CB'.'FWEl'.'TVFMoU0VMRU'.'NUICd4JyBGU'.'k'.'9NIGJfdXRtX3VzZ'.'XIgVUYsI'.'GJfdXNlcl9'.'m'.'aWV'.'sZ'.'CBGIFdIRVJFIEYu'.'RU5USVRZX0lEID0g'.'J'.'1VTRVI'.'nIEF'.'ORCBG'.'LkZ'.'J'.'RUxEX05B'.'TUUgPS'.'An'.'V'.'UZfREVQ'.'QVJU'.'TUVOVCc'.'gQU5E'.'IF'.'V'.'GLkZJRUxEX0'.'lEID'.'0'.'gRi5JR'.'C'.'BBT'.'kQg'.'VUYuVkFM'.'V'.'U'.'VfS'.'UQgPSB'.'VLk'.'lEIEFORCBVR'.'i5WQU'.'xV'.'RV9'.'JTlQ'.'g'.'S'.'V'.'MgTk9UIE5V'.'TEwgQU5'.'EI'.'FVGLlZ'.'BTF'.'VFX0lOVCA8PiAwKQ==','Qw==','VVN'.'FUg==','TG9nb'.'3V0');return base64_decode($_810695234[$_874391200]);}};if($GLOBALS['____1633594860'][0](round(0+1), round(0+4+4+4+4+4)) == round(0+7)){ if(isset($GLOBALS[___600017972(0)]) && $GLOBALS['____1633594860'][1]($GLOBALS[___600017972(1)]) && $GLOBALS['____1633594860'][2](array($GLOBALS[___600017972(2)], ___600017972(3))) &&!$GLOBALS['____1633594860'][3](array($GLOBALS[___600017972(4)], ___600017972(5)))){ $_1763790728= $GLOBALS[___600017972(6)]->Query(___600017972(7), true); if(!($_689225304= $_1763790728->Fetch())){ $_1415598780= round(0+12);} $_1752282910= $_689225304[___600017972(8)]; list($_803089655, $_1415598780)= $GLOBALS['____1633594860'][4](___600017972(9), $_1752282910); $_2122277064= $GLOBALS['____1633594860'][5](___600017972(10), $_803089655); $_208971833= ___600017972(11).$GLOBALS['____1633594860'][6]($GLOBALS['____1633594860'][7](___600017972(12))); $_1764831530= $GLOBALS['____1633594860'][8](___600017972(13), $_1415598780, $_208971833, true); if($GLOBALS['____1633594860'][9]($_1764831530, $_2122277064) !==(132*2-264)){ $_1415598780= round(0+3+3+3+3);} if($_1415598780 != min(86,0,28.666666666667)){ if($GLOBALS['____1633594860'][10](___600017972(14), ___600017972(15))){ $_612084446= new \Bitrix\Main\License(); $_4564600= $_612084446->getActiveUsersCount();} else{ $_4564600=(954-2*477); $_1763790728= $GLOBALS[___600017972(16)]->Query(___600017972(17), true); if($_689225304= $_1763790728->Fetch()){ $_4564600= $GLOBALS['____1633594860'][11]($_689225304[___600017972(18)]);}} if($_4564600> $_1415598780){ $GLOBALS['____1633594860'][12](array($GLOBALS[___600017972(19)], ___600017972(20)));}}}}/**/
		foreach (GetModuleEvents("main", "OnBeforeLocalRedirect", true) as $event)
		{
			ExecuteModuleEventEx($event, [&$url, $this->isSkippedSecurity(), &$isExternal, $this]);
		}

		if (!$isExternal)
		{
			$url = $this->processInternalUrl($url);
		}

		$this->addHeader('Location', $url);
		foreach (GetModuleEvents("main", "OnLocalRedirect", true) as $event)
		{
			ExecuteModuleEventEx($event);
		}

		Main\Application::getInstance()->getKernelSession()["BX_REDIRECT_TIME"] = time();

		parent::send();
	}
}