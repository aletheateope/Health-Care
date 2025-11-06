<?php

if (!function_exists('serviceToSpecialty')) {
    function serviceToSpecialty(int $serviceId): ?int
    {
        $map = [
            1  => 1,
            12 => 4,
            13 => 3,
            14 => 5,
        ];

        return $map[$serviceId] ?? null;
    }
}

if (!function_exists('nonDoctorServices')) {
    function nonDoctorServices(): array
    {
        return [2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
    }
}
