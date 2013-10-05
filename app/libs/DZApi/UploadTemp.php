<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nuiz
 * Date: 30/9/2556
 * Time: 10:35 น.
 * To change this template use File | Settings | File Templates.
 */

namespace DZApi;


class UploadTemp {
    protected $realPath = null;
    protected $path = null;
    public function __construct($file)
    {
        $upload_name = str_replace('.', '', microtime(true)).'.'.$file->getClientOriginalExtension();
        $file->move('upload_tmp', $upload_name);
        $this->path = 'upload_tmp/'.$upload_name;
        $this->realPath = realpath($this->path);
        chmod($this->path, 0777);
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getRealPath()
    {
        return $this->realPath;
    }

    public function deleteTemp()
    {
        @unlink($this->path);
    }
}