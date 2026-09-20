<x-docs-code language="PHP">use Sirius\Ui\Rules\PhoneNumber;

$rules = [
    'delivery' =&gt; ['required', new PhoneNumber(['62'])],
    'partner' =&gt; ['required', new PhoneNumber(['62', '44'])],
    'traveler' =&gt; ['nullable', new PhoneNumber],
];</x-docs-code>
