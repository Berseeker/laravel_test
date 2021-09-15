@component('mail::message')
# Introduction

Gracias por registrate con nosotros

Te compartimos ña URL para que puedas verificar tu email:


@component('mail::button', ['url' => $url])
Verificar Email
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
