<?php
class wacabAreportparse{
	public static function getAreports($auth){
		
		$reports = array();
		$response = $auth -> getUrl('https://www.webasyst.ru/my/?action=developerReports');
		$src_reports = explode('</tr>', self::getSubstring($response['content'], '<tbody>', '</tbody>', 7));
		foreach($src_reports as $src_report){

			if(!strpos($src_report, 'tr onclick')){
				continue;
			}else{
				$arep = explode('<td>', $src_report);
				$report = array(
						'rid' => self::getSubstring($arep[0], 'report/', "'", 7, 7),
						'sdate' => date("Y-m-d H:i:s", strtotime(strip_tags($arep[1]))),
						'edate' => date("Y-m-d H:i:s", strtotime(strip_tags($arep[2]))),
						'sum' => strip_tags(str_replace(' ', '', str_replace('руб.', '', $arep[3]))),
				);
				if(strlen(trim(strip_tags($arep[4]))) > 0){
echo strip_tags($arep[4])."size ".strip_tags($arep[4])."<br>";					
					$report['paydate'] = date("Y-m-d H:i:s", strtotime(strip_tags($arep[4]))); 
				}
				$reports[] = $report;
			}
		}
		
		return $reports;
	}

	public static function getSubstring($source, $s_anchor, $e_anchor, $s_offset = 0, $e_offset = 0)
	{
		$result = substr($source, strpos($source, $s_anchor) + $s_offset, strpos($source, $e_anchor, strpos($source, $s_anchor) + $s_offset) - strpos($source, $s_anchor) - $e_offset);
		return $result;
	}

}