<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', Prescription::class);

        $user = $request->user();

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'valid_until' => 'required',
            'clinical_items' => 'required|array|min:1',
            'clinical_items.*.item' => 'required|string',
            'clinical_items.*.qty' => 'required|numeric|min:1',
            'clinical_items.*.sig' => 'nullable|string',
            'remarks' => 'nullable|array',
            'remarks.*' => 'nullable|string',
        ]);

        $doctor_id = $user->profile->doctor->id;

        $prescription = Prescription::create([
        'doctor_id' => $doctor_id,
        'patient_id' => $validated['patient_id'],
        'valid_until' => $validated['valid_until'],
   ]);

        foreach ($validated['clinical_items'] as $item) {
            $prescription->items()->create([
                'item' => $item['item'],
                'quantity' => $item['qty'],
                'sig' => $item['sig'] ?? null,
            ]);
        }

        if (!empty($validated['remarks'])) {
            foreach ($validated['remarks'] as $remark) {
                if ($remark) {
                    $prescription->remarks()->create([
                        'remark' => $remark,
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'Prescription created successfully',
        ]);

    }
}
