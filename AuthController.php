<?php

namespace App\Http\Controllers;

use App\Models\Available;
use App\Models\Booked;
use App\Models\Expert;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
/*    //تسجيل حساب للمستخدم
    public function userRegister(Request $request):JsonResponse
    {
        $request->validate([
            'name'=>['required','max:55'],
            'email'=>['email','required',],
            'phone'=>['required','unique:users'],
            'password'=>['required',],
            'pocket'=>['required']
        ]);
        $input= $request->all();
        //تشفير الباسورد
        $input['password']= bcrypt($input['password']);
        $user= User::query()->create($input);
        $name = $user->name;
        $email = $user->email;
        $phone = intval($user->phone);
        $password = $user->password;
        $pocket= intval($user->pocket);
        $accessToken =$user->createToken('MyApp',['user'])->accessToken;
        $user_details = [
            "name" => $name ,
            "email" => $email,
            "phone" =>$phone ,
            "password"=>$password,
            "pocket"=>$pocket ,
            "token" =>$accessToken
            ];
//        var_dump($phone);
        return response()->json(['user'=>$user_details]);
    }*/
    //تسجيل حساب للمستخدم
    public function userRegister(Request $request):JsonResponse
    {
        $request->validate([
            'name'=>['required','max:55'],
            'email'=>['email','required',],
            'phone'=>['required','unique:users'],
            'password'=>['required',],
            'pocket'=>['required',],
        ]);
        //here the input has it all (name , pass ,email ...)
        $input= $request->all();
        //تشفير الباسورد
        $input['password']= bcrypt($input['password']);
        $user= User::query()->create($input);
        $accessToken =$user->createToken('MyApp',['user'])->accessToken;
        return response()->json([
            'user'=>$user ,
            // 'password'=>$input['password'],
            'access_Token'=>$accessToken]);
    }
    //دخول للمستخدم
    public function userLogin(Request $request):JsonResponse
    {
        $request->validate([
            'phone'=>'required',
            'password'=>'required',
        ]);
        $credentials = request(['phone','password']);
        // $credentials['active']=1;
        // $credentials['deleted_at']=null;
        if (auth()->guard('user')->attempt($request->only('phone','password'))){
            config(['auth.guard.api.provider'=>'user']);
            $user = User::query()->select('users.*')->find(auth()->guard('user')->user()['id']);
            $success=$user;
            $success['token']=$user->createToken('MyApp',['user'])->accessToken;
            return response()->json(['user' => $success],200);
        }
        else{
            return response()->json(['error'=>['Unauthorized']],401);
        }
    }
   /* //خروج للمستخدم
    public function userLogout(): JsonResponse
    {
        Auth::guard('user-api')->user()->token()->revoke();
        return response()->json(['success'=>'logged out successfully']);
    }
    //تسجيل حساب للخبير
    public function expertRegister(Request $request):JsonResponse
    {
        $request->validate([
            'name'=>['required','max:55'],
            'email'=>['email','required',],
            'password'=>['required',],
            'address'=>['required',],
            'phone'=>['required','unique:experts','integer'],
            'skill_id'=>['required',],
            'description'=>['required',],
            'pocket'=>['required','integer'],
            'price'=>['required','integer'],
            'photo'=>['required',],
        ]);
        $input= $request->all();
        $input['password']= bcrypt($input['password']);
        $expert= Expert::query()->create($input);
        $name = $expert->name;
        $email = $expert->email;
        $password = $expert->password;
        $address = $expert->address;
        $phone = intval($expert->phone);
        $skill_id = $expert->skill_id ;
        $description = $expert -> description;
        $pocket = intval($expert->pocket);
        $price = intval($expert->price);
        $photo = $expert -> photo ;
        $accessToken =$expert->createToken('MyApp',['expert'])->accessToken;
        $expert_details = [
            "name" => $name ,
            "email" => $email,
            "password"=>$password,
            "address" => $address,
            "phone" =>$phone ,
            "skill_id"=>$skill_id,
            "description"=>$description,
            "pocket"=>$pocket ,
            "price"=>$price,
            "photo"=>$photo,
            "token" =>$accessToken
        ];
        return response()->json(['expert'=>$expert_details ]);
    }*/

    //تسجيل حساب للخبير
    public function expertRegister(Request $request):JsonResponse
    {
        $request->validate([
            'name'=>['required','max:55'],
            'email'=>['email','required',],
            'password'=>['required',],
            'address'=>['required',],
            'phone'=>['required','unique:experts'],
            'skill_id'=>['required',],
            'description'=>['required',],
            'pocket'=>['required',],
            'price'=>['required',],
            'photo'=>['required',],
        ]);
        //here the input has it all (name , pass ,email ...)
        $input= $request->all();
        //تشفير الباسورد
        $input['password']= bcrypt($input['password']);
        $expert= Expert::query()->create($input);
        $accessToken =$expert->createToken('MyApp',['expert'])->accessToken;
        return response()->json([
            'expert'=>$expert ,
            'access_Token'=>$accessToken]);
    }
    //دخول للخبير
    public function expertLogin(Request $request):JsonResponse
    {
        $request->validate([
            'phone'=>'required',
            'password'=>'required',
        ]);
        $credentials = request(['phone','password']);
        // $credentials['active']=1;
        // $credentials['deleted_at']=null;
        if (auth()->guard('expert')->attempt($request->only('phone','password'))){
            config(['auth.guard.api.provider'=>'expert']);
            $expert = Expert::query()->select('experts.*')->find(auth()->guard('expert')->user()['id']);
            $success=$expert;
            $success['token']=$expert->createToken('MyApp',['expert'])->accessToken;
            return response()->json(['expert' => $success],200);
        }
        else{
            return response()->json(['error'=>['Unauthorized']],401);
        }
    }
    //خروج للخبير
    public function expertLogout(): JsonResponse
    {
        Auth::guard('expert-api')->user()->token()->revoke();
        return response()->json(['success'=>'logged out successfully']);
    }
    //ميثود بترجعلي كل الخبراء التابعين لتصنيف معين
    public function getAllExperts(Request $request): JsonResponse
    {
        $request->validate(['skill_id' => 'required',]);
        $input = $request->all();
        $expert = DB::table('experts')->where('skill_id', 'like', $input)->get();
        return response()->json(['message' => 'successfully', 'experts' => $expert,], 200);
    }
    //ميثود بترجعلي كل التصنيفااات
    public function getAllSkills(): JsonResponse
    {
        $skills=DB::table('skills')->get();
        return response()->json(['message'=>'successfully', 'skills'=>$skills ,],200);
    }
    //ميثود بتاخد ايدي خبير و بترجع كل الحجوزات عندو
    public function getAllBooked(): JsonResponse
    {
       // $request->validate(['expert_id'=>'required',]);
        $expert_id = auth('expert-api')->user()->id;//$request->all();
        $booked=DB::table('bookeds')->where('expert_id','=',$expert_id)->get();
        return response()->json(['message'=>'successfully', 'bookeds'=>$booked ,],200);
    }
//تابع ادخال الايام المتاحة للخبير
    public function availableDay(Request $request): JsonResponse{
        $expert_id = auth('expert-api')->user()->id;
        $request->validate([
            'day_id'=>['array','required'],
            'from'=>'required',
            'to'=>'required',
            'session_time'=>'required',]);
        if($request['to'] <= $request['from'])
        {return response()->json(['Error'=>'Try again',],401);}
        $TotalTime = $request['to'] - $request['from'];
        if($TotalTime <= $request['session_time'])
        {return response()->json(['error'=>'Your session is greater than your total time',],200);}
        foreach ($request->day_id as $key => $value) {
            $row = [
                'expert_id' => $expert_id,
                'day_id' => $request->day_id[$key],
                'from' => $request->from,
                'to' => $request->to,
                'hour' => $request->from,
                'session' => $request->session_time,
            ];
            Available::insert($row);
        }
        return response()->json([
            'message'=>' successfully',
            'TotalTime' => $TotalTime
            ],200);
    }
    //ميثود بتحجز موعد
    public function bookDate(Request $request): JsonResponse{
        $user_id = auth('user-api')->user()->id;
        $request->validate([
            'expert_id' => ['required'],
            'day_id' => 'required',
            'hourDate' => 'required', // hour
             ]);
        $expert_id = request(['expert_id']);
        $user_pocket = auth('user-api')->user()->pocket;
        $price = DB::table('experts')->where('id', 'Like', $expert_id)->first();
        $available = DB::table('availables')->where('day_id' , 'Like' , $request->day_id)
            ->where('expert_id' , 'Like' , $request->expert_id)->first();
        if ($user_pocket >= $price->price) {
                            $row = [
                    'user_id' => $user_id ,
                    'expert_id' => $request->expert_id ,
                    'day_id' => $request->day_id,
                    'hour' => $request->hourDate,
                ];
                Booked::create($row);
            $new_expert_pocket = $price-> pocket + $price->price;
             DB::table('experts')
                ->where('id' ,'=' , $expert_id)
                ->update(['pocket' => $new_expert_pocket]);
            $new_user_pocket = $user_pocket - $price->price;
            DB::table('users')
                ->where('id' ,'=' , $user_id)
                ->update(['pocket' => $new_user_pocket]);
            //update hour
            $session=$available->session;
            $new_hour=$request->hourDate+ $session;
            DB::table('availables')->where('day_id' , 'Like' , $request->day_id)
                ->where('expert_id' , 'Like' , $request->expert_id)->update(['hour' => $new_hour]);
            //ckeck full state
            $TotalTime = $available->to - $new_hour;
            if($TotalTime<$session){
                DB::table('availables')->where('day_id' , 'Like' , $request->day_id)
                    ->where('expert_id' , 'Like' , $request->expert_id)->update(['full' => true]);
            }
            return response()->json(['message' => 'successfully',],200);}
        return response()->json(['error' => 'You dont have money'], 401);}

    ///////// ترجيع تفاصيل الخبير
    public function getExpertDetails(Request $request): JsonResponse
    {
        $user_id = auth('user-api')->user()->id;
        $request->validate(['expert_id'=>['required']]);
        $input= $request->all();
        $expert = DB::table('experts')->where('id', 'like', $input)->first();
        $available = DB::table('availables')->where('expert_id', 'like', $expert->id)
            ->where ('full', 'like' , false)
            ->get();
        if($available->isEmpty())
        {
            return response()->json(['Expert'=>$expert,
                'Massage' => 'There is no time' ],200);
        }
        return response()->json(['Expert'=>$expert,
          'Available' => $available ],200);
    }
    public function searchExperts(Request $request): JsonResponse
    {
        $request->validate(['expert_name'=>['required'],]);
        $input = $request['expert_name'];
        $expert = DB::table('experts')->where(
                            'name' ,'like', '%'.$input. '%'
                                            )->get();
        if($expert -> isempty())
        {return response()->json(['message'=>'There is no results '],200);}
        return response()->json(['message'=>'Successfully : ','experts'=>$expert],200);
    }
    public function searchSkills(Request $request): JsonResponse
    {
        $request->validate(['skill_name'=>['required'],]);
        $input = $request['skill_name'];
        $skill = DB::table('skills')->where(
            'name' ,'like', '%'.$input. '%'
        )->get();
        if($skill -> isempty())
        {return response()->json(['message'=>'There is no results '],200);}
        return response()->json(['message'=>'Successfully : ','experts'=>$skill],200);
    }
    public  function setFavorite(Request $request): JsonResponse
    {
        $user_id = auth('user-api')->user()->id;
        $request->validate(['expert_id'=>['required']]);
        $row = [ 'user_id'=>$user_id,
               'expert_id'=>$request ->expert_id,];
        Favorite::create($row);
        return response()->json(['message'=>'Successfully '],200);
    }
    public  function deleteFavorite(Request $request): JsonResponse
    {
        $user_id = auth('user-api')->user()->id;
        $request->validate(['expert_id'=>['required']]);
        /*$row = [ 'user_id'=>$user_id,
            'expert_id'=>$request ->expert_id,];*/
        $expert_id = $request -> expert_id;
        $deletee = DB :: table ('favorites') -> where ('expert_id','=',$expert_id) ->
            where('user_id','=',$user_id) ->delete();
        return response()->json(['message'=>'Successfully ' , $deletee],200);
    }
    public  function getFavorite()
    {
        $user_id = auth('user-api')->user()->id;
        $favorite = DB::table('favorites') -> where('user_id','=',$user_id);//->get();
      /*  foreach ($favorite->expert_id as $value)
        {
            $expert = DB::table('experts')->where('id', 'like', $value)->get();
        }*/
        $expert = $this->getAllExperts($favorite -> expert_id);
        return response()->json(['message'=>'Successfully ',$expert ],200);
    }
}


