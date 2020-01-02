<?php

namespace App\EventListener;

use App\Entity\User;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Vich\UploaderBundle\Event\Event;
use Vich\UploaderBundle\Storage\StorageInterface;

class UploadListener
{
    private $storage;
    private $requestStack;

    public function __construct(StorageInterface $storage, RequestStack $requestStack)
    {
        $this->storage      = $storage;
        $this->requestStack = $requestStack;
    }

    public function onVichUploaderPostUpload(Event $event)
    {
        $object = $event->getObject();

        if ($object instanceof User) {

            $params = $this->getRequest()->get('user')['crop'];

            if (!$params || !$this->getRequest()->files->count())
                return;
            $path         = $this->storage->resolvePath($object, 'avatarFile');
            $params       = json_decode($params, true);
            $imageManager = new ImageManager();
            $image        = $imageManager->make($path);

             if ($params['x'] && $params['y'] && $params['width'] && $params['height'])
                 $image->crop((int)$params['width'], (int)$params['height'], (int)$params['x'], (int)$params['y']);
            if ($params['rotate'])
                $image->rotate($params['rotate']);

            $image->save($path)->destroy();
        }
    }

    private function getRequest()
    {
        return $this->requestStack->getMasterRequest();
    }
}