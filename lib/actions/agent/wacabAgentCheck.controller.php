<?php
class wacabAgentCheckController extends waController{
	public function execute(){
		$settings_model = new waAppSettingsModel();
		$settings = $settings_model->get('wacab');
		
		$session = new wacabWaauth();
		$reps = wacabAreportparse::getAreports($session);
		
		$model = new wacabAgentModel();
		$db_reps = $model->getAll();
		
		foreach($reps as $rep){
			if($crep = $model->getByField('rid', $rep['rid'])){
				if(isset($rep['paydate'])){
					if($crep['paydate'] != $rep['paydate']){
						$model->updateById($rep['rid'], $rep);
					}
				}else{
					continue;
				}
			}else{
				$tmp_html = $session->getUrl('https://www.webasyst.ru/my/?action=developerReport&id='.$rep['rid']);
				//			$wacss = $session->getUrl('https://webasyst-926085.c.cdn77.org/wa-apps/baza/css/print.css');
				if(isset($settings['agent_face']) && $settings['agent_face'] != ''){
					$tmp_html['content'] = str_replace('Принципал, в лице _______________________________________________________', 'Принципал, в лице '.$settings['agent_face'], $tmp_html['content']);
				}
				if(isset($settings['agent_basis']) && $settings['agent_basis'] != ''){
					$tmp_html['content'] = str_replace('основании _________________________________', 'основании '.$settings['agent_basis'], $tmp_html['content']);
				}
				if(isset($settings['agent_short_name']) && $settings['agent_short_name'] != ''){
					$tmp_html['content'] = str_replace('/_______________/', '/ '.$settings['agent_short_name'].' /', $tmp_html['content']);
				}
				if(isset($settings['agent_fsize']) && $settings['agent_fsize'] != ''){
					$my_style = '<style>body {font-size: '.$settings['agent_fsize'].';}</style>';
				}else{
					$my_style = '';
				}
		
				//			print_r($rep);
				$rep['html'] = substr($tmp_html['content'], $tmp_html['header_size']).$my_style;
				$model->insert($rep, 1);
			}
		}		
	}
}