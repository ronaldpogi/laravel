<?php

namespace App\Repositories;

use App\Models\Campaign;
use Illuminate\Support\Facades\Log;
use App\Interfaces\BidRequestRepositoryInterface;

class BidRequestRepository implements BidRequestRepositoryInterface {

    protected $dimensionArray;

    public function __construct() {
        $this->dimensionArray = [];
    }

    public function extractDimension(array $data): array {
        
        foreach ($data as $key => $imp) {
            foreach ($imp['banner']['format'] as $formats) {
                array_push($this->dimensionArray, "{$formats['w']}X{$formats['h']}");
                 
            }
        }
        Log::alert($this->dimensionArray);

        return $this->dimensionArray;
    }

    public function compareWithCampaign(array $data): mixed {

        return $campaign = Campaign::osWiseFilter($data['device']['os'])
        ->deviceModelWiseFilter($data['device']['model'])
        ->countryWiseFilter($data['device']['geo']['country'])
        ->cityWiseFilter($data['device']['geo']['city'])
        ->appNameWiseFilter($data['app']['name'])
        ->dimensionWiseFilter($this->extractDimension($data['imp']))
        ->first();
    }
}