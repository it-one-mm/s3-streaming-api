<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\S3CloudFrontService;
use Aws\Exception\AwsException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Get CloudFront Signed Url
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function stream(Request $request) {

        if ($request->filled('key')) {
            $key = $request->input('key');

            if (!Storage::disk('s3')->exists($key)) {
                return response()->json([
                        'error' => 'File does not exists'
                    ],Response::HTTP_NOT_FOUND);
            }

            $client = new S3CloudFrontService($key);

            $url = $client->signPrivateDistribution();

            return response()->json([
                'url' => $url,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'error' => 'Please Provide S3 Object Key!',
        ], Response::HTTP_BAD_REQUEST);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        if ($request->filled('key')) {
            $key = $request->input('key');

            Storage::disk('s3')->delete($key);

            return response()->json(null, Response::HTTP_NO_CONTENT);
        }

        return response()->json([
            'error' => 'Please Provide S3 Object Key!',
        ], Response::HTTP_BAD_REQUEST);

    }
}
