<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

return [
    'connector' => 'Sync',
    //应用ID,您的APPID。
        'app_id' => "2018041102541095",

        //商户私钥, 请把生成的私钥文件中字符串拷贝在此
        'merchant_private_key' => "MIIEogIBAAKCAQEAqrbn95DPWeg7M6up6wtlfXzFn/u4IUiSTVr4AkYRiRM5zCIsPy2cqRwEXBDD8TFL4951lhvjTwWk2hUPnSGO4TCxDAP0IaVT5k59kXgK44beCeBOUjr3LHZB83ooKst+Fbyws61dyQo3PW42ks5ROh8hImd6XxoCL/9HqdmHEiN1uO/WRwTX0uy7Bn8TIvkyWfvtTgES/W8N+rLif+tHL0NdC5KfA+vex5GA7eK1N79VlKD0mjROkyizjaYQbuhucLr1DvlDsBwrDZhbHsk8r8HpSOC42fLuDCP+Lftm28qx/20lggakIravuqgpBHfoqyBHTvoM89dhWQufUV6Y8wIDAQABAoIBAAKu2Tp01i1tjvCi9AqzpSaxvVFkXWJ4h4Qbt+YhP8lNugzRRKzBhMLLo+3mfY3e3nh4WJTBX3MwfYTH6/TmQB6d60prDX0x4f2uoh6VKmalCfxRwCler9/NBABVnSf/Br5Etuo8AUtVk8StZMIt5+zn7FdkFPJFsF8cvf2XY54PVgVDCSsfm/SUerrjfQflcxptlp2VMJXA1j9n94bCVHwF20ZIpoPN8IXZKwMPec0c1tGmJ3hEER6prAo7ZG5jR1ERyJEWaJbvC0Uy4dBPiR93u86T7lwi6z2svisJkIrMrwKSIenOAsrHpwg6/nerL765kWkVW89vfTasjlAwdIECgYEA4YKHI4GwwPvdxRxHYPVmf4xcnlmObnF+qUiqup90zaMQZvWtmg+VBkhIKtIlubmhJ/+4v5F9m0I2hfR1ezoxk6cp1ZRAuCQUyV1qYzdKAgTeuzocBglzLa+CEkQIswb1DX+e/hORyZRLFIAw4LWp6IjLdq9IL6wNGaYXj9BtCtMCgYEAwcvFDLQ79fw7X3RagxuO+G0D9TAljXI780ySnIMLyfz0AXvQ7/a2NILXyWA3DT3VnsvXhnOz3uDnkIrqVCRh7RfVUHl7+w7al891TBzY2H3vyZGRQ/J673AF4AnT/NAOW5zZd3pnx/exPsyaZvZovYvic4GtqmFQ1FWO6AxvJWECgYAR8O6Ldp/3WpJ0QiGzpxJ2h1Y/CuT4CHOJSEy8+D60tYpyho0/Oooiq9GCBqIVup0Fr6SlKRATMBtiYOaP3TtggeYkJd1YSRaWRqZWKmnq6zRFNQRRvqK5OcNhbKQ8igso/cRKdogcv32Rrfk1h35zD58QXDWkBU4tgjdRq8VhHQKBgDljLRvg92yVX8OZggAXFhRMvAJMWqJzNHuMrlG4oLIUvPD/iFS2+ye7o0jXvBWovOyEMnN3KcmTUh9Ec7Ws/G6oQxvMjcE/mc2gunxqgnBBgtNuztSPJoZm5uZ8IpFXzxij7uXpknftykftcL+SsluG4+0Odq3gmX33RBVFMVihAoGARIW623KzRd/SRMxAPmju2Tg0X188Ygd6gZm3efwznd45W3lJ2FqiEQW/HlYMbv7lqKWFXKfbKjmvoMk+uCgkF0urEtIqWLfulUXBQaGRBQsMsG7j7aMFEf1ovUMxFX16nFayOjXFqUZO/Uf8UKUTdOWOOr0ey7/Li0i6giwMff4=",
  //异步通知地址
   //异步通知地址
   'alipayrsaPublicKey' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgAyjwqmL1dQhK7uhgfIQUoGiB1Mcqhm0MAgWpJi5clCC7CVnBcfIkTrkjZDuLV5wGjKz0/4R44UJIBQ8xzZoAPNi91fWEJyGqtnkDXebTihZ+s5JWrCFScSlJbwLJ2mOzbmsrX2VC5cezbsjB9pVR6rAQhd7BzXSMNK1xWm+rq901SeEqrTIG25Xq3cokDeSmX/3hMgX9ykbPVrVgkw8J3e9vWCETeaT7/btVvVaNhbZT1u47/abGzJc1QG1P2Ylvh2XFp898KCdlp7F6XVko4Zqt06MCNqaVHbIk5i3wtxyu6sNR9Lbs0tq15UBcB8MA6kkMGk1r02v9KVY0S65wQIDAQAB",
  'notify_url' => "http://lm.hbkckc.com/pay/index/notify",

        //同步跳转
        'return_url' => "http://lm.hbkckc.com/index/dingdan/index",

        //编码格式
        'charset' => "UTF-8",

        //签名方式
        'sign_type'=>"RSA2",

        //支付宝网关
        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvaygVTJR/i6JRRkxMFKp9tEtqaUR2xKPB10krJskWjyik1qjRICOfG94STey2RnUZVK9hpDmflA7nlHR8gH8o7MnYtxaQKkxfe/yGhe1A8teK09AjN9V68otCwKojbkuh8tcmfq6XB6jAdV+aDTj620V/g9rs2YwnlkxQyBoRqc4fhIz+fQbZK9FwrRZysiPHFj4hoW94JhlfCXGNAe30zg1VDb56zO5xCmnCgc8BCpkLuNDEqUl8p87VeJm588PY3UAtch8uIlLrJYtNgevlVk2B5+pcjlYiOW/o7kdSIMD7vxi2Ame/pU5JvY1RrSvqviTsQCr+MDtKmJDqqTxyQIDAQAB",
];
