<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; color: #74787E; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
<style>
    @media only screen and (max-width: 600px) {
        .inner-body {
            width: 100% !important;
        }

        .footer {
            width: 100% !important;
        }
    }

    @media only screen and (max-width: 500px) {
        .button {
            width: 100% !important;
        }
    }
</style>
<?php
$systemSetting = \Helper::getSystemSetting();
$logo = null;
if ($systemSetting) {
    $logo = $systemSetting->logo;
}
?>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0"
       style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
            <table class="content" width="100%" cellpadding="0" cellspacing="0"
                   style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                <tr>
                    <td class="header"
                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;">
                        <a href="{{ config('app.url') }}"
                           style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
                            @if($logo)
                                <img src="{{ asset($logo) }}"/>
                            @else
                                {{ config('app.name') }}
                            @endif
                        </a>
                    </td>
                </tr>
                <!-- Email Body -->
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0"
                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; border-bottom: 1px solid #EDEFF2; border-top: 1px solid #EDEFF2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0"
                               style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                            <!-- Body content -->
                            <tr>
                                <td class="content-cell"
                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                        Greetings {{$account_name}},</p>

                                    <div class="table"
                                         style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                        <table style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                                            <tr>
                                                <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">
                                                    This serves as your friendly reminder that you have
                                                    until {{date("Y-m-d", strtotime($end_date))}} before your purchased
                                                    products expire.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">
                                                    See product details attached.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">
                                                    <table class="footer" align="center" width="570" cellpadding="0"
                                                           cellspacing="0"
                                                           style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                                                        @if($bank_logo || $other_bank)
                                                            <tr>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    Bank
                                                                </td>
                                                                <td class="content-cell" align="center"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    :
                                                                </td>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    @if($bank_logo)
                                                                        <img src="{{asset($bank_logo)}}" alt=""/>
                                                                    @elseif($other_bank)
                                                                        {{ $other_bank }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if($account_name)
                                                            <tr>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    Account Name
                                                                </td>
                                                                <td class="content-cell" align="center"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    :
                                                                </td>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    @if($account_name)
                                                                        {{ $account_name }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if($amount)
                                                            <tr>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    Amount
                                                                </td>
                                                                <td class="content-cell" align="center"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    :
                                                                </td>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    @if($amount)
                                                                        {{ $amount }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if($tenure)
                                                            <tr>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    Tenure
                                                                </td>
                                                                <td class="content-cell" align="center"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    :
                                                                </td>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    {{ !empty($tenure) ? $tenure . ' ' . $tenure_calender : '-' }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if($start_date)
                                                            <tr>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    Start Date
                                                                </td>
                                                                <td class="content-cell" align="center"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    :
                                                                </td>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    {{ !empty($start_date) ? date("d-m-Y", strtotime($start_date)) : '-' }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if($end_date)
                                                            <tr>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    End Date
                                                                </td>
                                                                <td class="content-cell" align="center"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    :
                                                                </td>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    {{ !empty($end_date) ? date("d-m-Y", strtotime($end_date)) : '-' }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                            @if($interest_earned)
                                                            <tr>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    Interest Earned
                                                                </td>
                                                                <td class="content-cell" align="center"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    :
                                                                </td>
                                                                <td class="content-cell" align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 5px;">
                                                                    {{ isset($interest_earned) ? $interest_earned : '-' }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                        Have a good day!
                                    </p>

                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                        Regards,<br/>DollarDollar.sg</p>

                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                        <a href="@if(isset($adLink)){{$adLink}}@endif"><img
                                                    src="@if(isset($ad)){{asset($ad)}}@endif" alt=""
                                                    style="max-width:570px"></a></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0"
                               style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                            <tr>
                                <td class="content-cell" align="center"
                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #AEAEAE; font-size: 12px; text-align: center;">
                                        Copyright &copy; {{ date('Y') }} {{ config('app.name') }} SG. All rights
                                        reserved.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>