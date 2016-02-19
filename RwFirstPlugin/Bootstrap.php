<?php

class Shopware_Plugins_Frontend_RwFirstPlugin_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{

    public function getInfo()
    {
        return [
            'link' => 'http://github.com/wesolowski',
            'author' => 'Rafal Wesolowski',
            'version' => $this->getVersion(),
            'label' => $this->getLabel()
        ];
    }

    public function getVersion()
    {
        return '0.1';
    }

    public function getLabel()
    {
        return 'My First Plugin';
    }

    public function install()
    {
        // Global Controller Event
        $this->subscribeEvent('Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail', 'onPostDispatchSecureFrontendDetail');
        $this->subscribeEvent('Enlight_Controller_Action_PreDispatch_Frontend_Detail', 'onPreDispatchFrontendDetail');

        return true;
    }


    public function onPreDispatchFrontendDetail(Enlight_Event_EventArgs $args)
    {
//        if (Shopware()->Modules()->Admin()->sCheckUser() === false) {
//            return $args->get('subject')->forward('index', 'index');
//        }
    }

    public function onPostDispatchSecureFrontendDetail(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Controller_Request_RequestHttp $request */
        $request = $args->get('request');
        if ($request->getActionName() === 'index') {
            /** @var Enlight_View_Default $view */
            $view = $args->get('subject')->View();
            $sArticle = $view->getAssign('sArticle');
            $sArticle['articleName'] = $sArticle['articleName'] . ' Test';

            $view->assign('sArticle', $sArticle);
        }
    }


}