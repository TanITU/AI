<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller{
    public function login(Request $request){
        $email = request('email');
        $password = request('password');
        $admin = Admin::login($email,$password);
        if ($admin != null) {
            $request->session()->put('idAdmin',$admin['id']);
            $categories = DB::table('categorie')->get();
            $technologies = DB::table('technologie')->get();
            return view('Admin.index',[
                'categories' => $categories,
                'technologies' => $technologies,
            ]);
        }
        else{
            return view('Admin.login',[ 
                'error'=>'Wrong email or password'
            ]);
        }
    }
    public function insertArticle(Request $request){
        $article = new Article();
        $article->idadmin =$request->session()->get('idAdmin');
        $article->idcategorie = request('idcategorie');
        $article->idtechnologie = request('idtechnologie');
        $article->nom = request('nom');
        $article->description = request('description');
        // echo($article);
        $article->save();
        $categories = DB::table('categorie')->get();
        $technologies = DB::table('technologie')->get();
        return view('Admin.index',[
            'categories' => $categories,
            'technologies' => $technologies,
        ]);
    }
}
