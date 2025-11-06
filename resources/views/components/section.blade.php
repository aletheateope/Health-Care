<section class="flex flex-col gap-16 {{ $class }}">
    @isset($title)
    <header class="flex flex-col items-center justify-center text-center gap-2">
        <h3 class="font-bold">{{ $title }}</h3>
        @isset($description)
        <p class="max-w-150">{{ $description }}</p>
        @endisset
    </header>
    @endisset
    {{ $slot }}
</section>