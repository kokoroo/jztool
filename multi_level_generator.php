<?php

include_once('common.php');


error_reporting(E_ERROR);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" src="script.js" type="text/javascript"></script>
<title>Multi Level Generator</title>
<link href="images/css.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Multi Level Generator</h1>
<div id="form_warp">
  <form method="post" action="">
    <div class="tab">
      <ul>
        <li><a href="#">Level 1</a></li>
        <li><a href="#">Level 2</a></li>
        <li><a href="#">Level 3</a></li>
        <li><a href="#">Level 4</a></li>
        <li><a href="#">Level 5</a></li>
        <li><a href="#">Level 6</a></li>
      </ul>
    </div>
    <div class="tab_contents">
      <ul>
        <li>
          <div class="tab_content_wrap">
            <div class="list_tag_wrap tbd_form_wrap">
              <label class="tbd_form_label" for="list_tag">List Tag :</label>
              <input id="list_tag" name="list_tag" class="tbd_form_input" type="text" />
            </div>
            <div class="list_item_tag_wrap tbd_form_wrap">
              <label class="tbd_form_label" for="list_item_tag">List Item Tag :</label>
              <input id="list_item_tag" name="list_item_tag" class="tbd_form_input" type="text" />
            </div>
            <div class="list_item_template_wrap tbd_form_wrap">
              <label class="tbd_form_label" for="list_item_template">List Item Template :</label>
              <input />
              <textarea id="list_item_template" name="list_item_template" class="tbd_form_input" cols="100" rows="10"></textarea>
            </div>
            <div class="clf"></div>
          </div>
        </li>
      </ul>
    </div>
  </form>
</div>
</body>
</html>