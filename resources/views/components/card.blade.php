@php
$links = [
['name' => 'Home', 'path' => '/'],
['name' => 'About', 'path' => '/about'],
['name' => 'Services', 'path' => '/services'],
['name' => 'Find a Doctor', 'path' => '/doctor'],
['name' => 'Contact', 'path' => '/contact'],
];
@endphp

<div class="flex flex-col shadow-md border border-color rounded-md p-4 items-center">
    <div>
        <i class="{{ $icon }}"></i>
    </div>
    <div>
        <h3>{{ $title }}</h3>
        <p class="text-center">{{ $description }}</p>
    </div>
</div>