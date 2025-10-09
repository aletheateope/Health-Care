<x-layout title="Login">
    <div class="flex border border-color flex-col md:flex-row xl:mx-24 rounded-md shadow-md overflow-hidden">
        <div class="flex flex-col h-200 md:h-auto md:flex-grow bg-no-repeat bg-cover bg-top"
            style="background-image: url('{{ asset('img/nurse.jpg') }}');">
        </div>
        <div class="w-full p-4  md:w-[26rem] lg:w-[34rem] lg:px-0  sm:p-14 md:p-8 lg:px-18" data-vue="LoginForm"></div>
    </div>
</x-layout>