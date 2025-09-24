@php
$links = [
['name' => 'Home', 'path' => '/'],
['name' => 'About', 'path' => '/about'],
['name' => 'Services', 'path' => '/services'],
['name' => 'Find a Doctor', 'path' => '/doctor'],
['name' => 'Contact', 'path' => '/contact'],
];
@endphp

<header class="flex items-center justify-between py-6 px-6 sticky top-0 bg-color">
    <a href="/" class="flex items-center gap-4">
        <i class="pi pi-sparkles border rounded-full p-2 bg-teal-800 text-emerald-100" style="font-size: 24px"></i>
        <h6>Healthcare Company</h6>
    </a>
    <div>
        <ul class="flex gap-8 items-center">
            @foreach ($links as $link)
            @php
            $isActive = request()->is(ltrim($link['path'], '/')) || ($link['path'] === '/' && request()->is('/'));
            @endphp
            <li>
                <div class="flex {{ $isActive ? 'border-b-2 bold accent-color' : '' }}">
                    <a href="{{ $link['path'] }}" class="py-2">
                        {{ $link['name'] }}
                    </a>
                </div>
            </li>
            @endforeach
            <li>
                <div data-vue="Button" data-label="Login" data-as="a" data-href="/login"></div>
            </li>
        </ul>
    </div>
</header>