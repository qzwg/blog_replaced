<?php
/* 支付宝支付的控制器 */
namespace controllers;

use Yansongda\Pay\Pay;

class AlipayController
{
    // 配置
    public $config = [
        'app_id' => '2016091600527626',
        // 支付宝公钥
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzcDiUmAFgiaBi2PzVpP+GdyPNLQuja3B26Z/3tcDDiuWbndLaA4o45J+Xj6KZ2GgQpZe5a9ZGoasas7YLGxPA5Z91eTooqmVwfPsaTUx4JHJlhiS+3R4738kA7BCXvmVKAHjG52ExwjwM4XWh+zN0jldPaS+4EtZnCrciDQtUk7IU7hbjDwqe6mUzwpI0zgyGQ0CPvug1VJBLdRgOlIaGNwVn1WbwqkrXYkHXMKHZhgT/WF4UTr+X4TpFIyA24ZVl2BtLchvFvf9C0+Ui8pWjfxjD6uE1VHtVQNEJ4MIaisfXpDMgQgkqClYDQN/udub7mq/CQUGsm9ZN5SUJEUXLwIDAQAB',
        // 商户应用密钥
        'private_key' => 'MIIEpAIBAAKCAQEAuoy1DMW1bDvNQc7CZOALVRERL+wcVV3UhbP59ICtpBx+zGiEsDuOmAFAcEPDwGNk4NhXdAkN9n/1jGiSZaKwfkBNU3tmyuYVLH0shgGzWL/S4XG51EwonUH2a6rVaI2OaiAjUXcYPfxbnpo/52PwiF8B/bfezUp+G6pjC0UbxruO2tE8nyfCq0cz1qYNGBulmECPyG5y69ECtiwVvw/+cK3rm+lxlSCUXp5cqB+HaGgd+trXLOJxZONd/fPkmKEts1pllCkTsDTxT77O0ZLtM5+D1e7VE68OMiIQvNRyl1p+HNQjsUNVX62cNfRb3cjtET5wqUT56AOeJgl9qVDDFwIDAQABAoIBAQCoy9C2sd6rBKGBPjifVipq2nqWxioNBE3cfTFaj2SO7km9Y4VMgVdRKzDHZEmnt0f8O0VGdTrxJG9mkOiGlmLkmgJd23bzeKUIEGtNBhTl5QxHecQP2KmXQaxbV8SqSgvm8xWCDSUeUU4FgMT59nAatPz0On+beiAJoG7mL64mbtuW8YsUB0wIFhTwe1T1+Q9qTO+YEh4ejteXZc1flGahjGDJbzCWwErmMILAAopiNaLNDcgx3AXeqf+ddP6jK32MikXhddYSDogX7/BXIMkOg7co5gXCG/aXMueMKsuR2wWC+pUZfxl7VBM8IEBfR8ptq9DIE8QcfMWYml4qpPNhAoGBAOZ0twlxxPGthlJ1q1EWdUy6qGD/yzHvVY0TEW4dXTJNqBv4GyF0sQktDRG0FCQtqk1lzbOHcbsEz737xwn9EpuJGWqFB4gy3Z1e77Dr5qM6bXScm5HSPX7MfC99H6cu4uxogrGLqlgE/S7OO0bNFEU4nFNcaASqZjcH9C82P1FTAoGBAM86If8Sk1tYm/TqT8p9IB2ww8+mNwZo7AVrTgYvmampRPfDX0UrmrlkdZLJVbdxYLNexmu+AwsvS3XXknWNyPf6UXqELPYNO9y+0VNusNRl03UabW4Czf5QWZPSlC0bu8xbBjVUA3O761XMfBbPtS7/X41wn3/4w1T2eGVyPjqtAoGAOMiBYR5bPIFZG3BK6gvykxla66ubUY57MeuE2/D4SbDAv0N+y9uI0436LmaEn/VwhOmUqaux5jblSRaEkH1+3DwHuytUE8cUu/XscVdu2MFIvvbnjiKTbG7OGpVl+zeeSknmCgEz08RG7gV6rZNSb0vnmNKn/p5N2TlofUmMiGkCgYApXKgWeoWxEOGoI/CjMRBs/LBIzRtkiyK4/i8Hqw6Xv7KFZZipfMeYQ4X4M3mJcPblNoCSVs3SuLDuJ4YTMqavYGZM9v7macPODsRHS+u9qUlosUqwT50AKteGWty6mDOG2ZBGqqs5uYOCj5shDnpSlCRlXdpoN6X9Wmizjvb+zQKBgQCJl5ppVH363lV6cY1dVY80oEfLHBaiMom3O/N5WcDe6G4rulBvJYtZeTF2A/EoYozsPz25MrtEFCwvluNFoH36U6hg5HL8HiXYdbp442KY/GMWLYJsSpWo737fmU5hlSqrqzOYy+ukGX/toKgBAMC72UY2S4Z5gaywlUA9GiNPHg==',
        
        // 通知地址
        'notify_url' => 'http://requestbin.fullcontact.com/ymx119ym',
        // 跳回地址
        'return_url' => 'http://localhost:9999/alipay/return',
        
        // 沙箱模式（可选）
        'mode' => 'dev',
    ];

    // 跳转到支付宝
    public function pay()
    {
        // 先在本地的数据库中生成一个订单（支付的金额、支付状态等信息、订单号）
        // 模拟一个假的订单
        $order = [
            'out_trade_no' => time(),    // 本地订单ID
            'total_amount' => '0.01',    // 支付金额（单位：元）
            'subject' => 'test subject', // 支付标题
        ];

        // 跳转到支付宝
        $alipay = Pay::alipay($this->config)->web($order);
        $alipay->send();
    }
    // 支付完成跳回
    public function return()
    {
        // 验证数据是否是支付宝发过来
        $data = Pay::alipay($this->config)->verify();


        echo '<h1>支付成功！</h1> <hr>';

        var_dump( $data->all() );

    }
    // 接收支付完成的通知
    public function notify()
    {
        $alipay = Pay::alipay($this->config);
        try{
            $data = $alipay->verify(); // 是的，验签就这么简单！
            // 这里需要对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            
            echo '订单ID：'.$data->out_trade_no ."\r\n";
            echo '支付总金额：'.$data->total_amount ."\r\n";
            echo '支付状态：'.$data->trade_status ."\r\n";
            echo '商户ID：'.$data->seller_id ."\r\n";
            echo 'app_id：'.$data->app_id ."\r\n";

        } catch (\Exception $e) {
            echo '失败：';
            var_dump($e->getMessage()) ;
        }

        // 回应支付宝服务器（如何不回应，支付宝会一直重复给你通知）
        $alipay->success()->send();
    }

    // 退款
    public function refund()
    {
        // 生成唯一退款订单号（以后使用这个订单号，可以到支付宝中查看退款的流程）
        $refundNo = md5( rand(1,99999) . microtime() );

        try{
            $order = [
                'out_trade_no' => '1536291256',    // 退款的本地订单号
                'refund_amount' => 0.01,              // 退款金额，单位元
                'out_request_no' => $refundNo,     // 生成 的退款订单号
            ];

            // 退款
            $ret = Pay::alipay($this->config)->refund($order);

            if($ret->code == 10000)
            {
                echo '退款成功！';
            }
            else
            {
                echo '失败' ;
                var_dump($ret);
            }
        }
        catch(\Exception $e)
        {
            var_dump( $e->getMessage() );
        }
    }
}