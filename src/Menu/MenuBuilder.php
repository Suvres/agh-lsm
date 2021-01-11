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

        if ($this->security->getUser()) {
            $this->makeChild($menu);
        }

        return $menu;
    }

    private function makeChild(ItemInterface $menu): void
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $menu->addChild('Panel', [
                'route' => 'admin_panel',
                'attributes' => [
                    'icon' => 'fa fa-columns',
                ],
            ]);
            $menu->addChild('Książki', [
                'route' => 'admin_book_panel',
                'attributes' => [
                    'icon' => 'fa fa-book',
                ],
            ]);
            $menu->addChild('Zarządzaj', [
                'route' => 'admin_loan',
                'attributes' => [
                    'icon' => 'fa fa-save',
                ],
            ]);
            $menu->addChild('Użytkownicy', [
                'route' => 'admin_user_panel',
                'attributes' => [
                    'icon' => 'fa fa-user',
                ],
            ]);
        } else {
            $menu->addChild('Książki', [
                'route' => 'book_search',
                'attributes' => [
                    'icon' => 'fa fa-book',
                ],
            ]);
        }

        $menu->addChild('Ja', [
            'route' => 'account',
            'attributes' => [
                'icon' => 'fa fa-user',
            ],
        ])
        ->setAttribute('class', 'ml-lg-auto');


        $menu->addChild('Wyloguj się', [
            'route' => 'app_logout',
            'attributes' => [
                'icon' => 'fa fa-sign-out',
            ],
        ]);

        foreach ($menu->getChildren() as $child) {
            $c = $child->getAttribute('class');
            $linkC = $child->getLinkAttribute('class');

            $child->setLinkAttribute('class', $linkC.' nav-link');
            $child->setAttribute('class', $c.' nav-item');
        }
    }
}
