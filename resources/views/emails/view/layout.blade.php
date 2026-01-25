<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Email')</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:40px 0;">
        <tr>
            <td align="center">

                <table width="100%" cellpadding="0" cellspacing="0"
                    style="max-width:600px; background:#ffffff; border-radius:10px;
                    box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="padding:30px; text-align:center;">

                            {{-- Header --}}
                            <h1 style="margin:0 0 20px; font-size:24px; color:#111827;">
                                @yield('heading')
                            </h1>

                            {{-- Content --}}
                            <h1 style="margin:0 0 20px; font-size:24px; color:#111827;">
                                @yield('content')
                            </h1>
                            {{-- Footer --}}
                            <p style="margin-top:30px; font-size:14px; color:#6b7280;">
                                © {{ date('Y') }} Your App Name. All rights reserved.
                            </p>

                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>

</html>
