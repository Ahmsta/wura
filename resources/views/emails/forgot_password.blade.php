<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <h3>Password Reset Request</h3>

            <p>Hello {{ $header }},</p>

            <p>Someone has requested a link to change your password, and you can do this through the link below. </p>

            <a href="{{ $resetUrl }}"> Change my password </a>

            <p>If you didn't request this, please ignore this email.</p>

            <p>Your password won't change until you access the link above and create a new one.</p>

            <p>This email comes from Feedfast.org<br />
            http://feedfast.org
            </p>

            <hr />
            If you have received this email in error, please contact mailto:support@feedfast.org

        </div>
    </body>
</html>