<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{

    //  * Display a listing of the resource.
    public function index()
    {
        $transaction = Transaction::orderBy('time', 'DESC')->get();
        $response = [
            'message' => 'List transaction order by time',
            'data' => $transaction
        ];
        return response()->json($response, Response::HTTP_OK);
    }


    //  * Show the form for creating a new resource.
    public function create()
    {
        //
    }


    //  * Store a newly created resource in storage.
    public function store(Request $request)
    {
        //melakukan validasi terlebih dahulu
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'amount' => ['required', 'numeric'],
            'type' => ['required', 'in:expense,revenue']
        ]);
        //jika validator gagal akan memberikan respon error
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        //juka berhasil akan masuk fungsi try yg isinya create ke database dan kirim respon
        //kalau gagal akan masuk ke fungsi catch dan memberikan respon querry error
        try {
            $transaction = Transaction::create($request->all());
            $response = [
                'message' => 'Transaction Created Succesfully!',
                'data' => $transaction
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }

    //  * Display the specified resource.
    public function show($id)
    {
        //pengecekan kalo ada lanjut, kalo gaada akan dapat response 404
        $transaction = Transaction::findOrFail($id);
        //mengisi response
        $response = [
            'message' => 'Transaction Created Succesfully!',
            'data' => $transaction
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    //  * Show the form for editing the specified resource.
    public function edit($id)
    {
    }

    //  * Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        //pengecekan kalo ada lanjut, kalo gaada akan dapat response 404
        $transaction = Transaction::findOrFail($id);
        //melakukan validasi terlebih dahulu
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'amount' => ['required', 'numeric'],
            'type' => ['required', 'in:expense,revenue']
        ]);
        //jika validator gagal akan memberikan respon error
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        //juka berhasil akan masuk fungsi try yg isinya create ke database dan kirim respon
        //kalau gagal akan masuk ke fungsi catch dan memberikan respon querry error
        try {
            $transaction->update($request->all());
            $response = [
                'message' => 'Transaction Updated Succesfully!',
                'data' => $transaction
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }


    //  * Remove the specified resource from storage.
    public function destroy($id)
    {
        //pengecekan kalo ada lanjut, kalo gaada akan dapat response 404
        $transaction = Transaction::findOrFail($id);

        //juka berhasil akan masuk fungsi try yg isinya create ke database dan kirim respon
        //kalau gagal akan masuk ke fungsi catch dan memberikan respon querry error
        try {
            $transaction->delete();
            $response = [
                'message' => 'Transaction Deleted Succesfully!'
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }
}
