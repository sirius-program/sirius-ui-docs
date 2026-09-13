<x-sirius::field id="demo-consent" layout="inline" label="Send me product updates" helper="You can change this preference later.">
    <input type="checkbox" {{ $component->controlAttributes() }}>
</x-sirius::field>
<x-sirius::field id="demo-channels" group label="Contact channels" helper="Choose the channels that suit you.">
    <div class="flex flex-wrap gap-4">
        <div><input id="demo-channel-email" type="checkbox" name="channels[]" value="email"> <x-sirius::label for="demo-channel-email">Email</x-sirius::label></div>
        <div><input id="demo-channel-sms" type="checkbox" name="channels[]" value="sms"> <x-sirius::label for="demo-channel-sms">SMS</x-sirius::label></div>
    </div>
</x-sirius::field>
