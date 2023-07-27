<?php

namespace App\Services;

use App\Repositories\Contracts\DesignerSectionRepositoryContract;
use App\Services\Contracts\DesignerSectionServiceContract;

class DesignerSectionService implements DesignerSectionServiceContract
{
    protected $designer_section_contract;
    public function __construct(DesignerSectionRepositoryContract $designer_section_contract)
    {
        $this->designer_section_contract = $designer_section_contract;
    }
    public function store($data)
    {
        return $this->designer_section_contract->store($data);
    }
    public function update($id, $data)
    {
        return $this->designer_section_contract->update($id, $data);
    }
    // public function loadCountRequestResult($data)
    // {
    //     $result = $this->designer_section_contract->loadCountRequestResult($data);

    //     $data_count = [];
    //     $hinsei_ok = 0;
    //     $hinsei_ng = 0;
    //     $lsa_ok = 0;
    //     $lsa_ng = 0;
    //     foreach ($result as $count) {
    //         $data_count = [$count['request_result']];
    //         foreach ($data_count as $count_request_result) {
    //             if ($count_request_result === "Hinsei OK") {
    //                 $hinsei_ok += 1;
    //             } elseif ($count_request_result === "Hinsei NG") {
    //                 $hinsei_ng += 1;
    //             } elseif ($count_request_result === "LSA OK") {
    //                 $lsa_ok += 1;
    //             } elseif ($count_request_result === "LSA NG") {
    //                 $lsa_ng += 1;
    //             }
    //         }
    //     }
    //     $datastorage_count_request[] = [
    //         'hinsei_ok' => $hinsei_ok,
    //         'hinsei_ng' => $hinsei_ng,
    //         'lsa_ok' => $lsa_ok,
    //         'lsa_ng' => $lsa_ng,
    //     ];
    //     return $datastorage_count_request;
    // }
}
