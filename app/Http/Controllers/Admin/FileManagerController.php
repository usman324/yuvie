<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackgroundMusic;
use App\Models\FileManager;
use App\Traits\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileManagerController extends Controller
{
    use Main;
    const TITLE = 'Folder';
    const VIEW = 'admin/file_manager';
    const URL = 'admin/file-managers';

    public function __construct()
    {
        view()->share([
            'url' => url(self::URL),
            'title' => self::TITLE,
        ]);
    }
    public function index(Request $request)
    {
        $records = FileManager::latest()->get();
        return view(self::VIEW . '.index', get_defined_vars());
    }
    public function create(Request $request)
    {

        return view(self::VIEW . '.create', get_defined_vars());
    }
    public function store(Request $request)
    {
        ini_set('memory_limit', '1000M');
        $request->validate([
            'name' => 'required',
        ]);
        FileManager::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
        ]);
        return response()->json(['status' => true, 'message' => 'Folder has been created successfully'], 200);
    }
    public function edit($id)
    {
        $record = FileManager::find($id);
        return view(self::VIEW . '.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        ini_set('memory_limit', '1000M');
        $record = FileManager::find($id);
        $request->validate([
            'name' => 'required',
        ]);
        $record->update([
            'name' => $request->name ? $request->name : $record->name,
        ]);
        return response()->json(['status' => true, 'message' => 'Folder has been updated successfully'], 200);
    }
    public function destroy($id)
    {
        $record = FileManager::find($id);
        if ($record) {
            $bacckground_musics = BackgroundMusic::where('file_manager_id', $record->id)->get();
            if (!$bacckground_musics->isEmpty()) {
                BackgroundMusic::where('file_manager_id', $record->id)->delete();
            }
            $record->delete();
            return 1;
        }
    }
}
