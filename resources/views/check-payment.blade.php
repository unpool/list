<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="KeyDesign"/>
    <meta name="description"
          content="&#1591;&#1585;&#1575;&#1581;&#1740; &#1608;&#1576; &#1587;&#1575;&#1740;&#1578; &#1711;&#1585;&#1608;&#1607; &#1575;&#1740;&#1606;&#1578;&#1585;&#1606;&#1578;&#1740; &#1575;&#1605;&#1606;&#1740;&#1578;&#1740; &#1606;&#1575;&#1589;&#1585;&#1740;"/>
    <meta name="keywords"
          content="&#1576;&#1740;&#1606;&#1705; , &#1591;&#1585;&#1575;&#1581;&#1740; &#1587;&#1575;&#1740;&#1578;, &#1591;&#1585;&#1575;&#1581;&#1740; &#1581;&#1585;&#1601;&#1607; &#1575;&#1740; &#1587;&#1575;&#1740;&#1578;, &#1591;&#1585;&#1575;&#1581;&#1740; &#1570;&#1585;&#1605;, &#1591;&#1585;&#1575;&#1581;&#1740; &#1604;&#1608;&#1711;&#1608;, &#1591;&#1585;&#1575;&#1581;&#1740; &#1587;&#1575;&#1740;&#1578; &#1575;&#1585;&#1586;&#1575;&#1606;, &#1591;&#1585;&#1575;&#1581;&#1740; &#1608;&#1576;"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- SITE TITLE -->
    <title>'&#1711;&#1585;&#1608;&#1607; &#1601;&#1585;&#1607;&#1606;&#1711;&#1740; &#1583;&#1575;&#1606;&#1575;&#1583;&#1740;&#1587;</title>

    <!-- FAVICON -->
    <link rel="icon" href="images/fav.ico">

    <!-- WEB FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:100,300,400,600,700' rel='stylesheet' type='text/css'>

    <!-- STYLESHEETS -->
    <link rel="stylesheet" type="text/css" href="{{asset('site/css/style.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('site/css/flaticon.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('site/css/responsive.css')}}"/>
</head>
<body>
<div  style="display: flex;direction: rtl;justify-content: center;align-items: center;height: 100%;flex-direction: column">
    @if($data['Status'] == "OK")
        <strong>پرداخت موفقیت آمیز بود.</strong>
    @else
        <strong>مشکلی به وجود آمده است، لطفا مجددا سعی نمایید.</strong>
    @endif
        @php
        $url = "facoor://facoor.ir?status={$data['Status']}&order_id={$data['order_id']}";
        @endphp
    <form action="{{$url}}" target="_blank">
        <input type="submit" class="btn btn-dager" value="باز کردن نرم افزار" style="display: inline-block;font-weight: 400;text-align: center;white-space: nowrap;vertical-align: middle;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;border: 1px solid transparent;border-top-color: transparent;border-right-color: transparent;border-bottom-color: transparent;border-left-color: transparent;padding: .375rem .75rem;font-size: 1rem;line-height: 1.5;border-radius: .25rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;font-family: 'B-Morvarid';background-color: #007bff;color: #fff;cursor: pointer"/>
    </form>
</div>
</body>
</html>
