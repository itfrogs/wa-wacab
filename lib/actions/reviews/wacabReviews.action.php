<?php

class wacabReviewsAction extends waViewAction
{

    public function execute()
    {
        $settings_model = new waAppSettingsModel();
        $settings = $settings_model -> get('wacab');

        $model = new wacabPaymentModel();
        $reviews = $model->query('SELECT * FROM wacab_review ORDER BY date DESC')->fetchAll();
        $this->view->assign('reviews', $reviews);
        
        $this->setTemplate(wacabHelper::getAppPath() . '/templates/actions/reviews/reviews_page.html');
    }

}