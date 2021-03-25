<?php

namespace App\Libraries;

class Image
{
  public function resize($filename, $width, $height, $maintain_ratio, $master_dim)
  {
		if (!is_file(ROOTPATH . 'public/assets/files/' . $filename)) {
			return ;
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$image_old = $filename;
		$image_new = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!is_file(ROOTPATH . 'public/assets/' . $image_new) || (filectime(ROOTPATH . 'public/assets/files/' . $image_old) > filectime(ROOTPATH . 'public/assets/' . $image_new))) {
			list($width_orig, $height_orig, $image_type) = getimagesize(ROOTPATH . 'public/assets/files/' . $image_old);
				 
			if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF))) { 
				return ROOTPATH . 'public/assets/files/' . $image_old;
			}
 
			$path = '';

			$directories = explode('/', dirname($image_new));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(ROOTPATH . 'public/assets/' . $path)) {
					mkdir(ROOTPATH . 'public/assets/' . $path, 0777);
				}
			}

			if ($width_orig != $width || $height_orig != $height) {
				$image = \Config\Services::image()
				        ->withFile(ROOTPATH . 'public/assets/files/' . $image_old)
				        ->resize($width, $height, $maintain_ratio, $master_dim)
				        ->save(ROOTPATH . 'public/assets/' . $image_new);

			} else {
				copy(ROOTPATH . 'public/assets/files/' . $image_old, ROOTPATH . 'public/assets/' . $image_new);
			}
		}

		return base_url('assets/' . $image_new);
  }

  public function render($filename)
  {
		return base_url('assets/files/' . $filename);
  }
}