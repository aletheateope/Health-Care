<x-layout title="Login">
    <div class="flex flex-row border border-color mx-24 rounded-md shadow-md overflow-hidden">
        <div class="flex flex-col flex-grow bg-no-repeat bg-cover bg-top"
            style="background-image: url('{{ asset('img/nurse.jpg') }}');">
        </div>
        <div data-vue="LoginForm"></div>
    </div>
</x-layout>