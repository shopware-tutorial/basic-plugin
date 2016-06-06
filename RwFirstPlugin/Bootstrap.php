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

        // Application Event
        $this->subscribeEvent('Shopware_Modules_Articles_GetPromotionById_Start', 'onShopwareModulesArticlesGetPromotionByIdStart'); // notifyUntil (true|false)
        $this->subscribeEvent('Shopware_Modules_Basket_AddArticle_CheckBasketForArticle', 'onShopwareModulesBasketAddArticleCheckBasketForArticle'); // notify (log or change object)
        $this->subscribeEvent('Shopware_Modules_Basket_GetBasket_FilterSQL', 'onShopwareModulesBasketGetBasketFilter'); // filter (change return value)
        // collect (Add To Array)

        // Hooks (Public/protected Method in ProxyClass)
        $this->subscribeEvent('sArticles::sGetArticleCharts::after', 'onArticlesSGetArticleChartsAfter');
        $this->subscribeEvent('sArticles::sGetArticleCharts::before', 'onArticlesSGetArticleChartsBefore');

        $this->subscribeEvent('sArticles::sGetArticleCharts::replace', 'onArticlesSGetArticleChartsReplace', 1);
        $this->subscribeEvent('sArticles::sGetArticleCharts::replace', 'onArticlesSGetArticleChartsReplace2', 2);
        return true;
    }

    /**
     * @param Enlight_Hook_HookArgs $args
     */
    public function onArticlesSGetArticleChartsReplace2(Enlight_Hook_HookArgs $args)
    {
        //echo  __FUNCTION__ .' / '. __FILE__ .' / '. __LINE__  . '<br>';
        $args->setReturn(
            $args->get('class')->executeParent(
                $args->getMethod(), $args->getArgs()
            )
        );
    }

    /**
     * @param Enlight_Hook_HookArgs $args
     */
    public function onArticlesSGetArticleChartsReplace(Enlight_Hook_HookArgs $args)
    {
        //echo  __FUNCTION__ .' / '. __FILE__ .' / '. __LINE__  . '<br>';
        $args->setReturn(
            $args->get('class')->executeParent(
                $args->getMethod(), $args->getArgs()
            )
        );
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function onShopwareModulesBasketGetBasketFilter(Enlight_Event_EventArgs $args)
    {
//        $sql = $args->getReturn();
//        $sql = str_replace('BY id ASC, datum DESC', 'BY id DESC, datum ASC', $sql);
//        $args->setReturn($sql);
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function onShopwareModulesBasketAddArticleCheckBasketForArticle(Enlight_Event_EventArgs $args)
    {
        $args->get('queryBuilder')->andWhere('false');
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function onShopwareModulesArticlesGetPromotionByIdStart(Enlight_Event_EventArgs $args)
    {
//        if( $args->get('value') !== 114 ) {
//            return false;
//        }
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