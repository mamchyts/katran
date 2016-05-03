<?php
/**
 * The file contains class File()
 */
namespace Admin\Controller;

use Katran\Controller;
use Katran\Helper;
use Katran\Request;
use Katran\Library\FileAPI;
use Katran\Library\FileHelper;
use Admin\Traits\BulkHelper;

/**
 * File controller
 */
class File extends Controller
{
    use BulkHelper;

    /**
     * Function return save files into tmp folder
     *
     * @param    object  $request
     * @return   view
     * @access   public
     */
    public function uploadImagesAction(Request $request)
    {
        $files  = FileAPI::getFiles(); // Retrieve File List
        $images = array();

        // Fetch all image-info from files list
        $this->_fetchImages($files, $images);

        // JSONP callback name
        $jsonp  = isset($_REQUEST['callback']) ? trim($_REQUEST['callback']) : null;

        // JSON-data for server response
        $json = array(
            'images' => $images,
            'data'   => array(
                '_REQUEST' => $_REQUEST,
                '_FILES' => $files
            ),
        );

        // Server response: "HTTP/1.1 200 OK"
        FileAPI::makeResponse(array(
            'status' => FileAPI::OK,
            'statusText' => 'OK',
            'body' => $json,
        ), $jsonp);
        exit;
    }


    /**
     * Helper
     *  
     * @param  array  $files
     * @param  array  $images
     * @param  string $name
     * @return void
     * @access private
     */
    private function _fetchImages($files, &$images, $name = 'file')
    {
        if( isset($files['tmp_name']) ){
            $dotPos = strrpos($files['name'], '.');
            $tmpName = Helper::_slug(substr($files['name'], 0, $dotPos)).'.'.substr($files['name'], $dotPos+1);

            $tmpPath = '/files/tmp/'.$tmpName.'_'.md5(time().microtime());
            $filePath = Helper::_cfg('path_web').$tmpPath;

            // create tmp folder if need
            if(!file_exists(dirname($filePath)))
                Helper::_mkdir(dirname($filePath));

            if(FileHelper::isImage($files['tmp_name'], $files['name'])){
                if(move_uploaded_file($files['tmp_name'], $filePath)){
                    // set mode for tmp file
                    Helper::_chmod($filePath, 0666);

                    $size = getimagesize($filePath);
                    $base64 = base64_encode(file_get_contents($filePath));

                    $images[$name] = array(
                        'width'   => $size[0],
                        'height'  => $size[1],
                        'mime'    => $files['type'],
                        'newName' => basename($filePath),
                        'size'    => filesize($filePath),
                        'dataURL' => 'data:'. $files['type'] .';base64,'. $base64,
                        'filePath' => $tmpPath,
                        'nameWrapped' => wordwrap(htmlentities($files['name']), 30, ' ', true),
                    );
                }
            }
        }
        else{
            foreach( $files as $name => $file ){
                $this->_fetchImages($file, $images, $name);
            }
        }
    }


    /**
     * Function delete image by path
     *
     * @param    object  $request
     * @return   view
     * @access   public
     */
    public function deleteImagesAction(Request $request)
    {
        $deleted = FALSE;
        $img = trim($request->get('img'));
        if(!empty($img)){
            $path = Helper::_cfg('path_web').$img;
            $deleted = $this->_deleteImagesByPath($path);
        }

        return $this->ajaxResponse(['status' => 'ok', 'deleted' => $deleted]);
    }
}