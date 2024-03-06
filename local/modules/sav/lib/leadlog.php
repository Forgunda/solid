<?php
namespace Bitrix\Sav;
use Bitrix\Main\Entity;
use Bitrix\Main;
use Bitrix\Main\Type\DateTime;
use Bitrix\Crm;
//Класс Книг
class Leadlog
{
    const $months = [ 1 => 'Январь' , 'Февраль' , 'Март' , 'Апрель' , 'Май' , 'Июнь' , 'Июль' , 'Август' , 'Сентябрь' , 'Октябрь' , 'Ноябрь' , 'Декабрь' ];
	public static function mklog($LeadID,$UserID,$dir)
		/*Создает лог файл в указанной дирректории $dir, 
			определяет и пишет кто удалил лид ($LeadID- ID удаляегомого Лида) по его $UserID.
		*/
	{

		//Создадим папку
		$mnth = mktime(0, 0, 0, date("m"), 1,  date("Y"));
		$new_dir1=$dir."/".$months[date('n',$mnth)].date('Y',$mnth)."/";
		if(!file_exists($new_dir1)){
			mkdir($new_dir1);
		}
		//Создадим папку
		$new_dir=$new_dir1.date('dmY').'/';
		if(!file_exists($new_dir)){
			mkdir($new_dir);
		}
		//создадим файл
		$filename=$new_dir."deleted.log";
		if(!file_exists($filename)){
			$fh=fopen($filename, "x");
			fclose($fh);
		}
		//Пользователь
		$rsUser = \Bitrix\Main\UserTable::getById($UserID);
		$arUser = $rsUser->fetch();
		$usr='Удалил-'.$arUser['ID'].'-'.$arUser['NAME'].' '.$arUser['LAST_NAME'];
		$leadResult = \Bitrix\Crm\LeadTable::getList([
			'select' => ["*"],
			'filter' => [
				'=ID' => $LeadID,
			],
		]);
		$lead=$leadResult->fetch()
        $new_str=$usr.' \n\r';
        if($lead["ID"]==$LeadID){
            foreach($lead as $key=>$ld)
            {
                $new_str.='['.$key.']=>'.$ld;
            }
            $ER.=file_put_contents($filename, PHP_EOL.$new_str, FILE_APPEND);
        }
		return true;
	}
	public static function arclogs($dir)
	{ 
		/*Делает архив за прошлый месяц. Формат искомой папки апрель2024*/
		$mnth = mktime(0, 0, 0, date("m")-1, 1,  date("Y"));
		$new_dir=$dir.'/'.$months[date("n",$mnth)].date("Y",$mnth);
		//создадим архив
		if(!file_exists($new_dir.'zip')){
			$arPackFiles = scandir($new_dir);
			$rsArchive = \CBXArchive::GetArchive($new_dir.'.zip');
			$pRes = $rsArchive->Pack($arPackFiles);
		}
		return $arPackFiles;
	}
}
?>