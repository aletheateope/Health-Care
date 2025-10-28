@php
$links = [
['name' => 'Home', 'path' => 'home'],
['name' => 'About', 'path' => 'about'],
['name' => 'Services', 'path' => 'services'],
['name' => 'Find a Doctor', 'path' => 'doctor'],
['name' => 'Contact', 'path' => 'contact'],
];
@endphp

<header class="flex items-center justify-between py-6 px-6 sticky top-0 bg-color">
    <a href="{{ route('home') }}" class="flex items-center gap-4">
        <i class="pi pi-sparkles border rounded-full p-2 bg-teal-800 text-emerald-100 hidden! md:block!"
            style="font-size: 24px"></i>
        <h6 class="">Healthcare Company</h6>
    </a>
    <div>
        <ul class="flex gap-8 items-center">
            @foreach ($links as $link)
            @php
            $isActive = request()->routeIs($link['path']);
            @endphp
            <li class="hidden lg:block">
                <div class="flex {{ $isActive ? 'border-b-2 font-bold accent-color' : '' }}">
                    <a href="{{ route($link['path']) }}" class="py-2">
                        {{ $link['name'] }}
                    </a>
                </div>
            </li>
            @endforeach
            <li class="hidden lg:block">
                <div data-vue="Button" data-label="Login" data-as="a" data-href="{{ route('login') }}"></div>
            </li>
            <li class="lg:hidden">
                <div data-vue="Sidebar"></div>
            </li>
        </ul>
    </div>
</header>