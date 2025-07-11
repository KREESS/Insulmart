<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>{{ config('app.name') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">

    <style>
        /* RESET */
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f2f3f8;
            font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        a {
            color: #8B0000;
            text-decoration: none;
        }

        .email-wrapper {
            width: 100%;
            padding: 40px 0;
            background: linear-gradient(135deg, #8B0000, #a60000);
        }

        .email-content {
            max-width: 620px;
            margin: auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 12px 25px rgba(0,0,0,0.08);
        }

        .email-header {
            background: #ffffff;
            text-align: center;
            padding: 32px 20px 12px;
            font-size: 24px;
            font-weight: bold;
            color: #8B0000;
            border-bottom: 1px solid #eee;
        }

        .email-body {
            padding: 30px 35px;
            font-size: 16px;
            color: #333;
            line-height: 1.7;
        }

        .email-footer {
            text-align: center;
            padding: 25px 20px;
            font-size: 13px;
            color: #bbb;
            background-color: #f8f8f8;
            border-top: 1px solid #eee;
        }

        .email-subcopy {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
            border-top: 1px dashed #ddd;
            padding-top: 15px;
        }

        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 20px;
            }
        }
    </style>

    {!! $head ?? '' !!}
</head>

<body>
    <div class="email-wrapper">
        <div class="email-content">
            
            {{-- Header --}}
            <div style="background-color: #8B0000; padding: 10px 0;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center">
                            <a href="{{ config('app.url') }}" style="display: inline-block;">
                                <img src="https://i.ibb.co/mCdNtvQh/insulmart-new-bg-new.png" alt="Insulmart Logo" style="height: 100px; display: block;">
                            </a>
                        </td>
                    </tr>
                </table>
            </div>


            {{-- Body --}}
            <div class="email-body">
                {!! Illuminate\Mail\Markdown::parse($slot) !!}

                @isset($subcopy)
                <div class="email-subcopy">
                    {!! $subcopy !!}
                </div>
                @endisset
            </div>

            {{-- Footer --}}
            @isset($footer)
            <div class="email-footer">
                {!! $footer !!}
            </div>
            @endisset

        </div>
    </div>
</body>
</html>
