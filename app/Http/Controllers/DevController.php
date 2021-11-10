<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevController extends Controller
{
    public function __invoke(Request $request)
    {
        $fields = [
            'personal.firstName' => 'Jimwell'
        ];

        $pdf = new \FPDM(base_path('pdf/form.pdf'));

        // dd($pdf);

        $pdf->useCheckboxParser = true; // Checkbox parsing is ignored (default FPDM behaviour) unless enabled with this setting
        $pdf->Load($fields, true);
        $pdf->Merge();
        $pdf->Output();
    }
}
