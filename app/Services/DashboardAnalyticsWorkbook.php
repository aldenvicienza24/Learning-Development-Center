<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DashboardAnalyticsWorkbook
{
    public function build(array $analytics): Spreadsheet
    {
        $spreadsheet = new Spreadsheet;
        $spreadsheet->getProperties()
            ->setCreator('UISI Pusat Sertifikasi')
            ->setTitle('Dasbor Visualisasi Data UISI')
            ->setSubject("Periode {$analytics['filters']['start_date']} sampai {$analytics['filters']['end_date']}");

        $dashboard = $spreadsheet->getActiveSheet();
        $dashboard->setTitle('Dasbor Grafik');
        $data = $spreadsheet->createSheet()->setTitle('Data Grafik');
        $programSheet = $spreadsheet->createSheet()->setTitle('Per Pelatihan');
        $periodSheet = $spreadsheet->createSheet()->setTitle('Tren Bulanan');
        $this->fillChartData($data, $analytics);
        $this->fillPrograms($programSheet, $analytics);
        $this->fillPeriods($periodSheet, $analytics);
        $this->fillDashboard($dashboard, $analytics);

        $spreadsheet->setActiveSheetIndex(0);

        return $spreadsheet;
    }

    private function fillDashboard(Worksheet $sheet, array $analytics): void
    {
        $sheet->setShowGridlines(false);
        $sheet->getSheetView()->setZoomScale(80);
        foreach (range('A', 'Q') as $column) {
            $sheet->getColumnDimension($column)->setWidth(12);
        }

        $sheet->mergeCells('A1:Q1')->setCellValue('A1', 'DASBOR VISUALISASI DATA UISI');
        $sheet->mergeCells('A2:Q2')->setCellValue(
            'A2',
            'Periode '.CarbonImmutable::parse($analytics['filters']['start_date'])->translatedFormat('d M Y')
            .' sampai '.CarbonImmutable::parse($analytics['filters']['end_date'])->translatedFormat('d M Y')
            .' · Data mengikuti filter aktif'
        );
        $sheet->getStyle('A1:Q2')->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '6D1F33']],
            'font' => ['color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(20);
        $sheet->getStyle('A2')->getFont()->setSize(11)->getColor()->setRGB('F5DDE4');
        $sheet->getRowDimension(1)->setRowHeight(34);
        $sheet->getRowDimension(2)->setRowHeight(24);

        $sheet->mergeCells('A3:B3')->setCellValue('A3', 'Pilih pelatihan');
        $sheet->mergeCells('C3:H3')->setCellValue('C3', 'Semua pelatihan');
        $sheet->mergeCells('I3:Q3')->setCellValue('I3', 'Gunakan dropdown untuk memperbarui KPI dan seluruh grafik secara otomatis.');
        $sheet->getStyle('A3:B3')->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E9D8DE']],
            'font' => ['bold' => true, 'color' => ['rgb' => '6D1F33']],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getStyle('C3:H3')->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
            'font' => ['bold' => true, 'color' => ['rgb' => '273242']],
            'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CBB5BD']]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getStyle('I3:Q3')->applyFromArray([
            'font' => ['italic' => true, 'color' => ['rgb' => '687383']],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $validation = $sheet->getCell('C3')->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST)
            ->setErrorStyle(DataValidation::STYLE_STOP)
            ->setAllowBlank(false)
            ->setShowInputMessage(true)
            ->setShowErrorMessage(true)
            ->setShowDropDown(true)
            ->setErrorTitle('Pilihan tidak tersedia')
            ->setError('Pilih pelatihan dari daftar yang tersedia.')
            ->setPromptTitle('Filter dasbor')
            ->setPrompt('Pilih Semua pelatihan atau salah satu pelatihan.')
            ->setFormula1('=ProgramList');
        $sheet->getRowDimension(3)->setRowHeight(27);

        $programLastRow = max(2, count($analytics['programs']) + 2);
        $cards = [
            ['A4:D4', 'A5:D5', 'Jumlah pendaftar', "=IFERROR(INDEX('Data Grafik'!\$L\$2:\$L\$$programLastRow,MATCH(\$C\$3,'Data Grafik'!\$K\$2:\$K\$$programLastRow,0)),0)", false, false],
            ['E4:H4', 'E5:H5', 'Kapasitas', "=IFERROR(INDEX('Data Grafik'!\$M\$2:\$M\$$programLastRow,MATCH(\$C\$3,'Data Grafik'!\$K\$2:\$K\$$programLastRow,0)),0)", false, false],
            ['I4:L4', 'I5:L5', 'Tingkat minat', "=IFERROR(INDEX('Data Grafik'!\$N\$2:\$N\$$programLastRow,MATCH(\$C\$3,'Data Grafik'!\$K\$2:\$K\$$programLastRow,0)),0)", false, true],
            ['M4:Q4', 'M5:Q5', 'Pendapatan diterima', "=IFERROR(INDEX('Data Grafik'!\$O\$2:\$O\$$programLastRow,MATCH(\$C\$3,'Data Grafik'!\$K\$2:\$K\$$programLastRow,0)),0)", true, false],
        ];
        foreach ($cards as [$labelRange, $valueRange, $label, $value, $currency, $percentage]) {
            $sheet->mergeCells($labelRange)->mergeCells($valueRange);
            $labelCell = explode(':', $labelRange)[0];
            $valueCell = explode(':', $valueRange)[0];
            $sheet->setCellValue($labelCell, $label)->setCellValue($valueCell, $value);
            $cardStyle = [
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8F4F5']],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E3D7DB']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ];
            $sheet->getStyle($labelRange)->applyFromArray($cardStyle);
            $sheet->getStyle($valueRange)->applyFromArray($cardStyle);
            $sheet->getStyle($labelCell)->getFont()->setBold(true)->setSize(10)->getColor()->setRGB('6A5960');
            $sheet->getStyle($valueCell)->getFont()->setBold(true)->setSize(18)->getColor()->setRGB('8F2941');
            if ($currency) {
                $sheet->getStyle($valueCell)->getNumberFormat()->setFormatCode('"Rp" #,##0');
            }
            if ($percentage) {
                $sheet->getStyle($valueCell)->getNumberFormat()->setFormatCode('0.0"%"');
            }
        }
        $sheet->getRowDimension(4)->setRowHeight(22);
        $sheet->getRowDimension(5)->setRowHeight(34);

        $this->addChart($sheet, 'registrations', 'Jumlah pendaftar per pelatihan', DataSeries::TYPE_BARCHART,
            DataSeries::DIRECTION_BAR, 'B', 'A', 5, 'A7', 'H22', 'A92B45', 'Jumlah pendaftar', true);
        $this->addChart($sheet, 'popularity', 'Pelatihan paling diminati', DataSeries::TYPE_BARCHART,
            DataSeries::DIRECTION_BAR, 'D', 'C', 5, 'J7', 'Q22', 'D46638', '% dari kapasitas', true);
        $this->addChart($sheet, 'revenue_trend', 'Pendapatan per bulan', DataSeries::TYPE_LINECHART,
            DataSeries::DIRECTION_COL, 'F', 'E', $this->sourceRowCount($sheet->getParent()->getSheetByName('Data Grafik'), 'E'), 'A24', 'H39', '237567', 'Pendapatan (Rp)');
        $this->addChart($sheet, 'program_revenue', 'Pendapatan per pelatihan', DataSeries::TYPE_BARCHART,
            DataSeries::DIRECTION_BAR, 'H', 'G', 5, 'J24', 'Q39', '237567', 'Pendapatan (Rp)');

        $sheet->mergeCells('A41:Q41')->setCellValue('A41', 'Interaktif: ubah dropdown C3 untuk memilih pelatihan. Periode dan status tetap mengikuti filter web saat file diunduh.');
        $sheet->getStyle('A41')->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('6A7482');
    }

    private function fillChartData(Worksheet $sheet, array $analytics): void
    {
        $headers = ['Program', 'Pendaftar', 'Program', 'Minat (%)', 'Bulan', 'Pendapatan', 'Program', 'Pendapatan'];
        $sheet->fromArray($headers, null, 'A1');

        $registrations = $this->topPrograms($analytics['programs'], 'registrations');
        $popularity = array_values(array_filter($analytics['programs'], fn (array $row): bool => ($row['capacity'] ?? 0) > 0 && ($row['registrations'] ?? 0) > 0));
        usort($popularity, fn (array $a, array $b): int => ($b['popularity_rate'] <=> $a['popularity_rate']) ?: strcmp($a['title'], $b['title']));
        $popularity = array_slice($popularity, 0, 5);
        $revenue = $this->topPrograms($analytics['programs'], 'actual_revenue');
        $registrations = $registrations ?: [['title' => 'Belum ada data', 'registrations' => 0]];
        $popularity = $popularity ?: [['title' => 'Belum ada data', 'popularity_rate' => 0]];
        $revenue = $revenue ?: [['title' => 'Belum ada data', 'actual_revenue' => 0]];
        $periods = $analytics['periods'] ?: [['start_date' => $analytics['filters']['start_date'], 'actual_revenue' => 0]];

        $programLabels = $this->programLabels($analytics['programs']);
        $programLastRow = max(3, count($analytics['programs']) + 2);
        $namedRangeLastRow = max(2, count($analytics['programs']) + 2);
        $selector = "'Dasbor Grafik'!\$C\$3";

        $sheet->fromArray(['Pilihan pelatihan', 'Pendaftar', 'Kapasitas', 'Minat (%)', 'Pendapatan'], null, 'K1');
        $sheet->fromArray([
            'Semua pelatihan',
            $analytics['summary']['registrations'] ?? 0,
            $analytics['summary']['capacity'] ?? 0,
            ($analytics['summary']['capacity'] ?? 0) > 0
                ? round(($analytics['summary']['registrations'] ?? 0) / $analytics['summary']['capacity'] * 100, 1)
                : 0,
            $analytics['summary']['actual_revenue'] ?? 0,
        ], null, 'K2');
        foreach (array_values($analytics['programs']) as $index => $program) {
            $sheet->fromArray([
                $programLabels[$program['id']], $program['registrations'], $program['capacity'],
                $program['popularity_rate'] ?? 0, $program['actual_revenue'],
            ], null, 'K'.($index + 3));
        }
        $sheet->getParent()->addNamedRange(new NamedRange('ProgramList', $sheet, "\$K\$2:\$K\$$namedRangeLastRow"));

        $sheet->fromArray(['Program', 'Periode', 'Pendaftar', 'Pendapatan'], null, 'Q1');
        foreach (array_values($analytics['program_periods'] ?? []) as $index => $period) {
            $sheet->fromArray([
                $programLabels[$period['program_id']] ?? $period['title'],
                CarbonImmutable::parse($period['start_date'])->translatedFormat('M Y'),
                $period['registrations'], $period['actual_revenue'],
            ], null, 'Q'.($index + 2));
        }
        $programPeriodLastRow = max(2, count($analytics['program_periods'] ?? []) + 1);

        $sheet->fromArray(['Top pendaftar', 'Nilai', 'Top minat', 'Nilai', 'Top pendapatan', 'Nilai', 'Periode total', 'Nilai'], null, 'V1');
        for ($index = 0; $index < 5; $index++) {
            $row = $index + 2;
            $registration = $registrations[$index] ?? null;
            $popular = $popularity[$index] ?? null;
            $income = $revenue[$index] ?? null;
            $sheet->fromArray([
                $registration ? ($programLabels[$registration['id'] ?? null] ?? $registration['title']) : '',
                $registration['registrations'] ?? null,
                $popular ? ($programLabels[$popular['id'] ?? null] ?? $popular['title']) : '',
                $popular['popularity_rate'] ?? null,
                $income ? ($programLabels[$income['id'] ?? null] ?? $income['title']) : '',
                $income['actual_revenue'] ?? null,
            ], null, "V$row");
        }

        for ($index = 0; $index < 5; $index++) {
            $row = $index + 2;
            if ($index === 0) {
                $sheet->setCellValue("A$row", "=IF($selector=\"Semua pelatihan\",V$row,$selector)")
                    ->setCellValue("B$row", "=IF($selector=\"Semua pelatihan\",W$row,IFERROR(INDEX(\$L\$3:\$L\$$programLastRow,MATCH($selector,\$K\$3:\$K\$$programLastRow,0)),0))")
                    ->setCellValue("C$row", "=IF($selector=\"Semua pelatihan\",X$row,$selector)")
                    ->setCellValue("D$row", "=IF($selector=\"Semua pelatihan\",Y$row,IFERROR(INDEX(\$N\$3:\$N\$$programLastRow,MATCH($selector,\$K\$3:\$K\$$programLastRow,0)),0))")
                    ->setCellValue("G$row", "=IF($selector=\"Semua pelatihan\",Z$row,$selector)")
                    ->setCellValue("H$row", "=IF($selector=\"Semua pelatihan\",AA$row,IFERROR(INDEX(\$O\$3:\$O\$$programLastRow,MATCH($selector,\$K\$3:\$K\$$programLastRow,0)),0))");
            } else {
                $sheet->setCellValue("A$row", "=IF($selector=\"Semua pelatihan\",V$row,\"\")")
                    ->setCellValue("B$row", "=IF($selector=\"Semua pelatihan\",W$row,NA())")
                    ->setCellValue("C$row", "=IF($selector=\"Semua pelatihan\",X$row,\"\")")
                    ->setCellValue("D$row", "=IF($selector=\"Semua pelatihan\",Y$row,NA())")
                    ->setCellValue("G$row", "=IF($selector=\"Semua pelatihan\",Z$row,\"\")")
                    ->setCellValue("H$row", "=IF($selector=\"Semua pelatihan\",AA$row,NA())");
            }
        }
        foreach (array_values($periods) as $index => $period) {
            $row = $index + 2;
            $periodLabel = CarbonImmutable::parse($period['start_date'])->translatedFormat('M Y');
            $sheet->setCellValue("AB$row", $periodLabel)
                ->setCellValue("AC$row", $period['actual_revenue'])
                ->setCellValue("E$row", "=AB$row")
                ->setCellValue("F$row", "=IF($selector=\"Semua pelatihan\",AC$row,SUMIFS(\$T\$2:\$T\$$programPeriodLastRow,\$Q\$2:\$Q\$$programPeriodLastRow,$selector,\$R\$2:\$R\$$programPeriodLastRow,E$row))");
        }

        $sheet->freezePane('A2');
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setWidth(in_array($column, ['A', 'C', 'G'], true) ? 34 : 18);
        }
        $sheet->getStyle('A1:H1')->applyFromArray($this->headerStyle('7D2037'));
        $sheet->getStyle('K1:O1')->applyFromArray($this->headerStyle('6A7482'));
        $sheet->getStyle('Q1:T1')->applyFromArray($this->headerStyle('6A7482'));
        $sheet->getStyle('V1:AC1')->applyFromArray($this->headerStyle('6A7482'));
        $sheet->getStyle('F2:F'.max(2, count($periods) + 1))->getNumberFormat()->setFormatCode('"Rp" #,##0');
        $sheet->getStyle('H2:H6')->getNumberFormat()->setFormatCode('"Rp" #,##0');
        $sheet->getStyle("O2:O$programLastRow")->getNumberFormat()->setFormatCode('"Rp" #,##0');
        $sheet->getStyle("T2:T$programPeriodLastRow")->getNumberFormat()->setFormatCode('"Rp" #,##0');
        $sheet->getStyle('AA2:AA6')->getNumberFormat()->setFormatCode('"Rp" #,##0');
        $sheet->getStyle('AC2:AC'.max(2, count($periods) + 1))->getNumberFormat()->setFormatCode('"Rp" #,##0');
        foreach (range('K', 'Z') as $column) {
            $sheet->getColumnDimension($column)->setVisible(false);
        }
        foreach (['AA', 'AB', 'AC'] as $column) {
            $sheet->getColumnDimension($column)->setVisible(false);
        }
    }

    private function fillPrograms(Worksheet $sheet, array $analytics): void
    {
        $headers = ['Pelatihan', 'Kategori', 'Harga', 'Pendaftar', 'Kapasitas', 'Minat (%)', 'Disetujui', 'Menunggu bayar', 'Menunggu verifikasi', 'Ditolak', 'Peserta diterima', 'Pembayaran diterima', 'Nominal belum lengkap', 'Pendapatan'];
        $sheet->fromArray($headers, null, 'A1');
        foreach (array_values($analytics['programs']) as $index => $program) {
            $payments = (array) $program['payments'];
            $participants = (array) $program['participants'];
            $sheet->fromArray([[
                $program['title'], $program['category'], $program['price'], $program['registrations'], $program['capacity'], $program['popularity_rate'],
                $program['approved'], $payments['menunggu_pembayaran'] ?? 0, $payments['menunggu_verifikasi'] ?? 0,
                $payments['ditolak'] ?? 0, $participants['diterima'] ?? 0, $program['receipt_count'],
                $program['missing_receipts'], $program['actual_revenue'],
            ]], null, 'A'.($index + 2));
        }
        $lastRow = max(2, count($analytics['programs']) + 1);
        $sheet->getStyle('A1:N1')->applyFromArray($this->headerStyle('7D2037'));
        $sheet->getStyle("C2:C$lastRow")->getNumberFormat()->setFormatCode('"Rp" #,##0');
        $sheet->getStyle("N2:N$lastRow")->getNumberFormat()->setFormatCode('"Rp" #,##0');
        $sheet->setAutoFilter("A1:N$lastRow")->freezePane('A2');
        $sheet->getColumnDimension('A')->setWidth(38);
        foreach (range('B', 'N') as $column) {
            $sheet->getColumnDimension($column)->setWidth(18);
        }
    }

    private function fillPeriods(Worksheet $sheet, array $analytics): void
    {
        $headers = ['Periode mulai', 'Periode akhir', 'Pendaftar', 'Disetujui', 'Menunggu', 'Pembayaran diterima', 'Pendapatan'];
        $sheet->fromArray($headers, null, 'A1');
        foreach (array_values($analytics['periods']) as $index => $period) {
            $sheet->fromArray([[
                $period['start_date'], $period['end_date'], $period['registrations'], $period['approved'],
                $period['pending'], $period['receipt_count'], $period['actual_revenue'],
            ]], null, 'A'.($index + 2));
        }
        $lastRow = max(2, count($analytics['periods']) + 1);
        $sheet->getStyle('A1:G1')->applyFromArray($this->headerStyle('237567'));
        $sheet->getStyle("G2:G$lastRow")->getNumberFormat()->setFormatCode('"Rp" #,##0');
        $sheet->setAutoFilter("A1:G$lastRow")->freezePane('A2');
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setWidth(20);
        }
    }

    private function addChart(Worksheet $sheet, string $name, string $title, string $type, string $direction,
        string $valueColumn, string $categoryColumn, int $count, string $topLeft, string $bottomRight,
        string $color, string $axisTitle, bool $showValues = false): void
    {
        $count = max(1, $count);
        $lastRow = $count + 1;
        $dataSheet = "'Data Grafik'";
        $labels = [new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "$dataSheet!\$$valueColumn\$1", null, 1)];
        $categories = [new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "$dataSheet!\$$categoryColumn\$2:\$$categoryColumn\$$lastRow", null, $count)];
        $values = [new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, "$dataSheet!\$$valueColumn\$2:\$$valueColumn\$$lastRow", null, $count, [], $type === DataSeries::TYPE_LINECHART ? 'circle' : null, $color)];
        $values[0]->setLineWidth(2.5);
        $series = new DataSeries($type, DataSeries::GROUPING_STANDARD, [0], $labels, $categories, $values, $direction, false,
            $type === DataSeries::TYPE_LINECHART ? DataSeries::STYLE_LINEMARKER : null);
        $layout = new Layout(['showVal' => $showValues, 'dLblPos' => $direction === DataSeries::DIRECTION_BAR ? 'outEnd' : 't']);
        $chart = new Chart($name, new Title($title), null, new PlotArea($layout, [$series]), false, DataSeries::EMPTY_AS_ZERO,
            $type === DataSeries::TYPE_BARCHART ? new Title($axisTitle) : null,
            $type === DataSeries::TYPE_LINECHART ? new Title($axisTitle) : null);
        $chart->setTopLeftPosition($topLeft)->setBottomRightPosition($bottomRight)->setRoundedCorners(true);
        $sheet->addChart($chart);
    }

    private function topPrograms(array $programs, string $field): array
    {
        $rows = array_values(array_filter($programs, fn (array $row): bool => ($row[$field] ?? 0) > 0));
        usort($rows, fn (array $a, array $b): int => ($b[$field] <=> $a[$field]) ?: strcmp($a['title'], $b['title']));

        return array_slice($rows, 0, 5);
    }

    private function programLabels(array $programs): array
    {
        $titleCounts = array_count_values(array_column($programs, 'title'));
        $labels = [];
        foreach ($programs as $program) {
            $labels[$program['id']] = ($titleCounts[$program['title']] ?? 0) > 1
                ? "{$program['title']} (#{$program['id']})"
                : $program['title'];
        }

        return $labels;
    }

    private function sourceRowCount(?Worksheet $sheet, string $column): int
    {
        if (! $sheet) {
            return 1;
        }

        $row = 2;
        while ($sheet->getCell("$column$row")->getValue() !== null && $sheet->getCell("$column$row")->getValue() !== '') {
            $row++;
        }

        return max(1, $row - 2);
    }

    private function headerStyle(string $color): array
    {
        return [
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $color]],
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ];
    }
}
