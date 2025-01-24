<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;



class ItemController extends Controller
{

    // // 検索
    // public function search(Request $request)
    // {

    //     // $items = Item::paginate(6);
    //     $items = Item::query();

    //     $keyword = $request->input("name");

    //     if (!empty($keyword)) {
    //         $items->where("name", "LIKE", "%{$keyword}%");
    //     }

    //     $items = $items->paginate(6);

    //     return view("items-index", ["items" => $items]);
    // }



    // 商品一覧画面表示
    public function index()
    {
        // $items = Item::paginate(6);
        $items = Item::all();

        return view("items/index", ["items" => $items]);
        // return view("items/index");
    }


    // 商品詳細画面表示
    public function show($itemId)
    {
        $item = Item::findOrFail($itemId);
        //  $categories = Category::all();
        $categories = $item->categories;
        $condition = $item->conditions->first(); //  コレクション対応

        return view('items.show', ['item' => $item, "categories" => $categories, "condition" => $condition]);
    }


    // 商品登録画面表示
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view("items.sell", ["categories" => $categories, "conditions" => $conditions]);
    }


    // 商品登録処理
    public function store(ExhibitionRequest $exhibitionRequest)
    {
        // Log::info($exhibitionRequest->all());

        $savedfilepath = basename($exhibitionRequest->file("item_image")->store("photos/item_images", "public"));
        $item = new Item($exhibitionRequest->validated());
        $item["item_image"] = $savedfilepath;
        $item["user_id"] = auth()->id(); // ログイン中のユーザーIDを設定
        $item->save();
        // $item->conditions()->sync($item->conditions);
        $item->categories()->sync($exhibitionRequest->input('categories',[]));
        $item->conditions()->sync($exhibitionRequest->input('condition',[]));

        // $item=$exhibitionRequest->velidated();
        // $item["image"]=basename($exhibitionRequest->file("image")->store("photo","public"));
        // Item::create($item);

        return to_route("items.index");
    }


     // 商品登録処理
    //  public function store(Request $request)
    //  {
    //     $validatedData = $request->validate([
    //         'item_name' => 'required|string|max:255',
    //         'price' => 'required|numeric|min:0',
    //         'item_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'categories' => 'array',
    //         'condition' => 'required|integer|exists:conditions,id',
    //     ]);

    //      $savedfilepath = basename($request->file("item_image")->store("photos/item_images", "public"));
    //      $item = new Item($validatedData);
    //      $item["item_image"] = $savedfilepath;
    //      $item["user_id"] = auth()->id(); // ログイン中のユーザーIDを設定
    //      $item["description"] = $request->input('description'); // descriptionが、データに含まれないというエラーのため、明示
    //      $item->save();
    //      // $item->conditions()->sync($item->conditions);
    //      $item->categories()->sync($request->input('categories[]'));
    //      $item->conditions()->sync([$request->input('condition')]);

    //      // $item=$exhibitionRequest->velidated();
    //      // $item["image"]=basename($exhibitionRequest->file("image")->store("photo","public"));
    //      // Item::create($item);

    //      return to_route("items.index");
    //  }



     // 商品購入画面表示
     public function purchase($itemId)
     {
         $item = Item::findOrFail($itemId);
         $user = Auth::user();

         return view('items.purchase', ['item' => $item, "user" => $user]);
     }






    //  // 商品編集画面表示
    //  public function edit($itemId)
    //  {
    //      $item = Item::findOrFail($itemId);
    //      $seasons = Season::all();

    //      return view('items-edit', ['item' => $item, "seasons" => $seasons]);
    //  }

    //  // 商品更新処理
    //  public function update(EdititemRequest $request, $itemId)
    //  {
    //      $item = Item::findOrFail($itemId);
    //      $updateData = $request->validated();

    //      // 画像を変更する場合
    //      if ($request->has("image")) {
    //          // 変更前の画像をstrage>app>public>photo ディレクトリから削除
    //          Storage::disk("public")->delete($item->image);
    //          // 変更後の画像をstrage>app>public>photo ディレクトリに保存、ファイルパスを $updateData["image"]にセット
    //          $updateData["image"] = basename($request->file("image")->store("photos", "public"));
    //          // $updateData["image"] = $request->file("image")->store("photos", "public");
    //      }

    //      // itemsテーブルのデータを更新
    //      $item->update($updateData);
    //      // 中間テーブル（item_season テーブル）のデータを更新
    //      $item->seasons()->sync($updateData["seasons"]);
    //      // $item->seasons()->attach($updateData["seasons"]);

    //      return to_route("items.index");
    //  }


    // 商品一覧画面（マイリスト）表示
    public function showMylist()
    {

        return view('items.show-mylist');
    }
}
