<x-layout title="Contact">
    <x-section>
        <div class="flex flex-col gap-8 max-w-222">
            <h3 class="font-bold">For Inquiries & Assistance</h3>
            <p>Lorem ipsum dolor sit amet consectetur. Quam cursus et augue ultricies neque cras aliquam amet. Ut
                egestas turpis augue
                scelerisque vitae at convallis potenti neque. Ullamcorper purus vitae sed felis non proin eu. Egestas
                nisi enim
                parturient tincidunt egestas ut sit aenean venenatis. Quam dui nibh consequat est eleifend nisl
                pellentesque fermentum
                ac. Lacus aliquam vel eu fermentum in dui diam. Varius in pretium eu diam magna viverra netus diam.</p>
        </div>
    </x-section>
    <x-section>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <div>
                <x-card.contact title="Contact Number" description="(+63) 123-456-7890" icon="pi pi-phone" />
            </div>
            <div>
                <x-card.contact title="Email" description="xyz@example.com" icon="pi pi-envelope" />
            </div>
            <div>
                <x-card.contact title="Address" description="123 Main Street, City, Country" icon="pi pi-map-marker" />
            </div>
        </div>
    </x-section>
    <x-section>
        <div class="flex flex-col lg:flex-row gap-30">
            <div class="flex flex-col flex-1 gap-6">
                <h4 class="font-semibold">Where to Find Us</h4>
                <div class="rounded-md overflow-hidden w-full h-80 lg:h-full">
                    <iframe class="w-full h-full"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3863.3288414867548!2d121.0409260760378!3d14.465797180360935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397cf007cd9fc6f%3A0xc7e6460d7f5733b2!2sInnovato%20Information%20Technology%20Solutions!5e0!3m2!1sen!2sph!4v1761527307107!5m2!1sen!2sph"
                        width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="flex flex-col flex-1 gap-6">
                <h4 class="font-semibold">Send Us a Message</h4>
                <div>
                    <div data-vue="MessageForm"></div>
                </div>
            </div>
        </div>
    </x-section>
</x-layout>