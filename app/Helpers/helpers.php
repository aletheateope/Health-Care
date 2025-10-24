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
