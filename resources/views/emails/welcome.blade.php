<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" dir="rtl">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <!-- Web Font / @font-face : BEGIN -->
    <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->

    <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
    <!--[if mso]>
    <style>
        * {
            font-family: sans-serif !important;
        }
    </style>
    <![endif]-->

    <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
    <!--[if !mso]><!-->
    <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
    <!--<![endif]-->

    <!-- Web Font / @font-face : END -->

    <!-- CSS Reset : BEGIN -->
    <style>

        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],  /* iOS */
        .unstyle-auto-detected-links *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }
        /* If the above doesn't work, add a .g-img class to any image in question. */
        img.g-img + div {
            display: none !important;
        }

        /* What it does: Prevents underlining the button text in Windows 10 */
        .button-link {
            text-decoration: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            .email-container {
                min-width: 320px !important;
            }
        }
        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            .email-container {
                min-width: 375px !important;
            }
        }
        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            .email-container {
                min-width: 414px !important;
            }
        }

    </style>
    <!-- CSS Reset : END -->
    <!-- Reset list spacing because Outlook ignores much of our inline CSS. -->
    <!--[if mso]>
    <style type="text/css">
        ul,
        ol {
            margin: 0 !important;
        }
        li {
            margin-left: 30px !important;
        }
        li.list-item-first {
            margin-top: 0 !important;
        }
        li.list-item-last {
            margin-bottom: 10px !important;
        }
    </style>
    <![endif]-->

    <!-- Progressive Enhancements : BEGIN -->
    <style>

        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td-primary:hover,
        .button-a-primary:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

        /* Media Queries */
        @media screen and (max-width: 600px) {

            .email-container {
                width: 100% !important;
                margin: auto !important;
            }

            /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
            .fluid {
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: rtl !important;
            }
            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }

            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }

            /* What it does: Adjust typography on small screens to improve readability */
            .email-container p {
                font-size: 17px !important;
            }
        }

    </style>
    <!-- Progressive Enhancements : END -->

    <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->

</head>
<!--
	The email background color (#222222) is defined in three places:
	1. body tag: for most email clients
	2. center tag: for Gmail and Inbox mobile apps and web versions of Gmail, GSuite, Inbox, Yahoo, AOL, Libero, Comcast, freenet, Mail.ru, Orange.fr
	3. mso conditional: For Windows 10 Mail
-->
<body width="100%" style="margin: 0; mso-line-height-rule: exactly; background-color: #222222;">
<center style="width: 100%; background-color: #222222; text-align: right;">
    <!--[if mso | IE]>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #222222;">
        <tr>
            <td>
    <![endif]-->

    <!-- Visually Hidden Preheader Text : BEGIN -->
    <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">

    </div>
    <!-- Visually Hidden Preheader Text : END -->

    <!-- Create white space after the desired preview text so email clients don’t pull other distracting text into the inbox preview. Extend as necessary. -->
    <!-- Preview Text Spacing Hack : BEGIN -->
    <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>
    <!-- Preview Text Spacing Hack : END -->
    <!-- Email Body : BEGIN -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="margin: auto;" class="email-container">

        <!-- Hero Image, Flush : BEGIN -->

        <!-- Hero Image, Flush : END -->

        <!-- 1 Column Text + Button : BEGIN -->
        <tr>
            <td style="background-color: #ffffff;">
                <div dir="rtl">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <div style="padding: 40px 40px 20px; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;">
                            <tr>
                                <td align="center" style="background-color: #ffffff;">
                                    <img src="{{env('PRD_URL')}}/images/logo1.png" width="100px" height="100px" alt="logo_pic!" border="0" align="center" style="width: 50%; max-width: 600px; height: auto; background: #dddddd; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555; margin: auto;" class="g-img">
                                </td>
                            </tr>
                        <br>
                            <h1 style="margin: 0 0 10px; font-size: 24px; line-height: 125%; color: #333333; font-weight: normal;">חיכינו לך! כיף שהצטרפת אלינו</h1>

                            <h3 style="margin: 0 0 10px;">
                            <h2>מה אפשר לעשות במערכת קפה אמון?</h2>
                            <ul style="padding: 0; margin: 0; list-style-type: disc;">
                                <li style="margin:0 0 10px 30px;"><b>נגמר החלב בעמדה? יש תקלה במכונה?</b> מהיום אתם לא צריכים לחפש את נציגי האגודה כדי שיעזרו, פתחו דיווח בתקלה והמתנדבים החרוצים שלנו מיד יגיעו</li>
                                <li style="margin:0 0 10px 30px;">חשוב לזכור שקפה אמון מבוסס על מתנדבים ולכן אנחנו צריכים גם אתכם! <b>התנדבות לא כרוכה בשום התחייבות מצידכם. פשוט אשרו קבלת התראות ואם תהיו ליד העמדה תקפצו לראות אם אפשר לעזור.</b></li>
                                <li style="margin:0 0 10px 30px;">שימו לב שמערכת קפה אמון זמינה דרך הדפדפן, בקרוב גם באפליקציה</li>
                                <li style="margin:0 0 10px 30px;" class="list-item-first"><b>הפיצו את הבשורה! שלחו את לינק המערכת לחברים בתואר ובקבוצות וביחד נשתה קפה טעים וזול יותר!</b></li>
                            </ul>
                            <br>
                            <p>
                            <h3>לכל שאלה ניתן לפנות {{env('Kafe_Emun_Manager')}} בטלפון <a href="tel:{{env('Kafe_Emun_Manager_Phone')}}">{{env('Kafe_Emun_Manager_Phone')}}</a> </h3>
                            </h3>
                        <tr>
                            <td>
                                <h3><a href="https://api.whatsapp.com/send?phone=972528477546"> או בוואטסאפ:<img src="{{env('PRD_URL')}}/images/WhatsApp_NEW_Logo.png" height="35px" height="35px"> </a></h3>
                            </td>
                        </tr>
                            </div>
                            </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0 40px 40px; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;">
                                <!-- Button : BEGIN -->
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: auto;">
                                    <tr>
                                        <td class="button-td button-td-primary" style="border-radius: 4px; background: #222222;">
                                        </td>
                                    </tr>
                                </table>
                                <!-- Button : END -->
                            </td>
                        </tr>

                    </table>
                </div>
            </td>
        </tr>
        <!-- 1 Column Text + Button : END -->

        <!-- Background Image with Text : BEGIN -->

        <!-- Background Image with Text : END -->
        <!-- 2 Even Columns : END -->

        <!-- Thumbnail Left, Text Right : BEGIN -->
    </table>
    </table>
    <!-- Email Body : END -->

    <!-- Email Footer : BEGIN -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px;">
        <tr>
            <td style="padding: 40px 10px; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;">
                <br><br>
                אגודת הסטודנטים<br><span class="unstyle-auto-detected-links">רבנו ירוחם 12, תל אביב<br><a href="tel:03-9292929">03-9292929</a></span>
                <br><br>
                <a href="{{env('PRD_URL')}}/notifications/unsubscribe/{{$user->secret_token}}"> <unsubscribe style="color: #888888; text-decoration: underline;">unsubscribe</unsubscribe> </a>
            </td>
        </tr>
    </table>
    <!-- Email Footer : END -->
    <!-- Full Bleed Background Section : END -->

    <!--[if mso | IE]>
    </td>
    </tr>
    </table>
    <![endif]-->
</center>
</body>
</html>