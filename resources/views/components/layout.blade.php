<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    @vite(['resources/css/app.css', 'resources/js/mpa/app.js'])
</head>

<body>
    @if ($showHero)
    <div class="flex flex-col h-screen mb-22">
        <x-header></x-header>
        <section
            style="background-image: linear-gradient(rgba(6, 39, 35, 0.5),rgba(20, 184, 166, 0.5)), url('{{ asset('img/hero-section_bg.jpg') }}')"
            class="flex flex-row flex-grow bg-no-repeat bg-left bg-size-[150%] text-white p-24 items-center">
            <div class="flex flex-col flex-1 gap-10">
                <h1 class="bold">Smarter Healthcare <br> Starts Here</h1>
                <h6>Our healthcare management system helps clinics and hospitals streamline appointments, patient
                    records,
                    and billing in
                    one secure platform. By simplifying operations, we give providers more time to focus on what truly
                    matters—delivering
                    quality care.
                </h6>
                <div class="flex flex-row gap-4">
                    <div class="flex flex-col justify-center">
                        <i class="pi pi-phone" style="font-size: var(--h4)"></i>
                    </div>
                    <div class="flex flex-col">
                        <h6 class="inactive-text-light">Emergency Line</h6>
                        <p class="h5">(+63) 123 456 789</p>
                    </div>
                </div>
                <div data-vue="Button" data-label="Book an Appointment" data-icon="pi pi-calendar"></div>
            </div>
            <div class="flex flex-col flex-1">
            </div>
        </section>
    </div>
    @else
    <x-header></x-header>
    @endif
    <main class="flex flex-col gap-40 px-24 py-12">
        {{ $slot }}
    </main>
    <footer id="vue-footer"></footer>
</body>

</html>