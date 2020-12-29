<?php


namespace App\Menu;


use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav');
        $menu->addChild('Menu 1', ['route' => 'home']);
        $menu->addChild('Menu 2', ['route' => 'home']);
        $menu->addChild('Menu 3', ['route' => 'home']);

        foreach ($menu->getChildren() as $child) {
            $child->setAttributes([
                'class' => 'nav-item'
            ]);

            $child->setLinkAttributes([
               'class' => 'nav-link'
            ]);
        }
        return $menu;
    }
}