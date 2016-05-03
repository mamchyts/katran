<?php
/**
 * The file contains class Page()
 */
namespace Visitor\Controller;

use Katran\Request;
use Katran\View;
use Katran\Helper;
use Katran\Controller;
use Katran\Database\Db;
use Katran\Library\Pager;
use Katran\Library\Sorter;
use Katran\Url;
use Common\Model as m;

/**
 * Page controller
 */
class Page extends Controller
{
    /**
     * [defaultAction description]
     * @param  Request $request [description]
     * @return View
     */
    public function defaultAction(Request $request)
    {
        // get page information, if page exists
        $url = new Url();
        $alias = $url->getParam('alias');
        $dbPages = Db::getModel(new m\Pages);
        $page = $dbPages->find($alias, 'url');

        if(empty($page) || ($page['status'] !== 'active'))
            $this->redirectPage('/404');

        // set active menu
        Helper::_menu($alias);

        $view = new View('./page/default.php');
        $view->setVar('page', $page);
        return $view;
    }


    /**
     * [homeAction description]
     * @param  Request $request [description]
     * @return View
     */
    public function homeAction(Request $request)
    {
        // set active menu
        Helper::_menu('home');
        $view = new View('./page/home.php');
        return $view;
    }


    /**
     * [contactsAction description]
     * @param  Request $request [description]
     * @return View
     */
    public function contactsAction(Request $request)
    {
        // set active menu
        Helper::_menu('contacts');
        $view = new View('./page/contacts.php');
        return $view;
    }
}