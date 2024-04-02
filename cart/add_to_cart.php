<?php

$itemHtml = '<div class="input-group justify-content-around cart-item mb-3 w-100">';
$itemHtml .= '<p class="ml-1">' . $_POST['name'] . '</p> 
              <div class="input-group-append">
                <input type="number" class="form-control px-1 ml-1 quantity" name="products[' . $_POST["id"] . '][quantity]" value="1" min="1" max="' . $_POST["quantity"] . '">
              </div> 
              <p class="ml-1 price"><small>EGP </small>' . $_POST["price"] . '</p>
              
              <div class="input-group-append">
                <button class="btn btn-outline-danger remove-item" type="button">
                  <i class="fa-solid fa-xmark"></i>
                </button>
              </div>';
$itemHtml .= '<input type="hidden" name="products[' . $_POST["id"] . '][id]" value="' . $_POST["id"] . '">
              <input type="hidden" name="products[' . $_POST["id"] . '][name]" value="' . $_POST["name"] . '">
              <input type="hidden" name="products[' . $_POST["id"] . '][price]" value="' . $_POST["price"] . '">';
$itemHtml .= '</div>';

echo $itemHtml;
