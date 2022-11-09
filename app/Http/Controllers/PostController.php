<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    // post create page
    public function createPage(){
        // $posts = Post::orderBy('id','desc')->paginate(3);

        // $posts = Post::get()->last(); //where('id','<','6')->where('address','yangon')->get();
        // $posts = Post::pluck('title');
        // $posts = Post::where('id','<',5)->get('id')->random();
        // $posts = Post::whereBetween('price',[5000,9000])->orderBy('price','asc')
        // ->select('id','address')->dd();
        // $posts = DB::table('posts')->where('address','yangon')->orWhere('id','<',5)->select('id','title')->orderBy('id','desc')->get();
        // $posts = DB::table('posts')->count();
        // $posts = Post::avg('price');
        // $posts = DB::table('posts')->where('address','Monywa')->exists(); // true false
        // $posts = DB::table('posts')->where('address','Monywa')->doesntExist(); // true false
        // $posts = DB::table('posts')->select('id','title as data_title')->get();
        // $posts = Post::select('rating', DB::raw('COUNT(rating) as count_rating'), DB::raw('SUM(price) as total_price'))
        // $posts = Post::select('rating',DB::raw('COUNT(rating) as rating_count'),DB::raw('SUM(price) as total_price'))
        // ->groupBy('rating')->get();

        // map each  data only get
        //through function paginate + data get
        // $posts = Post::get()->map(function($p){
        //     $p->title = strtoupper($p->title);// to change upper case
        //     $p->description = strtoupper($p->title);
        //     return $p;
        // }); return important
        // $posts = Post::get()->each(function($p){
        //     $p ->title = \strtoupper($p->title);
        //     $p->description = strtoupper($p->description);
        //     $p->price = $p->price*2;
        //     return $p;
        // });
        // $posts = Post::paginate(5)->through(function($p){
        //     $p ->title = strtoupper($p->title);
        //     $p->description = strtoupper($p->description);
        //     $p->price = $p->price*2;
        //     return $p;
        // });
        // dd($posts->toArray());
        //http://127.0.0.1:8000/create/page?key=code lab
            // dd($_REQUEST['key']);
            // $searchKey = $_REQUEST['key'];
            // $posts = Post::where('title','like','%'.$searchKey.'%')->get();
        //    $posts = Post::when(request('key'),function($p){
        //     $key = \request('key');
        //     $p->orwhere('title','like','%'.$key.'%');
        //     $p->orwhere('description','like','%'.$key.'%');
        //    })->get();
        //     dd($posts->toArray());

        $posts =Post::when(request('searchKey'),function($query){
            $key = request('searchKey');
            $query->orwhere('title','like','%'.$key.'%')
            ->orwhere('description','like','%'.$key.'%');//to get search neet to append
        })
        ->orderBy('id','desc')->paginate(3);
        // dd(count($posts));
        return view('create',compact('posts'));
    }
    // postCreate
    public function postCreate(Request $request){
        // dd($request->all());
        // dd($request->hasFile('postImage') ? "ture" : "false");
        // dd($request->file('postImage')->getClientOriginalName());// name and type
        $this->postValidationCheck($request);
        $data = $this->getPostData($request);
        if($request->hasFile('postImage')){
            // $request->file('postImage')->store('myImage');
            // $fileName =uniqid() ." KT ". $request->file('postImage')->getClientOriginalName();
            // $request->file('postImage')->storeas('myImage',$fileName);
            // $data['image']=$fileName;
            //  dd('store success');
           $imgName = uniqid() . $request->file('postImage')->getClientOriginalName();
           $request->file('postImage')->storeas('public',$imgName);
           $data['image'] = $imgName;
        }
        // dd($data);
        // dd('image not found');
        Post::create($data);
        // return redirect('create/page');
        return back()->with(['insertSuccess'=>'Post ဖန်တီးခြင်းအောင် မြင်ပါသည်။']);
    }
    // post delete
    public function postDelete($id){
        // dd($id);
        Post::where('id',$id)->delete();// first way
        // Post::find($id)->delete();// sec way
        // return redirect('create/page');
        return back()->with(['deleteSuccess'=>'Delete လုပ်ခြင်းအောင်မြင်ပါသည်။']);
    }
    //direct post update page
    public function updatePage($id){
        // dd($id);
    //    $data = Post::where('id',$id)->get()->toArray(); $data[0]['title];
       $data = Post::where('id',$id)->first()->toArray();

    //    dd($data);
        return view('update',compact('data'));
    }

    // edit page
    public function editPage($id){
        $data = Post::where('id',$id)->first()->toArray();
        // dd($data);
        return view('edit',compact('data'));
    }

    //post update dirext
    public function update(Request $request){
        // dd($request->all());
        $this->postValidationCheck($request);
        $dataUpdate = $this->getPostData($request);
        $id = $request->postId;
        // dd($request->hasFile('postImage') ? "Yes" : "No");
        if($request->hasFile('postImage')){
            $oldImgName = Post::select('image')->where('id',$request->postId)->first()->toArray();
            $oldImgName = $oldImgName['image'];
            // dd($oldImgName);
            Storage::delete('public/'.$oldImgName);

            $fileName = \uniqid().$request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeas('public',$fileName);
            $dataUpdate['image']=$fileName;
        }
        Post::where('id',$id)->update($dataUpdate);
        return redirect('create/page')->with(['updateSuccess'=>'Update လုပ်ခြင်းအောင် မြင်ပါသည်။']);
        // dd($dataUpdate);
    }

    //get post data
    private function getPostData($request){
        $data = [
            'title'=>$request->postTitle,
            'description'=>$request->postDescription,
        ];
        $data['price'] = $request->postFee == null ? 2000 : $request->postFee;
        $data['address'] = $request->postAddress == null ? "Yangon" : $request->postAddress;
        $data['rating'] = $request->postRating == null ? "5" : $request->postRating;
        return $data;
        // dd($data);
        // return [

        //     'price'=>$request->postFee,
        //     'address'=>$request->postAddress,
        //     'rating' => $request->postRating,
        // ];
    }
    private function postValidationCheck($request){
        $validationRule =[
            'postTitle'=> 'required|min:5|Unique:posts,title,'.$request->postId,
            'postDescription'=>'required',
            'postImage'=>'mimes:jpg,jpeg,png,webp',
            // 'postFee'=>'required',
            // 'postAddress'=>'required',
            // 'postRating'=>'required',
        ];
        $validationMessage=[
            'postTitle.required'=>'Post Title ဖြည့်ရန်လိုအပ်ပါသည်။',
            'postDescription.required'=>'Post Description ဖြည့်ရန်လိုအပ်ပါသည်။',
            'postFee.required'=>'Post fee ဖြည့်ရန်လိုအပ်ပါသည်။',
            'postAddress.required'=>'Post address ဖြည့်ရန်လိုအပ်ပါသည်။',
             'postRating.required'=>'Post rating ဖြည့်ရန်လိုအပ်ပါသည်။',
        ];
        Validator::make($request->all(),$validationRule,$validationMessage)->validate();
    }
}
