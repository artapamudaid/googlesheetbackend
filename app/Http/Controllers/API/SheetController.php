<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GoogleSheetService;

class SheetController extends Controller
{

    public function getData($sheet, $index)
    {
        $googleSheet = new GoogleSheetService;
        $datas = $googleSheet->getData($sheet, $index);

        return response()
            ->json([
                $datas
            ]);
    }

    public function getForm($sheet)
    {
        return view('sheet.form', compact(['sheet']));
    }

    public function saveData($sheet, Request $request)
    {
        $values = [
            [
                $request->nama,
                $request->pekerjaan,
                $request->kota,
            ]
        ];

        // dd($values);

        $googleSheet = new GoogleSheetService;
        $googleSheet->saveData($sheet, $values);

        return response()
            ->json([
                $googleSheet
            ]);
    }
}
