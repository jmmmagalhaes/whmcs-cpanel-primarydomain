<?php

use WHMCS\View\Menu\Item as MenuItem;


add_hook('ClientAreaPrimarySidebar', 1, function (MenuItem $primarySidebar)

{


$id = $_GET['id'];
$id = preg_replace('/[^0-9]/', '', $id);
$id = strip_tags(htmlspecialchars($id));

    if (!is_null($primarySidebar->getChild('Service Details Actions'))) {
        $primarySidebar->getChild('Service Details Actions')
            ->addChild('Change Primary Domain')
                ->setLabel('Change Primary Domain')
                ->setUri('update-domain?id=' . $id)
                ->setOrder(100);
    }
});