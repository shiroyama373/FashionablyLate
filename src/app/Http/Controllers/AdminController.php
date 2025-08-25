<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // クエリビルダ
        $query = Contact::with('category'); // カテゴリのリレーションも取得

        // 1. 名前 or メールアドレスで検索（部分一致）
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$keyword}%"])
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 2. 性別で絞り込み
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // 3. カテゴリIDで絞り込み
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 4. 日付で絞り込み（完全一致）
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // 5. ページネーション（7件ずつ表示）
        $contacts = $query->paginate(7)->appends($request->all());

        // カテゴリ一覧も取得（ビューに渡す）
        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'));
    }

    // 詳細表示（モーダル用）
    public function show($id)
    {
        $contact = Contact::with('category')->findOrFail($id);
        return view('admin.contacts.modal', compact('contact'));
    }

    public function export(Request $request)
    {
        $query = Contact::with('category');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                  ->orWhere('last_name', 'like', "%{$keyword}%")
                  ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$keyword}%"])
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->get();

        $response = new StreamedResponse(function() use ($contacts) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF"); // BOM

            fputcsv($handle, [
                'お名前',
                '性別',
                'メールアドレス',
                '電話番号',
                '住所',
                '建物名',
                'お問い合わせの種類',
                'お問い合わせ内容'
            ]);

            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->last_name . ' ' . $contact->first_name,
                    $contact->gender,
                    $contact->email,
                    $contact->tel ?? '',
                    $contact->address ?? '',
                    $contact->building ?? '',
                    $contact->category->name ?? '',
                    $contact->body ?? ''
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="contacts.csv"');

        return $response;
    }

    // 削除
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'お問い合わせを削除しました。');
    }

}