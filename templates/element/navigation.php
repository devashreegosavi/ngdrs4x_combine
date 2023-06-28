<?php
$c_name = $this->request->getParam('controller');
$a_name = $this->request->getParam('action');

?>

<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <?php foreach ($menus as $key => $menu) : ?>
      <?php if (empty($menu->submenus)) : ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= $this->Url->build(['controller' => $menu->controller, 'action' => $menu->action]); ?>">
            <i class="fa fa-th-large text-aqua"></i>&nbsp;&nbsp;<?= $menu->name_en; ?></a>
        </li>
      <?php else : ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= $this->Url->build(['controller' => $menu->controller, 'action' => $menu->action]); ?>" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-th-large text-aqua"></i>&nbsp;&nbsp;<?= $menu->name_en; ?>
          </a>
          <ul class="nav nav-treeview">
            <?php foreach ($menu->submenus as $key => $submenu) : ?>
              <li class="nav-item">
                <a class="nav-link" href="<?= $this->Url->build(['controller' => $submenu->controller, 'action' => $submenu->action]); ?>">
                  <i class="fa fa-link text-red"></i>&nbsp;&nbsp;<?= $submenu->name_en ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</nav>