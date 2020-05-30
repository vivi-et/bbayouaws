<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('settings.index');
    }


    function panel()
    {

        return view('settings.panel');
    }

    public function changepass(Request $request, User $user)
    {
        $this->validate($request, [

            'fromPass' => 'required|min:8|max:20',
            'toPass' => 'required|min:8|max:20',
            'toPassConfirm' => 'required|min:8|max:20',
        ]);

        $currentPass = $request->fromPass;
        $newPass = $request->toPass;
        $newPassConfirm = $request->toPassConfirm;

        if (!Hash::check($currentPass, $user->password)) {
            return redirect()->back()->withErrors(['잘못된 비밀번호입니다']);
        } elseif ($newPass !== $newPassConfirm) {
            return redirect()->back()->withErrors(['새 비밀번호가 일치하지 않습니다']);
        } else {
            $user->password = Hash::make($newPass);
            $user->save();
            session()->flash('message', '비밀번호가 변경되었습니다');
            return redirect('/settings/panel');
        }
    }

    public function authenticate(Request $request)
    {
        $password = $request->pwd;

        $user = auth()->user();

        if (Hash::check($password, $user->password)) {
            session()->put('auth', 'true');
            // Session::forget('auth');
            return redirect('/settings/panel');
        } else {
            return redirect()->back()->withErrors(['잘못된 비밀번호입니다']);
        }
    }

    public function changename(Request $request, User $user)
    {

        $this->validate($request, [

            'toName' => 'required|max:12',
        ]);

        $toName = $request->toName;

        if (User::where('name', $toName)->first()) {
            return redirect()->back()->withErrors(['중복된 닉네임입니다']);
        } else {
            $user->name = $toName;
            $user->save();

            session()->flash('message', '닉네임이 변경되었습니다');
            return redirect('/settings/panel');
        }



        return view('settings.panel');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $this->validate($request, [

            'confirmPass' => 'required|min:8|max:20',
            'confirmTest' => 'required|max:20',
        ]);


        $confirmPass = $request->confirmPass; // 비밀번호 확인
        $confirmTest = $request->confirmTest; // '회원탈퇴' 확인


        if ($confirmTest !== '회원탈퇴') {
            return redirect()->back()->withErrors(['회원탈퇴를 정확히 입력해주세요']);
        } elseif (!Hash::check($confirmPass, $user->password)) {
            return redirect()->back()->withErrors(['비밀번호가 일치하지 않습니다']);
        } else {
            $userposts = $user->posts;                              // 1. 회원이 작성한 글들
            $usercomments = $user->comments;                        // 2. 댓글들
            $usergiftcons = $user->giftcons;                        // 3. 등록한 기프티콘들
            $usergiftcontradeposts = $user->giftcontradepost;       // 4. 기프티콘 거래글
            $usergiftcontradecomments = $user->giftcontradecomment; // 5. 기프티콘 교환 댓글들




            foreach ($usergiftcons as $usergiftcon) {   //3. 등록된 기프티콘 삭제. 사용완료된 기프티콘들은 추후 재등록, 악용 방지를 위해 보존
                if ($usergiftcon->used !== 0) {

                    $usergiftcon->on_trade = 0;
                    $usergiftcon->user_id = 0;
                    $usergiftcon->save();
                } else
                    $usergiftcon->delete();             //사용안된 기프티콘은 삭제
            }
            foreach ($userposts as $userpost) {         //1. 게시글 삭제
                $userpost->delete();
            }


            foreach ($usercomments as $usercomment) {   //2. 댓글 삭제
                $usercomment->delete();
            }




            foreach ($usergiftcontradeposts as $usergiftcontradepost) {   //4. 사용자의 기프티콘 거래글들 삭제

                $hascomments = $usergiftcontradepost->comments;

                if ($usergiftcontradepost->traded == 1) {           //거래가 완료된 거래글은 바로 삭제
                    $usergiftcontradepost->delete();
                } else {                                            //거래중인  거래글은 교환중인 댓글들을 별도 처리후 삭제
                    foreach ($hascomments as $hascomment) {                         //이 게시글의 각 댓글들

                        foreach ($hascomment->giftcons as $eachGiftcon) {           //그 댓글들속의 기프티콘들
                            $eachGiftcon->on_trade = 0;                             //거래상태 해제
                            $eachGiftcon->save();                                   //저장
                        }
                        $hascomment->giftcons()->detach($hascomment->giftcons);     //pivot table에서 삭제
                        $hascomment->delete();                                      //댓글 삭제
                    }
                }


                $usergiftcontradepost->delete();
            }

            foreach ($usergiftcontradecomments as $usergiftcontradecomment) {   //5. 사용자의 거래댓글들 삭제


                $hasTheseGiftcons = $usergiftcontradecomment->giftcons;             //거래댓글에 등록된 기프티콘들 변경

                if ($usergiftcontradecomment->traded == 1) {                          //이미 거래가 완료된 댓글들은 바로 삭제
                    $usergiftcontradecomment->giftcons()->detach($hasTheseGiftcons);
                    $usergiftcontradecomment->delete();
                } else {
                    foreach ($hasTheseGiftcons as $item) {
                        $item->on_trade = 0;
                        $item->user_id = 0;
                        $item->save();
                    }
                    $usergiftcontradecomment->giftcons()->detach($hasTheseGiftcons);    // pivot 삭제
                    $usergiftcontradecomment->delete();                                 // 거래댓글 삭제

                }
            }






            $user->delete();

            session()->flash('message', '회원탈퇴가 완료되었습니다. 그동안 이용해주셔서 감사합니다');
            return redirect('/');
        }
    }
}
