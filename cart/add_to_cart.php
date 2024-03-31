<?php

$itemHtml = '<div class="cart-item">';
$itemHtml .= '<span> ' . $_POST['name'] . '</span>';
$itemHtml .= '<span> $' . $_POST['price'] . '</span>';

$itemHtml .= '</div>';
echo $itemHtml;
