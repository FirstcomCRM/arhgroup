<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title></title>
      
      <style type="text/css">
         /* Client-specific Styles */
         div, p, a, li, td { -webkit-text-size-adjust:none; }
         #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
         html{width: 100%; }
         body{font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #282828; width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
         /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
         .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
         .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing. */
         #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
         img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
         a img {border:none;}
         .image_fix {display:block;}
         p {margin: 0px 0px !important;}
         table td {border-collapse: collapse;}
         table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
         a {color: #33b9ff;text-decoration: none;text-decoration:none!important;}
         /*STYLES*/
         table[class=full] { width: 100%; clear: both; }
         /*IPAD STYLES*/
         @media only screen and (max-width: 640px) {
         a[href^="tel"], a[href^="sms"] {
         text-decoration: none;
         color: #33b9ff; /* or whatever your want */
         pointer-events: none;
         cursor: default;
         }
         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
         text-decoration: default;
         color: #33b9ff !important;
         pointer-events: auto;
         cursor: default;
         }
         table[class=devicewidth] {width: 440px!important;text-align:center!important;}
         table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}
         img[class=banner] {width: 440px!important;height:220px!important;}
         img[class=col2img] {width: 440px!important;height:220px!important;}
         
         
         }
         /*IPHONE STYLES*/
         @media only screen and (max-width: 480px) {
         a[href^="tel"], a[href^="sms"] {
         text-decoration: none;
         color: #33b9ff; /* or whatever your want */
         pointer-events: none;
         cursor: default;
         }
         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
         text-decoration: default;
         color: #33b9ff !important; 
         pointer-events: auto;
         cursor: default;
         }
         table[class=devicewidth] {width: 280px!important;text-align:center!important;}
         table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}
         img[class=banner] {width: 280px!important;height:140px!important;}
         img[class=col2img] {width: 280px!important;height:140px!important;}
         
        
         }
      </style>
      <?php $this->head() ?>
   </head>
   <body>
       <?php $this->beginBody() ?>

<br><br>
    <table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
        <tbody>
            <tr>
                <td>
                    <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                        <tbody>
                            <tr>
                                <td>
                                    <img src="images/logo.jpg" width="24%">      
                                </td>
                            </tr>
                            <tr>
                                <td width="100%" height="40"></td>
                            </tr>
                            <tr>
                                <td width="100%" align="left" valign="middle" style="font-size: 27px; font-weight: bold; color: #19417f; line-height: 30px;">
                                Thank you for choosing our services 
                                </td>
                            </tr>
                            <tr>
                                <td width="100%" height="40"></td>
                            </tr>
                            <tr>
                                <td width="100%" align="left" valign="middle" style="font-size: 18px; color: #19417f">
                                Dear, Sample</td>
                            </tr>
                            <tr>
                                <td width="100%" height="10"></td>
                            </tr>
                            <tr>
                                <td width="100%" align="left" valign="middle" style="line-height: 24px">We would like to thank you for choosing our services. Attached is the signed contract service report.</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" height="20"></td>
            </tr>
        </tbody>
    </table>
       
    
    
    <table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
        <tbody>
            <tr>
                <td height="20"></td>
            </tr>
            <tr>
                <td>
                    <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                        <tbody>
                            <tr>
                                <td>
                                    <table width="280" align="left" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                                        <tbody>
                                            <tr>
                                                <td colspan="2" align="left" style="font-size: 15px"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <table width="300" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                                        <tbody>
                                            <tr>
                                                <td colspan="2" align="left" style="font-size: 15px; line-height: 30px"><strong>Woo Aircon Solution</strong></td>
                                            </tr>
                                            <tr>
                                                <td width="100%" height="5"></td>
                                            </tr>
                                            <tr>
                                                <th valign="top" align="left" style="width: 100px; padding-bottom: 5px">Co reg no. :</th>
                                                <td align="left" style="line-height: 20px; padding-bottom: 5px">53147361M</td>
                                            </tr>
                                            <tr>
                                                <th valign="top" align="left" style="width: 100px; padding-bottom: 5px">Address :</th>
                                                <td align="left" style="line-height: 20px; padding-bottom: 5px">BLK 801 French Road #02-41 Singapore 200801 </td>
                                            </tr>
                                            <tr>
                                                <th align="left" style="padding-bottom: 5px">Phone :</th>
                                                <td align="left" style="padding-bottom: 5px">9100 8901</td>
                                            </tr>
                                            <tr>
                                                <th align="left" style="padding-bottom: 5px"></th>
                                                <td align="left" style="padding-bottom: 5px">9196 2878</td>
                                            </tr>
                                            <tr>
                                                <th align="left" style="padding-bottom: 5px">Email :</th>
                                                <td align="left" style="padding-bottom: 5px">
                                                    <a href="mailto:wooairconsolution@gmail.com">wooairconsolution@gmail.com</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th align="left" style="padding-bottom: 5px">Website :</th>
                                                <td align="left" style="padding-bottom: 5px">
                                                    www.wooairconsolution.com
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="280" align="left" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                        <tbody>
                            <tr>
                                <td colspan="2" align="left" style="font-size: 15px"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                        <tbody>
                            <tr>
                                <td style="font-size: 18px; font-style: italic"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td height="40"></td>
            </tr>
        </tbody>
    </table>
       
    <?php $this->endBody() ?>      
   </body>
   </html>

<?php $this->endPage() ?>