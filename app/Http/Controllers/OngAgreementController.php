<?php

namespace App\Http\Controllers;

use App\Models\OngAgreement;
use App\Http\Requests\StoreOngAgreementRequest;
use App\Http\Requests\UpdateOngAgreementRequest;

class OngAgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOngAgreementRequest $request)
    {
        $ongAgreement = new OngAgreement();

        $data = $request->validated();
        $data['ong_id'] = session('ong_id');
        $ongAgreement->create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(OngAgreement $ongAgreement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OngAgreement $ongAgreement)
    {
        return view('app.ong-agreement.edit', [
            'ongAgreement' => $ongAgreement,
            'my_fields' => $this->ongAgreementFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOngAgreementRequest $request, OngAgreement $ongAgreement)
    {
        $ongAgreement->fill($request->validated());
        $ongAgreement->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OngAgreement $ongAgreement)
    {
        try {
            $ongAgreement = $ongAgreement->delete();
            return back();
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    private function ongAgreementFields()
    {
        $fields = [
            'agreement' => [
                'title' => "Agrément",
                'placeholder' => 'Sélectionnez le fichier de l\'agrement',
                'field' => 'file',
                'required' => true,
                'required_on_edit' => true,
            ],
            'num_agreement' => [
                'title' => "N° Agrément",
                'placeholder' => 'Entrez le numéro de l\'agrement',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
            'obtainment_date' => [
                'title' => "Date d'obtention",
                'placeholder' => '',
                'field' => 'date',
                'required' => true,
                'required_on_edit' => true,
            ],
            'expiration_date' => [
                'title' => "Date d'expiration",
                'placeholder' => '',
                'field' => 'date',
                'required' => true,
                'required_on_edit' => true,
            ],
            'detail' => [
                'title' => "Observation supplémentaire",
                'placeholder' => 'Optionnel',
                'field' => 'text',
                'required' => false,
                'required_on_edit' => false,
            ],
        ];
        return $fields;
    }
}
