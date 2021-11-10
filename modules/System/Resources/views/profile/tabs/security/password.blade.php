<x-ui.card title="Password">

   

    <form id="ajax_form" action="{{ route('sys.profile.security.password') }}" method="POST">
        @csrf
        @method('PATCH')

        <x-ui.form.input type="password" label="Old Password" name="password_old" />

        <x-ui.form.input type="password" label="New Password" name="password" />

        <x-ui.form.input type="password" label="Confirm Password" name="password_confirmation" />


        <button class="btn btn-primary">Chang password</button>
    </form>

    <hr>
    <p>Looking to manage account username settings? You can find them in the Account username tab.</p>

</x-ui.card>

<x-include.form.ajax />

