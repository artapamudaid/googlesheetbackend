<?php

namespace App\Services;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;

class GoogleSheetService
{
    private $spreadSheetId;
    private $client;
    private $googleSheetService;

    public function __construct()
    {
        $this->spreadSheetId = env('GOOGLE_SHEET_ID');

        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('json/google-sheet.json'));
        $this->client->addScope("https://www.googleapis.com/auth/spreadsheets");

        $this->googleSheetService = new Google_Service_Sheets($this->client);
    }

    public function getData($sheet, $index)
    {

        $index = $index + 1;

        $range = 'Sheet' . $sheet . '!A' . $index . ':C' . $index;

        $data = $this->googleSheetService
            ->spreadsheets_values
            ->batchGet($this->spreadSheetId, ['ranges' => $range]);

        return $data->getValueRanges()[0]->values;
    }

    public function saveData($sheet, $data)
    {
        $body = new Google_Service_Sheets_ValueRange([
            'values' => $data
        ]);

        $range = 'Sheet' . $sheet;

        $params = [
            'valueInputOption' => 'RAW',
        ];

        $insert = [
            'insertDataOption' => "INSERT_ROWS",
        ];

        return $this->googleSheetService->spreadsheets_values->append($this->spreadSheetId, $range, $body, $params, $insert);
    }
}
