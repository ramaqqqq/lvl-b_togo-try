<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\FamilyList;


class UserController extends Controller
{

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'nationality_id' => 'required|exists:nationalities,nationality_id',
            ]);

            $customer = new Customer();
            $customer->cst_name = $request->input('nama');
            $customer->cst_dob = $request->input('tanggal_lahir');
            $customer->nationality_id = $request->input('nationality_id');
            $customer->save();

            $customerId = $customer->cst_id;

            $familyListData = $request->input('keluarga');

            foreach ($familyListData as $familyMemberData) {
                $familyMember = new FamilyList();
                $familyMember->fl_name = $familyMemberData['nama'];
                $familyMember->fl_dob = $familyMemberData['tanggal_lahir'];
                $familyMember->cst_id = $customerId;
                $familyMember->save();
            }
        
            return response()->json(['message' => 'Data has been successfully created'], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create data: ' . $e->getMessage()], 400);
        }
    }

    public function index()
    {
        $customers = Customer::all();

        $response = [];

        foreach ($customers as $customer) {
            $customerData = [
                'nama' => $customer->cst_name,
                'tanggal_lahir' => $customer->cst_dob,
                'nationality_id' => $customer->nationality_id,
                'keluarga' => [],
            ];

            $familyMembers = FamilyList::where('cst_id', $customer->cst_id)->get();

            foreach ($familyMembers as $familyMember) {
                $familyMemberData = [
                    'nama' => $familyMember->fl_name,
                    'tanggal_lahir' => $familyMember->fl_dob,
                ];

                $customerData['keluarga'][] = $familyMemberData;
            }

            $response[] = $customerData;
        }

        return response()->json($response, 200);
    }


    public function update(Request $request, $cst_id)
    {
        try {
            $request->validate([
                'nama' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'nationality_id' => 'required|exists:nationalities,nationality_id',
                'keluarga.*.nama' => 'required|string', 
                'keluarga.*.tanggal_lahir' => 'required|date', 
            ]);

            $customer = Customer::find($cst_id);

            if (!$customer) {
                return response()->json(['message' => 'Pelanggan tidak ditemukan'], 404);
            }

            $customer->cst_name = $request->input('nama');
            $customer->cst_dob = $request->input('tanggal_lahir');
            $customer->nationality_id = $request->input('nationality_id');
            $customer->save();

            $familyListData = $request->input('keluarga');

            foreach ($familyListData as $familyMemberData) {
                $familyMember = FamilyList::find($familyMemberData['fl_id']); 
                
                if (!$familyMember) {
                    $familyMember = new FamilyList();
                }

                $familyMember->fl_name = $familyMemberData['nama'];
                $familyMember->fl_dob = $familyMemberData['tanggal_lahir'];
                $familyMember->cst_id = $customer->cst_id; 
                $familyMember->save();
            }

            return response()->json(['message' => 'Data berhasil diperbarui'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui data: ' . $e->getMessage()], 400);
        }
    }


    public function delete($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            FamilyList::where('cst_id', $id)->delete();
            $customer->delete();

            return response()->json(['message' => 'Data has been successfully deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete data: ' . $e->getMessage()], 400);
        }
    }


}
