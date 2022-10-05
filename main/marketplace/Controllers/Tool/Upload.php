<?php

namespace Main\Marketplace\Controllers\Tool;

class Upload extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    public function index()
    {
        $json = [];

        $validationRule = [
            'file' => [
                'label' => 'Image File',
                'rules' => 'uploaded[file]'
                    . '|is_image[file]'
                    . '|mime_in[file,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[file,100000]'
                    . '|max_dims[file,30000,30000]',
            ],
        ];

        if (! $this->validate($validationRule)) {
            $error = ['errors' => $this->validator->getErrors()];
        }

        $img = $this->request->getFile('file');

        if (empty($error) && !$img->hasMoved()) {
            $dir_image = ROOTPATH . 'public/assets/images/';
            $dir_cache = ROOTPATH . 'public/assets/images/cache/';

            $dir_customer = 'marketplace/customers/' . $this->customer->getId();

            if (!is_dir($dir_image . $dir_customer)) {
                mkdir($dir_image . $dir_customer, 0755, true);
                file_put_contents($dir_image . $dir_customer . '/' . 'index.html', '');
            }

            if (!is_dir($dir_cache . $dir_customer)) {
                mkdir($dir_cache . $dir_customer, 0755, true);
                file_put_contents($dir_cache . $dir_customer . '/' . 'index.html', '');
            }

            $newName = $img->getRandomName();

            $filepath = $img->move($dir_image . $dir_customer, $newName);

            $image_cache = $this->image->resize($dir_customer . '/' . $newName, 100, 100, true);

            $json['image'] = [
                'src' => $image_cache,
                'path' => $dir_customer . '/' . $newName,
            ];

            $json['success'] = $image_cache;
        } else {
            $json['error'] = $error['errors']['file'];
        }

        return $this->response->setJSON($json);
    }
}