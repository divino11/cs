<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Untitled Document</title>
    <style type="text/css">

        h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6{
            Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        h1,.h1,h2,.h2,h3,.h3{
            margin-top:20px;
            margin-bottom:10px;
            letter-spacing:.0425em;
        }
        h4,.h4,h5,.h5,h6,.h6{
            margin-top:10px;
            margin-bottom:10px;
            letter-spacing:.0625em;
        }
        h1,.h1{
            font-size:36px;
        }
        h2,.h2{
            font-size:30px;
        }
        h3,.h3{
            font-size:24px;
        }
        h4,.h4{
            font-size:18px;
        }
        h5,.h5{
            font-size:14px;
        }
        h6,.h6{
            font-size:12px;
        }

        p{
            font-size:14px;
            line-height: 22px;
        }


    </style>
</head>
<body style="background-color:#f1f1f1;">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0" style="background-color:#fff;">
    <tbody>
    {{ $header ?? '' }}
    <tr>
        <td>
            <!-- Text box -->
            <table width="600px" border="0" cellspacing="0" cellpadding="0" style="padding-left:50px; padding-top:20px;padding-right:50px; padding-bottom:50px;">
                <tbody>
                <tr>
                    <td>
                        {{ Illuminate\Mail\Markdown::parse($slot) }}
                    </td>
                </tr>
                </tbody>
            </table>
            <!-- END text box -->
        </td>
    </tr>

    </tbody>
</table>

<!-- TABLE SOCIAL -->
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
    <tbody>
    <tr>
        <td>
            <!-- social icons -->
            <table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td style="padding-right:10px;"><a href="#" target="_blank"><img src="{{ asset('images/ico_fb.png') }}" style="width: 24px;" alt=""></a></td>
                    <td style="padding-right:10px;"><a href="#" target="_blank"><img src="{{ asset('images/ico_twitter.png') }}" style="width: 25px;" alt=""></a></td>
                    <td style="padding-right:10px;"><a href="#" target="_blank"><img src="{{ asset('images/ico_google.png') }}" style="width: 28px;" alt=""></a></td>
                    <td><a href="#"><img src="{{ asset('images/ico_insta.png') }}" style="width: 20px;" alt=""></a></td>
                </tr>
                </tbody>
            </table>
            <!-- END social icons -->
        </td>
    </tr>
    </tbody>
</table>
<!-- END social -->

<!-- TABLE BOT -->
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top: 0;">
    <tbody>
    <tr>
        <td class="footer-text">
            {{ $subcopy ?? '' }}

            {{ $footer ?? '' }}
        </td>
    </tr>
    </tbody>
</table>
<!-- END bot -->

</body>
</html>