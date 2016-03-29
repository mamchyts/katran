<?php
/**
 * The file contains class Content()
 */
namespace Site\Visitor\Controller;

use Katran\Controller;
use Katran\Request;
use Katran\View;
use Katran\Helper;
use Katran\Database\Db;
use Katran\Library\Pager;
use Katran\Library\Sorter;
use Katran\Url;

/**
 * Content controller
 */
class Content extends Controller
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
        $page = Db::getModel('Site\Visitor\Model\Pages')->find($alias, 'url');

        if(empty($page) || ($page['status'] !== 'active'))
            $this->redirectPage('/404');

        // set active menu
        Helper::_menu($alias);

        $view = new View('content/default.php');
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
        $view = new View('content/page_home.php');
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
        $view = new View('content/page_contacts.php');
        return $view;
    }
}