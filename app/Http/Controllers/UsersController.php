<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function create()
    {
        return view('users.create'); // 这个相当于 /users/create
    }

    public function show(User $user) // 这个参数会匹配路由片段中的 {user}
    {
        return view('users.show', compact('user')); //  compact 方法转化为一个关联数组，并作为第二个参数传递给 view 方法，将数据与视图进行绑定。
    }

    public function store(Request $request)
    {
        $this->validate($request, [  // 需要对用户输入的数据进行 验证，在验证成功后再将数据存入数据库
            // validate 方法接收两个参数，第一个参数为用户的输入数据，第二个参数为该输入数据的验证规则。
            'name' => 'required|max:50', // 使用 required 来验证用户名是否为空。
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        // 保存用户并重定向

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
        
    }
    /*
    存在性验证：在用户填写表单的时候，我们会要求用户必须填写上自己的用户名，当用户名为空时将注册失败。使用 required 来验证用户名是否为空。
    长度验证：我们还可以使用 min 和 max 来限制用户名所填写的最小长度和最大长度。
    正则表达式：在其它的一些应用上，如果要对用户邮箱进行验证，则可能需要你写一段非常冗长且不易理解的 正则表达式 来匹配邮箱格式。但在 Laravel 中，我们只需简单的使用 email 便能够完成邮箱格式的验证。'email' => 'email'
    唯一性验证：unique:users，针对于数据表 users 做验证。   这种验证方式还是不够严谨，所以我们需要在一开始创建 用户数据表 时便设置邮箱字段的唯一属性。这个 Laravel 在默认给我们生成的用户表迁移文件中便已经默认设定好了。
    如果我们需要确保用户在输入密码时，保证两次输入的密码一致。这时候则可以使用 confirmed 来进行密码匹配验证。'password' => 'confirmed'
     */

     
}
