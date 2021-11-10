<x-ui.card title="Username">

    <p>Changing your username can have unintended side effects .</p>

    <form action="">
        @csrf
        <x-ui.form.input label="New Username" />

        <button class="btn btn-primary">Chang username</button>
    </form>

    <hr>


    <p>Looking to manage account security settings? You can find them in the Account security tab.</p>

</x-ui.card>