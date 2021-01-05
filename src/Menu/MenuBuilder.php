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
        $menu->setChildrenAttribute('class', 'navbar-nav w-100');

        if($this->security->getUser()) {
            $this->makeChild($menu);
        }

        return $menu;
    }

    private function makeChild(ItemInterface $menu): void
    {
        if($this->security->isGranted("ROLE_ADMIN")) {
            $dropdown = $menu->addChild(
                'Admin', ['attributes' => ['dropdown' => true]]
            );

            $dropdown->addChild(
                'Panel', ['route' => 'admin_panel', 'attributes' => ['icon' => 'fa fa-columns']]
            );
            $dropdown->addChild(
                'Książki', ['route' => 'admin_book_panel', 'attributes' => ['icon' => 'fa fa-book']]
            );

            $menu->addChild("Wypożycz", ['route' => 'admin_loan_new', 'attributes' => ['icon' => 'fa fa-save']]);
        }
        $menu->addChild('Menu 1', ['route' => 'home']);
        $menu->addChild('Menu 2', ['route' => 'home']);
        $menu->addChild('Menu 3', ['route' => 'home']);


        $menu->addChild('Wyloguj się', ['route' => 'app_logout', 'attributes' => ['icon' => 'fa fa-sign-out']])
        ->setAttribute('class', 'ml-lg-auto');

        foreach ($menu->getChildren() as $child) {
            $c = $child->getAttribute('class');
            $linkC = $child->getLinkAttribute('class');

            $child->setLinkAttribute('class', $linkC. ' nav-link');
            $child->setAttribute('class', $c. ' nav-item');
        }
    }
}