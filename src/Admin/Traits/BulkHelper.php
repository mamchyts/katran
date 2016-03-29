<?php
/**
 * The file contains trait BulkHelper()
 */
namespace Site\Admin\Traits;

use Katran\Request;
use Katran\Helper;
use Katran\Database\Db;
use Katran\Url;

/**
 * Trait
 */
trait BulkHelper
{
    /**
     * Function save data info or create new user
     *
     * @param    object  $request
     * @return   void
     * @access   public
     */
    public function bulkDeleteAction(Request $request)
    {
        $ids = $request->getArray('ids');
        if(sizeof($ids) === 0)
            $this->forward('/admin/?controller=content&action=list', 'Ничего не выбрано');

        // get table name
        $controller = trim($request->getString('controller'));
        if($controller === 'content')
            $controller = 'page';

        // add `s` for model name
        $modelName = $controller.'s';

        // get DB model
        $db = Db::getModel('Site\Visitor\Model\\'.ucfirst($modelName));

        $errors = [];
        foreach ($ids as $id) {
            $row = $db->find($id);

            try {
                if(empty($row))
                    throw new \Exception('Запись уже удалена', 1);

                // remove also files related to DB model
                $folderPath = Helper::_cfg('path_web').'/img/'.$controller.'/'.$row['id'];
                if(file_exists($folderPath)){
                    foreach (glob($folderPath.'/*.*', GLOB_ERR) as $i) {
                        $this->_deleteImagesByPath($i);
                    }
                }

                // delete rows in db
                $db->delete($row['id']);
            }
            catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        $this->forward($_SERVER['HTTP_REFERER'], empty($errors)?[]:$errors, empty($errors)?Helper::_msg('ok'):[]);
    }


    /**
     * [_deleteImagesByPath description]
     * @param  string $path [description]
     * @return bool
     */
    public function _deleteImagesByPath($path = '')
    {
        $deleted = FALSE;
        if(file_exists($path)){
            $filename = basename($path);

            // delete thumbnails if exist
            foreach (glob(dirname($path).'/*', GLOB_ONLYDIR|GLOB_ERR) as $i) {
                foreach (glob($i.'/*') as $thumbnail) {
                    if(is_file($thumbnail) && (basename($thumbnail) === $filename)){
                        // delete thumbnails file
                        unlink($thumbnail);
                    }
                }

                // if folder is empty - remove them  sizeof(`.`, `..`) = 2;
                if(sizeof(scandir($i)) === 2)
                    rmdir($i);
            }

            // delete fullsize image
            unlink($path);
            $deleted = true;

            // if main folder is empty - remove them (path like: /image/path/{integer}/image.jpg)_
            if( is_numeric(basename(dirname($path))) && sizeof(scandir(dirname($path))) === 2)
                rmdir(dirname($path));
        }

        return $deleted;
    }


}