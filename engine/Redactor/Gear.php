<?php
/**
 * Redactor gear 
 *
 * @author		Dmitriy Belyaev <admin@cogear.ru>
 * @copyright		Copyright (c) 2011, Dmitriy Belyaev
 * @license		http://cogear.ru/license.html
 * @link		http://cogear.ru
 * @package		WYSIWYG
 * @subpackage
 * @version		$Id$
 */
class Redactor_Gear extends Gear {
    protected $name = 'Redactor';
    protected $description = 'Simple WYSIWYG editor';
    /**
     * Init
     */
    public function init(){
        parent::init();
        hook('image.upload',array($this,'uploadImage'));
    }
    /**
     * Upload image
     */
    public function uploadImage(){
        $upload_path = Filesystem::makeDir(UPLOADS.DS.'images'.DS.'pages'.DS.date('Y/m/d/'));
        $filter = new Form_Filter_MachineName();
        if(!empty($_POST['editor_file_link'])){
            $file = $upload_path.DS.$filter->value(basename($_POST['editor_file_link']));
            $info = Image::getInfo($file);
            copy($_POST['editor_file_link'], $file);
        }
        else {
            $image = new Upload_Image('file',array('path'=>$upload_path));
            if($image->upload()){
                $info = $image->getInfo();
                $file = $image->file->path;
                //Ajax::json(array('succes'=>TRUE,'data'=>HTML::img(Url::toUri($image->file->path),$_POST['editor_file_alt'],array('width'=>$info->width,'height'=>$info->height))));
            }
            //Ajax::json(array('success'=>FALSE,'data'=>implode("\n",$image->errors)));
        }
        if(isset($file)){
            if($max = config('pages.image.max','600x600')){
                $size = explode('x',$max);
                sizeof($size) == 1 && $size[1] = $size[0];
                if($info->width > $size[0] OR $info->height > $size[1]){
                    $image = new Image($file);
                    $image->resize($max);
                    $image->save();
                }
            }
            exit(Url::toUri($file));
        }
        exit();
    }
}
