<?php

namespace App\Controllers;

use App\Models\SaleModel;

class ReportsController extends AdminBaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $from  = $this->request->getGet('from') ?: date('Y-m-01');
        $to    = $this->request->getGet('to') ?: date('Y-m-d');
        $group = $this->request->getGet('group') ?: 'day';

        $db = db_connect();

        $totals = $db->table('sales')
            ->selectSum('total_price', 'revenue')
            ->selectSum('quantity', 'items')
            ->where('created_at >=', $from . ' 00:00:00')
            ->where('created_at <=', $to . ' 23:59:59')
            ->get()
            ->getRowArray();

        $revenue    = (float) ($totals['revenue'] ?? 0);
        $items_sold = (int) ($totals['items'] ?? 0);

        $groupExpr = match ($group) {
            'month' => "DATE_FORMAT(sales.created_at, '%Y-%m')",
            'week'  => 'YEARWEEK(sales.created_at, 1)',
            default => 'DATE(sales.created_at)',
        };

        $series = $db->query(
            "SELECT {$groupExpr} AS period, SUM(total_price) AS revenue, SUM(quantity) AS items
             FROM sales
             WHERE created_at >= ? AND created_at <= ?
             GROUP BY {$groupExpr}
             ORDER BY period ASC",
            [$from . ' 00:00:00', $to . ' 23:59:59']
        )->getResultArray();

        $byProduct = $db->table('sales')
            ->select('product_name, SUM(quantity) AS total_qty, SUM(total_price) AS total_rev')
            ->where('created_at >=', $from . ' 00:00:00')
            ->where('created_at <=', $to . ' 23:59:59')
            ->groupBy('product_name')
            ->orderBy('total_rev', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/pages/reports', [
            'page'       => 'reports',
            'title'      => 'Reports',
            'from'       => $from,
            'to'         => $to,
            'group'      => $group,
            'revenue'    => $revenue,
            'items_sold' => $items_sold,
            'series'     => $series,
            'by_product' => $byProduct,
        ]);
    }

    public function exportCsv()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $from = $this->request->getGet('from') ?: date('Y-m-01');
        $to   = $this->request->getGet('to') ?: date('Y-m-d');

        $rows = db_connect()->table('sales')
            ->select('id, product_id, product_name, quantity, unit_price, total_price, cashier_id, created_at')
            ->where('created_at >=', $from . ' 00:00:00')
            ->where('created_at <=', $to . ' 23:59:59')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        $filename = 'sales_' . $from . '_to_' . $to . '.csv';

        $this->response->setHeader('Content-Type', 'text/csv; charset=utf-8');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');

        $out = fopen('php://temp', 'r+');
        fputcsv($out, ['id', 'product_id', 'product_name', 'quantity', 'unit_price', 'total_price', 'cashier_id', 'created_at']);

        foreach ($rows as $r) {
            fputcsv($out, [
                $r['id'] ?? '',
                $r['product_id'] ?? '',
                $r['product_name'] ?? '',
                $r['quantity'] ?? '',
                $r['unit_price'] ?? '',
                $r['total_price'] ?? '',
                $r['cashier_id'] ?? '',
                $r['created_at'] ?? '',
            ]);
        }

        rewind($out);
        $csv = stream_get_contents($out);
        fclose($out);

        return $this->response->setBody($csv);
    }
}
