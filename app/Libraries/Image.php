<?php

/**
 * This file is part of OpenMVM.
 *
 * (c) OpenMVM <admin@openmvm.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace App\Libraries;

class Image {
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Libraries
        $this->session = \Config\Services::session();
        $this->image = \Config\Services::image();
    }

    /**
     * Resize.
     *
     */
    public function resize($file, int $width, int $height, bool $maintainRatio = false, string $masterDim = 'auto')
    {
        $dir_image = ROOTPATH . 'public/assets/images/';
        $dir_cache = ROOTPATH . 'public/assets/images/cache/';

        $path_parts = pathinfo($file);
        $dirname = $path_parts['dirname'];
        $basename = $path_parts['basename'];
        $filename = $path_parts['filename'];
        $ext = pathinfo(ROOTPATH . $file, PATHINFO_EXTENSION);

        $new_name = $dirname . '/' . $filename . '-' . $width . 'x' . $height . '.' . $ext;

        // Create cache dir
        if (!is_dir($dir_cache . $dirname)) {
            mkdir($dir_cache . $dirname, 0755, true);
            file_put_contents($dir_cache . $dirname . '/index.html', '');
        }

        if (!is_file($dir_cache . $new_name)) {
            $this->image->withFile($dir_image . $file);
            $this->image->resize($width, $height, $maintainRatio, $masterDim);

            if ($ext == 'jpg' || $ext == 'jpeg') {
                $exif = exif_read_data($dir_image . $file);

                if (!empty($exif['Orientation'])) {
                    //$imageResource = imagecreatefromjpeg($dir_image . $file);

                    switch ($exif['Orientation']) {
                        case 3:
                        //$img = imagerotate($imageResource, 180, 0);
                        $this->image->rotate(180);
                        break;
                        case 6:
                        //$img = imagerotate($imageResource, -90, 0);
                        $this->image->rotate(270);
                        break;
                        case 8:
                        //$img = imagerotate($imageResource, 90, 0);
                        $this->image->rotate(90);
                        break;
                    }
                }
            }

            $this->image->save($dir_cache . $new_name);
        }

        return base_url('assets/images/cache/' . $new_name);
    }
}
