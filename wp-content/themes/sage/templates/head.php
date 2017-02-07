<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <?php if (function_exists('isLocalEnvironment') && isDevEnvironment(true)) : ?>
  <meta name='robots' content='Noindex, nofollow' />
  <?php endif; ?>
</head>