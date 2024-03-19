<?php

namespace App\Http\Controllers\Api\Doctors;

use App\Http\Controllers\Controller;
use App\Http\Resources\ComplainResource;
use App\Models\Complain;
use App\Traits\Helper;
use Illuminate\Http\Request;

class ComplainsController extends Controller
{
    use Helper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complains = Complain::paginate();
        $paginationData = $this->getPaginationData($complains);

        return $this->sendResponse(
          ComplainResource::collection($complains),
          'complains sent successfully',
            $paginationData
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
