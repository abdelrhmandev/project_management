<?php

namespace App\Helpers;

final class VirtualCard {

   public function __construct() {}

  static public function _frontCard($teamImg,$observerID,$teamName,$teamNameEn,$projectTitle,$teamTel) :string {
        
$card=<<<EOD
<!DOCTYPE html>
<html dir="rtl" style="direction: rtl" lang="ar-SA"> 
<head>
<title>$teamName</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
</head>

<body style="background-color:#FAFAFA;">
        <div id="kt_app_body_content" style="font-family:'Cairo', sans-serif !important; line-height: 1.5;text-align:center !important; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
                    <div style="background-color:#fff;margin:40px auto;width: 340px;height:500px;box-sizing:border-box;padding:20px 30px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                            <tbody>
                                <tr>
                                    <td align="center" valign="center" colspan="2" style="text-align:right !important; padding-bottom: 10px">
                                        <img alt="al-fares Logo" src="https://al-fares.sa/project/public/assets/media/training/alfars-logo.png" />
                                        <br> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="center" colspan="2" style="text-align:right !important; padding-bottom: 10px">
                                            <div style="text-align:right !important;margin-bottom: 3px;border-bottom:5px solid #003547;padding-bottom:10px;">
                                                    <img alt="al-fares" style="display:block;max-width:94px;height:auto;"
                                                    src='https://al-fares.sa/project/public/storage/$teamImg'/>
                                            </div>
                                       </td>
                                    </tr>

                                    <tr>
                                      <td style="vertical-align:top;!important;">
                                            <div style="font-weight: bold;font-family:'Cairo', sans-serif !important; text-align: right !important;">
                                                <p style="margin:0px 0 4px 0;padding-top:0;color:#003547; font-size:20px;font-family:'Cairo', sans-serif !important;
                                                    text-align: right !important;">
                                                      باحــــــــث ميـداني
                                                </p>
                                                <p style="margin:4px 0 4px 0; color:#003547; font-size:18px;font-family:'Cairo', sans-serif !important;
                                                    text-align: right !important;">
                                                      Field Researcher
                                                </p>
                                                </div>
                                       </td>
                                       <td style="vertical-align:top;!important;">
                                       <div style="background-color:#1BA090;padding:5px;width:100% !important;box-sizing:border-box;min-width:60% !important;">
                                                <p style="color:#003547; font-size: 18px;
                                                    font-weight:600;font-family:'Cairo', sans-serif !important;width:100% !important;box-sizing:border-box;
                                                    text-align: center !important;margin:4px 0 4px 0;min-width:60% !important;">
                                                    $observerID
                                                </p>
                                            </div>
                                          </td>
                                         </tr>
                                         <tr>
                                         <td colspan="2">
                                            <div style="border-right:6px solid #1C9F8C;font-family:'Cairo', sans-serif !important;padding-right:10px;margin-top:25px;text-align: right !important;">
                                                <p style="margin-bottom:2px; color:#003547; font-size: 14px;font-family:'Cairo', sans-serif !important;
                                                    text-align: right !important;">
                                                    $teamName
                                                </p> 
                                                <p style="margin-top:2px;margin-bottom:5px; color:#003547; font-size: 22px;font-family:'Cairo', sans-serif !important;
                                                    text-align: right !important;font-weight:bold;">
                                                    $teamNameEn
                                                </p> 
                                                <p style="margin-bottom:15px;margin-top:5px; color:#003547; font-size:10px;font-family:'Cairo', sans-serif !important;
                                                    text-align: right !important;">
                                                       مشروع  $projectTitle
                                                       <br>
                                                       field research project 
                                                </p> 
                                          </div> 
                                       </td>
                                    </tr>
                                    <tr>
                                         <td colspan="2">
                                         <div style="font-family:'Cairo', sans-serif !important;padding-right:10px;margin-top:25px;">
                                                <p style="margin-bottom:2px; color:#003548;font-weight:600; font-size: 12px;font-family:'Cairo', sans-serif !important;
                                                    text-align: left !important;">
                                                     Tel : $teamTel  &nbsp;&nbsp;|&nbsp;&nbsp;  C.R. 1010116224
                                                </p> 
                                                </div> 
                                         </td>
                                    </tr> 
                            </tbody>
                        </table>
                    </div>
                </div>
</body>
</html>
EOD;
        
$filename = public_path().'/cards/front-'.\Str::random(8).'.html';
     $fp = fopen($filename,'w');
     fwrite($fp,$card);
     fclose($fp);
     
     return $filename;
 }


 static public function _backCard($teamName,$teamTel) :string {
  
$card=<<<EOD
<!DOCTYPE html>
<html dir="rtl" style="direction: rtl" lang="ar-SA"> 
<head>
<title>$teamName</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
<style>
  @media print {    
    div#backCard {
        background-color:#003548 !important;
    }
  }
</style>
</head>

<body style="background-color:#FAFAFA;">
  <div id="kt_app_body_content" style="font-family:'Cairo', sans-serif !important; line-height: 1.5;text-align:center !important; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
  <div id="backCard" style="background-color:#003548; margin:40px auto;width: 340px;height:500px;box-sizing:border-box;">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
      <tbody>
          <tr>
              <td align="center" valign="center" colspan="2" style="text-align:center !important; padding-bottom: 10px">
                  <br> <br><br> <br>
                  <img alt="al-fares Logo" src="https://al-fares.sa/project/public/assets/media/training/Group 1349.png" />
                  <br> <br>
              </td>
          </tr>
          <tr>
              <td align="center" valign="center" colspan="2" style="text-align:center !important; padding-bottom: 10px">
              <br> <br><br> <br> <br> <br>
                  <img alt="al-fares QRCode" src="https://al-fares.sa/project/public/assets/media/training/Group 1370.png" />
                  <br>
              </td>
          </tr>
          <tr>
                   <td>
                   <div style="font-family:'Cairo', sans-serif !important;padding-right:10px;margin-top:8px;">
                          <p style="margin-bottom:2px; color:#1DA090;font-weight:normal; font-size: 10px;font-family:'Cairo', sans-serif !important;
                              text-align: center !important;">
                               Tel : $teamTel  &nbsp;&nbsp;|&nbsp;&nbsp;  C.R. 1010116224
                          </p> 
                          </div> 
                   </td>
              </tr> 
              <tr>
                   <td>
                   <div style="font-family:'Cairo', sans-serif !important;padding-right:10px;margin-top:8px;">
                          <p style="margin-bottom:2px; color:#1DA090;font-weight:normal; font-size: 10px;font-family:'Cairo', sans-serif !important;
                              text-align: center !important;direction:ltr;">
                             <img style="vertical-align:middle;" src="https://al-fares.sa/project/public/assets/media/training/Group 1362.png" />  al-fares.sa
                             <img style="vertical-align:middle;" src="https://al-fares.sa/project/public/assets/media/training/Group 1361.png" />  al-fares.sa
                             <img style="vertical-align:middle;" src="https://al-fares.sa/project/public/assets/media/training/Group 1357.png" />  al-fares.sa
                          </p> 
                          </div> 
                   </td>
              </tr> 
      </tbody>
  </table>
</div>  
  </div>
</body>
</html>
EOD;

$filename = public_path().'/cards/back-'.\Str::random(8).'.html';
     $fp = fopen($filename,'w');
     fwrite($fp,$card);
     fclose($fp);
     
     return $filename;
 
}

static public function _fullCard($teamImg,$observerID,$teamName,$teamNameEn,$projectTitle,$teamTel) :string {

$card=<<<EOD
<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:340.654px;height:510.236px;border-collapse:collapse;">
<tbody>
<tr>
<td align="center" valign="middle" width="30" style="text-align:center !important;width:30px;">&nbsp;</td>
<td align="right" valign="middle" colspan="2" style="text-align:right !important;">
<br><br><br>
<img alt="al-fares Logo" style="width:70px;height:auto;" src="https://al-fares.sa/wp-content/uploads/2022/09/alfars-logo.png" />
<br>
</td>
</tr>
<tr>
<td align="center" valign="middle" width="30" style="text-align:center !important;width:30px;">&nbsp;</td>
<td align="right" valign="middle" colspan="2" width="315" style="text-align:right !important;width:315px;">
<div style="box-sizing:border-box;text-align:right !important;margin-bottom:1px;border-bottom:4px solid #003547;padding-bottom:1px;height:108.748px;">
<img alt="al-fares" style="display:block;width:93.518px;height:108.748px;" src="https://al-fares.sa/project/public/storage/$teamImg">
</div>
</td>
</tr>
<tr>
<td align="center" valign="middle" width="30" style="text-align:center !important;width:30px;">&nbsp;</td>
<td valign="top" width="170" style="width:170px;">
<div style="text-align: right !important;color:#003547;">
<span>بــــــــــاحـــــــــث مــــــــيـــــــدانـــــــي</span>
<span style="line-height:1.5;"> Field Researcher </span>
</div>
</td>
<td valign="middle" width="145" style="width:145px;">
<div style="background-color:#1BA090;text-align:center !important;color:#003547;font-size:34px;"><b>$observerID</b>
</div>
</td>
</tr>
<tr>
<td align="center" valign="middle" width="30" style="text-align:center !important;width:30px;">&nbsp;</td>
<td colspan="2" valign="top">
<br><br>
<div style="border-right:8px solid #1C9F8C;text-align:right !important;color:#003547;text-indent:7px;"> 
<span>
$teamName
<br>
$teamNameEn
</span>
<br>
<span>
<small>مشروع  $projectTitle <br></small>
<small>Field Research Project </small>
</span>
</div> 
</td>
</tr>
<tr>
<td align="center" valign="middle" width="30" style="text-align:center !important;width:30px;">&nbsp;</td>
<td colspan="2">
<br><br>
<div style="text-align:left;color:#003547;">
<small>Tel : $teamTel  &nbsp;&nbsp;|&nbsp;&nbsp;  C.R. 1010116224</small>
</div> 
<br><br>
</td>
</tr> 
</tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" style="width:371.654px;height:600.236px;background-color:#003548;border-collapse:collapse;">
<tbody>
<tr>
<td align="center" valign="center" style="text-align:center !important;" colspan="3">
 <br> <br> <br><br> <br><br><br>
<img alt="al-fares Logo" style="width:110px;height:auto;" src="https://al-fares.sa/wp-content/uploads/2022/09/Group-1349-2x.png" />
<br> <br> <br> <br><br>
</td>
</tr>
<tr>
<td align="center" valign="center" style="text-align:center !important;" colspan="3">
<br> <br> <br>
<img alt="al-fares QRCode" style="width:63px;height:auto;" src="https://al-fares.sa/project/public/assets/media/training/Group-1370.png" />
<br> <br><br>
</td>
</tr>
<tr>
<td align="center" valign="center" colspan="3">
<div style="color:#1DA090;font-weight:normal; font-size: 10px;text-align: center !important;">
Tel : $teamTel  &nbsp;&nbsp;|&nbsp;&nbsp;  C.R. 1010116224
</div> 
<br>
</td>
</tr> 
<tr>
<td align="center" valign="center">
<img src="https://al-fares.sa/project/public/assets/media/training/f.png" style="width:18px;height:auto;" />
<br>
</td>
<td align="center" valign="center">
<img src="https://al-fares.sa/project/public/assets/media/training/g.png" style="width:19px;height:auto;" />
<br>
</td>
<td align="center" valign="center">
<img src="https://al-fares.sa/project/public/assets/media/training/in.png" style="width:18px;height:auto;" /> 
<br>
</td>
</tr> 
</tbody>
</table>                 
EOD;

\PDF::SetCreator('Al-Fares Co.');
\PDF::SetAuthor('Al-Fares');
\PDF::SetTitle('Virtual Card');
\PDF::SetSubject('Card For Researcher');
\PDF::SetKeywords('card,researcher,al-fares');

\PDF::SetPrintHeader(false);
\PDF::SetPrintFooter(false);
\PDF::SetMargins(0,0,0);
\PDF::SetAutoPageBreak(TRUE,0);

\PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);

$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'fa';
$lg['w_page'] = 'page';
\PDF::setLanguageArray($lg);

\PDF::AddPage('P','A6');
\PDF::setRTL(true);
\PDF::SetFont('aealarabiya', '');
\PDF::writeHTML($card,false,false,false,false,'');

$filename = public_path().'/cards/vcard-'.\Str::random(8).'.pdf';
\PDF::Output($filename, 'F');
\PDF::reset();
     
return $filename;
 

}

}