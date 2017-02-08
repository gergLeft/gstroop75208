<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <?php if (function_exists('isLocalEnvironment') && isDevEnvironment(true)) : ?>
  <meta name='robots' content='Noindex, nofollow' />
  <?php endif; ?>
  <link href="//db.onlinewebfonts.com/c/07dc45de3c2d37fcd503045055b2253b?family=Omnes" rel="stylesheet" type="text/css"/>
</head>