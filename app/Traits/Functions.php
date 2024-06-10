<?php

namespace App\Traits;

use Carbon\Carbon;
use TCPDF;

/**
 * Trait UploadAble
 * @package App\Traits
 */
trait Functions
{
    public function str_split(string $str, int $len = 1)
    {
        $arr = [];
        $length = mb_strlen($str, 'UTF-8');
        for ($i = 0; $i < $length; $i += $len) {
            $arr[] = mb_substr($str, $i, $len, 'UTF-8');
        }
        return $arr[0];
    }

    public function updateEnv($data = [])
    {
        if (! count($data)) {
            return;
        }
        $pattern = '/([^\=]*)\=[^\n]*/';
        $envFile = base_path() . '/.env';
        $lines = file($envFile);
        $newLines = [];
        foreach ($lines as $line) {
            preg_match($pattern, $line, $matches);

            if (! count($matches)) {
                $newLines[] = $line;
                continue;
            }

            if (! key_exists(trim($matches[1]), $data)) {
                $newLines[] = $line;
                continue;
            }

            $line = trim($matches[1]) . "={$data[trim($matches[1])]}\n";
            $newLines[] = $line;
        }
        $newContent = implode('', $newLines);
        file_put_contents($envFile, $newContent);
    }

    public function loadContractInfoObserver($attracting, $team_rank_item, $logo, $today_day_arabic, $project_title, $preview_pdf)
    {
        return view('pages.contracts.observer', [
            'div_class' => 'divContractPreview',
            'user' => $attracting,
            'typeTd' => 5,
            'logo' => $logo,
            'team_rank_item' => $team_rank_item,
            'today_day_arabic' => $today_day_arabic,
            'project_title' => $project_title,
            'preview_pdf' => $preview_pdf,
        ])->render();
    }

    public function loadContractInfo($attracting, $team_rank_item, $logo, $team_rank_type_trans, $today_day_arabic, $project_title, $preview_pdf, $contract_research_items)
    {
        return view('pages.contracts.index', [
            'div_class' => 'divContractPreview',
            'attracting' => $attracting,
            'team_rank_item' => $team_rank_item,
            'typeTd' => $attracting->type_id,
            'logo' => $logo,
            'team_rank_type_trans' => $team_rank_type_trans,
            'today_day_arabic' => $today_day_arabic,
            'project_title' => $project_title,
            'preview_pdf' => $preview_pdf,
            'contract_research_items' => $contract_research_items ?? '',
        ])->render();
    }

    public function generateContract($html, $team_rank_type_trans)
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $lg = [];
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';

        // set some language-dependent strings (optional)
        $pdf->setLanguageArray($lg);
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, [0, 64, 255], [0, 64, 128]);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once dirname(__FILE__) . '/lang/eng.php';
            $pdf->setLanguageArray($l);
        }
        $pdf->setLanguageArray($lg);
        $pdf->setRTL(true);
        $pdf->SetFont(\TCPDF_FONTS::addTTFfont('assets/fonts/Sakkal Majalla Bold.ttf', 'TrueTypeUnicode', '', 100), 'B');
        $pdf->SetPrintHeader(false);
        $pdf->AddPage();
        $pdf_file_name = 'contract-' . time() . '-' . Carbon::now()->format('d-m-Y') . '.pdf';
        $pdf->writeHTML($html, $ln = false, $fill = false, $reseth = false, $cell = false, $align = '');

        $data['upload'] = $pdf->Output(public_path('contracts') . '/' . $pdf_file_name, 'F');
        $data['contract_url'] = $pdf_file_name;
        return $data;
    }

    public function getRedFlagRepies($object)
    {

    }

    public function getRedFlagAttachments($object)
    {
    }
}