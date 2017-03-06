<?php

namespace App\Picture;

use Intervention\Image\ImageManagerStatic as Image;

Image::configure(array('driver' => 'imagick'));

class Picture
{
    public function uploadPicture($file, $id)
    {
        $filepath = pathinfo($file);
        $accepted_extensions = array('image/bmp', 'image/gif', 'image/jpeg', 'image/jpg', 'image/png');

        if ($file != '') {
            //Pruefen, ob richtiges Format!!! (.jpg, .png)
        // if (in_array($file->getClientMimeType(), $accepted_extensions)) {
            $file->move('./files/temp', $file->getClientOriginalName());
            $image = Image::make('./files/temp/'.$file->getClientOriginalName());
            $image = resizePicture($image);
            $image = $image->save('./files/'.$id.'.jpg', 80);
            File::delete('./files/temp/'.$file->getClientOriginalName());
        // } else {
            // Session::flash('error', 'Beim Bildupload gab es einen Fehler!');
        // }
        }
    }

    public function deletePicture($id, $category)
    {
        File::delete('./files/'.$id.'.jpg');
    }

    public function resizePicture($image)
    {
        $limit = 800;
        $height = $image->height();
        $width = $image->width();

        if ($width > $height && $height > $limit) {
            $scaling = $height / $limit;
            $newwidth = $width / $scaling;
            $image = $image->resize($newwidth, $limit);
        } elseif ($height > $width && $width > $limit) {
            $scaling = $width / $limit;
            $newheight = $height / $scaling;
            $image = $image->resize($limit, $newheight);
        }

        return $image;
    }
}
