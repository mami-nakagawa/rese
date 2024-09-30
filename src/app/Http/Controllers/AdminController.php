<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\ShopRepresentative;
use App\Mail\NotificationMail;
use Mail;
use Spatie\Permission\Models\Role;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ShopRepresentativeRequest;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Services\csvValidationService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class AdminController extends Controller
{
    public function admin()
    {
        $user = Auth::user();

        return view('admin.admin', compact('user'));
    }

    public function register(ShopRepresentativeRequest $request)
    {
        $password = $request->password;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
        ]);

        $user->roles()->attach(2);

        return redirect()->route('admin.done');
    }

    public function done()
    {
        return view('admin.done');
    }

    public function notificationMail(Request $request)
    {
        $users = User::doesntHave('roles')->get();
        $text = $request->text;

        Mail::to($users)->send(new NotificationMail($text));

        return redirect()->back()->with('message','お知らせメールを送信しました');
    }

    public function csvImport(Request $request)
    {
        if ($request->hasFile('csvFile')) {
            // リクエストからファイルを取得
            $file = $request->file('csvFile');
            $path = $file->getRealPath();
            // ファイルを開く
            $fp = fopen($path, 'r');
            // ヘッダー行をスキップ
            fgetcsv($fp);
            // 1行ずつ読み込む
            while (($csvData = fgetcsv($fp)) !== FALSE) {
                $validateErrors = csvValidationService::validateCsvDate($csvData);
                if (!is_null($validateErrors)) {
                    // バリデーションの エラーメッセージをセット
                    session()->flash('errors', $validateErrors);
                    // ファイルを閉じる
                    fclose($fp);

                    return redirect()->back();
                } else {
                    $this->InsertCsvData($csvData);
                    // ファイルを閉じる
                    fclose($fp);

                    return redirect()->back()->with('shop_create_message','店舗情報を登録しました');
                }
            }
        } else {
            try {
                throw new Exception();
            } catch (Exception $e) {
                return redirect()->back()->with('shop_create_message','csvファイルの取得に失敗しました');
            }
        }
    }

    public function InsertCsvData($csvData)
    {
        // csvファイル情報をインサートする
        $area = Area::where('name', $csvData[1])->first();
        $genre = Genre::where('name', $csvData[2])->first();

        $shop = new Shop;
        $shop->name = $csvData[0];
        $shop->area_id = $area->id;
        $shop->genre_id = $genre->id;
        $shop->summary = $csvData[3];
        $shop->image = $csvData[4];
        $shop->save();
    }
}
