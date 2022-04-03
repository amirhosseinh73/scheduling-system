<?php

defined( "QUERY_LIMIT" ) || define( "QUERY_LIMIT", 5 );
defined( "QUERY_OFFSET" ) || define( "QUERY_OFFSET", 0 );

function render_page_admin(string $page, array $data, string $header = "header", string $footer = "footer") {
    $header = view("Admin/{$header}", $data);

    $footer = view("Admin/{$footer}", $data);

    $content = view("Admin/{$page}", $data);

    return $header . $content . $footer;
}