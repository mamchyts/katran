<?php
/**
 * The file contains class Account()
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
use Admin\Model as m;

/**
 * Account controller
 */
class Account extends Controller
{
    use BulkHelper;

    /**
     * Function return login page
     *
     * @param    object
     * @return   view
     * @access   public
     */
    public function loginAction(Request $request)
    {
        $view = new View('./account/login.php');
        return $view;
    }


    /**
     * Function return do login
     *
     * @param    object
     * @return   void
     * @access   public
     */
    public function doLoginAction(Request $request)
    {
        $dbAccounts = Db::getModel(new m\Accounts);
        $val = new Validator();
        $val->setFields($request);
        $val->setRules('data[login]', 'Логин',  'trim|required');
        $val->setRules('data[pass]',  'Пароль', 'required');

        $errors = [];
        if($val->run()){

            $data = $request->getArray('data');
            $where = [
                ['login', '=', $data['login']],
                ['area', '=', 'admin'],
            ];

            // get user by $where
            $row = $dbAccounts->findBy($where);
            if(empty($row) || !Secure::passwordVerify($data['pass'], $row[0]['pass'])){
                $data = [];
                $errors = ['data[login]' => Helper::_msg('login_error')];
            }
            else{
                if($row[0]['status'] != $dbAccounts::STATUS_ACTIVE){
                    $data = [];
                    $errors = ['data[login]' => Helper::_msg('blocked_account')];
                }
                else{
                    // set session
                    $_SESSION['admin'] = $row[0];
                    unset($_SESSION['admin']['pass']);
                    $data = $_SESSION['admin'];
                }
            }
        }
        else{
            $data = [];
            $errors = $val->getErrors(true);
        }

        $this->forward('/admin', $errors, empty($errors)?Helper::_msg('ok'):false);
    }


    /**
     * Function logout user
     *
     * @param    object
     * @return   view
     * @access   public
     */
    public function logoutAction(Request $request)
    {
        // set session
        unset($_SESSION['admin']);
        $this->forward('/admin', null, Helper::_msg('ok'));
    }


    /**
     * Function return all info
     *
     * @param    object  $request
     * @return   view
     * @access   public
     */
    public function statAction(Request $request)
    {
        // set menu item
        Helper::_menu(['stat', 'Главная']);

        $view = new View('./account/statistics.php');

        $dbAccounts = Db::getModel(new m\Accounts);

        $view->setVar('users', $dbAccounts->countBy());
        $view->setVar('usersActive', $dbAccounts->countBy([['status', '=', $dbAccounts::STATUS_ACTIVE]]));
        return $view;
    }


    /**
     * Function return list of users
     *
     * @param    object  $request
     * @return   view
     * @access   public
     */
    public function listAction(Request $request)
    {
        // set menu item
        Helper::_menu(['account', 'Пользователи']);

        $view = new View('./account/list.php');
        $dbAccounts = Db::getModel(new m\Accounts);

        $url = new Url();
        $sorter = new Sorter($url);
        $pager  = new Pager($url, 20);
        $sorter->init(array('id' => 'desc'));

        $where = [];
        $search = $request->get('search', '');
        if(!empty($search))
            $where[] = ['CONCAT(name, login, tel, note)', 'LIKE', $search];

        $rows = $dbAccounts->findByFull($where, $pager, $sorter);

        $view->setVar('search', $search);
        $view->setVar('rows', $rows);
        $view->setVar('sorter', $sorter);
        $view->setVar('pager', $pager);
        $view->setVar('dbAccounts', $dbAccounts);
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
        Helper::_menu(['account', 'Пользователи']);

        $view = new View('./account/view.php');
        $dbAccounts = Db::getModel(new m\Accounts);

        $row = $dbAccounts->find($request->getInt('id'));

        $view->setVar('row', $row);
        $view->setVar('dbAccounts', $dbAccounts);
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
        $val->setFields($request);
        $val->setRules('data[login]',  'Login',  'trim|required|max_length[35]');
        $val->setRules('data[name]',   'Имя',    'trim|required|max_length[100]');
        $val->setRules('data[role]',   'Права',  'trim|required');
        $val->setRules('data[status]', 'Статус', 'trim|required');

        if(!empty($data['pass']) || !empty($data['pass_re']) || !$id){
            $val->setRules('data[pass]',  'Пароль', 'trim|required|match[data[pass_re]]|min_length[4]');
            $val->setRules('data[pass_re]',  'Пароль (повтор)', 'trim|required');
        }
        else{
            unset($data['pass']);
        }

        $errors = [];
        $dbAccounts = Db::getModel(new m\Accounts);
        if($val->run()){
            $user = $dbAccounts->find($data['login'], 'login');

            if(isset($user['id']) && (intval($user['id']) !== $id))
                $errors[] = 'Пользователь с таким Login\'ом уже существует.';
            else{
                // encrypt password
                if(isset($data['pass'])){
                    $data['salt'] = Secure::generateSalt();
                    $data['pass'] = Secure::generateHash($data['pass'], $data['salt']);
                }

                $data['area'] = 'admin';
                if(!$id){
                    $data['cdate'] = date('Y-m-d H:i:s');
                    $dbAccounts->insert($data);
                }
                else
                    $dbAccounts->update($data, $id);

                $this->forward('/admin?controller=account&action=list', [], Helper::_msg('ok'));
            }
        }

        // add errors into Session
        $this->addSessionErrors(array_merge($val->getErrors(), $errors));

        // set menu item
        Helper::_menu(['account', 'Пользователи']);

        $view = new View('./account/view.php');
        $data['id'] = $id;
        $view->setVar('row', $data);
        $view->setVar('dbAccounts', $dbAccounts);
        return $view;
    }
}