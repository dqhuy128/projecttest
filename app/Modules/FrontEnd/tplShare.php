<?php


\View::share('def', \Lib::tplShareGlobal());
\View::share('isHome', false);
\View::share('menu', \Menu::getMenuWithFilter(3));
\View::share('menu_footer', \Menu::getMenu(4));