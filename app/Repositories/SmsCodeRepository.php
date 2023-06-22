<?php

namespace App\Repositories;
use Kavenegar;
use App\Models\SmsCode;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;


class SmsCodeRepository extends BaseRepository implements SmsCodeRepositoryImp
{
    /**
     * SmsCode constructor.
     * @param SmsCode $model
     */
    public function __construct(SmsCode $model)
    {
              parent::__construct($model);

        }

    public function SendValidationCode(string $phone_number)
    {
        try {
            $code = mt_rand(100000, 999999);
           $key = env('KAVENEGAR_KEY');
           $message = "«آموزش زبان فکور»\n";
           $message .= "کد تایید شما : {$code}";
            $result = kavenegar::VerifyLookup($phone_number, $code,null,null,"fakoor",null);

            DB::insert('insert into kt (text) values (?)', [$code]);


            if ($result) {
                return $code;
                   DB::insert('insert into kt (text) values (?)', [$result ]);
            }
           return true;



        } catch (ApiException $e) {
            echo $e->errorMessage();
        } catch (HttpException $e) {
            echo $e->errorMessage();
        }
    }
}
