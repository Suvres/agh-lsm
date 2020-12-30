<?php


namespace App\Menu;


use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Security;

class MenuBuilder
{
    private FactoryInterface $factory;

    private Security $security;

    public function __construct(FactoryInterface $factory, Security $security)
    {
        $this->security = $security;
        $this->factory = $factory;
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav');

        if($this->security->getUser()) {
            $this->makeChild($menu);
        }

        return $menu;
    }

    private function makeChild(ItemInterface $menu): void
    {
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
    }
}