<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SaleModel;

class DashboardController extends AdminBaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $pModel = new ProductModel();
        $sModel = new SaleModel();
        $db     = db_connect();

        $products = $pModel->findAll();
        $sales    = $sModel->findAll();

        $revenue    = 0;
        $itemsSold  = 0;
        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd   = date('Y-m-d 23:59:59');

        $todayRevenue = 0;
        $todayItems   = 0;

        foreach ($sales as $s) {
            $revenue   += (float) ($s['total_price'] ?? 0);
            $itemsSold += (int) ($s['quantity'] ?? 0);

            $created = $s['created_at'] ?? null;
            if ($created && $created >= $todayStart && $created <= $todayEnd) {
                $todayRevenue += (float) ($s['total_price'] ?? 0);
                $todayItems   += (int) ($s['quantity'] ?? 0);
            }
        }

        $lowStockCount = 0;
        $lowStockItems = [];
        foreach ($products as $p) {
            if ((int) ($p['stock'] ?? 0) < 10) {
                $lowStockCount++;
                $lowStockItems[] = $p;
            }
        }

        $topSellers = $db->table('sales')
            ->select('product_name, SUM(quantity) AS qty')
            ->groupBy('product_name')
            ->orderBy('qty', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $chartLabels = [];
        $chartValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime("-{$i} days"));
            $chartLabels[] = date('M j', strtotime($d));

            $row = $db->table('sales')
                ->selectSum('total_price', 'rev')
                ->where('created_at >=', $d . ' 00:00:00')
                ->where('created_at <=', $d . ' 23:59:59')
                ->get()
                ->getRowArray();

            $chartValues[] = round((float) ($row['rev'] ?? 0), 2);
        }

        return view('admin/pages/dashboard', [
            'page'             => 'dashboard',
            'title'            => 'Dashboard',
            'revenue'          => $revenue,
            'items_sold'       => $itemsSold,
            'today_revenue'    => $todayRevenue,
            'today_items_sold' => $todayItems,
            'product_count'    => count($products),
            'low_stock_count'  => $lowStockCount,
            'low_stock_items'  => $lowStockItems,
            'top_sellers'      => $topSellers,
            'chart_labels'     => $chartLabels,
            'chart_values'     => $chartValues,
            'recent_sales'     => $sModel->orderBy('id', 'DESC')->findAll(5),
        ]);
    }
}
