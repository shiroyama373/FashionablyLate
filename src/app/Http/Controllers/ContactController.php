<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use App\Models\Category;

class ContactController extends Controller
{
    // フォーム表示
    public function create(Request $request)
{
    $categories = Category::all(); // カテゴリを取得
    $oldInput = $request->session()->get('contact_input', []); // 前回入力値取得

    return view('contact.create', compact('categories', 'oldInput'));
}

    // 確認画面表示
    public function confirm(ContactFormRequest $request)
{
    $validated = $request->validated();

    // 電話番号を結合
    $validated['tel'] = $validated['tel1'].'-'.$validated['tel2'].'-'.$validated['tel3'];

    // カテゴリ名取得
    $category = Category::find($validated['category_id']);
    $validated['category'] = $category ? $category->name : '不明なカテゴリ';

    // セッションに保存（修正リンク用）
    $request->session()->put('contact_input', $validated);

    $categories = Category::all();

    return view('contact.confirm', compact('validated', 'categories'));
}

    // フォーム送信処理
    public function store(Request $request)
    {
        // 「修正」ボタンが押された場合
        if ($request->input('action') === 'modify') {
            // 入力画面へリダイレクト（セッションに保存済みの入力値を使って復元）
            return redirect()->route('contact.create')->withInput();
        }
    
        // セッションからデータ取得
        $validated = $request->session()->get('contact_input');
    
        if (!$validated) {
            return redirect()->route('contact.create'); // セッションがない場合は入力画面へ
        }
    
        // 電話番号はすでに結合済み
        unset($validated['tel1'], $validated['tel2'], $validated['tel3']);
    
        // DBカラム名に合わせて変換
        $validated['detail'] = $validated['content'];
        unset($validated['content']);
    
        // 保存
        Contact::create($validated);
    
        // セッション削除
        $request->session()->forget('contact_input');
    
        return redirect()->route('contact.thanks');
    }

    // 送信完了ページ
    public function thanks()
    {
        return view('contact.thanks');
    }

    // 管理画面 一覧表示
    public function index()
    {
        $contacts = Contact::with('category')->get();
        return view('admin.contacts.index', compact('contacts'));
    }

    // モーダル用 詳細表示
    public function show($id)
    {
        $contact = Contact::with('category')->findOrFail($id);
        return view('admin.contacts.modal', compact('contact'));
    }
}