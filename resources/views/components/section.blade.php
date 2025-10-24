<section class="flex flex-col gap-16">
    @isset($title)
    <header class="flex justify-center text-center">
        <h3 class="font-bold">{{ $title }}</h3>
    </header>
    @endisset
    {{ $slot }}
</section>