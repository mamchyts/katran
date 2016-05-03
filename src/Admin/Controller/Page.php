<?php
/**
 * The file contains class Page()
 */
namespace Admin\Controller;

use Katran\Controller;
use Katran\View;
use Katran\Helper;
use Katran\Database\Db;
use Katran\Url;
use Katran\Secure;
use Katran\Request;
use Katran\Library\Validator;
use Katran\Library\Pager;
use Katran\Library\Sorter;
use Admin\Traits\BulkHelper;
use Common\Model as m;

/**
 * Page controller
 */
class Page extends Controller
{
    use BulkHelper;

    /**
     * Index function
     *
     * @param    object  $request
     * @return   void
     */
    public function action(Request $request)
    {
        return $this->listAction($request);
    }


    /**
     * Function return list of pages in site
     *
     * @param    object  $request
     * @return   view
     * @access   public
     */
    public function listAction(Request $request)
    {
        // set menu item
        Helper::_menu(['page', 'Страницы']);

        $view = new View('./page/list.php');
        $dbPages = Db::getModel(new m\Pages);

        $url = new Url();
        $sorter = new Sorter($url);
        $pager  = new Pager($url, 20);
        $sorter->init(array('id' => 'desc'));

        $where = [];
        $search = trim($request->get('search'));
        $where[] = ['CONCAT(title, descr, url)', 'LIKE', $search];

        $rows = $dbPages->findByFull($where, $pager, $sorter);

        $view->setVar('search', $search);
        $view->setVar('rows', $rows);
        $view->setVar('sorter', $sorter);
        $view->setVar('pager', $pager);
        $view->setVar('dbPages', $dbPages);
        return $view;
    }


    /**
     * Function return single user info
     *
     * @param    object  $request
     * @return   view
     * @access   public
     */
    public function viewAction(Request $request)
    {
        // set menu item
        Helper::_menu(['page', 'Страницы']);

        $view = new View('./page/view.php');
        $dbPages = Db::getModel(new m\Pages);

        $row = $dbPages->find($request->getInt('id'));

        $view->setVar('row', $row);
        $view->setVar('dbPages', $dbPages);
        return $view;
    }


    /**
     * Function save data info or create new user
     *
     * @param    object  $request
     * @return   void
     * @access   public
     */
    public function saveAction(Request $request)
    {
        $dbPages = Db::getModel(new m\Pages);

        $id   = $request->getInt('id');
        $data = $request->getArray('data');

        $val = new Validator();
        $val->setFields($data);
        $val->setRules('url',    'Url', 'trim|required|max_length[250]');
        $val->setRules('title',  'Название страницы', 'trim|required|max_length[250]');
        $val->setRules('status', 'Статус', 'trim|required');

        $errors = array();
        if($val->run()){
            // only english symbols
            $data['url'] = Helper::_slug(trim($data['url']));

            $article = $dbPages->find($data['url'], 'url');
            if(isset($article['id']) && ($article['id'] !== $id))
                $errors[] = 'Страница с таким `Url` уже существует.';
            else{             

                // update or create new row in Db
                if($request->get('id') === 'new'){
                    $data['cdate'] = date('Y-m-d H:i:s');
                    $id = $dbPages->insert($data);
                }
                else
                    $dbPages->update($data, $id);

                $this->forward('/admin/?controller=page&action=list', array(), Helper::_msg('ok'));
            }
        }

        $errors = array_merge($errors, $val->getErrors());
        $data['id'] = $request->get('id');

        $view = new View('./page/view.php');
        $view->setVar('row', $data);
        $view->setVar('dbPages', $dbPages);

        // add errors into Session
        $this->addSessionError($errors);
        return $view;
    }


}