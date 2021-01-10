@component('mail::message')

<style>
    .logo {
        background-color: #5E58F5;
        display: flex;
        padding: 2%;
        margin: 0 auto;
        border-radius: 15px;
        width: 150px !important;
    }

    .logo a,
    .mail,
    .footer-logo {
        margin: auto;
    }

    .mail {
        text-align: center;
        padding: .8rem
    }

    .footer-logo {
        background-color: #5E58F5;
        display: flex;
        padding: 2%;
        float: right;
        width: 100px !important;
        border-radius: 15px;
    }

    .footer-logo a {
        padding: .5rem;
    }

    .footer-mail {
        width: 100%;
        padding: .5rem;
    }

    .footer {
        display: flex;
        width: 33% !important;
        float: right;
        flex-wrap: wrap;
    }
</style>

<div class="logo">
    <a href="https://mazadii.net"><img src="{{asset('assets/images/logo/logo.png')}}" alt="mazadii-logo"></a>
</div>
<div class="mail">
    support@mazadii.net
</div>

<hr>
<br>

Congratulations, You are approved from admin and you can login to mazadii.net now.

<strong>User Code : </strong> {{$user->code}}

Thanks,<br>
<a href="http://mazadii.net">{{ config('app.name') }}</a>
<div class="footer">
    <div class="footer-logo">
        <a href="http://mazadii.net"><img src="{{asset('assets/images/logo/logo.png')}}" alt="mazadii-logo"></a>
    </div>
    <span class="footer-mail">support@mazadii.net</span>
</div>



@endcomponent
