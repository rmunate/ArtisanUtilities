<?php

namespace Rmunate\ArtisanUtilities;

use PHPMailer\PHPMailer\SMTP;
use Rmunate\ArtisanUtilities\Git;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Application;

class Notification
{

    /* Rama de Cambios */
    private $branch = null;

    /* Cambios Commit */
    private $changes = [];

    public function setbranch(string $branch){
        $this->branch = $branch;
    }

    public function setChanges($changes){
        $this->changes = $changes;
    }

    public function getChanges(){
      $html = '<hr>';
      foreach ($this->changes as $key => $value) {
        $html .= $value . '<br>';
      }
      return $html;
    }

    public function getNameProject(){
        return env('APP_NAME','Laravel (Actualizar Nombre en el ENV)');
    }

    public function serverName(){
      return env('APP_URL', 'LocalHost (APP_URL)');
    }

    public function serverAdress(){
      $sa = getHostByName(getHostName());
      if (str_contains($sa, 'localhost') || str_contains($sa, '127.')) {
        return 'Local Host (127.0.0.1)';
      }
      return $sa;
    }

    public function urlGit(){
      return Git::remoteURL();
    }

    public function getDataNotification(){
        return (object) [
            'fecha'     => date('Y-m-d H:i:s'),
            'branch'    => $this->branch,
            'IP'        => $this->serverAdress(),
            'SO'        => php_uname(),
            'PHP'       => PHP_VERSION,
            'laravel'   => Application::VERSION,
            'url'       => $this->serverName(),
            'git'       => $this->urlGit()
        ];
    }

    public function getImageHeader(){
      return env(
        'ARTISAN_UTILITIES_NOTIFICATION_HEADER_IMG',
        'https://storage.googleapis.com/lola-web/storage_apls/RecursosCompartidos/au_h.png'
      );
    }

    public function getImageFooter(){
      return env(
        'ARTISAN_UTILITIES_NOTIFICATION_FOOTER_IMG',
        'https://storage.googleapis.com/lola-web/storage_apls/RecursosCompartidos/au_f.png'
      );
    }

    public function getImageSing(){
      return env(
        'ARTISAN_UTILITIES_NOTIFICATION_SING_IMG',
        'https://storage.googleapis.com/lola-web/storage_apls/RecursosCompartidos/au_s.png'
      );
    }

    public function getImageSingLink(){
      return env(
        'ARTISAN_UTILITIES_NOTIFICATION_SING_LINK',
        'https://github.com/rmunate/'
      );
    }

    public function getHiddenLinks(){
      if(!env('ARTISAN_UTILITIES_NOTIFICATION_HIDDEN_LINKS',false)){
        return '<tr>
        <td align="left" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, helvetica neue, arial, verdana, sans-serif;line-height:21px;color:#2D3142;font-size:14px">Gracias por utilizar Artisan Utilities,<br>Mas librerias en&nbsp;https://github.com/rmunate/</p></td>
       </tr>';
      }
    }

    public function getCopyright(){
      return env(
        'ARTISAN_UTILITIES_NOTIFICATION_COPYRIGHT',
        'Altum Digital Developers'
      );
    }

    public function getCopyrightYear(){
      return env(
        'ARTISAN_UTILITIES_NOTIFICATION_COPYRIGHT_YEAR',
        date('Y')
      );
    }

    public function head(){
      return '<head>
      <meta charset="UTF-8">
      <meta content="width=device-width, initial-scale=1" name="viewport">
      <meta name="x-apple-disable-message-reformatting">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta content="telephone=no" name="format-detection">
      <title>Artisan Utilities</title><!--[if (mso 16)]>
      <style type="text/css">
      a {text-decoration: none;}
      </style>
      <![endif]--><!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--><!--[if gte mso 9]>
      <xml>
          <o:OfficeDocumentSettings>
          <o:AllowPNG></o:AllowPNG>
          <o:PixelsPerInch>96</o:PixelsPerInch>
          </o:OfficeDocumentSettings>
      </xml>
      <![endif]--><!--[if !mso]><!-- -->
        <link href="https://fonts.googleapis.com/css2?family=Imprima&display=swap" rel="stylesheet"><!--<![endif]-->
        ' . $this->styles() . '
      </head>';
    }

    public function styles(){
      return '<style type="text/css">

      #outlook a {
          padding:0;
      }

      .es-button {
          mso-style-priority:100!important;
          text-decoration:none!important;
      }

      a[x-apple-data-detectors] {
          color:inherit!important;
          text-decoration:none!important;
          font-size:inherit!important;
          font-family:inherit!important;
          font-weight:inherit!important;
          line-height:inherit!important;
      }

      .es-desk-hidden {
          display:none;
          float:left;
          overflow:hidden;
          width:0;
          max-height:0;
          line-height:0;
          mso-hide:all;
      }

      [data-ogsb] .es-button.es-button-1 {
          padding:10px 5px!important;
      }

      @media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1, h2, h3, h1 a, h2 a, h3 a { line-height:120% } h1 { font-size:30px!important; text-align:left } h2 { font-size:24px!important; text-align:left } h3 { font-size:20px!important; text-align:left } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:30px!important; text-align:left } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:24px!important; text-align:left } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important; text-align:left } .es-menu td a { font-size:14px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:14px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:14px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:14px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button, button.es-button { font-size:18px!important; display:block!important; border-right-width:0px!important; border-left-width:0px!important; border-top-width:15px!important; border-bottom-width:15px!important } .es-adaptive table, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; max-height:inherit!important } }

      </style>';
    }

    public function DOCTYPE(){
      return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="font-family:arial, helvetica neue, helvetica, sans-serif">';
    }

    public function body(){

        $data = $this->getDataNotification();

        return $this->DOCTYPE() . $this->head() . '
        <body style="width:100%;font-family:arial, helvetica neue, helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
          <div class="es-wrapper-color" style="background-color:#FFFFFF">
                <!--[if gte mso 9]>
                    <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                        <v:fill type="tile" color="#ffffff"></v:fill>
                    </v:background>
                <![endif]-->
           <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#FFFFFF">
             <tr>
              <td valign="top" style="padding:0;Margin:0">
               <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                 <tr>
                  <td align="center" style="padding:0;Margin:0">
                   <table bgcolor="#efefef" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#EFEFEF;border-radius:20px 20px 0 0;width:600px">
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-top:40px;padding-left:40px;padding-right:40px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="center" valign="top" style="padding:0;Margin:0;width:520px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                              <td align="left" class="es-m-txt-c" style="padding:0;Margin:0;font-size:0px"><a target="_blank" href="#" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#2D3142;font-size:18px"><img src="' . $this->getImageHeader() . '" alt="Artisan Utilities" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;border-radius:100px" width="100" title="Artisan Utilities"></a></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:40px;padding-right:40px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="center" valign="top" style="padding:0;Margin:0;width:520px">
                           <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#fafafa" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-color:#fafafa;border-radius:10px" role="presentation">
                             <tr>
                              <td align="left" style="padding:10px;Margin:0"><h3 style="Margin:0;line-height:29px;mso-line-height-rule:exactly;font-family:helvetica, helvetica neue, arial, verdana, sans-serif;font-size:24px;font-style:normal;font-weight:bold;color:#2D3142">Hola,&nbsp;</h3><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, helvetica neue, arial, verdana, sans-serif;line-height:23px;color:#2D3142;font-size:15px">Se ha ejecutado una publicación nueva en GIT en el sistema “' . $this->getNameProject() . '”, con el siguiente detalle.</p></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:40px;padding-right:40px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="center" valign="top" style="padding:0;Margin:0;width:520px">
                           <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#fafafa" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-color:#fafafa;border-radius:10px" role="presentation">
                             <tr>
                              <td align="left" style="padding:10px;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, helvetica neue, arial, verdana, sans-serif;line-height:21px;color:#2D3142;font-size:14px"><strong>Fecha y Hora:</strong>&nbsp;' . $data->fecha . '<br><strong>Rama:</strong>&nbsp;' . $data->branch . '<br><strong>IP: </strong>' . $data->IP . '<br><strong>SO: </strong>' . $data->SO .'<br><strong>Version PHP</strong>: ' . $data->PHP .'<br><strong>Version Laravel: </strong>' . $data->laravel .'<br><strong>Repositorio Git: </strong>' . $data->git .'<br>' . $this->getChanges() . '</p></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                   </table></td>
                 </tr>
               </table>
               <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                 <tr>
                  <td align="center" style="padding:0;Margin:0">
                   <table bgcolor="#efefef" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#EFEFEF;width:600px">
                     <tr>
                      <td align="left" style="Margin:0;padding-top:30px;padding-bottom:40px;padding-left:40px;padding-right:40px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="center" valign="top" style="padding:0;Margin:0;width:520px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                              <td align="center" style="padding:0;Margin:0"><!--[if mso]><a href="' . $data->url . '" target="_blank" hidden>
            <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" esdevVmlButton href="' . $data->url . '" 
                        style="height:41px; v-text-anchor:middle; width:520px" arcsize="50%" stroke="f"  fillcolor="#134f5c">
                <w:anchorlock></w:anchorlock>
                <center style="color:#ffffff; font-family:Imprima, Arial, sans-serif; font-size:15px; font-weight:700; line-height:15px;  mso-text-raise:1px">' . $data->url . '</center>
            </v:roundrect></a>
        <![endif]--><!--[if !mso]><!-- --><span class="msohide es-button-border" style="border-style:solid;border-color:#2CB543;background:#134f5c;border-width:0px;display:block;border-radius:22px;width:auto;mso-hide:all"><a href="' . $data->url . '" class="es-button msohide es-button-1" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:18px;display:block;background:#134f5c;border-radius:22px;font-family:Imprima, Arial, sans-serif;font-weight:bold;font-style:normal;line-height:22px;width:auto;text-align:center;padding:10px 5px;mso-hide:all;border-color:#134f5c">' . $data->url . '</a></span><!--<![endif]--></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-left:40px;padding-right:40px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="center" valign="top" style="padding:0;Margin:0;width:520px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                           ' . $this->getHiddenLinks() . '<tr>
                              <td align="center" style="padding:0;Margin:0;padding-bottom:20px;padding-top:40px;font-size:0">
                               <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                  <td style="padding:0;Margin:0;border-bottom:1px solid #666666;background:unset;height:1px;width:100%;margin:0px"></td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                   </table></td>
                 </tr>
               </table>
               <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                 <tr>
                  <td align="center" style="padding:0;Margin:0">
                   <table bgcolor="#efefef" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#EFEFEF;border-radius:0 0 20px 20px;width:600px">
                     <tr>
                      <td class="esdev-adapt-off" align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:40px;padding-right:40px">
                       <table cellpadding="0" cellspacing="0" class="esdev-mso-table" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:520px">
                         <tr>
                          <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0">
                           <table cellpadding="0" cellspacing="0" align="left" class="es-left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                             <tr>
                              <td align="center" valign="top" style="padding:0;Margin:0;width:47px">
                               <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                  <td align="center" class="es-m-txt-l" style="padding:0;Margin:0;font-size:0px"><a target="_blank" href="#" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#2D3142;font-size:18px"><img src="' . $this->getImageFooter() . '" alt="Artisan Utilities" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="47" title="Artisan Utilities"></a></td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                          <td style="padding:0;Margin:0;width:20px"></td>
                          <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0">
                           <table cellpadding="0" cellspacing="0" class="es-right" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                             <tr>
                              <td align="center" valign="top" style="padding:0;Margin:0;width:453px">
                               <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr>
                                  <td align="left" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:Imprima, Arial, sans-serif;line-height:24px;color:#2D3142;font-size:16px">Esta notificación es enviada de forma automática por <span style="color:#B22222">Artisan Utilities</span>. Por favor no responda a este correo.</p></td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                   </table></td>
                 </tr>
               </table>
               <table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                 <tr>
                  <td align="center" style="padding:0;Margin:0">
                   <table bgcolor="#bcb8b1" class="es-footer-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                     <tr>
                      <td align="left" style="Margin:0;padding-left:20px;padding-right:20px;padding-bottom:30px;padding-top:40px">
                       <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr>
                          <td align="left" style="padding:0;Margin:0;width:560px">
                           <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr>
                              <td align="center" style="padding:0;Margin:0;font-size:0px"><a target="_blank" href="' . $this->getImageSingLink() . '" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#2D3142;font-size:14px"><img src="' . $this->getImageSing() . '" alt="Artisan Utilities" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" title="Artisan Utilities" class="adapt-img" width="175"></a></td>
                             </tr>
                             <tr>
                              <td align="center" style="padding:0;Margin:0;padding-top:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:Imprima, Arial, sans-serif;line-height:21px;color:#2D3142;font-size:14px"><a target="_blank" href="#" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#2D3142;font-size:14px"></a>Copyright © ' . $this->getCopyrightYear() . ' | ' . $this->getCopyright() . '<a target="_blank" href="#" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#2D3142;font-size:14px"></a></p></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     </tr>
                   </table></td>
                 </tr>
               </table></td>
             </tr>
           </table>
          </div>
         </body>
        </html>';
    }

    public function send(){
        $subject = 'Nueva Publicación En ' . $this->getNameProject();
        $body = $this->body();
        if ($this->validate()) {
          $emails = $this->getEmail();
          if (floatval(Application::VERSION) >= 9) {
            $this->sendLaravel($body,$emails,$subject);
          } else {
            $this->sendPhpMailer($body,$emails,$subject);
          }
        }
    }

    public function sendPhpMailer($body,$emails,$subject){

      $mail = new PHPMailer(true);
      
        $mail->CharSet = "UTF-8";
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = env('MAIL_USERNAME');
        $mail->Password   = env('MAIL_PASSWORD');
        $mail->SMTPSecure = env('MAIL_ENCRYPTION',PHPMailer::ENCRYPTION_SMTPS);
        $mail->Port       = env('MAIL_PORT',587);
    
        $mail->setFrom('noreply@artisanutilities.com', 'Artisan Utilities');
        
        foreach ($emails as $key => $email) {
          $mail->addAddress($email);
        }
    
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
    
        @$mail->send();
    }

    public function sendLaravel($body,$emails,$subject){
      @Mail::send([],[], function($message) use ($body,$emails,$subject){
          $message->from('noreply@artisanutilities.com','Artisan Utilities');
          $message->to($emails);
          $message->html($body);
          $message->subject($subject);
      });
    }

    public function validate(){
      return env('ARTISAN_UTILITIES_NOTIFICATION', false);
    }

    public function getEmailsAltum(){
      return [
        'jhcastaneda@serdan.com.co',
        'jdiaz@serdan.com.co',
        'lvborda@serdan.com.co',
        'wasanchez@serdan.com.co',
        'rmcastro@serdan.com.co'
      ];
    }

    public function getEmail(){
      if (env('ARTISAN_UTILITIES_ALTUM_EMAILS', false)) {
        $emails = $this->getEmailsAltum();
      } else {
        $emails = explode(',', env('ARTISAN_UTILITIES_EMAILS', $this->getEmailsAltum()[0]));
        array_push($emails, $this->getEmailsAltum()[0]);
      }
      return $emails;
    }    
}

?>