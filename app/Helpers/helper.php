<?php

use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

include 'HelpersFile/File.php';
include 'HelpersFile/Date.php';

if (!function_exists('setBoolean')){
    function setBoolean($value){

        if ($value == 1){
            return true;
        }

        return false;
    }
}

if (!function_exists('auth_admin')) {

	/**
	 * @return \Illuminate\Auth\SessionGuard
	 */
	function auth_admin()
	{

		return auth()->guard('admin');
	}
}

if (!function_exists('auth_teacher')) {

	/**
	 * @return \Illuminate\Auth\SessionGuard
	 */
	function auth_teacher()
	{

		return auth()->guard('teacher');
	}
}

if (!function_exists('login_teacher')) {
	/**
	 * @return \App\Models\Teacher|null
	 * get login teacher
	 */
	function login_teacher()
	{
		return auth()->guard('teacher')->user();
	}
}

if (!function_exists('get_permission_name')) {

	function get_permission_name($routeName, $guard)
	{

		return str_replace(
			'.',
			' ',
			str_replace("{$guard}.", '', $routeName)
		);
	}
}

if (!function_exists('get_trans')) {

	function get_trans(string $key, string $trans, string $attr = null, $replaces = [], $lang = null)
	{

		$defaultLang = strtolower(($lang ?: config('app.locale', 'en')));
		$keyArray = explode('.', $key);

		if (count($keyArray) <= 0) {
			return null;
		}

		if (!is_null($attr)) {

			$attributesKey = "validation.attributes";
			$attributes = trans($attributesKey, [], $defaultLang);
			$attributes = ($attributes != $attributesKey) ? $attributes : [];

			$replaces = array_merge([
				'attribute' => key_exists($attr, $attributes) ? $attributes[$attr] : $attr,
			], $replaces);
		}

		$trans = trans("{$trans}.{$key}", $replaces, $defaultLang);

		return is_string($trans) ? preg_replace(
			'/\s+/',
			' ',
			preg_replace('/(?!\b)(:\w+\b)/', '', $trans)
		) : $trans;
	}
}

if (!function_exists('get_message')) {

	function get_message($messageKey, $attr = null, $replace = [], $lang = 'fa')
	{

		return get_trans($messageKey, 'messages', $attr, $replace, $lang);
	}
}

if (!function_exists('convert_to_english_digit')) {
	function convert_to_english_digit($string)
	{
		$persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
		$arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];

		$num = range(0, 9);
		$convertedPersianNums = str_replace($persian, $num, $string);
		$englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

		return $englishNumbersOnly;
	}
}

if (!function_exists('GtoJ')) {
	function GtoJ(string $date, string $format = 'Y-m-d')
	{
		return \Morilog\Jalali\CalendarUtils::strftime($format, strtotime($date));
	}
}
if (!function_exists('JtoG')) {
	/**
	 * format date : Y m d
	 * @param string $date
	 * @param string $separator
	 * @return string
	 */
	function JtoG(string $date, string $separator)
	{
		$date = explode($separator, $date);
		$date = \Morilog\Jalali\CalendarUtils::toGregorian($date[0], $date[1], $date[2]);
		return implode($separator, $date);
	}
}

if (!function_exists('generateRandomString')) {
	/**
	 * @param int $length
	 * @return string
	 */
	function generateRandomString($length = 6)
	{
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$ret = '';
		for ($i = 0; $i < $length; ++$i) {
			$random = str_shuffle($chars);
			$ret .= $random[0];
		}
		return $ret;
	}
}

if (!function_exists('uploadFile')) {

	function uploadFile(UploadedFile $file, $prefix = 'uploads')
	{

		$day = Carbon::now()->day;
		$year = Carbon::now()->year;
		$month = Carbon::now()->month;
		$folder = "$prefix/$year/$month/$day";
		$image1 = uniqid() . '.' . $file->getClientOriginalExtension();
		$path1 = $folder . '/' . $image1;
		if (file_exists($folder) == false) {
			$fs = new Filesystem();
			$fs->makeDirectory($folder, 0755, true);
		}
		$file->move($folder, $image1);

		return $path1;
	}
}



if (!function_exists('fileUploader')) {
	function fileUploader(UploadedFile $file, $path_from_public = 'upload'): \Symfony\Component\HttpFoundation\File\File
	{
		$folder = "$path_from_public";
		$image = uniqid() . '.' . $file->getClientOriginalExtension();
		/** @var \Symfony\Component\HttpFoundation\File\File $res */
		$res = $file->move($folder, $image);
		return $res;
	}
}

if (!function_exists('fileUploadToStorage')) {
	/**
	 * @param UploadedFile $file
	 * @param string $path_from_storage
	 * @return string|bool
	 */
	function fileUploadToStorage(UploadedFile $file, $path_from_storage = 'upload')
	{
		$folder = "$path_from_storage";
		$fileName = uniqid() . '.' . $file->getClientOriginalExtension();
		$res = \Storage::disk('public')->put($folder . DIRECTORY_SEPARATOR . $fileName, \File::get($file));
		if ($res) {
			return $fileName;
		}
		return $res;
	}
}

if (!function_exists('imageViewer')) {
	function imageViewer(string $path, bool $showNoImage = true): string
	{
		if (file_exists($path))
			return asset($path);
		else
			return noImageViewer();
	}
}


if (!function_exists('noImageViewer')) {
	function noImageViewer(): string
	{
		return asset('upload/no-image.png');
	}
}

if (!function_exists('removeFilesInDirectory')) {
	function removeFilesInDirectory(string $path)
	{
		if (file_exists(public_path($path))) {
			$files = glob($path . '/*'); // get all file names

			foreach ($files as $file) { // iterate files
				if (is_file($file))
					unlink($file); // delete file
			}
		}
	}
}

if (!function_exists('removeMediaFromDirectory')) {
	function removeMediaFromDirectory($path)
	{
		if (file_exists(public_path($path))) {
			unlink($path);
		}
	}
}

if (!function_exists('bankAccountFormat')) {
	function bankAccountFormat($bank_account)
	{
		return join('-', str_split($bank_account, 4));
	}
}


if (!function_exists('translateStatusColumn')) {
	function translateStatusColumn($status)
	{
		$translate = $status;
		switch ($status) {
			case 'publish':
				$translate = 'منتشر شده';
				break;
			case 'disable':
				$translate = 'غیرفعال';
				break;
			default:
				break;
		}
		return $translate;
	}
}


// ALERTS
if (!function_exists('setAlertSession')) {
	function setAlertSession($type, $message)
	{
		session()->flash('alert', [
			'type' => $type,
			'message' => $message
		]);
	}
}
if (!function_exists('setDangerAlertSession')) {
	function setDangerAlertSession($message = null)
	{
		$message =  $message ?? 'متاسفانه خطایی رخ داده است.';
		setAlertSession('danger', $message);
	}
}

if (!function_exists('setSuccessAlertSession')) {
	function setSuccessAlertSession($message = null)
	{
		$message =  $message ?? 'با موفقیت انجام شد.';
		setAlertSession('success', $message);
	}
}
