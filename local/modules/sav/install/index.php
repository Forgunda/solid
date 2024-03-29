<?
use Bitrix\Main\Localization\Loc;
Class sav extends CModule
{
	var $MODULE_ID ="sav";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";

	public function __construct()
	{
		$arModuleVersion = array();

		include(__DIR__.'/version.php');

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = "Удаление лида и запись в лог";
		$this->MODULE_DESCRIPTION = "Делаем логи ваших удалений";
	}


	function InstallDB($install_wizard = true)
	{
		global $DB, $APPLICATION;
        $this->errors = false;
		$clearInstall = false;
		RegisterModule("sav");
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		global $DB, $APPLICATION;
        $this->errors = false;
		UnRegisterModule("sav");
		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles()
	{
		return true;
	}

	function UnInstallFiles()
	{
		return true;
	}

	function DoInstall()
	{

		$this->InstallFiles();
		$this->InstallDB();
	}

	function DoUninstall()
	{
        $this->UnInstallFiles();
		$this->UnInstallDB();
	}
}
?>