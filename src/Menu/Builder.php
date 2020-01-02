<?php

namespace App\Menu;

use App\Entity\MenuItem;
use App\Repository\MenuItemRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    private $factory;
    private $itemRepository;

    public function __construct(FactoryInterface $factory, MenuItemRepository $itemRepository)
    {
        $this->factory        = $factory;
        $this->itemRepository = $itemRepository;
    }

    public function managerMainMenu(array $options = [])
    {
        $menu = $this->factory->createItem('root')
            ->setChildrenAttribute('class', 'nav metismenu')
            ->setChildrenAttribute('id', 'side-menu')
        ;

        $this->addManagerChildren($menu, $this->itemRepository->findBy(['parent' => null]));

        return $menu;
    }

    private function addManagerChildren(ItemInterface $menu, $items)
    {
        foreach ($items as $item) {
            $menu->addChild($item->getId(), [
                'label' => $item->getLabel(), 'route' => $item->getRoute()]);

            if ($item->getIcon())
                $menu[$item->getId()]->setExtra('icon', $item->getIcon());
            if ($children = $item->getChildren())
                $this->addManagerChildren($menu[$item->getId()], $children);
        }

        return $menu;
    }
}