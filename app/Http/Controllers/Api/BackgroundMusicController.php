<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BackgroundMusicCollection;
use App\Http\Resources\Image\ImageCollection;
use App\Models\BackgroundMusic;
use App\Models\WaterMark;
use Illuminate\Http\Request;

class BackgroundMusicController extends Controller
{
    public function getCompanyBackgroundMusic(Request $request)
    {
        $request->validate([
            'company_id',
        ]);
        $records = BackgroundMusic::byCompany($request->company_id)
        // where('company_id', $request->company_id)
            ->get()
            ->sortBy('order_sort');
        // ->groupBy(function ($file_manager_id) {
        //     return $file_manager_id?->fileManager?->name;
        // });

        $music_records = [];
        // foreach ($records as $key => $record) {
        // $music_records_by_folders = [
        //     'folder'=>$key,
        // ];
        foreach ($records as  $data) {
            $music_records[] = [
                'id' => (string) $data->id,
                'name' => $data->name ? $data->name : '',
                // 'folder' => $data->fileManager ? $data?->fileManager?->name  : '',
                'company' => $data?->company?->name ? $data?->company?->name : '',
                'audio' => $data->audio ? env('APP_IMAGE_URL') . 'background-music/' . $data->audio : '',
                // 'audios' => new ImageCollection($data->images),
                'order_sort' => $data->order_sort ? $data->order_sort : '',

            ];
            // $music_records_by_folders['backgroundMusic'][] = $music_records_by_folder;
        }
        //     $music_records[] = $music_records_by_folders;
        // }
        // $test = array(
        //     'name' => 'test',
        //     'backgroundMusic' => [(object)['name' => 'test 2323 ']]
        // );
        return response()->json(['status' => true, 'message' => 'Record Found', 'data' => $music_records]);
    }
    public function getBackgroundMusic(Request $request)
    {
        // $request->validate([
        //     'company_id',
        // ]);
        $records = BackgroundMusic::where('company_id', null)
            ->get()
            ->sortBy('order_sort');
        // ->groupBy(function ($file_manager_id) {
        //     return $file_manager_id?->fileManager?->name;
        // });

        $music_records = [];
        // foreach ($records as $key => $record) {
        // $music_records_by_folders = [
        //     'folder'=>$key,
        // ];
        foreach ($records as  $data) {
            $music_records[] = [
                'id' => (string) $data->id,
                'name' => $data->name ? $data->name : '',
                // 'folder' => $data->fileManager ? $data?->fileManager?->name  : '',
                'company' => $data?->company?->name ? $data?->company?->name : '',
                'audio' => $data->audio ? env('APP_IMAGE_URL') . 'background-music/' . $data->audio : '',
                // 'audios' => new ImageCollection($data->images),
                'order_sort' => $data->order_sort ? $data->order_sort : '',

            ];
            // $music_records_by_folders['backgroundMusic'][] = $music_records_by_folder;
        }
        //     $music_records[] = $music_records_by_folders;
        // }
        // $test = array(
        //     'name' => 'test',
        //     'backgroundMusic' => [(object)['name' => 'test 2323 ']]
        // );
        return response()->json(['status' => true, 'message' => 'Record Found', 'data' => $music_records]);
    }
    public function oldGetBackgroundMusic(Request $request)
    {
        $request->validate([
            'company_id',
        ]);
        $records = BackgroundMusic::where('company_id', $request->company_id)
            ->get()
            ->groupBy(function ($file_manager_id) {
                return $file_manager_id?->fileManager?->name;
            });

        $music_records = [];
        foreach ($records as $key => $record) {
            $music_records_by_folders = [
                'folder' => $key,
            ];
            foreach ($record as  $data) {
                $music_records_by_folder = [
                    'id' => (string) $data->id,
                    'name' => $data->name ? $data->name : '',
                    'folder' => $data->fileManager ? $data?->fileManager?->name  : '',
                    'company' => $data?->company?->name ? $data?->company?->name : '',
                    'audio' => $data->audio ? env('APP_IMAGE_URL') . 'background-music/' . $data->audio : '',
                ];
                $music_records_by_folders['backgroundMusic'][] = $music_records_by_folder;
            }
            $music_records[] = $music_records_by_folders;
        }
        $test = array(
            'name' => 'test',
            'backgroundMusic' => [(object)['name' => 'test 2323 ']]
        );
        return response()->json(['status' => true, 'message' => 'Record Found', 'data' => $music_records]);
    }
}
