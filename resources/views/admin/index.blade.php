<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="<%= BASE_URL %>favicon.ico">
    <title></title>
</head>

<!-- BODY options, add following classes to body to change options

  // Header options
  1. '.header-fixed'					- Fixed Header

  // Brand options
  1. '.brand-minimized'       - Minimized brand (Only symbol)

  // Sidebar options
  1. '.sidebar-fixed'					- Fixed Sidebar
  2. '.sidebar-hidden'				- Hidden Sidebar
  3. '.sidebar-off-canvas'		- Off Canvas Sidebar
  4. '.sidebar-minimized'			- Minimized Sidebar (Only icons)
  5. '.sidebar-compact'			  - Compact Sidebar

  // Aside options
  1. '.aside-menu-fixed'			- Fixed Aside Menu
  2. '.aside-menu-hidden'			- Hidden Aside Menu
  3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu

  // Breadcrumb options
  1. '.breadcrumb-fixed'			- Fixed Breadcrumb

  // Footer options
  1. '.footer-fixed'					- Fixed footer

  -->

<body>
    <noscript>
        <strong></strong>
    </noscript>
    <div id="app"></div>
    <!-- built files will be auto injected -->
</body>

</html>
<script src="{{ mix('js/app.js') }}"></script>