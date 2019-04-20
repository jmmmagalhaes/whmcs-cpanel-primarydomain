Tool to allow WHMCS clients to manually change their primary domain on cPanel via xmlapi

1) Move template/updatedomain.tpl to your WHMCS /templates/theme folder
2) Modify email on line 21 of update-domain.php
3) Modify lines 56-66 of update-domain.php to match cPanel server's IDs
4) Modify custom/cpanel.php to reflect the same variable names as inputted in step #3, and add cPanel IP + Domain
