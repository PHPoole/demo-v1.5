<?php
namespace PHPoole;
use PHPoole\Utils;

/**
 * PHPoole plugin Gallery
 */
Class Gallery extends Plugin
{
    const RESIZE_W = 1024;
    const RESIZE_H = 768;

    public function postloopLoadPages($e)
    {
        $params = $e->getParams();
        extract($params);
        $gallery = array();
        if (isset($pageInfo['gallery']) && !empty($pageInfo['gallery'])) {
            $galleryIterator = new \FilesystemIterator($pageInfo['gallery']);
            foreach ($galleryIterator as $galleryFile) {
                if ($galleryFile->isFile()
                    && (strtolower($galleryFile->getExtension()) == 'jpg'
                        || strtolower($galleryFile->getExtension()) == 'png'))
                {
                    $gallery[] = array(
                        'name'      => Utils\slugify($galleryFile->getBasename($galleryFile->getExtension())) . '.' . $galleryFile->getExtension(),
                        'extension' => $galleryFile->getExtension(),
                        'filepath'  => $galleryFile->getPathname(),
                    );
                }
            }
            $pageData['gallery'] = $gallery;
        }
        return compact('pageInfo', 'pageIndex', 'pageData');
    }

    public function postloopGenerate($e)
    {
        $phpoole = $e->getTarget();
        $params = $e->getParams();
        extract($params);
        if (isset($page['gallery']) && !empty($page['gallery'])) {
            foreach ($page['gallery'] as $image) {
                copy($image['filepath'], $phpoole->getWebsitePath() . '/' . $page['path'] . '/' . $image['name']);
                $phpoole->addMessage(sprintf("Copy %s", $image['name']));
                $this->imageResize($phpoole->getWebsitePath() . '/' . $page['path'] . '/' . $image['name'], self::RESIZE_W, self::RESIZE_H);
                $phpoole->addMessage(sprintf("Resize %s", $image['name']));
            }
        }
    }

    private function imageResize($file, $w, $h, $crop=FALSE)
    {
        $fileInfo = new \SplFileInfo($file);
        $fileExt =  $fileInfo->getExtension();
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*($r-$w/$h)));
            }
            else {
                $height = ceil($height-($height*($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        }
        else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            }
            else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }
        if ($fileExt == 'jpg') {
            $src = imagecreatefromjpeg($file);
        }
        elseif ($fileExt == 'png') {
            $src = imagecreatefrompng($file);
        }
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagedestroy($src);
        if ($fileExt == 'jpg') {
            imagejpeg($dst, $file, 100);
        }
        elseif ($fileExt == 'png') {
            imagepng($dst, $file, 0);
        }
    }
}
