<?php

require_once 'config/database.php';
require_once 'app/models/DashboardModel.php';

class DashboardController
{
    private $model;

    public function __construct()
    {
        $this->model = new DashboardModel();
    }

    public function index()
    {
        // Busca os dados através do modelo
        $pedidos = $this->model->getPedidosInativos();
        $vendas = $this->model->getTotalVendas();
        $ganhos = $this->model->getTotalGanhos();

        // Passa os dados para a view
        include 'app/views/dashboard.php';
    }
} 