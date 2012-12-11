<?php

namespace view\pages;

define ("PRIME_TEMPLATE", ROOT_PATH."view/pages/main.tmpl.php");

define ("DOCUMENT_TYPE","HTML 5");

define ("METADATA", "
<meta charset='utf-8'>
<meta name='keywords' content='{META-KEYWORDS}'>
<meta name='description' content='{META-DESCRIPTION}'>
<meta name='author' content='{META-AUTHOR}'>
<meta name='viewport' content='width=device-width'>");

define ("GLOBAL_LINK","
<link rel='shortcut icon' href='library/images/rel/logo.favicon.ico'>
<link rel='apple-touch-icon' href='library/images/rel/apple-touch-icon.png'>
<link rel='apple-touch-icon' sizes='72x72' href='library/images/rel/apple-touch-icon-72x72.png'>
<link rel='apple-touch-icon' sizes='114x114' href='library/images/rel/apple-touch-icon-114x114.png'>
<link rel='stylesheet' href='".APP."view/pages/main.css.php' type='text/css' />");

define ("GLOBAL_SCRIPT","<script src='".APP."view/pages/main.js.php' type='text/javascript'></script>");


?>