<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Illuminate\Contracts\View\View;

class CurrencyRateController extends Controller
{
    public function scrapeAndStore()
    {
        try {
            // Fetch the webpage
            $response = Http::get('https://www.smartdeal.co.id/rates/dki_banten');
            if (!$response->successful()) {
                throw new \Exception('Gagal mengambil data dari website.');
            }
            $html = $response->body();

            // Create DOM document with proper encoding
            $dom = new DOMDocument('1.0', 'UTF-8');
            libxml_use_internal_errors(true);
            $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();

            $xpath = new DOMXPath($dom);

            // Get last update time
            $lastUpdateText = $xpath->evaluate('string(//div[@class="time"]/p)');
            $lastUpdate     = $this->parseLastUpdate($lastUpdateText);

            // Find all currency rows
            $rows = $xpath->query("//div[@id='tablerates']//table[@id='tableExchange']//tr[@class='body']");
            if (!$rows || $rows->length === 0) {
                throw new \Exception('Tidak dapat menemukan data kurs mata uang.');
            }

            // Clear existing data
            CurrencyRate::truncate();

            $rates           = [];
            $currentCurrency = null;

            foreach ($rows as $row) {
                $cells = $xpath->query(".//td", $row);

                // Skip rows with insufficient cells
                if ($cells->length < 4) continue;

                // Check if the first cell contains currency code
                $kodenegaraCell = $cells->item(0);
                if ($kodenegaraCell && trim($kodenegaraCell->textContent)) {
                    // Extract currency code from the cell
                    $currentCurrency = trim(preg_replace('/\s+/', '', $kodenegaraCell->textContent));
                }

                // Skip if no current currency is set
                if (!$currentCurrency) continue;

                // Extract data from cells
                $denomination = trim($cells->item(1)->textContent);
                $buyRate      = $this->cleanRate($cells->item(2)->textContent);
                $sellRate     = $this->cleanRate($cells->item(3)->textContent);

                // Skip if sell rate is invalid
                if ($sellRate <= 0) continue;

                // Store in database
                $rates[] = [
                    'currency_code' => $currentCurrency,
                    'denomination'  => $denomination ?: null,
                    'buy_rate'      => $buyRate,
                    'sell_rate'     => $sellRate,
                    'last_update'   => $lastUpdate,
                    'created_at'    => now(),
                    'updated_at'    => now()
                ];
            }

            if (empty($rates)) {
                throw new \Exception('Tidak ada data yang berhasil di-scrape.');
            }

            // Bulk insert for better performance
            CurrencyRate::insert($rates);

            return response()->json([
                'success'     => true,
                'message'     => 'Data berhasil di-scrape dan disimpan',
                'last_update' => $lastUpdate,
                'total_data'  => count($rates),
                'data'        => $rates
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine()
            ], 500);
        }
    }
    private function parseLastUpdate(?string $lastUpdateText): Carbon
    {
        if (!$lastUpdateText) {
            return now();
        }

        try {
            return Carbon::createFromFormat('d M Y H:i:s', trim($lastUpdateText));
        } catch (\Exception $e) {
            return now();
        }
    }

    private function cleanRate(string $rate): float
    {
        $cleaned = preg_replace('/[^0-9,.]/', '', $rate);
        $cleaned = str_replace(',', '.', $cleaned);
        return (float) $cleaned ?: 0;
    }

    public function index(): View
    {
        $rates = CurrencyRate::all();
        return view('currency-rate.index', compact('rates'));
    }
}
