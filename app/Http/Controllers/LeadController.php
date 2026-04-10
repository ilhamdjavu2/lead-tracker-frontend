<?php

namespace App\Http\Controllers;

use App\Services\Api\LeadApiService;
use Illuminate\Http\Request;

class LeadController extends Controller
{
	protected $service;

    public function __construct(LeadApiService $service)
    {
        $this->service = $service;
    }
	 
    public function index()
    {
        return view('leads.index');
    }
	
	public function loaddtleads(Request $request)
    {
		$columns = $request->input('columns', []);

		$filters = [];

		foreach ($columns as $col) {
			$key = $col['data'] ?? null;
			$value = $col['search']['value'] ?? null;

			if ($key && $value !== null && $value !== '') {
				$filters[$key] = $value;
			}
		}

		$params = array_merge($filters, [
			'start'  => $request->input('start', 0),
			'length' => $request->input('length', 10)
		]);
		
        return $this->service->datatable($params);
    }
	
	public function leadform(Request $request){
		$dataid = $request->dataid;
		$dataaction = $request->dataaction;
		
		return view('leads.leadform', [
			'dataid'=>$dataid,
			'dataaction'=>$dataaction
		]);
    }
	
	public function store(Request $request){
		return $this->service->store($request->all());
    }
	
	public function update(Request $request, $id)
    {
        return $this->service->update($id, $request->all());
    }
	
	public function delete($id)
    {
        return $this->service->delete($id);
    }
}
