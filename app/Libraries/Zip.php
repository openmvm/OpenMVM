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

class Zip {
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->zip_archive = new \ZipArchive;
    }

    /**
     * Extract to.
     *
     */
    public function extractTo($file, $destination, $delete = false)
    {
        if ($this->zip_archive->open($file) === TRUE) {
            $this->zip_archive->extractTo($destination);
            $this->zip_archive->close();

            if ($delete) {
                unlink($file);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Zip it.
     *
     */
    public function zipIt($zip_name, $files = [])
    {
        $this->zip_archive->open($zip_name, \ZipArchive::CREATE);

        foreach ($files as $file) {
            $zip_filename = str_replace(ROOTPATH . 'public/assets/images/marketplace/', '', $file);

            if (is_file($file)) {
                $this->zip_archive->addFile($file, $zip_filename);
            } elseif (is_dir($file)) {
                // if we find a folder, create a folder in the zip
                $this->zip_archive->addEmptyDir($zip_filename);

                $this->zipDir($file, $zip_name);
            }
        }

        $this->zip_archive->close();
    }

    /**
     * Zip dir.
     *
     */
    private function zipDir($file, $zip_name)
    {
        $this->zip_archive->open($zip_name, \ZipArchive::CREATE);

        // Store the path into the variable
        $dir = opendir($file);
           
        while($dir_file = readdir($dir)) {
            if ($dir_file != "." && $dir_file != ".." && $dir_file != "index.html") {
                $zip_filename = str_replace(ROOTPATH . 'public/assets/images/marketplace/', '', $file . '/' . $dir_file);

                if(is_file($file . '/' . $dir_file)) {
                    $this->zip_archive->addFile($file . '/' . $dir_file, $zip_filename);
                } elseif (is_dir($file . '/' . $dir_file)) {
                    // if we find a folder, create a folder in the zip
                    $this->zip_archive->addEmptyDir($zip_filename);

                    $this->zipDir($file . '/' . $dir_file, $zip_name);
                }
            }
        }
    }
}