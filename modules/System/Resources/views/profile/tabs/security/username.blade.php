<x-ui.card title="Username">

    <p>Changing your username can have unintended side effects .</p>

    <form id="ajax_form" action="{{ route('sys.profile.security.username') }}" method="POST">
        @csrf
        @method('PATCH')
        <x-ui.form.input label="New Username" name="username" value="{{ auth()->user()->username }}" />

        <button class="btn btn-primary">Chang username</button>
    </form>

    <hr>
    <p>Looking to manage account security settings? You can find them in the Account security tab.</p>

</x-ui.card>

<x-include.form.ajax />

