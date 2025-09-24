<x-layout>
    <div class="flex flex-row border border-color mx-24 rounded-md shadow-md overflow-hidden">
        <div class="flex flex-col flex-grow bg-no-repeat bg-cover bg-top"
            style="background-image: url('{{ asset('img/nurse.jpg') }}');">
        </div>
        <div class="flex flex-col w-[34rem] items-center gap-14 text-center p-14">
            <div class="flex flex-col gap-2">
                <h3>Hello!</h3>
                <p>Log in to access your account and get started.</p>
            </div>
            <div class="flex flex-col gap-6 w-full">
                <div data-vue="InputText" data-id="email" data-label="Email" data-type="email"></div>
                <div data-vue="Password" data-id="password"></div>
                <div class="flex flex-row items-center justify-between px-2">
                    <div data-vue="Checkbox" data-id="remember-me" data-label="Remember me"></div>
                    <div data-vue="Button" data-variant="link" data-label="Forgot Password?" data-class="p-0!">
                    </div>
                </div>
            </div>
            <div class="w-full" data-vue="Button" data-label="Log In" data-type="submit" data-class="w-full"></div>
            <p>Dont have an account?
                <span data-vue="Button" data-variant="link" data-label="Sign Up" data-as="a" data-href="/register"
                    data-class="p-0!"></span>
            </p>
            <p class="border-b w-full text-center leading-[0.1em]"><span class="bg-color px-4">Or Sign in
                    with</span>
            </p>
            <div class="flex flex-row w-full justify-center gap-4">
                <div data-vue="Button" data-icon="pi pi-google" data-label="Google" data-severity="secondary"></div>
                <div data-vue="Button" data-icon="pi pi-facebook" data-label="Facebook" data-severity="secondary">
                </div>
            </div>
        </div>
    </div>
</x-layout>