<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <style>
        .blue {
            color: blue;
        }
        *{
            text-align: right;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
<p dir="rtl">
<h3 class="service-description"><b> שם פרטי: {{ $user->first_name }} </b></h3>
<h3 class="service-description"><b> שם שפחה: {{ $user->last_name }} </b></h3>
<h3 class="service-description"><b> אימייל: {{ $user->email }} </b></h3>
<h3 class="service-description"><b> מועד: {{$user->created_at}} </b></h3>
</p>
</body>
</html>