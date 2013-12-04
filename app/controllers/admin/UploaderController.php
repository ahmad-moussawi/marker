<?php

class UploaderController extends BaseController {

    public function Image() {
        $destdir = base_path() . '/public/upload/';


        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $size = $file->getSize();
            $mime = $file->getMimeType();
            $ext = $file->getClientOriginalExtension();

            $destname = Str::slug(str_replace(".$ext", '', $file->getClientOriginalName()));
            $destfull = $destdir . $destname . '.' . $ext;

            $filecounter = 1;
            $duplicate = null;
            while (File::exists($destfull)) {
                $duplicate = $destname . '_' . $filecounter++;
                $destfull = $destdir . $duplicate . '.' . $ext;
            }
            
            if ($duplicate !== null) {
                $destname = $duplicate;
            }

//            return Response::Json(array(
//                        $file->getClientOriginalName(),
//                        $ext,
//                        str_replace(".$ext", '', $file->getClientOriginalName()),
//                        $destname,
//                        $destfull,
//                        $destdir,
//                        $filecounter
//            ));


            if ($file->move($destdir, "$destname.$ext")) {
                $dimensions = getimagesize($destfull);
                return Response::json(array(
                            'path' => URL::to("upload/$destname.$ext"),
                            'meta' => array(
                                'size' => $size,
                                'mime' => $mime,
                                'width' => $dimensions[0],
                                'height' => $dimensions[1],
                            )
                ));
            } else {
                return Response::json('failed to move file ' . $destfull, 501);
            }
        } else {
            return Response::json('NoFileException', 501);
        }

        //echo Input::file('image');
    }

}
