<?php
if ($authUser['username'] == $username) {
    $removeButton = '<i class="fa fa-trash-o"></i>';
} else {
    $removeButton = '';
}

echo $removeButton;

