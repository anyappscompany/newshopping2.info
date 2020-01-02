<?php
$content = "";

$content = <<<EOD
<div class="row">
                <div class="col-12">
                  <form class="form-horizontal" onsubmit="addmessage();return false;">
                    <div class="form-group">
                      <label for="username-lab">Name</label>
                      <input maxlength="100" type="text" class="form-control" id="username" placeholder="Jane Doe" required>
                    </div>
                    <div class="form-group">
                      <label for="useremail-lab">Email</label>
                      <input maxlength="100" type="email" class="form-control" id="useremail" placeholder="jane.doe@example.com" data-error="Bruh, that email address is invalid" required>
                    </div>
                    <div class="form-group ">
                      <label for="usermessage-text">Your Message</label>
                     <textarea id="usermessage"  class="form-control" placeholder="Description" required maxlength="1000"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default">Send Message</button>
                    <button type="reset" class="btn btn-default">Clear</button>
                  </form>
                </div>
              </div>
EOD;

$page_template = str_replace("[META]", '<meta name="robots" content="noindex,nofollow" />', $page_template);
$page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);
$page_template = str_replace("[PAGINATION]", "", $page_template);
$page_template = str_replace("[BOTTOM-ROW]", "", $page_template);



$page_template = str_replace("[CONTENT]", $content, $page_template);
$page_template = str_replace("[H-TITLE]", "<h4>Contact Us</h4>", $page_template);
$page_template = str_replace("[TITLE]", "Contacts - ".$_SERVER['SERVER_NAME'], $page_template);
?>