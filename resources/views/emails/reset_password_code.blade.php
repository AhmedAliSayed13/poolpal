@component('mail::message')
# إعادة تعيين كلمة المرور

مرحباً،

كود إعادة التعيين الخاص بك هو:

@component('mail::panel')
{{ $code }}
@endcomponent

صالح لمدة 15 دقيقة فقط.

شكراً،
{{ config('app.name') }}
@endcomponent
