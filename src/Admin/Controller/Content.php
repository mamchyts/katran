<?php
/**
 * The file contains class Content()
 */
namespace Site\Admin\Controller;

use Katran\Controller;
use Katran\Request;
use Katran\View;
use Katran\Helper;
use Katran\Database\Db;
use Katran\Url;
use Katran\Library\Validator;
use Katran\Library\Pager;
use Katran\Library\Sorter;
use Katran\Library\FileHelper;
use Intervention\Image\ImageManagerStatic;
use Site\Admin\Traits\BulkHelper;

/**
 * Content controller
 */
class Content extends Controller
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
        Helper::_menu(['content', 'Страницы']);

        $view = new View('./content/list.php');
        $dbPages = Db::getModel('Site\Visitor\Model\Pages');

        $url = new Url();
        $sorter = new Sorter($url);
        $pager  = new Pager($url, 20);
        $sorter->init(array('id' => 'desc'));

        $where = [];
        $search = trim($request->getString('search'));
        $where[] = ['CONCAT(title, descr, url)', 'LIKE', $search];

        $rows = $dbPages->findByFull($where, $pager, $sorter);

        $view->setVar('search', $search);
        $view->setVar('rows', $rows);
        $view->setVar('sorter', $sorter);
        $view->setVar('pager', $pager);
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
        Helper::_menu(['content', 'Страницы']);

        $view = new View('./content/view.php');
        $dbPages = Db::getModel('Site\Visitor\Model\Pages');

        $row = $dbPages->find($request->getInt('id'));

        $view->setVar('row', $row);
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
        $id   = $request->getInt('id');
        $data = $request->getArray('data');

        $val = new Validator();
        $val->setFields($data);
        $val->setRules('url',    'Url', 'trim|required|max_length[250]');
        $val->setRules('title',  'Название страницы', 'trim|required|max_length[250]');
        // $val->setRules('descr',  'Краткое описание страницы', 'trim|required|max_length[2000]');
        // $val->setRules('html',   'Полное описание страницы', 'trim|required|max_length[20000]');
        $val->setRules('status', 'Статус', 'trim|required');

        $errors = array();
        if($val->run()){
            // only english symbols
            $data['url'] = Helper::_slug(trim($data['url']));

            $dbPages = Db::getModel('Site\Visitor\Model\Pages');
            $article = $dbPages->find($data['url'], 'url');
            if(isset($article['id']) && ($article['id'] != $id))
                $errors[] = 'Страница с таким `Url` уже существует.';
            else{             

                // update or create new row in Db
                if($request->getString('id') == 'new'){
                    $data['cdate'] = date('Y-m-d H:i:s');
                    $id = $dbPages->insert($data);
                }
                else
                    $dbPages->update($data, $id);

                $this->forward('/admin/?controller=content&action=list', array(), Helper::_msg('ok'));
            }
        }

        $errors = array_merge($errors, $val->getErrors());
        $data['id'] = $request->getString('id');

        $view = new View('./content/view.php');
        $view->setVar('row', $data);

        // add errors into Session
        $this->addSessionError($errors);
        return $view;
    }


}