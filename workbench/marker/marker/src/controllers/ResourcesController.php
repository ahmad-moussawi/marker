<?php

class ResourcesController extends \BaseController {

    public function Image() {
        $destination = base_path() . '/public/upload/';

        echo Response::json('Hello');die;
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $size = $file->getSize();
            $mime = $file->getMimeType();
            $file->move($destination, 'image.jpg');
            echo Response::json(array(
                'path' => URL::to('upload/image.jpg'),
                'size' => $size,
                'mime' => $mime
            ));
        }else{
            echo Response::json('NoFileException', 501);
        }
        
        //echo Input::file('image');
    }
}
