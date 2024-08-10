<?php

$title = config('table.title');
$location = config('table.location');
$desc = config('table.description');
$size = config('table.size');

return [
    'land_create_body' => "Thank you for registering land with us. We will review the
                            details and will come back to you ASAP!. The provided details are as follow
                            Land Title :{$title}\n
                            Land Description :{$desc}\n
                            Land size :{$size}\n
                            Land description :{$location}\n
                            ",
];
