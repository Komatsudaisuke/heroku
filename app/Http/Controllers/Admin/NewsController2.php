<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News2;
use App\History2;
use Carbon\Carbon;

class NewsController2 extends Controller
{

public function add()
  {
      return view('admin.news2.create');
  }


  // 以下を追記
  public function create(Request $request)
  {
      // admin/news/createにリダイレクトする
      $this->validate($request, News2::$rules);

      $news = new News2;
      $form = $request->all();

      // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $news->image_path = basename($path);
      } else {
          $news->image_path = null;
      }

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);

      // データベースに保存する
      $news->fill($form);
      $news->save();

      return redirect('admin/news2/create');
  }
  
  public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = News2::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = News2::all();
      }
      return view('admin.news2.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
  
  public function edit(Request $request)
  {
      // News Modelからデータを取得する
      $news = News2::find($request->id);
      if (empty($news)) {
        abort(404);    
      }
      return view('admin.news2.edit', ['news_form' => $news]);
  }


  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, News2::$rules);
      // News Modelからデータを取得する
      $news = News2::find($request->id);
      // 送信されてきたフォームデータを格納する
      $news_form = $request->all();
      if (isset($news_form['image'])) {
        $path = $request->file('image')->store('public/image');
        $news->image_path = basename($path);
        unset($news_form['image']);
      } elseif (isset($request->remove)) {
        $news->image_path = null;
        unset($news_form['remove']);
      }
      unset($news_form['_token']);
      // 該当するデータを上書きして保存する
      $news->fill($news_form)->save();
      $history = new History2;
        $history->news_id = $news->id;
        $history->edited_at = Carbon::now();
        $history->save();

      return redirect('admin/news2');
  }
  
  public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      $news = News2::find($request->id);
      // 削除する
      $news->delete();
      return redirect('admin/news2/');
  }
}