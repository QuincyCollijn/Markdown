<?php namespace Azion\Markdown\Controllers;

use Azion\Filemaker\Base\Controllers\BaseController;
use Illuminate\Support\Facades\View;
use Azion\Page\Models\Page;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Michelf\markdown;

Class MarkdownController extends BaseController
{
	public function index()
	{
		if (Input::get('t') == "page")
		{
			$result = Page::where('id', '=', Input::get('id'))->firstOrFail();

			$body = Markdown::defaultTransform($result->translation->body);

			return View::make('azion.markdown.markdown')->with('body', $body)->with('result', $result);
		} elseif(Input::get('t') == "event"){
			$result = \Event::where('id', '=', Input::get('id'))->firstOrFail();

			$body = Markdown::defaultTransform($result->translation->body);

			return View::make('azion.markdown.markdown')->with('body', $body)->with('result', $result);
		}
	}

	public function update()
	{
		$page = Page::find(Input::get('id'));

		$Parsedown = new \Parsedown();
		$page->translation->body = Input::get('body');
		$page->translation->save();


		return Redirect::back()->with('result', $page);
	}
}