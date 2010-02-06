<?php
/**
 * Main template.
 *
 * Variables in this template:
 * - $head_title: The page title
 * - $metadata: Any meta tags or other (well-formed) XHTML that goes in the header.
 * - $head_links: <link> tags for the header, excluding style sheets. (Example: Atom feed).
 * - $styles: Well-formed style <link> or <style> tags. Order will determine the cascade.
 * - $scripts: Well-formed <script> sections.
 * - $bodyclasses: Body classes, separated by spaces.
 * - $body: The body (whatever goes inside of <body>), as well-formed XHTML.
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <?php print $metadata; ?>
	<title><?php print $head_title; ?></title>
	<?php print $head_links; ?>
	<?php print $styles; ?>
	<?php print $inline_styles; ?>
	<?php print $scripts; ?>
	<?php print $inline_scripts; ?>
</head>
<body class="<?php print $bodyclasses; ?>">
  <div class="main-div">
    <div class="main-logo"></div>
    <div class="main-nav">
      <a href="<?php print Util::url('default'); ?>">Home</a>
      <a href="<?php print Util::url('notes'); ?>">Notes</a>
      <a href="<?php print Util::url('sources'); ?>">Sources</a>
      <a href="<?php print Util::url('journals'); ?>">Journal</a>
    </div>
    <h1 class="page-title"><?php print isset($title) ? $title : $head_title; ?></h1>
    <div class="body-div">
    <?php print $body; ?>
    </div>
  </div>
</body>
</html>