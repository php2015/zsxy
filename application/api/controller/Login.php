<?php

namespace app\api\controller;

use think\Config;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Login extends Controller
{

    //登陆
    public function login()
    {
        $names = input('mid');
        $passwordss = input('password');
        $password = md5($passwordss . Config::get('salt'));
        $user = db('user')->where('mid', '=', $names)->whereOr('mobile', '=', $names)->find();
        if ($user) {
            if (isset($user['status']) && $user['status'] != 1) {
                $data = ['status' => 'error', 'msg' => '您的账号因违规，已被限制使用，请联系客服处理！'];
                return $data;
            }
            if ($user['agent_class'] > 1) {
                if ($user['isStaff'] == 1) {
                    $data = ['status' => 'error', 'msg' => '账号不存在！'];
                    return $data;
                }
                if ($user['password'] == $password) {
                    session('mid', $user['mid']);
                    session('name', $user['names']);
                    session('uid', $user['id']);
                    session('isStaff', $user['isStaff']);
                    $data = ['status' => 'success', 'msg' => '登录成功！', 'isStaff' => $user['isStaff']];
                    return $data;

                } else {
                    $data = ['status' => 'error', 'msg' => '密码错误！'];
                    return $data;
                }
            } else {
                $data = ['status' => 'error', 'msg' => '账号不存在！'];
                return $data;
            }

        } else {
            $data = ['status' => 'error', 'msg' => '账号不存在！'];
            return $data;
        }

    }


    public function ylogin()
    {
        $names = input('mid');
        $passwordss = input('password');
        $password = md5($passwordss . Config::get('salt'));
        $user = db('user')->where('mid', '=', $names)->whereOr('mobile', '=', $names)->find();
        if ($user) {
            if ($user['isStaff'] != 1) {
                $data = ['status' => 'error', 'msg' => '账号不存在！'];
                return $data;
            }
            if (isset($user['status']) && $user['status'] != 1) {
                $data = ['status' => 'error', 'msg' => '您的账号因违规，已被限制使用，请联系客服处理！'];
                return $data;
            }
            if ($user['agent_class'] > 1) {
                if ($user['password'] == $password) {
                    session('mid', $user['mid']);
                    session('name', $user['names']);
                    session('uid', $user['id']);
                    session('isStaff', $user['isStaff']);
                    $data = ['status' => 'success', 'msg' => '登录成功！', 'isStaff' => $user['isStaff']];
                    return $data;

                } else {
                    $data = ['status' => 'error', 'msg' => '密码错误！'];
                    return $data;
                }
            } else {
                $data = ['status' => 'error', 'msg' => '账号不存在！'];
                return $data;
            }

        } else {
            $data = ['status' => 'error', 'msg' => '账号不存在！'];
            return $data;
        }

    }

    public function loginss()
    {
        $data = input('post.');
        
        if ($data['code'] != session('code')) {
            //验证码错误
            return 3;
        }
        if ($data['mobile'] != session('mobile')) {
            //手机号不是发送短信的手机号
            return 4;
        }
        $time = time();
        $codetime = session('codetime');
        $c_time = $time - $codetime;
        $user = db('user')->where('mobile', '=', $data['mobile'])->find();
        if ($user) {
            session('mid', $user['mid']);
            session('name', $user['names']);
            session('uid', $user['id']);
            return 1;
        } else {
            return 0;
        }

    }

    public function editpd()
    {
        $psd['id'] = session('uid');
        $xposswordss = input('xpossword');
        $psd['password'] = md5($xposswordss . Config::get('salt'));
        if (db('user')->where('id', '=', $psd['id'])->update($psd)) {
            $data = ['status' => "success", 'msg' => "修改密码成功！"];
            return $data;
        } else {
            $data = ['status' => "error", "msg" => "修改密码错误！"];
            return $data;
        }
    }

    public function zhuce()
    {
        $pid = session('pid');
        if (empty($pid)) {
            $pid = 1;
        }
        $username = input('username');
        $mobile = input('mobile');
        $password = input('password');
        $usermobile = db('user')->where('mobile', '=', $mobile)->find();
        if ($usermobile) {
            if ($usermobile['mobile'] == $mobile) {
                if ($usermobile['agent_class'] > 1) {
                    return 4;
                } else {
                    //判断上级是否规定下级等级
                    $s_user_ss = db('user')
                        ->alias("u")
                        ->field("u.*,z.maid")
                        ->join("sun_agent a", "a.id=u.agent_class", "LEFT")
                        ->join("sun_agentzhuce z", "z.paid=u.agent_class", "LEFT")
                        ->where('u.id', '=', $usermobile['pid'])
                        ->find();
                    if ($usermobile['pid'] == $pid) {
                        if (!empty($s_user_ss['maid'])) {
                            $agent_class_ss = $s_user_ss['maid'];
                        } else {
                            $agent_class_ss = 2;
                        }
                    } else {
                        $um_data['pid'] = $pid;
                        $agent_class_ss = 2;
                    }
                    $um_data['agent_class'] = $agent_class_ss;
                    $um_data['id'] = $usermobile['id'];
                    $um_data['password'] = md5($password . Config::get('salt'));
                    $um_data['names'] = $username;
                    if (db('user')->where('id', '=', $usermobile['id'])->update($um_data)) {
                        session('mid', $usermobile['mid']);
                        session('name', $usermobile['names']);
                        session('uid', $usermobile['id']);
                        return 1;
                    }
                }
            } else {
                return 4;
            }
        } else {
            $max = db('user')->max("id");
            $max++;
            $max += 10000;
            $new_mid = "M00" . $max;
            //判断上级是否规定下级等级
            $s_user = db('user')
                ->alias("u")
                ->field("u.*,z.maid")
                ->join("sun_agent a", "a.id=u.agent_class", "LEFT")
                ->join("sun_agentzhuce z", "z.paid=u.agent_class", "LEFT")
                ->where('u.id', '=', $pid)
                ->find();
            if (!empty($s_user['maid'])) {
                $agent_class = $s_user['maid'];
            } else {
                $agent_class = 2;
            }
            $user = [
                'names' => $username,
                'mid' => $new_mid,
                //'idcard'=>$idca,
                'mobile' => $mobile,
                'status' => 1,
                'create_time' => time(),
                //'province'=>$city['city_name'],
                //'city'=>$citys['city_name'],
                'agent_class' => $agent_class,
                'pid' => $pid,
                'password' => md5($password . Config::get('salt'))
            ];
            $bjimg_id = db('user')->insertGetId($user);
            if (!empty($bjimg_id)) {
                session('mid', $user['mid']);
                session('name', $user['names']);
                session('uid', $bjimg_id);
                return 1;

            } else {
                return 0;
            }
        }
      }

    public function duanxin()
    {
        $data = input('post.');
        if ($data['code'] != session('code')) {
            return 3;
        }
        if ($data['mobile'] != session('mobile')) {
            return 4;
        }
        $time = time();
        $codetime = session('codetime');
        $c_time = $time - $codetime;
        if ($c_time > 120) {
            return 5;
        }
        $user = db('user')->where('mobile', '=', $data['mobile'])->find();
        $password['password'] = md5($data['password'] . Config::get('salt'));
        $password['id'] = $user['id'];
        if (db('user')->where('id', '=', $user['id'])->update($password)) {
            session('mid', $user['mid']);
            session('name', $user['names']);
            session('uid', $user['id']);
            return 1;
        } else {
            return 1;
        }

    }


}
