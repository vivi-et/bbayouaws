<?php

namespace App\Http\Controllers;

use App\Post;
use App\Giftcon;
use Illuminate\Http\Request;
use Com\Tecnick\Barcode\Barcode;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class PostController extends Controller

{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        //tasks
        return view('post.index', compact('posts'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // tasks/create
        return view('post.create');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // POST /tasks

        // dd(request()->all());

        // method 1
        // $post = new Post;
        // $post->title = request('title');
        // $post->body = request('body');

        // $post->save();

        $this->validate(request(), [
            'title' => 'required|max:20', // 최대 10글자
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);


        session()->flash('message', 'Post Created!');


        // server side validation (null 체크 등)
        // $this->validate(request(),[
        //     'title'=>'required|max:10', // 최대 10글자
        //     'body'=>'required'
        // ]);

        //파일 업로드
        if ($request->hasFile('cover_image')) {

            //파일이름 & 확장자
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            //파일이름만
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //확장자만
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            //db에 저장할 파일이름
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //이미지 업로드
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }


        //tesseract 실행
        $string = shell_exec('tesseract /home/viviet/bbayou/public/storage/cover_images/' . $fileNameToStore . ' stdout -l kor');
        
        
        
        preg_match('/(?:\d[ \-]*){12,16}/', $string, $barcodeNo);
        $barcodeNo[0] = preg_replace('/\D/', '', $barcodeNo[0]);
        // if (preg_match('/\d\d\d\d \d\d\d\d \d\d\d\d \d\d\d\d/', $string, $barcodeNo));
        // else (preg_match('/\d\d\d\d \d\d\d\d \d\d\d\d/', $string, $barcodeNo));
        // 기프티콘 제목에 교환권, 교환처 등이 있을경우 제거
        $countEXCHANGE = substr_count($string, "교환");
        if ($countEXCHANGE == 2) {
            $findstr = "교환";
            $pos = strpos($string, $findstr);
            $string = substr_replace($string, '', $pos, strlen($findstr));
        }

        //문자열 $string 추가 가공
        $string = str_replace("\n", "\\n\n", $string);
        $string = str_replace("\t", "\\t\t", $string);
        $string = preg_replace('/교......../', '교환처', $string);


        // 뽑아낼 항목들 지정
        $cat[0] = '유효기간';
        $cat[1] = '주문번호';
        $cat[2] = '교환처';
        $cat[3] = '선물수신일';
        $cat[4] = '쿠폰상태';
        $cat[5] = '바코드';

        //특정 문자열(이경우 항목)을 분리하는 함수
        function get_string_between($string, $start, $end)
        {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }


        // 년 월 도 string 날짜를 y m d date 형식으로 변경
        function strtodate($input)
        {
            if (substr_count($input, "년")) {
                $toRemove = array("년 ", "월 ", ".");
                $input = str_replace($toRemove, '-', $input);
                $input = mb_substr($input, 0, -1);
            } else {
                $input = str_replace('.', '-', $input);
            }
            $date = date_create_from_format('d/m/Y:H:i:s', $input);
            return $input;
        }

        //항목(cat[]) 이후 이어지는 값을 찾아서 catdata[]에 저장
        $nn = '\n';
        for ($i = 0; $i < 5; $i++) {
            $catdata[$i] = get_string_between($string, $cat[$i], $nn);
        }

        //catdata[0, 3], 유통기한
        $key = array_search($cat[0], $cat);
        $catdata[0] = strtodate($catdata[$key]);
        $key = array_search($cat[3], $cat);
        $catdata[3] = strtodate($catdata[$key]);
        $catdata[3] = date("Y-m-d");




        // catdata[2], 교환처
        if (strpos($catdata[2], '6525'))
            $catdata[2] = 'GS25';
        elseif (strpos($catdata[2], '7'))
            $catdata[2] = '7ELEVEN';
        elseif (strpos($catdata[2], '0'))
            $catdata[2] = 'CU';
        elseif (strpos($catdata[2], '뻬') || strpos($catdata[2], '태'))
            $catdata[2] = 'BHC';
        elseif (strpos($catdata[2], '개') && strpos($catdata[2], '웨'))
            $catdata[2] = '7ELEVEN/바이더웨이';
        //빈 공백 쳐내기
        for ($i = 0; $i < 5; $i++) {
            $catdata[$i] = str_replace(' ', '', $catdata[$i]);
        }

        //catdata[4] 기프티콘 사용 여부 확인
        $used = false;
        if ($catdata[4] == '사용완료') {
            $used = true;
        } elseif ($catdata[4] == '사용안함') {
            $used = false;
        }

        //catdata[5], 바코드

        $catdata[5] = $barcodeNo[0];



        //기프티콘 생성
        Giftcon::create([
            'expire_date' => $catdata[0],
            'orderno' => (int) $catdata[1],
            'place' => $catdata[2],
            'recieved_date' => $catdata[3],
            'used' => $used,
            'user_id' => auth()->id(),
            'barcode' => $barcodeNo[0],
        ]);


        Post::create([
            'title' => request('title'),
            'body' => request('body'),
            'body' => request('title'),
            // 'body' => $a,
            'user_id' => auth()->id(),
            'hasGiftconOrderNO' => (int) $catdata[1],
            'cover_image' => $fileNameToStore,

            //auto saved!
        ]);



        return redirect('/post');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //GET /tasks/id

        // $orderno = Post::get('hasGiftconOrderNO');
        $orderno = $post->hasGiftconOrderNO;

        //giftcon을 view에 보낼경우 개별 데이터 추출시 timeout 에러, 추후 해결
        //추후 코드 개선 요망, Eloquent::find() 로만 보내야 추출할수있음
        // eg) $giftcon = Giftcon::where('orderno', '=', $orderno)->get(); 하면 view에서 개별 column 호출시 timeout
        $giftconID = Giftcon::where('orderno', $orderno)->first()->id;
        $giftcon = Giftcon::find($giftconID);

        //barcode 생성
        $barcode = new \Com\Tecnick\Barcode\Barcode();
        $bobj = $barcode->getBarcodeObj(
            'C128',                     // barcode type and additional comma-separated parameters
            $giftcon->barcode,          // data string to encode
            -1,                             // bar width (use absolute or negative value as multiplication factor)
            -90,                             // bar height (use absolute or negative value as multiplication factor)
            'black',                        // foreground color
            array(-1, -1, -1, -1)           // padding (use absolute or negative values as multiplication factors)
        )->setBackgroundColor('white'); // background color

        // output the barcode as HTML div (see other output formats in the documentation and examples)


        return view('post.show')->with('post', $post)->with('giftcon', $giftcon)->with('bobj', $bobj);
        // return view('post.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // GET /tasks/id/edit
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->withErrors('error', 'Unauthorized Page');
        }
        // PATCH /tasks/id

        $this->validate(request(), [
            'title' => 'required|max:20', // 최대 10글자
            'body' => 'required'
        ]);

        //Handle file upload
        if ($request->hasFile('cover_image')) {

            //Get Filename with extension

            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            //Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }



        $post->update($request->all());
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/post');
        // $post->update($request->all());


        // $post->title = $request->input('title');
        // $post->body = $request->input('body');
        // $post->save();


        // $update = Post::find($post->id);

        // Post::create([
        //     'title' => request('title'),
        //     'body'=> request('body'),
        //     'user_id'=> auth()->id(),
        // ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // DELETE /tasks/id

        //삭제할 파일 이름 가져오기
        $fileNameToStore = $post->cover_image;
        $path = 'storage/cover_images/' . $fileNameToStore;

        //기프티콘 파일 삭제
        unlink($path);

        //게시글 삭제
        $post->delete();

        //연결된 기프티콘 항목도 삭제
        $orderno = $post->hasGiftconOrderNO;
        $giftconID = Giftcon::where('orderno', $orderno)->first()->id;
        $giftcon = Giftcon::find($giftconID);
        $giftcon->delete();

        return redirect('/post');
    }
}
