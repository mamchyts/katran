<?php
/**
 * The file contains class Setting()
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

/**
 * Setting controller
 */
class Setting extends Controller
{
    /**
     * Index function
     *
     * @param    object  $request
     * @return   void
     */
    public function action(Request $request)
    {
        return $this->tabsAction($request);
    }


    /**
     * Function return tabs of all settings
     *
     * @param    object  $request
     * @return   view
     * @access   public
     */
    public function tabsAction(Request $request)
    {
        // set menu item
        Helper::_menu(['setting', 'Настройки']);

        $view = new View('./setting/tabs.php');

        // one global array
        $tabs = [
            'slideshow' => $this->_getSlideshowImages(),
        ];

        $view->setVar('tabs', $tabs);
        return $view;
    }


    /**
     * Function return array of all images in slideshow dir
     *
     * @return   array
     * @access   private
     */
    private function _getSlideshowImages()
    {
        $slideshowSizes = Helper::_cfg('image_thumbnails', 'slideshow');

        // get images in $dir
        $images = [];
        foreach (glob(Helper::_cfg('path_web').'/img/slideshow/*') as $im){
            // get only files
            if(is_file($im)){
                $images[] = '/img/slideshow/'.basename($im);
            }
        }

        return $images;
    }


    /**
     * Function update images of slideshow
     *
     * @param    object  $request
     * @return   void
     * @access   public
     */
    public function slideshowUpdateAction(Request $request)
    {
        $images = $request->getArray('data');
        $images = (!empty($images['images']))?$images['images']:[];

        // create dir if it non exist
        $slideshowFolderPath = Helper::_cfg('path_web').'/img/slideshow/';
        if(!file_exists($slideshowFolderPath))
            Helper::_mkdir($slideshowFolderPath);

        $slideshowSizes = Helper::_cfg('image_thumbnails', 'slideshow');

        // make Thumbnails of image
        foreach ($images as $im){
            // new image has name = md5(time()), So length = 32, and symbol '_'
            $oldname = Helper::_cfg('path_web').$im;
            if(file_exists($oldname) && (strlen(strrchr($oldname, '_')) == 33)){
                $imageinfo = getimagesize($oldname);
                $extention = FileHelper::getExtentionByMime($imageinfo['mime']);

                $name = str_replace(strrchr($oldname, '_'), '', basename($oldname));
                $name = str_replace(strrchr($name, '.'), '', $name);
                $newname = $slideshowFolderPath.$name.'.'.$extention;

                // create dirs if need
                foreach ($slideshowSizes as $size) {
                    if(!file_exists($slideshowFolderPath.'/'.$size[0].'x'.$size[1])){
                        Helper::_mkdir($slideshowFolderPath.'/'.$size[0].'x'.$size[1]);
                    }
                }

                // create image instances and backup (backup need for best performance)
                $img = ImageManagerStatic::make($oldname);
                $img->backup();

                // create thumbnails
                foreach ($slideshowSizes as $size) {
                    $thumbnailPath = $slideshowFolderPath.'/'.$size[0].'x'.$size[1].'/'.basename($newname);

                    // resize the canvas
                    $img->fit($size[0], $size[1]);
                    $img->save($thumbnailPath);

                    // reset image (return to backup state)
                    $img->reset();

                    // set default file mode
                    chmod($thumbnailPath, Helper::_cfg('filemode', 'file'));
                }

                // move tmp file into folder (save original image)
                rename($oldname, $newname);
                chmod($newname, Helper::_cfg('filemode', 'file'));
            }
        }

        $this->forward('/admin?controller=setting', [], Helper::_msg('ok'));
    }

}