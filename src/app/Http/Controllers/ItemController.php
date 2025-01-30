<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;



class ItemController extends Controller
{

    // 検索機能
    public function search(Request $request)
    {

        // $items = Item::paginate(6);
        $items = Item::query();

        $keyword = $request->input("item_name");

        if (!empty($keyword)) {
            $items->where("item_name", "LIKE", "%{$keyword}%");
        }

        // $items = $items->paginate(6);
        $items = $items->get();

        // セッションに検索条件と、検索結果を保存（マイリストで表示）
        // Session::put(["search_keyword"=>$keyword,"items"=>$items]);
        session([
            "search_keyword" => $keyword,
            "search_items" => $items,
        ]);

        return view("items.index", ["items" => $items]);
    }

    // 商品一覧画面表示
    public function index()
    {
        // $items = Item::paginate(6);
        $items = Item::all();

        return view("items.index", ["items" => $items]);
        // return view("items/index");
    }

    // 商品一覧画面表示（マイリスト）
    public function indexMylist()
    {
        // // $items = auth()->user()->likeItem;
        // $items = Auth::user()->likeItem;

        // return view("items.index-mylist", ["items" => $items]);

        if (Auth::check()) {

            // ログインしている場合
            //いいねした商品
            $items = Auth::user()->likeItem;
            // 商品検索欄に検索したキーワードと検索したキーワードに一致する商品
            $keyword = session("search_keyword"); // ヘルパー関数
            // $keyword = Session::get("search_keyword"); // ファサード
            $searchItems = session("search_items");

            return view("items.index-mylist", [
                "items" => $items,
                "keyword" => $keyword,
                "searchItems" => $searchItems
            ]);
        } else {

            // 未ログインの場合
            return view("items.index-mylist");
        }
    }


    // 商品詳細画面表示
    public function show($itemId)
    {
        $item = Item::findOrFail($itemId);
        //  $categories = Category::all();
        $categories = $item->categories;
        $condition = $item->conditions->first(); //  コレクション対応
        $comments = $item->comments;

        return view('items.show', ['item' => $item, "categories" => $categories, "condition" => $condition, "comments" => $comments]);
    }


    // 商品登録（出品）画面表示
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view("items.sell", ["categories" => $categories, "conditions" => $conditions]);
    }


    // 商品登録（出品）処理
    public function store(ExhibitionRequest $exhibitionRequest)
    {
        // Log::info($exhibitionRequest->all());

        $savedfilepath = basename($exhibitionRequest->file("item_image")->store("photos/item_images", "public"));
        $item = new Item($exhibitionRequest->validated());
        $item["item_image"] = $savedfilepath;
        $item["user_id"] = auth()->id(); // ログイン中のユーザーIDを設定
        $item->save();
        // $item->conditions()->sync($item->conditions);
        $item->categories()->sync($exhibitionRequest->input('categories', []));
        $item->conditions()->sync($exhibitionRequest->input('condition', []));

        // $item=$exhibitionRequest->velidated();
        // $item["image"]=basename($exhibitionRequest->file("image")->store("photo","public"));
        // Item::create($item);

        return to_route("profile.show.sell");
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


    // いいねの処理
    public function like($itemId)
    {
        // 現在のユーザーを取得
        $user = auth()->user();

        // ユーザーがその商品を「いいね」していない場合
        if ($user->likeItem->contains($itemId)) {
            // すでにいいねしているので解除
            $user->likeItem()->detach($itemId);
        } else {
            // まだいいねしていないので追加
            $user->likeItem()->attach($itemId);
        }

        // 商品の詳細ページにリダイレクト
        return back();
    }


    // コメントの処理
    public function comment(CommentRequest $commentRequest, $itemId)
    // public function comment(Request $request, $itemId)
    {
        // バリデーション
        // $request->validate([
        //     'comment' => 'required|string|max:255',
        // ]);

        // コメントの保存
        // $user = Auth::user()->get;

        // Comment::create([
        //     'user_id' => $user->id,
        //     'item_id' => $itemId,
        //     'comment' => $request->input('comment'),
        // ]);

        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $itemId,
            'comment' => $commentRequest->input('comment'),
        ]);

        return redirect()->route('item.show', $itemId)->with('success', 'コメントを投稿しました！');
    }
}
