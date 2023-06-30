<?php

namespace App\Controllers\Modulos;

use App\Controllers\BaseController;
use App\Libraries\Pagination;
use Config\Database;

class FaturasDuplicadas extends BaseController
{
    public function index()
    {
        $db = Database::connect('whmcsDb');
        $builder = $db->table('tblinvoices');
        $yearAndMonth = (new \DateTime())->format('Y-m');

        // SELECT `tblinvoices`.*, `tblinvoices`.`id` AS `inv_id`, `cli`.`id` AS `cli_id` FROM `tblinvoices` INNER JOIN `tblclients` as `cli` ON `cli`.`id` = `tblinvoices`.`userid` WHERE `tblinvoices`.`date` LIKE '2023-06%' ESCAPE '!';
        $builder->select('tblinvoices.*, tblinvoices.id AS inv_id, cli.id AS cli_id, cli.firstname,
        cli.lastname, cli.companyname');
        $builder->like('tblinvoices.date', $yearAndMonth, 'after');
        $builder->join('tblclients as cli', 'cli.id = tblinvoices.userid', 'inner');
        $invoices = $builder->get()->getResult();

        // Encontrar os cli_id duplicados
        $cliIds = [];
        $duplicateCliIds = [];

        foreach ($invoices as $invoice) {
            if (in_array($invoice->cli_id, $cliIds)) {
                $duplicateCliIds[] = $invoice->cli_id;
            } else {
                $cliIds[] = $invoice->cli_id;
            }
        }

        // Filtrar as invoices com cli_id duplicado
        $filteredInvoices = array_filter($invoices, function ($invoice) use ($duplicateCliIds) {
            return in_array($invoice->cli_id, $duplicateCliIds);
        });

        // Remover duplicatas mantendo apenas a primeira ocorrência de cada cli_id duplicado
        $filteredInvoices = array_reduce($filteredInvoices, function ($carry, $invoice) {
            if (!isset($carry[$invoice->cli_id])) {
                $carry[$invoice->cli_id] = $invoice;
            }
            return $carry;
        }, []);

        // Obter todas as propriedades das invoices filtradas
        $filteredInvoiceProperties = array_map(function ($invoice) {
            return get_object_vars($invoice);
        }, $filteredInvoices);

        $pagination = new Pagination;

        $pagination->setTotalItems(count($filteredInvoiceProperties));
        $pagination->setItemsPerPage(15);
        $pagination->dump();

        $filteredInvoiceProperties = array_slice($filteredInvoiceProperties, $pagination->dump()['offset'], $pagination->dump()['itemsPerPage']);

        return view('home', ['bodyClean' => true, 'moduleName' => 'Faturas Duplicadas', 'invoices' => $filteredInvoiceProperties, 'pagination' => $pagination, 'routeToNameTitle' => 'home']);
    }
}
